<?php

namespace App\Http\Controllers;

use App\Models\BorrowRequest;
use App\Models\Item;
use App\Models\ItemCondition;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReturnController extends Controller
{
    public function returnForm()
    {
        $requests = BorrowRequest::with(['borrower', 'details.item', 'details.itemConditions'])
            ->where('status', 'BORROWED')
            ->latest()
            ->get();

        return view('borrow.return', compact('requests'));
    }

    public function processReturn(Request $request, $id)
    {
        $br = BorrowRequest::with(['details.item', 'details.itemConditions'])->findOrFail($id);

        if ($br->status !== 'BORROWED') {
            abort(400, 'Status tidak valid untuk pengembalian');
        }

        $isLate = Carbon::today()->gt(Carbon::parse($br->due_date));
        $lateDays = $isLate ? Carbon::today()->diffInDays(Carbon::parse($br->due_date)) : 0;

        DB::transaction(function () use ($br, $request) {
            foreach ($br->details as $detail) {
                $item = Item::where('id', $detail->item_id)
                    ->lockForUpdate()
                    ->first();

                $conditionAfter = $request->input("cond_after.{$detail->id}", 'Baik');
                $notes = $request->input("notes.{$detail->id}");

                $cond = $detail->itemConditions()->latest()->first();
                if (!$cond) {
                    $cond = ItemCondition::create([
                        'borrow_detail_id' => $detail->id,
                        'checked_by' => Auth::id(),
                        'condition_before' => 'Baik',
                        'condition_after' => $conditionAfter,
                        'notes' => $notes,
                    ]);
                } else {
                    $cond->update([
                        'checked_by' => Auth::id(),
                        'condition_after' => $conditionAfter,
                        'notes' => $notes ?? $cond->notes,
                    ]);
                }

                $quantity = $detail->quantity;

                if ($conditionAfter === 'Baik') {
                    $item->increment('stock_available', $quantity);
                } elseif ($conditionAfter === 'Rusak') {
                    $item->increment('stock_damaged', $quantity);
                } else {
                    $item->increment('stock_lost', $quantity);
                }

                $item->decrement('stock_borrowed', $quantity);
            }

            $br->update(['status' => 'RETURNED']);
        });

        $message = $isLate
            ? "Pengembalian diproses (terlambat {$lateDays} hari)."
            : 'Pengembalian diproses.';

        return back()->with('success', $message);
    }
}