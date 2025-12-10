@extends('layouts.merchant')

@section('title', 'Manage Branches')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Branches</h1>
        <a href="{{ route('merchant.branches.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg me-1"></i> Add Branch
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
                            <th class="ps-4">Name</th>
                            <th>Address</th>
                            <th>Contact</th>
                            <th class="text-end pe-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($branches as $branch)
                            <tr>
                                <td class="ps-4 fw-bold">{{ $branch->name }}</td>
                                <td>{{ Str::limit($branch->address, 50) }}</td>
                                <td>{{ $branch->contact_number ?? '-' }}</td>
                                <td class="text-end pe-4">
                                    <a href="{{ route('merchant.branches.edit', $branch->id) }}"
                                        class="btn btn-sm btn-light me-1">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('merchant.branches.destroy', $branch->id) }}" method="POST"
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
                                <td colspan="4" class="text-center py-5 text-muted">
                                    No branches found. <a href="{{ route('merchant.branches.create') }}">Create one</a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($branches->hasPages())
            <div class="card-footer bg-white border-0 py-3">
                {{ $branches->links() }}
            </div>
        @endif
    </div>
@endsection