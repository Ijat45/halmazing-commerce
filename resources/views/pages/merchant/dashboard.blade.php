@extends('layouts.merchant')

@section('title', 'Dashboard')

@section('content')
    <h1 class="h3 mb-4 text-gray-800">Overview</h1>

    <div class="row g-4 mb-4">
        <!-- Products Card -->
        <div class="col-xl-3 col-md-6">
            <div class="card border-left-primary shadow h-100 py-2 border-0 border-start border-4 border-primary">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Products</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['products_count'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-box-seam fa-2x text-gray-300"></i>
                        </div>
                    </div>
                    <a href="{{ route('merchant.products.index') }}" class="stretched-link"></a>
                </div>
            </div>
        </div>

        <!-- Branches Card -->
        <div class="col-xl-3 col-md-6">
            <div class="card border-left-success shadow h-100 py-2 border-0 border-start border-4 border-success">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Branches</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['branches_count'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-geo-alt fa-2x text-gray-300"></i>
                        </div>
                    </div>
                    <a href="{{ route('merchant.branches.index') }}" class="stretched-link"></a>
                </div>
            </div>
        </div>

        <!-- Placeholder for Orders -->
        <div class="col-xl-3 col-md-6">
            <div class="card border-left-info shadow h-100 py-2 border-0 border-start border-4 border-info">
                <div class="card-body">
                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Orders</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">--</div>
                    <small>Coming Soon</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Quick Actions</h6>
        </div>
        <div class="card-body">
            <a href="{{ route('merchant.products.create') }}" class="btn btn-primary btn-icon-split me-2">
                <span class="icon text-white-50">
                    <i class="bi bi-plus-lg"></i>
                </span>
                <span class="text">Add New Product</span>
            </a>
            <a href="{{ route('merchant.branches.create') }}" class="btn btn-success btn-icon-split">
                <span class="icon text-white-50">
                    <i class="bi bi-shop-window"></i>
                </span>
                <span class="text">Open New Branch</span>
            </a>
        </div>
    </div>
@endsection