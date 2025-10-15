@extends('layouts.app')

@section('title', 'All Products')

@section('content')
    <div class="container my-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h2 fw-bold">
                @if(request('category'))
                    {{ request('category') }}
                @else
                    All Products
                @endif
            </h1>
        </div>

        @if($products->isEmpty())
            <div class="alert alert-info text-center">
                No products found.
            </div>
        @else
            <div class="row row-cols-2 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
                @foreach ($products as $product)
                    <div class="col">
                        {{-- Assuming you have a product card component --}}
                        {{-- If not, you can build the card structure directly here --}}
                        <x-product.card :product="$product" />
                    </div>
                @endforeach
            </div>

            {{-- Pagination Links --}}
            <div class="d-flex justify-content-center mt-5">
                {{ $products->withQueryString()->links('pagination::bootstrap-5') }}
            </div>
        @endif
    </div>
@endsection

{{-- Note: This assumes you have a component at `resources/views/components/product/card.blade.php`. --}}
{{-- If you don't, you'll need to create it or replace `<x-product.card :product="$product" />` with your product display HTML. --}}