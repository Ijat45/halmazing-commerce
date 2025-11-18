@extends('layouts.admin')

@section('title', 'Merchant Applications')

@section('content')
    <div class="container-fluid">
        <h2 class="mb-4">Pending Merchant Applications</h2>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if ($pending->isEmpty())
            <div class="alert alert-info">No pending merchant applications.</div>
        @else
            <div class="row">
                @foreach ($pending as $applicant)
                    <div class="col-md-6 col-lg-4 mb-3">
                        <div class="card h-100">
                            <div class="card-body">
                                <h5 class="card-title">{{ $applicant->name }}</h5>
                                <p class="card-text text-muted small">{{ $applicant->email }}</p>
                                @if (!empty($applicant->merchant_info['business_name']))
                                    <p class="card-text"><strong>Business:</strong>
                                        {{ $applicant->merchant_info['business_name'] }}</p>
                                @endif
                                <p class="card-text"><small class="text-muted">Applied:
                                        {{ $applicant->created_at->toDayDateTimeString() }}</small></p>
                            </div>
                            <div class="card-footer bg-light">
                                <form method="POST" action="{{ route('admin.merchants.approve', $applicant) }}"
                                    class="d-inline">
                                    @csrf
                                    <button class="btn btn-sm btn-success">
                                        <i class="fa fa-check"></i> Approve
                                    </button>
                                </form>
                                <form method="POST" action="{{ route('admin.merchants.reject', $applicant) }}"
                                    class="d-inline">
                                    @csrf
                                    <button class="btn btn-sm btn-danger">
                                        <i class="fa fa-times"></i> Reject
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection
