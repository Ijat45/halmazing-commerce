<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the products.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $category = $request->query('category');

        $productsQuery = Product::latest();

        if ($category) {
            $productsQuery->where('category', $category);
        }

        $products = $productsQuery->paginate(); // Paginate with 12 products per page

        return view('pages.product.index', compact('products'));
    }

    /**
     * Display the product description page.
     *
     * @return \Illuminate\View\View
     */
    public function show(Product $product)
    {
        // The $product variable is automatically injected by route model binding.
        // We can load any relationships if needed, e.g., $product->load('category', 'brand');

        // Fetch "You may also like" products (e.g., latest products, excluding the current one)
        $newListingProducts = Product::where('id', '!=', $product->id)->where('is_top_sale', false)->latest()->take(10)->get();

        return view('pages.product.show', compact('product', 'newListingProducts'));
    }
}
