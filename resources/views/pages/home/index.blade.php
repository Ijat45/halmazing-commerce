@extends('layouts.app')

@section('title', 'Halmazing - Home')

@section('content')
    @include('layouts.header')
    
    <div class="container mt-4">
    {{-- Promo Banner Carousel --}}
    @include('pages.home.sections.promo-carousel')

    {{-- Category Menu --}}
    <div class="row text-center justify-content-start justify-content-md-center g-3 mb-4">
        @foreach ($mainCategories ?? [] as $index => $category)
            <div class="col-3 col-md-auto @if ($index >= 3) d-none d-md-block @endif">
                <x-buttons.category :icon="$category->icon" :label="$category->name" />
            </div>
        @endforeach

        {{-- "Others" button --}}
        <div class="col-3 col-md-auto">
            <a href="#"
                class="btn w-100 h-100 d-flex flex-column justify-content-center align-items-center p-2 rounded-4 border-0"
                data-bs-toggle="modal" data-bs-target="#allCategoriesModal">
                <div class="d-flex justify-content-center align-items-center rounded-3 mb-1"
                    style="width: 50px; height: 50px; background-color: #e9f7ea;">
                    <i class="fa-solid fa-grip fs-3" style="color: var(--primary-green);"></i>
                </div>
                <span class="text-dark d-block" style="font-size: 0.8rem;">Others</span>
            </a>
        </div>
    </div>

    {{-- Top Sales Section --}}
    @include('pages.home.sections.top-sales', ['topSalesProducts' => $topSalesProducts])

    {{-- New Listings Section --}}
    @include('pages.home.sections.new-listings', ['newListingProducts' => $newListingProducts])
    </div>
@endsection