<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Item;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function index()
    {
        $items = Item::with('category')->latest()->get();
        return view('items.index', compact('items'));
    }

    public function create()
    {
        $categories = Category::orderBy('category_name')->get();
        return view('items.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'item_code' => 'required|string|max:50|unique:items,item_code',
            'item_name' => 'required|string|max:255',
            'stock_total' => 'required|integer|min:0',
            'minimum_stock' => 'required|integer|min:0',
        ]);

        Item::create([
            'category_id' => $validated['category_id'],
            'item_code' => $validated['item_code'],
            'item_name' => $validated['item_name'],
            'stock_total' => $validated['stock_total'],
            'stock_available' => $validated['stock_total'],
            'stock_borrowed' => 0,
            'stock_damaged' => 0,
            'stock_lost' => 0,
            'minimum_stock' => $validated['minimum_stock'],
        ]);

        return redirect()->route('items.index')
            ->with('success', 'Barang berhasil ditambahkan.');
    }

    public function edit(Item $item)
    {
        $categories = Category::orderBy('category_name')->get();
        return view('items.edit', compact('item', 'categories'));
    }

    public function update(Request $request, Item $item)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'item_code' => 'required|string|max:50|unique:items,item_code,' . $item->id,
            'item_name' => 'required|string|max:255',
            'stock_total' => 'required|integer|min:0',
            'stock_damaged' => 'nullable|integer|min:0',
            'stock_lost' => 'nullable|integer|min:0',
            'minimum_stock' => 'required|integer|min:0',
        ]);

        $damaged = $validated['stock_damaged'] ?? $item->stock_damaged;
        $lost = $validated['stock_lost'] ?? $item->stock_lost;
        $stockAvailable = max(0, $validated['stock_total'] - $item->stock_borrowed - $damaged - $lost);

        $item->update([
            'category_id' => $validated['category_id'],
            'item_code' => $validated['item_code'],
            'item_name' => $validated['item_name'],
            'stock_total' => $validated['stock_total'],
            'stock_available' => $stockAvailable,
            'stock_damaged' => $damaged,
            'stock_lost' => $lost,
            'minimum_stock' => $validated['minimum_stock'],
        ]);

        return redirect()->route('items.index')
            ->with('success', 'Data barang berhasil diperbarui.');
    }

    public function destroy(Item $item)
    {
        $item->delete();

        return redirect()->route('items.index')
            ->with('success', 'Barang berhasil dihapus.');
    }
}