<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class OrderController extends Controller
{
    /**
     * Display a listing of the user's orders.
     */
    public function index(): View
    {
        $orders = Auth::user()
            ->orders()
            ->with('items.product') // Eager load items and their products
            ->latest()
            ->paginate(10);

        return view('pages.order.index', compact('orders'));
    }
}
