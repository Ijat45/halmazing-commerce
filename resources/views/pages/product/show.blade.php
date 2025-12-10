@extends('layouts.app')

@section('title', 'Product Details')

@section('content')
    {{-- Back + Share Icons (Mobile Only) --}}
    <div class="d-none d-md-flex top-0 w-100 justify-content-between p-3" style="z-index: 10;">
        <x-buttons.prev-page />
        <x-buttons.share />
    </div>

    <div class="container p-0 m-sm-auto m-0">
        <div class="card border-0 shadow-sm rounded-md-4 m-md-3 m-0">
            <div class="row g-0">
                {{-- Left: Product Image --}}
                <div class="col-md-6 position-relative rounded-md-4 rounded-bottom-4 bg-cover bg-center min-vh-50"
                    style="background-image: url('{{ Str::startsWith($product->image, 'http') ? $product->image : asset('storage/' . $product->image) }}');">
                    {{-- Back + Share Icons (Mobile Only) --}}
                    <div class="d-flex d-md-none position-absolute top-0 w-100 justify-content-between p-3"
                        style="z-index: 10;">
                        <x-buttons.prev-page />
                        <x-buttons.share />
                    </div>
                </div>

                {{-- Right: Product Details --}}
                <div class="col-md-6 d-flex flex-column">
                    <div class="card-body p-3 p-md-4">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <div>
                                <p class="text-muted mb-1">{{ $product->category ?? 'N/A' }}</p>
                                <h2 class="card-title fw-bold text-dark-green mb-1 me-3">{{ $product->name }}</h2>
                                <p class="text-muted small">SKU: {{ $product->sku ?? 'N/A' }}</p>
                            </div>
                            <div class="d-flex flex-column align-items-end">
                                <x-buttons.favorite :is-favorite="$product->is_featured ?? false" />
                            </div>
                        </div>

                        {{-- Tabs for Description and Halal Cert --}}
                        <ul class="nav nav-tabs nav-fill mb-3" id="productTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="description-tab" data-bs-toggle="tab"
                                    data-bs-target="#description-tab-pane" type="button" role="tab"
                                    aria-controls="description-tab-pane" aria-selected="true">Description</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="halal-cert-tab" data-bs-toggle="tab"
                                    data-bs-target="#halal-cert-tab-pane" type="button" role="tab"
                                    aria-controls="halal-cert-tab-pane" aria-selected="false">Halal Certificate</button>
                            </li>
                        </ul>
                        <div class="tab-content" id="productTabContent">
                            <div class="tab-pane fade show active" id="description-tab-pane" role="tabpanel"
                                aria-labelledby="description-tab" tabindex="0">
                                <p class="text-muted mb-4">By {{ $product->vendor_display_name }}</p>

                                {{-- Rating & Reviews Count --}}
                                <x-product.rating :rating="$product->rating" />

                                {{-- Size & Order --}}
                                <x-product.order-form :product="$product" :sizes="[]" :price="$product->price" />
                            </div>
                            <div class="tab-pane fade" id="halal-cert-tab-pane" role="tabpanel"
                                aria-labelledby="halal-cert-tab" tabindex="0">
                                @if($product->halalCertification)
                                    <div class="text-center">
                                        <div class="mb-3">
                                            <span
                                                class="badge {{ $product->halalCertification->expiry_date->isPast() ? 'bg-danger' : 'bg-success' }} mb-2">
                                                {{ $product->halalCertification->expiry_date->isPast() ? 'Expired' : 'Active' }}
                                            </span>
                                            <p class="mb-1 fw-bold">Ref:
                                                {{ $product->halalCertification->reference_number ?? 'N/A' }}
                                            </p>
                                            <p class="small text-muted mb-3">Expires:
                                                {{ $product->halalCertification->expiry_date->format('d M Y') }}
                                            </p>
                                        </div>
                                        <img src="{{ asset('storage/' . $product->halalCertification->file_path) }}"
                                            class="img-fluid rounded border shadow-sm" alt="Halal Certificate">
                                    </div>
                                @else
                                    <div class="text-center py-4 text-muted">
                                        <i class="bi bi-shield-x display-4 mb-2 d-block"></i>
                                        <p>No Halal Certification linked to this product.</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- New Listings Section --}}
    <div class="container mt-5">
        @include('pages.home.sections.new-listings', ['newListingProducts' => $newListingProducts])
    </div>
@endsection