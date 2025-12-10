<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HalalCertificationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $certifications = \App\Models\HalalCertification::where('user_id', auth()->id())->latest()->paginate(10);
        return view('pages.admin.halal-certifications.index', compact('certifications'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $products = \App\Models\Product::forMerchant()->get();
        return view('pages.admin.halal-certifications.form', compact('products'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'reference_number' => 'nullable|string|max:255',
            'expiry_date' => 'required|date',
            'file_path' => 'required|image|max:2048',
            // Security: Ensure the linked product belongs to the authenticated user
            'product_id' => [
                'nullable',
                \Illuminate\Validation\Rule::exists('products', 'id')->where(function ($query) {
                    return $query->where('vendor_id', auth()->id());
                }),
            ],
        ]);

        $data = $request->except('file_path');
        $data['user_id'] = auth()->id();

        if ($request->hasFile('file_path')) {
            $data['file_path'] = $request->file('file_path')->store('halal-certs', 'public');
        }

        \App\Models\HalalCertification::create($data);

        return redirect()->route('merchant.halal-certifications.index')->with('success', 'Certification uploaded successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $certification = \App\Models\HalalCertification::where('user_id', auth()->id())->findOrFail($id);
        $products = \App\Models\Product::forMerchant()->get();
        return view('pages.admin.halal-certifications.form', compact('certification', 'products'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $certification = \App\Models\HalalCertification::where('user_id', auth()->id())->findOrFail($id);

        $request->validate([
            'reference_number' => 'nullable|string|max:255',
            'expiry_date' => 'required|date',
            'file_path' => 'nullable|image|max:2048',
            // Security: Ensure the linked product belongs to the authenticated user
            'product_id' => [
                'nullable',
                \Illuminate\Validation\Rule::exists('products', 'id')->where(function ($query) {
                    return $query->where('vendor_id', auth()->id());
                }),
            ],
        ]);

        $data = $request->except('file_path');

        if ($request->hasFile('file_path')) {
            if ($certification->file_path) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($certification->file_path);
            }
            $data['file_path'] = $request->file('file_path')->store('halal-certs', 'public');
        }

        $certification->update($data);

        return redirect()->route('merchant.halal-certifications.index')->with('success', 'Certification updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $certification = \App\Models\HalalCertification::where('user_id', auth()->id())->findOrFail($id);

        if ($certification->file_path) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($certification->file_path);
        }

        $certification->delete();

        return back()->with('success', 'Certification deleted successfully.');
    }
}
