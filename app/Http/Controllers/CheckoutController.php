<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    /**
     * Display the checkout page.
     */
    public function index()
    {
        $cartItems = $this->getCartItems();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')
                ->with('info', 'Your cart is empty. Please add products before checking out.');
        }

        // === Consistent Calculation Logic ===
        $subtotal = $cartItems->sum('subtotal');
        $discountPercent = 10; // Example static (can be dynamic later)
        $taxPercent = 8;       // Example static (can be dynamic later)
        $shipping = 5.00;      // Example flat shipping

        $discountAmount = ($subtotal * $discountPercent) / 100;
        $subtotalAfterDiscount = $subtotal - $discountAmount;
        $taxAmount = $cartItems->sum('tax_amount');
        $total = $subtotalAfterDiscount + $taxAmount + $shipping;
        // =====================================

        return view('pages.checkout.index', compact(
            'cartItems',
            'subtotal',
            'discountPercent',
            'discountAmount',
            'taxPercent',
            'taxAmount',
            'shipping',
            'total'
        ));
    }

    /**
     * Process the checkout and create an order.
     */
    public function process(Request $request)
    {
        $validatedData = $request->validate([
            'shipping_name' => 'required|string|max:255',
            'shipping_address' => 'required|string|max:1000',
            'shipping_city' => 'required|string|max:100',
            'shipping_zip' => 'required|string|max:20',
            'payment_method' => 'required|in:cod,fpx,card',
        ]);

        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login')->with('error', 'Please log in to complete your order.');
        }

        $cartItems = $this->getCartItems();
        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        // === Consistent Calculation Logic ===
        $subtotal = $cartItems->sum('subtotal');
        $discountPercent = 10;
        $taxPercent = 8;
        $shippingAmount = 5.00;

        $discountAmount = ($subtotal * $discountPercent) / 100;
        $subtotalAfterDiscount = $subtotal - $discountAmount;
        $taxAmount = $cartItems->sum('tax_amount');
        $total = $subtotalAfterDiscount + $taxAmount + $shippingAmount;
        // =====================================

        $shippingAddress = json_encode([
            'name' => $validatedData['shipping_name'],
            'address' => $validatedData['shipping_address'],
            'city' => $validatedData['shipping_city'],
            'zip' => $validatedData['shipping_zip'],
        ]);

        // === Create the Order Transaction ===
        DB::transaction(function () use (
            $user,
            $cartItems,
            $subtotal,
            $discountAmount,
            $taxAmount,
            $shippingAmount,
            $total,
            $shippingAddress,
            $validatedData
        ) {
            $order = $user->orders()->create([
                'order_number'     => 'ORD-' . strtoupper(Str::random(10)),
                'subtotal'         => $subtotal,
                'discount_amount'  => $discountAmount,
                'tax_amount'       => $taxAmount,
                'shipping_amount'  => $shippingAmount,
                'total'            => $total,
                'currency'         => 'MYR', // Set to Malaysian Ringgit
                'shipping_address' => $shippingAddress,
                'billing_address'  => $shippingAddress,
                'payment_method'   => $validatedData['payment_method'],
                'payment_status'   => 'pending',
                'status'           => 'pending',
            ]);

            foreach ($cartItems as $item) {
                $order->items()->create([
                    'product_id' => $item->product_id,
                    'name'       => $item->name,
                    'quantity'   => $item->quantity,
                    'price'      => $item->price,
                    'total'      => $item->total,
                ]);

                if ($item->product) {
                    $item->product->decrement('stock_quantity', $item->quantity);
                }
            }

            // Clear the user's cart
            if (Auth::check()) {
                CartItem::where('user_id', Auth::id())->delete();
            } else {
                CartItem::where('session_id', session()->getId())->delete();
            }
        });

        // === Payment Method Handling ===
        switch ($validatedData['payment_method']) {
            case 'cod':
                return redirect()->route('checkout.success')
                    ->with('success', 'Your order has been placed successfully (Cash on Delivery).');

            case 'fpx':
                // --- FPX Placeholder Logic (Simulation) ---
                // Here you will integrate ToyyibPay, Billplz, or iPay88 later
                // For now, simulate a redirect or a pending FPX payment
                return redirect()->route('checkout.success')
                    ->with('info', 'FPX payment simulation: your order has been created and is pending confirmation.');

            case 'card':
                return redirect()->route('checkout.success')
                    ->with('info', 'Card payment method coming soon!');

            default:
                return redirect()->route('checkout.success')
                    ->with('info', 'Order placed successfully!');
        }
    }

    /**
     * Display the order success page.
     */
    public function success()
    {
        return view('pages.checkout.success');
    }

    /**
     * Get cart items for the current user or session.
     */
    private function getCartItems()
    {
        if (Auth::check()) {
            return CartItem::with('product')->where('user_id', Auth::id())->get();
        }

        return CartItem::with('product')->where('session_id', session()->getId())->get();
    }
}
