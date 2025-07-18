@extends('layouts.customer')

@section('title', 'Dashboard')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-12">
            <h2>Dashboard</h2>
            <p class="text-muted">Selamat datang, {{ auth()->user()->name }}!</p>
            
            @include('components.alert')
            
            <!-- Statistics Cards -->
            <div class="row mb-4">
                <div class="col-md-3">
                    <div class="card text-center">
                        <div class="card-body">
                            <i class="fas fa-shopping-cart fa-2x text-primary mb-2"></i>
                            <h5>{{ $totalOrders }}</h5>
                            <p class="text-muted mb-0">Total Pesanan</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card text-center">
                        <div class="card-body">
                            <i class="fas fa-clock fa-2x text-warning mb-2"></i>
                            <h5>{{ $pendingOrders }}</h5>
                            <p class="text-muted mb-0">Menunggu Konfirmasi</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card text-center">
                        <div class="card-body">
                            <i class="fas fa-truck fa-2x text-info mb-2"></i>
                            <h5>{{ $processingOrders }}</h5>
                            <p class="text-muted mb-0">Sedang Diproses</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card text-center">
                        <div class="card-body">
                            <i class="fas fa-check-circle fa-2x text-success mb-2"></i>
                            <h5>{{ $completedOrders }}</h5>
                            <p class="text-muted mb-0">Selesai</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Recent Orders -->
            <div class="row">
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Pesanan Terbaru</h5>
                            <a href="{{ route('customers.orders.index') }}" class="btn btn-sm btn-outline-primary">
                                Lihat Semua
                            </a>
                        </div>
                        <div class="card-body">
                            @if($recentOrders->count() > 0)
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Order ID</th>
                                                <th>Tanggal</th>
                                                <th>Total</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($recentOrders as $order)
                                                <tr>
                                                    <td>#{{ $order->id }}</td>
                                                    <td>{{ $order->created_at->format('d M Y') }}</td>
                                                    <td>Rp {{ number_format($order->total, 0, ',', '.') }}</td>
                                                    <td>
                                                        @if($order->status == 'pending')
                                                            <span class="badge bg-warning">Menunggu</span>
                                                        @elseif($order->status == 'processing')
                                                            <span class="badge bg-info">Diproses</span>
                                                        @elseif($order->status == 'shipped')
                                                            <span class="badge bg-primary">Dikirim</span>
                                                        @elseif($order->status == 'delivered')
                                                            <span class="badge bg-success">Selesai</span>
                                                        @else
                                                            <span class="badge bg-danger">Dibatalkan</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <a href="{{ route('customers.orders.show', $order->id) }}" 
                                                           class="btn btn-sm btn-outline-primary">
                                                            Detail
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="text-center py-4">
                                    <i class="fas fa-shopping-cart fa-3x text-muted mb-3"></i>
                                    <h5>Belum Ada Pesanan</h5>
                                    <p class="text-muted">Mulai berbelanja untuk melihat pesanan Anda</p>
                                    <a href="{{ route('products.index') }}" class="btn btn-primary">
                                        <i class="fas fa-shopping-bag me-2"></i>Mulai Belanja
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Profil Saya</h5>
                        </div>
                        <div class="card-body">
                            <div class="text-center mb-3">
                                <i class="fas fa-user-circle fa-4x text-muted"></i>
                                <h6 class="mt-2">{{ auth()->user()->name }}</h6>
                                <p class="text-muted">{{ auth()->user()->email }}</p>
                            </div>
                            
                            <div class="d-grid gap-2">
                                <a href="{{ route('customers.profile') }}" class="btn btn-outline-primary">
                                    <i class="fas fa-edit me-2"></i>Edit Profil
                                </a>
                                <a href="{{ route('customers.orders.index') }}" class="btn btn-outline-secondary">
                                    <i class="fas fa-history me-2"></i>Riwayat Pesanan
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection