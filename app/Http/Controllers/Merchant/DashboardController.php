<?php

namespace App\Http\Controllers\Merchant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // Quick Stats
        $stats = [
            'products_count' => \App\Models\Product::count(),
            'branches_count' => $user->branches()->count(),
            // 'orders_count' => $user->orders()->count(), // If orders are scoped to merchant
        ];

        return view('pages.merchant.dashboard', compact('stats'));
    }
}
