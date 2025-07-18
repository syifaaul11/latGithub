@extends('Layout.customer')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Detail Pesanan #{{ $order->order_number }}</h3>
                    <div class="card-tools">
                        <a href="{{ route('customers.orders') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <!-- Info Pesanan -->
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h5>Informasi Pesanan</h5>
                                </div>
                                <div class="card-body">
                                    <table class="table table-borderless">
                                        <tr>
                                            <td><strong>Nomor Pesanan:</strong></td>
                                            <td>{{ $order->order_number }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Tanggal Pesanan:</strong></td>
                                            <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Status:</strong></td>
                                            <td>
                                                <span class="badge {{ $order->status_badge }}">
                                                    {{ $order->status_label }}
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Total Pembayaran:</strong></td>
                                            <td><strong>Rp {{ number_format($order->total_amount, 0, ',', '.') }}</strong></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Info Pengiriman -->
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h5>Informasi Pengiriman</h5>
                                </div>
                                <div class="card-body">
                                    <table class="table table-borderless">
                                        <tr>
                                            <td><strong>Nama Penerima:</strong></td>
                                            <td>{{ $order->user->name }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Nomor Telepon:</strong></td>
                                            <td>{{ $order->phone }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Alamat:</strong></td>
                                            <td>{{ $order->shipping_address }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Detail Produk -->
                    <div class="card mt-4">
                        <div class="card-header">
                            <h5>Detail Produk</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Produk</th>
                                            <th>Harga Satuan</th>
                                            <th>Jumlah</th>
                                            <th>Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($order->orderItems as $item)
                                        <tr>
                                            <td>{{ $item->product->name }}</td>
                                            <td>Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                                            <td>{{ $item->quantity }}</td>
                                            <td>Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th colspan="3">Total Pembayaran:</th>
                                            <th>Rp {{ number_format($order->total_amount, 0, ',', '.') }}</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Status Timeline -->
                    <div class="card mt-4">
                        <div class="card-header">
                            <h5>Status Pesanan</h5>
                        </div>
                        <div class="card-body">
                            <div class="timeline">
                                <div class="timeline-item {{ $order->status === 'pending' ? 'active' : ($order->status !== 'cancelled' ? 'completed' : '') }}">
                                    <div class="timeline-marker"></div>
                                    <div class="timeline-content">
                                        <h6>Pesanan Dibuat</h6>
                                        <p>{{ $order->created_at->format('d/m/Y H:i') }}</p>
                                    </div>
                                </div>
                                
                                <div class="timeline-item {{ $order->status === 'processing' ? 'active' : (in_array($order->status, ['shipped', 'delivered']) ? 'completed' : '') }}">
                                    <div class="timeline-marker"></div>
                                    <div class="timeline-content">
                                        <h6>Pesanan Diproses</h6>
                                        <p>{{ $order->status !== 'pending' && $order->status !== 'cancelled' ? $order->updated_at->format('d/m/Y H:i') : 'Menunggu' }}</p