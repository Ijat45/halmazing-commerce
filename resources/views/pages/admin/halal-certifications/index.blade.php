@extends('layouts.merchant')

@section('title', 'Halal Certifications')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Halal Certifications</h1>
        <a href="{{ route('merchant.halal-certifications.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg me-1"></i> Upload Certification
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4">Preview</th>
                            <th>Reference No.</th>
                            <th>Status/Expiry</th>
                            <th>Linked Product</th>
                            <th class="text-end pe-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($certifications as $cert)
                            <tr>
                                <td class="ps-4">
                                    <a href="{{ asset('storage/' . $cert->file_path) }}" target="_blank">
                                        <img src="{{ asset('storage/' . $cert->file_path) }}"
                                            class="rounded border object-fit-cover" width="50" height="50" alt="Cert">
                                    </a>
                                </td>
                                <td>{{ $cert->reference_number ?? 'N/A' }}</td>
                                <td>
                                    <div>
                                        @if($cert->expiry_date->isPast())
                                            <span class="badge bg-danger">Expired</span>
                                        @elseif($cert->expiry_date->diffInDays(now()) < 30)
                                            <span class="badge bg-warning text-dark">Expiring Soon</span>
                                        @else
                                            <span class="badge bg-success">Active</span>
                                        @endif
                                    </div>
                                    <small class="text-muted">{{ $cert->expiry_date->format('d M Y') }}</small>
                                </td>
                                <td>{{ $cert->product->name ?? 'None' }}</td>
                                <td class="text-end pe-4">
                                    <a href="{{ route('merchant.halal-certifications.edit', $cert->id) }}"
                                        class="btn btn-sm btn-light me-1">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('merchant.halal-certifications.destroy', $cert->id) }}" method="POST"
                                        class="d-inline" onsubmit="return confirm('Are you sure?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-light text-danger">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-5 text-muted">
                                    No certifications found. <a
                                        href="{{ route('merchant.halal-certifications.create') }}">Upload
                                        one</a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($certifications->hasPages())
            <div class="card-footer bg-white border-0 py-3">
                {{ $certifications->links() }}
            </div>
        @endif
    </div>
@endsection