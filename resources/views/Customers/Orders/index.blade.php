### 18.3 Customer Orders Index
**File: `resources/views/customers/orders/index.blade.php`**
```html
@extends('layouts.customer')

@section('title', 'Riwayat Pesanan')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2>Riwayat Pesanan</h2>
                <a href="{{ route('customers.dashboard') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Kembali ke Dashboard
                </a>
            </div>
            
            @include('components.alert')
            
            <!-- Filter Status -->
            <div class="card mb-4">
                <div class="card-body">
                    <form method="GET" action="{{ route('customers.orders.index') }}">
                        <div class="row align-items-end">
                            <div class="col-md-3">
                                <label for="status" class="form-label">Filter Status</label>
                                <select class="form-select" id="status" name="status">
                                    <option value="">Semua Status</option>
                                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Menunggu</option>
                                    <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>Diproses</option>
                                    <option value="shipped" {{ request('status') == 'shipped' ? 'selected' : '' }}>Dikirim</option>
                                    <option value="delivered" {{ request('status') == 'delivered' ? 'selected' : '' }}>Selesai</option>
                                    <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="date_from" class="form-label">Dari Tanggal</label>
                                <input type="date" class="form-control" id="date_from" name="date_from" 
                                       value="{{ request('date_from') }}">
                            </div>
                            <div class="col-md-3">
                                <label for="date_to" class="form-label">Sampai Tanggal</label>
                                <input type="date" class="form-control" id="date_to" name="date_to" 
                                       value="{{ request('date_to') }}">
                            </div>
                            <div class="col-md-3">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-filter me-2"></i>Filter
                                </button>
                                <a href="{{ route('customers.orders.index') }}" class="btn btn-outline-secondary">
                                    <i class="fas fa-times me-2"></i>Reset
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            
            <div class="card">
                <div class="card-body">
                    @if($orders->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Order ID</th>
                                        <th>Tanggal</th>
                                        <th>Total Items</th>
                                        <th>Total Harga</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($orders as $order)
                                        <tr>
                                            <td>
                                                <strong>#{{ $order->id }}</strong>
                                            </td>
                                            <td>{{ $order->created_at->format('d M Y H:i') }}</td>
                                            <td>{{ $order->orderItems->count() }} items</td>
                                            <td>
                                                <strong>Rp {{ number_format($order->total, 0, ',', '.') }}</strong>
                                            </td>
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
                                                    <i class="fas fa-eye me-1"></i>Detail
                                                </a>
                                                
                                                @if($order->status == 'pending')
                                                    <button class="btn btn-sm btn-outline-danger" 
                                                            onclick="confirmCancelOrder('{{ $order->id }}')">
                                                        <i class="fas fa-times me-1"></i>Batal
                                                    </button>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="d-flex justify-content-center mt-4">
                            {{ $orders->links() }}
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-shopping-cart fa-4x text-muted mb-3"></i>
                            <h4>Belum Ada Pesanan</h4>
                            <p class="text-muted">Anda belum memiliki pesanan apapun</p>
                            <a href="{{ route('products.index') }}" class="btn btn-primary">
                                <i class="fas fa-shopping-bag me-2"></i>Mulai Belanja
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Cancel Order Modal -->
<div class="modal fade" id="cancelOrderModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Konfirmasi Pembatalan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin membatalkan pesanan ini?</p>
                <p class="text-muted">Pembatalan tidak dapat dibatalkan.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tidak</button>
                <form id="cancelOrderForm" method="POST" style="display: inline;">
                    @csrf
                    @method('PUT')
                    <button type="submit" class="btn btn-danger">Ya, Batalkan</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function confirmCancelOrder(orderId) {
    const form = document.getElementById('cancelOrderForm');
    form.action = `/customers/orders/${orderId}/cancel`;
    const modal = new bootstrap.Modal(document.getElementById('cancelOrderModal'));
    modal.show();
}
</script>
@endsection
```

