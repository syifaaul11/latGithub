@extends('layouts.customer')

@section('title', 'Keranjang Belanja')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2>Keranjang Belanja</h2>
                <a href="{{ route('products.index') }}" class="btn btn-outline-primary">
                    <i class="fas fa-arrow-left me-2"></i>Lanjut Belanja
                </a>
            </div>
            
            @include('components.alert')
            
            @if(session('cart') && count(session('cart')) > 0)
                <div class="row">
                    <div class="col-lg-8">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">Items di Keranjang</h5>
                            </div>
                            <div class="card-body">
                                @php
                                    $total = 0;
                                @endphp
                                
                                @foreach(session('cart') as $id => $details)
                                    @php
                                        $subtotal = $details['price'] * $details['quantity'];
                                        $total += $subtotal;
                                    @endphp
                                    
                                    <div class="row align-items-center border-bottom py-3" id="cart-item-{{ $id }}">
                                        <div class="col-md-2">
                                            @if($details['image'])
                                                <img src="{{ asset('storage/' . $details['image']) }}" 
                                                     class="img-fluid rounded" 
                                                     style="width: 80px; height: 80px; object-fit: cover;">
                                            @else
                                                <div class="bg-light rounded d-flex align-items-center justify-content-center" 
                                                     style="width: 80px; height: 80px;">
                                                    <i class="fas fa-image text-muted"></i>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="col-md-4">
                                            <h6 class="mb-1">{{ $details['name'] }}</h6>
                                            <small class="text-muted">{{ $details['category'] }}</small>
                                        </div>
                                        <div class="col-md-2">
                                            <span class="fw-bold">Rp {{ number_format($details['price'], 0, ',', '.') }}</span>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="input-group">
                                                <button class="btn btn-outline-secondary btn-sm" 
                                                        onclick="updateQuantity('{{ $id }}', 'decrease')">
                                                    <i class="fas fa-minus"></i>
                                                </button>
                                                <input type="number" 
                                                       class="form-control form-control-sm text-center" 
                                                       value="{{ $details['quantity'] }}" 
                                                       min="1" 
                                                       id="quantity-{{ $id }}"
                                                       onchange="updateQuantity('{{ $id }}', 'set', this.value)">
                                                <button class="btn btn-outline-secondary btn-sm" 
                                                        onclick="updateQuantity('{{ $id }}', 'increase')">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <span class="fw-bold">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                                                <button class="btn btn-sm btn-outline-danger" 
                                                        onclick="removeFromCart('{{ $id }}')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                                
                                <div class="mt-3">
                                    <button class="btn btn-outline-danger" onclick="clearCart()">
                                        <i class="fas fa-trash me-2"></i>Kosongkan Keranjang
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-4">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">Ringkasan Belanja</h5>
                            </div>
                            <div class="card-body">
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Subtotal:</span>
                                    <span id="subtotal">Rp {{ number_format($total, 0, ',', '.') }}</span>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Ongkir:</span>
                                    <span>Rp 0</span>
                                </div>
                                <hr>
                                <div class="d-flex justify-content-between mb-3">
                                    <strong>Total:</strong>
                                    <strong class="text-primary" id="total">Rp {{ number_format($total, 0, ',', '.') }}</strong>
                                </div>
                                
                                <div class="d-grid">
                                    <a href="{{ route('customers.cart.checkout') }}" class="btn btn-primary">
                                        <i class="fas fa-credit-card me-2"></i>Checkout
                                    </a>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Coupon Code -->
                        <div class="card mt-4">
                            <div class="card-header">
                                <h6 class="mb-0">Kode Kupon</h6>
                            </div>
                            <div class="card-body">
                                <form method="POST" action="{{ route('customers.cart.apply-coupon') }}">
                                    @csrf
                                    <div class="input-group">
                                        <input type="text" 
                                               class="form-control" 
                                               name="coupon_code" 
                                               placeholder="Masukkan kode kupon">
                                        <button class="btn btn-outline-primary" type="submit">
                                            Gunakan
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-shopping-cart fa-4x text-muted mb-3"></i>
                    <h4>Keranjang Belanja Kosong</h4>
                    <p class="text-muted">Belum ada produk di keranjang Anda</p>
                    <a href="{{ route('products.index') }}" class="btn btn-primary">
                        <i class="fas fa-shopping-bag me-2"></i>Mulai Belanja
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>

<script>
function updateQuantity(productId, action, value = null) {
    let quantity = parseInt(document.getElementById('quantity-' + productId).value);
    
    if (action === 'increase') {
        quantity += 1;
    } else if (action === 'decrease' && quantity > 1) {
        quantity -= 1;
    } else if (action === 'set' && value >= 1) {
        quantity = parseInt(value);
    }
    
    // Update cart via AJAX
    fetch('/customers/cart/update', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            product_id: productId,
            quantity: quantity
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert('Gagal memperbarui keranjang');
        }
    });
}

function removeFromCart(productId) {
    if (confirm('Apakah Anda yakin ingin menghapus item ini dari keranjang?')) {
        fetch('/customers/cart/remove', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                product_id: productId
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Gagal menghapus item dari keranjang');
            }
        });
    }
}

function clearCart() {
    if (confirm('Apakah Anda yakin ingin mengosongkan keranjang?')) {
        fetch('/customers/cart/clear', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Gagal mengosongkan keranjang');
            }
        });
    }
}
</script>
@endsection