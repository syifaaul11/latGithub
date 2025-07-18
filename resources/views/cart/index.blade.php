@extends('layouts.app')

@section('title', 'Keranjang Belanja')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-12">
            <h2>Keranjang Belanja</h2>
            
            @include('components.alert')
            
            @if($cartItems->count() > 0)
                <div class="row">
                    <div class="col-lg-8">
                        <div class="card">
                            <div class="card-body">
                                @foreach($cartItems as $item)
                                    <div class="row cart-item mb-3 pb-3 border-bottom">
                                        <div class="col-md-2">
                                            <img src="{{ $item->product->image ? asset('storage/' . $item->product->image) : asset('images/no-image.jpg') }}" 
                                                 class="img-fluid rounded" 
                                                 alt="{{ $item->product->name }}"
                                                 style="height: 80px; object-fit: cover;">
                                        </div>
                                        <div class="col-md-4">
                                            <h6>{{ $item->product->name }}</h6>
                                            <p class="text-muted small mb-1">
                                                {{ $item->product->category->name ?? 'Tanpa Kategori' }}
                                            </p>
                                            <p class="text-primary mb-0">
                                                Rp {{ number_format($item->product->price, 0, ',', '.') }}
                                            </p>
                                        </div>
                                        <div class="col-md-3">
                                            <form method="POST" action="{{ route('cart.update', $item->id) }}" class="d-flex align-items-center">
                                                @csrf
                                                @method('PUT')
                                                <div class="input-group">
                                                    <button type="button" class="btn btn-outline-secondary btn-sm" onclick="decreaseQuantity({{ $item->id }})">-</button>
                                                    <input type="number" 
                                                           class="form-control form-control-sm text-center" 
                                                           name="quantity" 
                                                           value="{{ $item->quantity }}" 
                                                           min="1" 
                                                           max="{{ $item->product->stock }}"
                                                           id="quantity-{{ $item->id }}"
                                                           onchange="this.form.submit()">
                                                    <button type="button" class="btn btn-outline-secondary btn-sm" onclick="increaseQuantity({{ $item->id }}, {{ $item->product->stock }})">+</button>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="col-md-2">
                                            <p class="mb-0 fw-bold">
                                                Rp {{ number_format($item->product->price * $item->quantity, 0, ',', '.') }}
                                            </p>
                                        </div>
                                        <div class="col-md-1">
                                            <form method="POST" action="{{ route('cart.remove', $item->id) }}" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-outline-danger btn-sm" 
                                                        onclick="return confirm('Hapus item ini dari keranjang?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-4">
                        <div class="card sticky-top">
                            <div class="card-header">
                                <h5 class="mb-0">Ringkasan Belanja</h5>
                            </div>
                            <div class="card-body">
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Total Item:</span>
                                    <span>{{ $cartItems->sum('quantity') }}</span>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Subtotal:</span>
                                    <span>Rp {{ number_format($cartItems->sum(function($item) { return $item->product->price * $item->quantity; }), 0, ',', '.') }}</span>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Ongkir:</span>
                                    <span>Rp 15.000</span>
                                </div>
                                <hr>
                                <div class="d-flex justify-content-between mb-3">
                                    <strong>Total:</strong>
                                    <strong class="text-primary">
                                        Rp {{ number_format($cartItems->sum(function($item) { return $item->product->price * $item->quantity; }) + 15000, 0, ',', '.') }}
                                    </strong>
                                </div>
                                
                                <div class="d-grid gap-2">
                                    <a href="{{ route('orders.checkout') }}" class="btn btn-primary">
                                        <i class="fas fa-credit-card me-2"></i>Checkout
                                    </a>
                                    <a href="{{ route('products.index') }}" class="btn btn-outline-secondary">
                                        <i class="fas fa-arrow-left me-2"></i>Lanjut Belanja
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-shopping-cart fa-3x text-muted mb-3"></i>
                    <h4>Keranjang Belanja Kosong</h4>
                    <p class="text-muted mb-4">Belum ada produk di keranjang Anda</p>
                    <a href="{{ route('products.index') }}" class="btn btn-primary">
                        <i class="fas fa-shopping-bag me-2"></i>Mulai Belanja
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>

<script>
function increaseQuantity(itemId, maxStock) {
    const input = document.getElementById('quantity-' + itemId);
    const currentValue = parseInt(input.value);
    if (currentValue < maxStock) {
        input.value = currentValue + 1;
        input.form.submit();
    }
}

function decreaseQuantity(itemId) {
    const input = document.getElementById('quantity-' + itemId);
    const currentValue = parseInt(input.value);
    if (currentValue > 1) {
        input.value = currentValue - 1;
        input.form.submit();
    }
}
</script>
@endsection