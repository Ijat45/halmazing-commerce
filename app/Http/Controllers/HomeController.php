<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Contracts\Support\Renderable;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     */
    public function index(): Renderable
    {
        // Fetch top sales products (where is_top_sale is true)
        $topSalesProducts = Product::where('is_top_sale', true)->take(10)->get();

        // Fetch new listings (latest products that are not top sales)
        $newListingProducts = Product::where('is_top_sale', false)->latest()->take(10)->get();

        // Fetch categories from the database
        $allCategories = Category::all();

        // Take a subset for the main view (e.g., the first 7)
        $mainCategories = $allCategories->take(config('view.main_categories_count', 7));

        return view('pages.home.index', [
            'topSalesProducts' => $topSalesProducts,
            'newListingProducts' => $newListingProducts,
            'mainCategories' => $mainCategories,
            'allCategories' => $allCategories,
        ]);
    }
}
