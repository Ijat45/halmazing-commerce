<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BranchController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $branches = \App\Models\Branch::where('user_id', auth()->id())->latest()->paginate(10);
        return view('pages.admin.branches.index', compact('branches'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.admin.branches.form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string',
            'contact_number' => 'nullable|string|max:20',
        ]);

        $request->user()->branches()->create($request->all());

        return redirect()->route('merchant.branches.index')->with('success', 'Branch created successfully.');
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
        $branch = \App\Models\Branch::where('user_id', auth()->id())->findOrFail($id);
        return view('pages.admin.branches.form', compact('branch'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $branch = \App\Models\Branch::where('user_id', auth()->id())->findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string',
            'contact_number' => 'nullable|string|max:20',
        ]);

        $branch->update($request->all());

        return redirect()->route('merchant.branches.index')->with('success', 'Branch updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $branch = \App\Models\Branch::where('user_id', auth()->id())->findOrFail($id);
        $branch->delete();

        return back()->with('success', 'Branch deleted successfully.');
    }
}
