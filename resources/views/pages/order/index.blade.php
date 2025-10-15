@extends('layouts.app')

@section('title', 'My Orders')

@section('content')
<div class="container my-5">
    <h1 class="mb-4 fw-bold">My Orders</h1>

    @if($orders->isEmpty())
        <div class="alert alert-info text-center">
            You have not placed any orders yet.
        </div>
    @else
        <div class="accordion" id="ordersAccordion">
            @foreach($orders as $order)
                <div class="accordion-item mb-3 border-0 shadow-sm rounded-4">
                    <h2 class="accordion-header" id="heading{{ $order->id }}">
                        <button class="accordion-button collapsed rounded-4" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $order->id }}" aria-expanded="false" aria-controls="collapse{{ $order->id }}">
                            <div class="d-flex justify-content-between w-100 pe-3">
                                <span>Order #{{ $order->order_number }}</span>
                                <span class="text-muted">{{ $order->created_at->format('M d, Y') }}</span>
                                <span class="badge bg-{{ $order->status == 'completed' ? 'success' : 'warning' }}">{{ ucfirst($order->status) }}</span>
                                <span class="fw-bold">@currency($order->total)</span>
                            </div>
                        </button>
                    </h2>
                    <div id="collapse{{ $order->id }}" class="accordion-collapse collapse" aria-labelledby="heading{{ $order->id }}" data-bs-parent="#ordersAccordion">
                        <div class="accordion-body">
                            <ul class="list-group list-group-flush">
                                @foreach($order->items as $item)
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <div>
                                            <h6 class="mb-0">{{ $item->name }}</h6>
                                            <small class="text-muted">Quantity: {{ $item->quantity }} @ @currency($item->price)</small>
                                        </div>
                                        <span class="fw-bold">@currency($item->total)</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="d-flex justify-content-center mt-4">
            {{ $orders->links('pagination::bootstrap-5') }}
        </div>
    @endif
</div>
@endsection