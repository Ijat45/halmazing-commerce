@extends('layouts.merchant')

@section('title', isset($certification) ? 'Edit Certification' : 'Upload Certification')

@section('content')
    <div class="d-flex align-items-center mb-4">
        <a href="{{ route('merchant.halal-certifications.index') }}" class="btn btn-light me-3">
            <i class="bi bi-arrow-left"></i>
        </a>
        <h1 class="mb-0">{{ isset($certification) ? 'Edit Certification' : 'Upload Certification' }}</h1>
    </div>

    <div class="card border-0 shadow-sm" style="max-width: 800px;">
        <div class="card-body p-4">
            <form
                action="{{ isset($certification) ? route('merchant.halal-certifications.update', $certification->id) : route('merchant.halal-certifications.store') }}"
                method="POST" enctype="multipart/form-data">
                @csrf
                @if(isset($certification))
                    @method('PUT')
                @endif

                <div class="mb-3">
                    <label for="reference_number" class="form-label">Reference Number (JAKIM/Other)</label>
                    <input type="text" class="form-control @error('reference_number') is-invalid @enderror"
                        id="reference_number" name="reference_number"
                        value="{{ old('reference_number', $certification->reference_number ?? '') }}"
                        placeholder="e.g. JAKIM/(S)/(22.00)/492/2/ 1 002-04/2011">
                    @error('reference_number')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="expiry_date" class="form-label">Expiry Date <span class="text-danger">*</span></label>
                    <input type="date" class="form-control @error('expiry_date') is-invalid @enderror" id="expiry_date"
                        name="expiry_date"
                        value="{{ old('expiry_date', isset($certification) ? $certification->expiry_date->format('Y-m-d') : '') }}"
                        required>
                    @error('expiry_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="product_id" class="form-label">Link to Product (Optional)</label>
                    <select class="form-select @error('product_id') is-invalid @enderror" id="product_id" name="product_id">
                        <option value="">-- General / No Branch Specific --</option>
                        @foreach($products as $product)
                            <option value="{{ $product->id }}" {{ old('product_id', $certification->product_id ?? '') == $product->id ? 'selected' : '' }}>
                                {{ $product->name }}
                            </option>
                        @endforeach
                    </select>
                    <div class="form-text">If this cert is specific to one product, select it here.</div>
                    @error('product_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="file_path" class="form-label">Certificate Image <span class="text-danger">*</span></label>
                    @if(isset($certification) && $certification->file_path)
                        <div class="mb-2">
                            <img src="{{ asset('storage/' . $certification->file_path) }}" alt="Current Cert"
                                class="img-thumbnail" style="max-height: 200px;">
                        </div>
                    @endif
                    <input type="file" class="form-control @error('file_path') is-invalid @enderror" id="file_path"
                        name="file_path" accept="image/*" {{ isset($certification) ? '' : 'required' }}>
                    <div class="form-text">Max 2MB.</div>
                    @error('file_path')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex justify-content-end">
                    <a href="{{ route('merchant.halal-certifications.index') }}" class="btn btn-light me-2">Cancel</a>
                    <button type="submit" class="btn btn-primary px-4">Save Certification</button>
                </div>
            </form>
        </div>
    </div>
@endsection