@extends('layout.index')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Order Details - {{ $order->order_number }}</h5>
                    <div>
                        <a href="{{ route('orders.edit', $order) }}" class="btn btn-primary">
                            <i class="fas fa-edit"></i> Edit Order
                        </a>
                        <a href="{{ route('orders.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Back to Orders
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <div class="row">
                        <!-- Order Information -->
                        <div class="col-md-8">
                            <h6 class="card-subtitle mb-3 text-muted">Order Information</h6>
                            
                            <div class="row mb-3">
                                <div class="col-sm-4"><strong>Order Number:</strong></div>
                                <div class="col-sm-8">{{ $order->order_number }}</div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-sm-4"><strong>Status:</strong></div>
                                <div class="col-sm-8">
                                    <span class="badge 
                                        @switch($order->status)
                                            @case('pending') bg-warning @break
                                            @case('processing') bg-info @break
                                            @case('shipped') bg-primary @break
                                            @case('delivered') bg-success @break
                                            @case('cancelled') bg-danger @break
                                        @endswitch
                                    ">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-sm-4"><strong>Total Amount:</strong></div>
                                <div class="col-sm-8">
                                    <strong class="text-success">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</strong>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-sm-4"><strong>Payment Method:</strong></div>
                                <div class="col-sm-8">{{ ucfirst(str_replace('_', ' ', $order->payment_method)) }}</div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-sm-4"><strong>Order Date:</strong></div>
                                <div class="col-sm-8">{{ $order->created_at->format('d M Y, H:i') }}</div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-sm-4"><strong>Last Updated:</strong></div>
                                <div class="col-sm-8">{{ $order->updated_at->format('d M Y, H:i') }}</div>
                            </div>

                            <hr>

                            <!-- Customer Information -->
                            <h6 class="card-subtitle mb-3 text-muted">Customer Information</h6>
                            
                            <div class="row mb-3">
                                <div class="col-sm-4"><strong>Name:</strong></div>
                                <div class="col-sm-8">{{ $order->user->name }}</div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-sm-4"><strong>Email:</strong></div>
                                <div class="col-sm-8">{{ $order->user->email }}</div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-sm-4"><strong>Shipping Address:</strong></div>
                                <div class="col-sm-8">{{ $order->shipping_address }}</div>
                            </div>

                            @if($order->notes)
                                <hr>
                                <h6 class="card-subtitle mb-3 text-muted">Notes</h6>
                                <div class="alert alert-info">
                                    {{ $order->notes }}
                                </div>
                            @endif
                        </div>

                        <!-- Order Image -->
                        <div class="col-md-4">
                            @if($order->order_image)
                                <h6 class="card-subtitle mb-3 text-muted">Order Image</h6>
                                <div class="text-center">
                                    <img src="{{ asset('storage/' . $order->order_image) }}" 
                                         alt="Order Image" 
                                         class="img-fluid rounded mb-3" 
                                         style="max-height: 300px; cursor: pointer;"
                                         onclick="openImageModal()">
                                    <br>
                                    <a href="{{ route('orders.downloadImage', $order) }}" 
                                       class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-download"></i> Download Image
                                    </a>
                                </div>
                            @else
                                <div class="text-center text-muted">
                                    <i class="fas fa-image fa-3x mb-3"></i>
                                    <p>No image uploaded</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <hr>

                    <!-- Order Items Section -->
                    <h6 class="card-subtitle mb-3 text-muted">Order Items</h6>
                    @if($order->orderItems && $order->orderItems->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th>Quantity</th>
                                        <th>Price</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($order->orderItems as $item)
                                        <tr>
                                            <td>{{ $item->product->name ?? 'Product not found' }}</td>
                                            <td>{{ $item->quantity }}</td>
                                            <td>Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                                            <td>Rp {{ number_format($item->quantity * $item->price, 0, ',', '.') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="alert alert-info">