### 18.4 Customer Order Detail
**File: `resources/views/customers/orders/show.blade.php`**
```html
@extends('layouts.customer')

@section('title', 'Detail Pesanan #' . $order->id)

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2>Detail Pesanan #{{ $order->id }}</h2>
                <a href="{{ route('customers.orders.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Kembali ke Riwayat
                </a>
            </div>
            
            @include('components.alert')
            
            <div class="row">
                <!-- Order Information -->
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Informasi Pesanan</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <p><strong>Order ID:</strong> #{{ $order->id }}</p>
                                    <p><strong>Tanggal Pesanan:</strong> {{ $order->created_at->format('d M Y H:i') }}</p>
                                    <p><strong>Status:</strong> 
                                        @if($order->status == 'pending')
                                            <span class="badge bg-warning">Menunggu Konfirmasi</span>
                                        @elseif($order->status == 'processing')
                                            <span class="badge bg-info">Sedang Diproses</span>
                                        @elseif($order->status == 'shipped')
                                            <span class="badge bg-primary">Sedang Dikirim</span>
                                        @elseif($order->status == 'delivered')
                                            <span class="badge bg-success">Selesai</span>
                                        @else
                                            <span class="badge bg-danger">Dibatalkan</span>
                                        @endif
                                    </p>
                                </div>
                                <div class="col-md-6">
                                    <p><strong>Total Items:</strong> {{ $order->orderItems->count() }}</p>
                                    <p><strong>Total Harga:</strong> 
                                        <span class="fs-5 text-primary">Rp {{ number_format($order->total, 0, ',', '.') }}</span>
                                    </p>
                                    @if($order->notes)
                                        <p><strong>Catatan:</strong> {{ $order->notes }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Order Items -->
                    <div class="card mt-4">
                        <div class="card-header">
                            <h5 class="mb-0">Detail Items</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Produk</th>
                                            <th>Harga</th>
                                            <th>Jumlah</th>
                                            <th>Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($order->orderItems as $item)
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        @if($item->product->image)
                                                            <img src="{{ asset('storage/' . $item->product->image) }}" 
                                                                 class="rounded me-3" 
                                                                 style="width: 50px; height: 50px; object-fit: cover;">
                                                        @else
                                                            <div class="bg-light rounded me-3 d-flex align-items-center justify-content-center" 
                                                                 style="width: 50px; height: 50px;">
                                                                <i class="fas fa-image text-muted"></i>
                                                            </div>
                                                        @endif
                                                        <div>
                                                            <h6 class="mb-1">{{ $item->product->name }}</h6>
                                                            <small class="text-muted">{{ $item->product->category->name }}</small>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                                                <td>{{ $item->quantity }}</td>
                                                <td>
                                                    <strong>Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</strong>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th colspan="3">Total</th>
                                            <th>
                                                <span class="fs-5 text-primary">
                                                    Rp {{ number_format($order->total, 0, ',', '.') }}
                                                </span>
                                            </th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Customer Information -->
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Informasi Pelanggan</h5>
                        </div>
                        <div class="card-body">
                            <p><strong>Nama:</strong> {{ $order->customer_name }}</p>
                            <p><strong>Email:</strong> {{ $order->customer_email }}</p>
                            <p><strong>No. Telepon:</strong> {{ $order->customer_phone }}</p>
                            <p><strong>Alamat:</strong></p>
                            <p class="text-muted">{{ $order->customer_address }}</p>
                        </div>
                    </div>
                    
                    <!-- Order Actions -->
                    <div class="card mt-4">
                        <div class="card-header">
                            <h5 class="mb-0">Aksi</h5>
                        </div>
                        <div class="card-body">
                            <div class="d-grid gap-2">
                                @if($order->status == 'pending')
                                    <button class="btn btn-outline-danger" 
                                            onclick="confirmCancelOrder('{{ $order->id }}')">
                                        <i class="fas fa-times me-2"></i>Batalkan Pesanan
                                    </button>
                                @endif
                                
                                @if($order->status == 'delivered')
                                    <a href="{{ route('customers.orders.download-invoice', $order->id) }}" 
                                       class="btn btn-outline-success">
                                        <i class="fas fa-download me-2"></i>Download Invoice
                                    </a>
                                @endif
                                
                                <a href="{{ route('customers.orders.index') }}" 
                                   class="btn btn-outline-primary">
                                    <i class="fas fa-list me-2"></i>Lihat Semua Pesanan
                                </a>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Order Status Timeline -->
                    <div class="card mt-4">
                        <div class="card-header">
                            <h5 class="mb-0">Status Pesanan</h5>
                        </div>
                        <div class="card-body">
                            <div class="timeline">
                                <div class="timeline-item {{ $order->status == 'pending' ? 'active' : ($order->status != 'cancelled' ? 'completed' : '') }}">
                                    <div class="timeline-marker"></div>
                                    <div class="timeline-content">
                                        <h6>Pesanan Dibuat</h6>
                                        <small class="text-muted">{{ $order->created_at->format('d M Y H:i') }}</small>
                                    </div>
                                </div>
                                
                                <div class="timeline-item {{ $order->status == 'processing' ? 'active' : (in_array($order->status, ['shipped', 'delivered']) ? 'completed' : '') }}">
                                    <div class="timeline-marker"></div>
                                    <div class="timeline-content">
                                        <h6>Pesanan Diproses</h6>
                                        @if($order->status != 'pending' && $order->status != 'cancelled')
                                            <small class="text-muted">{{ $order->updated_at->format('d M Y H:i') }}</small>
                                        @endif
                                    </div>
                                </div>
                                
                                <div class="timeline-item {{ $order->status == 'shipped' ? 'active' : ($order->status == 'delivered' ? 'completed' : '') }}">
                                    <div class="timeline-marker"></div>
                                    <div class="timeline-content">
                                        <h6>Pesanan Dikirim</h6>
                                        @if(in_array($order->status, ['shipped', 'delivered']))
                                            <small class="text-muted">{{ $order->updated_at->format('d M Y H:i') }}</small>
                                        @endif
                                    </div>
                                </div>
                                
                                <div class="timeline-item {{ $order->status == 'delivered' ? 'active' : '' }}">
                                    <div class="timeline-marker"></div>
                                    <div class="timeline-content">
                                        <h6>Pesanan Selesai</h6>
                                        @if($order->status == 'delivered')
                                            <small class="text-muted">{{ $order->updated_at->format('d M Y H:i') }}</small>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Cancel Order Modal -->
<div class="modal fade" id="cancelOrderModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Konfirmasi Pembatalan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin membatalkan pesanan ini?</p>
                <p class="text-muted">Pembatalan tidak dapat dibatalkan.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tidak</button>
                <form id="cancelOrderForm" method="POST" style="display: inline;">
                    @csrf
                    @method('PUT')
                    <button type="submit" class="btn btn-danger">Ya, Batalkan</button>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
.timeline {
    position: relative;
    padding-left: 30px;
}

.timeline::before {
    content: '';
    position: absolute;
    left: 15px;
    top: 0;
    bottom: 0;
    width: 2px;
    background: #e9ecef;
}

.timeline-item {
    position: relative;
    margin-bottom: 20px;
}

.timeline-marker {
    position: absolute;
    left: -22px;
    top: 0;
    width: 12px;
    height: 12px;
    border-radius: 50%;
    background: #e9ecef;
    border: 2px solid #fff;
}

.timeline-item.active .timeline-marker {
    background: #007bff;
}

.timeline-item.completed .timeline-marker {
    background: #28a745;
}

.timeline-content h6 {
    margin-bottom: 2px;
    font-size: 14px;
}

.timeline-content small {
    font-size: 12px;
}
</style>

<script>
function confirmCancelOrder(orderId) {
    const form = document.getElementById('cancelOrderForm');
    form.action = `/customers/orders/${orderId}/cancel`;
    const modal = new bootstrap.Modal(document.getElementById('cancelOrderModal'));
    modal.show();
}
</script>
@endsection