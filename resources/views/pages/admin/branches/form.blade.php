@extends('layouts.merchant')

@section('title', isset($branch) ? 'Edit Branch' : 'Create Branch')

@section('content')
    <div class="d-flex align-items-center mb-4">
        <a href="{{ route('merchant.branches.index') }}" class="btn btn-light me-3">
            <i class="bi bi-arrow-left"></i>
        </a>
        <h1 class="mb-0">{{ isset($branch) ? 'Edit Branch' : 'Create Branch' }}</h1>
    </div>

    <div class="card border-0 shadow-sm" style="max-width: 800px;">
        <div class="card-body p-4">
            <form
                action="{{ isset($branch) ? route('merchant.branches.update', $branch->id) : route('merchant.branches.store') }}"
                method="POST">
                @csrf
                @if(isset($branch))
                    @method('PUT')
                @endif

                <div class="mb-3">
                    <label for="name" class="form-label">Branch Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name"
                        value="{{ old('name', $branch->name ?? '') }}" required placeholder="e.g. KL Sentral Outlet">
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="address" class="form-label">Address <span class="text-danger">*</span></label>
                    <textarea class="form-control @error('address') is-invalid @enderror" id="address" name="address"
                        rows="3" required
                        placeholder="Full address of the branch">{{ old('address', $branch->address ?? '') }}</textarea>
                    @error('address')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="contact_number" class="form-label">Contact Number</label>
                    <input type="text" class="form-control @error('contact_number') is-invalid @enderror"
                        id="contact_number" name="contact_number"
                        value="{{ old('contact_number', $branch->contact_number ?? '') }}"
                        placeholder="e.g. +60 3-1234 5678">
                    @error('contact_number')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex justify-content-end">
                    <a href="{{ route('merchant.branches.index') }}" class="btn btn-light me-2">Cancel</a>
                    <button type="submit" class="btn btn-primary px-4">Save Branch</button>
                </div>
            </form>
        </div>
    </div>
@endsection