@extends('layouts.customer')

@section('title', 'Checkout')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-12">
            <h2 class="mb-4">Checkout</h2>
            
            @include('components.alert')
            
            @if(session('cart') && count(session('cart')) > 0)
                <form method="POST" action="{{ route('customers.orders.store') }}">
                    @csrf
                    <div class="row">
                        <div class="col-lg-8">
                            <!-- Customer Information -->
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h5 class="mb-0">Informasi Pelanggan</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="customer_name" class="form-label">Nama Lengkap</label>
                                                <input type="text" 
                                                       class="form-control @error('customer_name') is-invalid @enderror" 
                                                       id="customer_name" 
                                                       name="customer_name" 
                                                       value="{{ old('customer_name', auth()->user()->name) }}" 
                                                       required>
                                                @error('customer_name')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="customer_email" class="form-label">Email</label>
                                                <input type="email" 
                                                       class="form-control @error('customer_email') is-invalid @enderror" 
                                                       id="customer_email" 
                                                       name="customer_email" 
                                                       value="{{ old('customer_email', auth()->user()->email) }}" 
                                                       required>
                                                @error('customer_email')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="customer_phone" class="form-label">No. Telepon</label>
                                                <input type="text" 
                                                       class="form-control @error('customer_phone') is-invalid @enderror" 
                                                       id="customer_phone" 
                                                       name="customer_phone" 
                                                       value="{{ old('customer_phone', auth()->user()->phone) }}" 
                                                       required>
                                                @error('customer_phone')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="shipping_method" class="form-label">Metode Pengiriman</label>
                                                <select class="form-select @error('shipping_method') is-invalid @enderror" 
                                                        id="shipping_method" 
                                                        name="shipping_method" 
                                                        required>
                                                    <option value="">Pilih Metode Pengiriman</option>
                                                    <option value="regular" {{ old('shipping_method') == 'regular' ? 'selected' : '' }}>
                                                        Regular (3-5 hari) - Gratis
                                                    </option>
                                                    <option value="express" {{ old('shipping_method') == 'express' ? 'selected' : '' }}>
                                                        Express (1-2 hari) - Rp 25.000
                                                    </option>
                                                    <option value="same_day" {{ old('shipping_method') == 'same_day' ? 'selected' : '' }}>
                                                        Same Day - Rp 50.000
                                                    </option>
                                                </select>
                                                @error('shipping_method')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="customer_address" class="form-label">Alamat Lengkap</label>
                                        <textarea class="form-control @error('customer_address') is-invalid @enderror" 
                                                  id="customer_address" 
                                                  name="customer_address" 
                                                  rows="3" 
                                                  required>{{ old('customer_address', auth()->user()->address) }}</textarea>
                                        @error('customer_address')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="notes" class="form-label">Catatan Pesanan (Opsional)</label>
                                        <textarea class="form-control @error('notes') is-invalid @enderror" 
                                                  id="notes" 
                                                  name="notes" 
                                                  rows="2" 
                                                  placeholder="Tambahkan catatan untuk pesanan Anda">{{ old('notes') }}</textarea>
                                        @error('notes')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Payment Method -->
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="mb-0">Metode Pembayaran</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-check">
                                                <input class="form-check-input" 
                                                       type="radio" 
                                                       name="payment_method" 
                                                       id="payment_cod" 
                                                       value="cod" 
                                                       {{ old('payment_method') == 'cod' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="payment_cod">
                                                    <strong>Cash on Delivery (COD)</strong>
                                                    <small class="d-block text-muted">Bayar saat barang tiba</small>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-check">
                                                <input class="form-check-input" 
                                                       type="radio" 
                                                       name="payment_method" 
                                                       id="payment_transfer" 
                                                       value="transfer" 
                                                       {{ old('payment_method') == 'transfer' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="payment_transfer">
                                                    <strong>Transfer Bank</strong>
                                                    <small class="d-block text-muted">Transfer ke rekening toko</small>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    @error('payment_method')
                                        <div class="text-danger mt-2">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-lg-4">
                            <!-- Order Summary -->
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="mb-0">Ringkasan Pesanan</h5>
                                </div>
                                <div class="card-body">
                                    @php
                                        $subtotal = 0;
                                    @endphp
                                    
                                    @foreach(session('cart') as $id => $details)
                                        @php
                                            $itemTotal = $details['price'] * $details['quantity'];
                                            $subtotal += $itemTotal;
                                        @endphp
                                        
                                        <div class="d-flex justify-content-between mb-2">
                                            <div>
                                                <small>{{ $details['name'] }}</small>
                                                <small class="text-muted d-block">{{ $details['quantity'] }} x Rp {{ number_format($details['price'], 0, ',', '.') }}</small>
                                            </div>
                                            <span>Rp {{ number_format($itemTotal, 0, ',', '.') }}</span>
                                        </div>
                                    @endforeach
                                    
                                    <hr>
                                    
                                    <div class="d-flex justify-content-between mb-2">
                                        <span>Subtotal:</span>
                                        <span>Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                                    </div>
                                    
                                    <div class="d-flex justify-content-between mb-2">
                                        <span>Ongkir:</span>
                                        <span id="shipping-cost">Rp 0</span>
                                    </div>
                                    
                                    <hr>
                                    
                                    <div class="d-flex justify-content-between mb-3">
                                        <strong>Total:</strong>
                                        <strong class="text-primary" id="total-cost">Rp {{ number_format($subtotal, 0, ',', '.') }}</strong>
                                    </div>
                                    
                                    <div class="d-grid gap-2">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-credit-card me-2"></i>Buat Pesanan
                                        </button>
                                        <a href="{{ route('customers.cart.index') }}" class="btn btn-outline-secondary">
                                            <i class="fas fa-arrow-left me-2"></i>Kembali ke Keranjang
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-shopping-cart fa-4x text-muted mb-3"></i>
                    <h4>Keranjang Kosong</h4>
                    <p class="text-muted">Tidak ada produk untuk di-checkout</p>
                    <a href="{{ route('products.index') }}" class="btn btn-primary">
                        <i class="fas fa-shopping-bag me-2"></i>Mulai Belanja
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const shippingMethod = document.getElementById('shipping_method');
    const shippingCost = document.getElementById('shipping-cost');
    const totalCost = document.getElementById('total-cost');
    const subtotal = {{ $subtotal ?? 0 }};
    
    shippingMethod.addEventListener('change', function() {
        let shipping = 0;
        
        switch(this.value) {
            case 'regular':
                shipping = 0;
                break;
            case 'express':
                shipping = 25000;
                break;
            case 'same_day':
                shipping = 50000;
                break;
        }
        
        shippingCost.textContent = 'Rp ' + shipping.toLocaleString('id-ID');
        totalCost.textContent = 'Rp ' + (subtotal + shipping).toLocaleString('id-ID');
    });
});
</script>
@endsection