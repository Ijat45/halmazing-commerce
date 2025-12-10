@extends('layouts.merchant')

@section('title', isset($product) ? 'Edit Product' : 'Create Product')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">{{ isset($product) ? 'Edit Product' : 'Create New Product' }}</h1>
        <a href="{{ route('merchant.products.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back to List
        </a>
    </div>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ isset($product) ? route('merchant.products.update', $product) : route('merchant.products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @if(isset($product))
            @method('PUT')
        @endif

        <div class="row">
            <div class="col-md-8">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Product Information</h6>
                    </div>
                    <div class="card-body">
                        <ul class="nav nav-tabs" id="productTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="general-tab" data-toggle="tab" href="#general" role="tab" aria-controls="general" aria-selected="true">General</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="pricing-tab" data-toggle="tab" href="#pricing" role="tab" aria-controls="pricing" aria-selected="false">Pricing</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="inventory-tab" data-toggle="tab" href="#inventory" role="tab" aria-controls="inventory" aria-selected="false">Inventory</a>
                            </li>
                        </ul>
                        <div class="tab-content pt-4" id="productTabContent">
                            <!-- General Tab -->
                            <div class="tab-pane fade show active" id="general" role="tabpanel" aria-labelledby="general-tab">
                                <div class="form-group">
                                    <label for="name">Product Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $product->name ?? '') }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <textarea class="form-control" id="description" name="description" rows="5">{{ old('description', $product->description ?? '') }}</textarea>
                                </div>
                            </div>

                            <!-- Pricing Tab -->
                            <div class="tab-pane fade" id="pricing" role="tabpanel" aria-labelledby="pricing-tab">
                                <div class="form-group">
                                    <label for="price">Regular Price <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">$</span>
                                        </div>
                                        <input type="number" step="0.01" class="form-control" id="price" name="price" value="{{ old('price', $product->price ?? '') }}" required>
                                    </div>
                                </div>
                            </div>

                            <!-- Inventory Tab -->
                            <div class="tab-pane fade" id="inventory" role="tabpanel" aria-labelledby="inventory-tab">
                                <div class="form-group">
                                    <label for="sku">SKU</label>
                                    <input type="text" class="form-control" id="sku" name="sku" value="{{ old('sku', $product->sku ?? '') }}">
                                    <small class="form-text text-muted">Stock Keeping Unit (Unique ID)</small>
                                </div>
                                <div class="form-group">
                                    <label for="stock_quantity">Stock Quantity <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control" id="stock_quantity" name="stock_quantity" value="{{ old('stock_quantity', $product->stock_quantity ?? 0) }}" required>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <!-- Organization -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Organization</h6>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="categories">Categories</label>
                            <select class="form-control" id="categories" name="categories[]" multiple style="height: 150px;">
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" 
                                        {{ (collect(old('categories', isset($product) ? $product->categories->pluck('id') : []))->contains($category->id)) ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            <small class="form-text text-muted">Hold Ctrl/Cmd to select multiple.</small>
                        </div>
                    </div>
                </div>

                <!-- Branch Availability -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Branch Availability</h6>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label>Product Available At:</label>
                            @if(isset($branches) && $branches->count() > 0)
                                @foreach($branches as $branch)
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="branch_{{ $branch->id }}" name="branches[]" value="{{ $branch->id }}"
                                            {{ (collect(old('branches', isset($product) ? $product->branches->pluck('id') : []))->contains($branch->id)) ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="branch_{{ $branch->id }}">{{ $branch->name }}</label>
                                    </div>
                                @endforeach
                            @else
                                <p class="small text-muted">No branches created yet. <a href="{{ route('merchant.branches.create') }}">Create one</a></p>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Halal Certification -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Halal Certification</h6>
                    </div>
                    <div class="card-body">
                        @if(isset($product) && $product->halalCertification)
                            <div class="mb-3">
                                <span class="badge badge-success mb-2">Certified</span>
                                <p class="small mb-1">Ref: {{ $product->halalCertification->reference_number ?? 'N/A' }}</p>
                                <p class="small mb-2">Exp: {{ $product->halalCertification->expiry_date->format('d M Y') }}</p>
                                <img src="{{ asset('storage/' . $product->halalCertification->file_path) }}" class="img-thumbnail" style="max-height: 100px;">
                            </div>
                            <hr>
                            <label>Update Certificate:</label>
                        @else
                            <label>Upload Certificate:</label>
                        @endif

                        <div class="form-group">
                            <input type="file" class="form-control-file" id="halal_file" name="halal_file" accept="image/*">
                        </div>
                        <div class="form-group">
                            <label for="halal_ref_no" class="small">Reference Number</label>
                            <input type="text" class="form-control form-control-sm" id="halal_ref_no" name="halal_ref_no" value="{{ old('halal_ref_no', $product->halalCertification->reference_number ?? '') }}">
                        </div>
                        <div class="form-group">
                            <label for="halal_expiry" class="small">Expiry Date</label>
                            <input type="date" class="form-control form-control-sm" id="halal_expiry" name="halal_expiry" value="{{ old('halal_expiry', isset($product) && $product->halalCertification ? $product->halalCertification->expiry_date->format('Y-m-d') : '') }}">
                        </div>
                    </div>
                </div>

                <!-- Media -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Product Image</h6>
                    </div>
                    <div class="card-body text-center">
                        <div class="mb-3">
                            @if(isset($product) && $product->image)
                                <img src="{{ Str::startsWith($product->image, 'http') ? $product->image : asset('storage/' . $product->image) }}" id="image-preview" class="img-fluid img-thumbnail" style="max-height: 200px;">
                            @else
                                <img src="https://via.placeholder.com/200" id="image-preview" class="img-fluid img-thumbnail" style="max-height: 200px;">
                            @endif
                        </div>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="image" name="image" accept="image/*" onchange="previewImage(this)">
                            <label class="custom-file-label" for="image">Choose file</label>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary btn-block btn-lg">
                    <i class="fas fa-save"></i> {{ isset($product) ? 'Update Product' : 'Save Product' }}
                </button>
            </div>
        </div>
    </form>
</div>

<script>
    function previewImage(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('image-preview').src = e.target.result;
            }
            reader.readAsDataURL(input.files[0]);
            
            // Update label
            var fileName = input.files[0].name;
            var label = input.nextElementSibling;
            label.innerText = fileName;
        }
    }
</script>
@endsection
