@extends('layout.customer')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4>Detail Pesanan #{{ $order->id }}</h4>
                    <a href="{{ route('customers.orders') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h5>Informasi Pesanan</h5>
                            <table class="table table-borderless">
                                <tr>
                                    <td><strong>No. Pesanan:</strong></td>
                                    <td>#{{ $order->id }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Tanggal:</strong></td>
                                    <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Status:</strong></td>
                                    <td>
                                        @php
                                            $statusClass = match($order->status ?? 'pending') {
                                                'completed', 'delivered' => 'success',
                                                'processing', 'shipped' => 'info',
                                                'pending' => 'warning',
                                                'cancelled' => 'danger',
                                                default => 'secondary'
                                            };
                                        @endphp
                                        <span class="badge badge-{{ $statusClass }}">
                                            {{ ucfirst($order->status ?? 'Pending') }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Total:</strong></td>
                                    <td>
                                        @if(isset($order->total))
                                            <strong>Rp {{ number_format($order->total, 0, ',', '.') }}</strong>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                </tr>
                            </table>
                        </div>
                        
                        <div class="col-md-6">
                            <h5>Informasi Pengiriman</h5>
                            <table class="table table-borderless">
                                <tr>
                                    <td><strong>Nama:</strong></td>
                                    <td>{{ $order->shipping_name ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Alamat:</strong></td>
                                    <td>{{ $order->shipping_address ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Kota:</strong></td>
                                    <td>{{ $order->shipping_city ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Kode Pos:</strong></td>
                                    <td>{{ $order->shipping_postal_code ?? '-' }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    
                    <hr>
                    
                    <h5>Item Pesanan</h5>
                    @if(isset($order->items) && $order->items->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Produk</th>
                                        <th>Harga</th>
                                        <th>Jumlah</th>
                                        <th>Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($order->items as $item)
                                    <tr>
                                        <td>{{ $item->product_name ?? 'Produk tidak diketahui' }}</td>
                                        <td>Rp {{ number_format($item->price ?? 0, 0, ',', '.') }}</td>
                                        <td>{{ $item->quantity ?? 0 }}</td>
                                        <td>Rp {{ number_format(($item->price ?? 0) * ($item->quantity ?? 0), 0, ',', '.') }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="alert alert-info">
                            <p>Detail item pesanan tidak tersedia.</p>
                        </div>
                    @endif
                    
                    @if(isset($order->notes) && $order->notes)
                        <hr>
                        <h5>Catatan</h5>
                        <div class="alert alert-light">
                            {{ $order->notes }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection