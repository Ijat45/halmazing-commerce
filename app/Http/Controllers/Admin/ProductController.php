<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Branch;
use App\Models\HalalCertification;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', Product::class);
        $query = Product::with(['vendor', 'branches', 'categories'])->latest();

        if ($request->filled('q')) {
            $search = $request->q;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('sku', 'like', "%{$search}%");
            });
        }

        if ($request->filled('category')) {
            $query->whereHas('categories', function ($q) use ($request) {
                $q->where('id', $request->category);
            });
        }

        if ($request->filled('status')) {
            if ($request->status === 'in_stock') {
                $query->where('stock_quantity', '>', 0);
            } elseif ($request->status === 'out_of_stock') {
                $query->where('stock_quantity', '<=', 0);
            }
        }

        $products = $query->paginate(10);
        $categories = Category::all();

        return view('pages.admin.products.index', compact('products', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        $branches = Branch::where('user_id', auth()->id())->get();
        return view('pages.admin.products.form', compact('categories', 'branches'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'sku' => 'nullable|string|unique:products,sku',
            'stock_quantity' => 'required|integer|min:0',
            'categories' => 'array',
            'categories.*' => 'exists:categories,id',
            'image' => 'nullable|image|max:2048',
            'description' => 'nullable|string',
        ]);

        $validated['vendor_id'] = auth()->id();

        $validated['vendor_id'] = auth()->id();
        // vendor_name is removed in favor of relationships

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('products', 'public');
            $validated['image'] = $path;
        }

        $product = Product::create($validated);

        if ($request->has('categories')) {
            $product->categories()->sync($request->categories);
        }

        if ($request->has('branches')) {
            // Security: Ensure we only sync branches that belong to this user
            $validBranchIds = Branch::where('user_id', auth()->id())
                ->whereIn('id', $request->branches)
                ->pluck('id');
            $product->branches()->sync($validBranchIds);
        }

        // Handle Halal Certification
        if ($request->hasFile('halal_file')) {
            $path = $request->file('halal_file')->store('halal-certs', 'public');
            HalalCertification::create([
                'user_id' => auth()->id(),
                'product_id' => $product->id,
                'file_path' => $path,
                'expiry_date' => $request->input('halal_expiry'),
                'reference_number' => $request->input('halal_ref_no'),
                'status' => 'pending', // Default
            ]);
        }

        return redirect()->route('merchant.products.index')->with('success', 'Product created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $this->authorize('update', $product);

        $categories = Category::all();
        $branches = Branch::where('user_id', auth()->id())->get();
        return view('pages.admin.products.form', compact('product', 'categories', 'branches'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $this->authorize('update', $product);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'sku' => 'nullable|string|unique:products,sku,' . $product->id,
            'stock_quantity' => 'required|integer|min:0',
            'categories' => 'array',
            'categories.*' => 'exists:categories,id',
            'image' => 'nullable|image|max:2048',
            'description' => 'nullable|string',
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('products', 'public');
            $validated['image'] = $path;
        }

        $product->update($validated);

        if ($request->has('categories')) {
            $product->categories()->sync($request->categories);
        }

        if ($request->has('branches')) {
            // Security: Ensure we only sync branches that belong to this user
            $validBranchIds = Branch::where('user_id', auth()->id())
                ->whereIn('id', $request->branches)
                ->pluck('id');
            $product->branches()->sync($validBranchIds);
        }

        // Handle Halal Certification
        if ($request->hasFile('halal_file')) {
            $path = $request->file('halal_file')->store('halal-certs', 'public');

            // Delete old if exists? Or keep history? let's update or create.
            // Since relation is HasOne, we update the existing one if present.

            if ($product->halalCertification) {
                // Delete old file
                if ($product->halalCertification->file_path) {
                    \Illuminate\Support\Facades\Storage::disk('public')->delete($product->halalCertification->file_path);
                }
                $product->halalCertification->update([
                    'file_path' => $path,
                    'expiry_date' => $request->input('halal_expiry'),
                    'reference_number' => $request->input('halal_ref_no'),
                    'status' => 'pending',
                ]);
            } else {
                HalalCertification::create([
                    'user_id' => auth()->id(),
                    'product_id' => $product->id,
                    'file_path' => $path,
                    'expiry_date' => $request->input('halal_expiry'),
                    'reference_number' => $request->input('halal_ref_no'),
                    'status' => 'pending',
                ]);
            }
        } elseif ($request->filled('halal_expiry') || $request->filled('halal_ref_no')) {
            // Update metadata without file
            if ($product->halalCertification) {
                $product->halalCertification->update([
                    'expiry_date' => $request->input('halal_expiry'),
                    'reference_number' => $request->input('halal_ref_no'),
                ]);
            }
        }

        return redirect()->route('merchant.products.index')->with('success', 'Product updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $this->authorize('delete', $product);

        $product->delete();

        return redirect()->route('merchant.products.index')->with('success', 'Product deleted successfully.');
    }
}
