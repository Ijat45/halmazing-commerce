@extends('layouts.superadmin')

@section('title', 'Manage Merchants')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Merchant Applications</h2>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Pending Applications --}}
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-warning-subtle">
            <h5 class="mb-0"><i class="bi bi-hourglass-split"></i> Pending Review</h5>
        </div>
        <div class="card-body p-0">
            @if($pending->count() > 0)
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Applicant</th>
                            <th>Business Name</th>
                            <th>Email</th>
                            <th>Applied At</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pending as $merchant)
                            <tr>
                                <td>{{ $merchant->name }}</td>
                                <td>{{ $merchant->merchant_info['business_name'] ?? 'N/A' }}</td>
                                <td>{{ $merchant->email }}</td>
                                <td>{{ $merchant->created_at->format('M d, Y H:i') }}</td>
                                <td class="text-end">
                                    <form action="{{ route('superadmin.merchants.approve', $merchant) }}" method="POST"
                                        class="d-inline">
                                        @csrf
                                        <button class="btn btn-sm btn-success me-1"
                                            onclick="return confirm('Approve this merchant?')">
                                            <i class="bi bi-check-lg"></i> Approve
                                        </button>
                                    </form>
                                    <form action="{{ route('superadmin.merchants.reject', $merchant) }}" method="POST"
                                        class="d-inline">
                                        @csrf
                                        <button class="btn btn-sm btn-danger" onclick="return confirm('Reject this merchant?')">
                                            <i class="bi bi-x-lg"></i> Reject
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="p-4 text-center text-muted">
                    No pending applications.
                </div>
            @endif
        </div>
    </div>

    {{-- Approved Merchants (Recent) --}}
    <div class="card shadow-sm">
        <div class="card-header bg-light">
            <h5 class="mb-0">Recently Approved</h5>
        </div>
        <div class="card-body p-0">
            <table class="table mb-0">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Business</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($approved as $merchant)
                        <tr>
                            <td>{{ $merchant->name }}</td>
                            <td>{{ $merchant->merchant_info['business_name'] ?? '-' }}</td>
                            <td><span class="badge bg-success">Active</span></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection