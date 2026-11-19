<?php

namespace App\Http\Controllers;

use App\Models\BorrowRequest;
use App\Models\Item;

class ReportController extends Controller
{
    public function inventory()
    {
        $items = Item::with('category')->orderBy('item_name')->get();

        return view('reports.inventory', compact('items'));
    }

    public function borrowHistory()
    {
        $requests = BorrowRequest::with(['borrower', 'approvedBy', 'handedOverBy', 'details.item'])
            ->latest()
            ->get();

        return view('reports.borrow_history', compact('requests'));
    }
}