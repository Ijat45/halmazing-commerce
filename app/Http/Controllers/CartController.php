<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class CartController extends Controller
{
    /**
     * Display the shopping cart.
     */
    public function index(): View
    {
        $cartItems = $this->getCartItems();

        // Calculate order summary
        $subtotal = $cartItems->sum('subtotal');
        $discountPercent = 10; // Example, can be dynamic
        $taxPercent = 8; // Example, can be dynamic
        $shipping = 5.00; // Example, can be dynamic

        $discountAmount = ($subtotal * $discountPercent) / 100;
        $subtotalAfterDiscount = $subtotal - $discountAmount;
        $taxAmount = $cartItems->sum('tax_amount'); // Sum of tax from each item
        $total = $subtotalAfterDiscount + $taxAmount + $shipping;

        // Fetch top sales products
        $topSalesProducts = Product::where('is_top_sale', true)->take(10)->get();

        // Fetch new listings (exclude top sales)
        $newListingProducts = Product::where('is_top_sale', false)->latest()->take(10)->get();

        return view('pages.cart.index', compact(
            'cartItems',
            'subtotal',
            'discountPercent',
            'discountAmount',
            'taxPercent',
            'taxAmount',
            'shipping',
            'total',
            'topSalesProducts',
            'newListingProducts'
        ));
    }

    /**
     * Add a product to the cart.
     */
    public function addToCart(Request $request, Product $product)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
            'options' => 'sometimes|array',
            'variant_id' => 'sometimes|integer',
        ]);

        $cartItem = $this->findCartItem($product->id, $request->variant_id);

        $quantity = $request->input('quantity', 1);

        if ($cartItem) {
            // Update quantity for existing item
            $cartItem->increment('quantity', $quantity);
        } else {
            // Pre-calculate totals for the new item
            $price = $product->discounted_price ?? $product->price;
            $taxRate = $product->tax_rate ?? 0.06;
            $subtotal = $price * $quantity;
            $taxAmount = $subtotal * $taxRate;
            $total = $subtotal + $taxAmount; // Assuming no discount on initial add

            // Add new item to the cart
            $cartItem = CartItem::create([
                'user_id' => Auth::id(),
                'session_id' => ! Auth::check() ? session()->getId() : null,
                'product_id' => $product->id,
                'variant_id' => $request->variant_id,
                'name' => $product->name,
                'sku' => $product->sku ?? 'SKU-'.strtoupper(Str::random(6)),
                'image' => $product->image,
                'quantity' => $quantity,
                'price' => $price,
                'tax_rate' => $taxRate,
                'tax_amount' => $taxAmount,
                'subtotal' => $subtotal,
                'total' => $total,
                'attributes' => $request->options ?? [],
                'vendor_id' => $product->vendor_id,
            ]);
        }

        // Recalculate only if the item already existed and was updated
        if (! $cartItem->wasRecentlyCreated) {
            $this->recalculateItemTotals($cartItem);
        }

        return redirect()->route('cart.index')->with('success', 'Product added to cart successfully!');
    }

    /**
     * Update a cart item.
     */
    public function update(Request $request, CartItem $cartItem)
    {
        // Authorize that the user owns the cart item or is the correct guest
        $isOwner = (Auth::check() && $cartItem->user_id == Auth::id());
        $isGuest = (! Auth::check() && $cartItem->session_id == session()->getId());
        if (! $isOwner && ! $isGuest) {
            abort(403);
        }

        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $cartItem->update(['quantity' => $request->quantity]);
        $this->recalculateItemTotals($cartItem);

        return redirect()->route('cart.index')->with('success', 'Cart updated successfully.');
    }

    /**
     * Remove an item from the cart.
     */
    public function destroy(CartItem $cartItem)
    {
        // Authorize that the user owns the cart item or is the correct guest
        $isOwner = (Auth::check() && $cartItem->user_id == Auth::id());
        $isGuest = (! Auth::check() && $cartItem->session_id == session()->getId());
        if (! $isOwner && ! $isGuest) {
            abort(403);
        }

        $cartItem->delete();

        return redirect()->route('cart.index')->with('success', 'Product removed successfully.');
    }

    /**
     * Get cart items for the current user or session.
     */
    private function getCartItems()
    {
        if (Auth::check()) {
            return CartItem::with('product')->where('user_id', Auth::id())->get();
        } else {
            return CartItem::with('product')->where('session_id', session()->getId())->get();
        }
    }

    /**
     * Find a cart item by product and variant.
     */
    private function findCartItem(int $productId, ?int $variantId)
    {
        $query = CartItem::where('product_id', $productId)->where('variant_id', $variantId ?? null);

        if (Auth::check()) {
            return $query->where('user_id', Auth::id())->first();
        } else {
            return $query->where('session_id', session()->getId())->first();
        }
    }

    /**
     * Recalculate totals for a given cart item.
     */
    private function recalculateItemTotals(CartItem $cartItem)
    {
        $subtotal = $cartItem->price * $cartItem->quantity;
        $taxAmount = $subtotal * ($cartItem->tax_rate ?? 0);
        // Assuming discount is a per-item value, not calculated here.
        // For a total discount, it should be applied on the order summary.
        $total = $subtotal + $taxAmount - $cartItem->discount;

        $cartItem->update([
            'subtotal' => $subtotal,
            'tax_amount' => $taxAmount,
            'total' => $total,
        ]);
    }
}
