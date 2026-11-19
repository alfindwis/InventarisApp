<?php

namespace App\Http\Controllers;

use App\Models\BorrowDetail;
use App\Models\BorrowRequest;
use App\Models\Item;
use App\Models\ItemCondition;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BorrowController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $query = BorrowRequest::with(['borrower', 'approvedBy', 'handedOverBy', 'details.item'])->latest();

        if ($user->role === 'peminjam') {
            $query->where('borrower_id', $user->id);
        }

        $requests = $query->get();
        return view('borrow.index', compact('requests'));
    }

    public function create()
    {
        $items = Item::where('stock_available', '>', 0)->orderBy('item_name')->get();
        return view('borrow.create', compact('items'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'due_date' => 'required|date|after:today',
            'notes' => 'nullable|string',
            'items' => 'required|array|min:1',
            'items.*.item_id' => 'required|exists:items,id',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        $code = 'BRW-' . date('Ymd-His') . '-' . rand(10, 99);

        DB::transaction(function () use ($request, $validated, $code) {
            $br = BorrowRequest::create([
                'transaction_code' => $code,
                'borrower_id' => $request->user()->id,
                'due_date' => $validated['due_date'],
                'notes' => $validated['notes'] ?? null,
                'status' => 'PENDING',
            ]);

            foreach ($validated['items'] as $it) {
                BorrowDetail::create([
                    'borrow_request_id' => $br->id,
                    'item_id' => $it['item_id'],
                    'quantity' => $it['quantity'],
                ]);
            }
        });

        return redirect()->route('borrow.index')
            ->with('success', 'Pengajuan peminjaman terkirim.');
    }

    public function approve($id)
    {
        $br = BorrowRequest::findOrFail($id);

        if ($br->status !== 'PENDING') {
            abort(400, 'Status tidak valid');
        }

        $br->update([
            'status' => 'APPROVED',
            'approved_by' => Auth::id(),
            'borrow_date' => now()->toDateString(),
        ]);

        return back()->with('success', 'Pengajuan disetujui.');
    }

    public function reject($id)
    {
        $br = BorrowRequest::findOrFail($id);

        if ($br->status !== 'PENDING') {
            abort(400, 'Status tidak valid');
        }

        $br->update([
            'status' => 'REJECTED',
            'approved_by' => Auth::id(),
        ]);

        return back()->with('success', 'Pengajuan ditolak.');
    }

    public function handoverForm()
    {
        $requests = BorrowRequest::with(['borrower', 'details.item'])
            ->where('status', 'APPROVED')
            ->latest()
            ->get();

        return view('borrow.handover', compact('requests'));
    }

    public function handover(Request $request, $id)
    {
        $br = BorrowRequest::with('details.item')->findOrFail($id);

        if ($br->status !== 'APPROVED') {
            abort(400, 'Status tidak valid untuk penyerahan');
        }

        DB::transaction(function () use ($br, $request) {
            foreach ($br->details as $detail) {
                $item = Item::where('id', $detail->item_id)
                    ->lockForUpdate()
                    ->first();

                if (!$item || $item->stock_available < $detail->quantity) {
                    throw new \RuntimeException("Stok tidak mencukupi untuk {$item->item_name}");
                }

                ItemCondition::create([
                    'borrow_detail_id' => $detail->id,
                    'checked_by' => Auth::id(),
                    'condition_before' => $request->input("cond_before.{$detail->id}", 'Baik'),
                    'notes' => $request->input("notes.{$detail->id}"),
                ]);

                $item->decrement('stock_available', $detail->quantity);
                $item->increment('stock_borrowed', $detail->quantity);
            }

            $br->update([
                'status' => 'BORROWED',
                'handed_over_by' => Auth::id(),
                'borrow_date' => $br->borrow_date ?? now()->toDateString(),
            ]);
        });

        return back()->with('success', 'Barang berhasil diserahkan (stok dikurangi).');
    }
}