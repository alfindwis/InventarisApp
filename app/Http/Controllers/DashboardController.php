<?php

namespace App\Http\Controllers;

use App\Models\BorrowRequest;
use App\Models\Category;
use App\Models\Item;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_items' => Item::count(),
            'total_categories' => Category::count(),
            'total_users' => User::count(),
            'low_stock_items' => Item::whereColumn('stock_available', '<=', 'minimum_stock')->count(),
            'pending_requests' => BorrowRequest::where('status', 'PENDING')->count(),
            'approved_requests' => BorrowRequest::where('status', 'APPROVED')->count(),
            'borrowed_requests' => BorrowRequest::where('status', 'BORROWED')->count(),
            'returned_requests' => BorrowRequest::where('status', 'RETURNED')->count(),
        ];

        $recentRequests = BorrowRequest::with(['borrower', 'details.item'])
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard.index', compact('stats', 'recentRequests'));
    }
}