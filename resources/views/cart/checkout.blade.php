@extends('layouts.app')

@section('title', 'Checkout')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-12">
            <h2>Checkout</h2>
            
            @include('components.alert')
            
            @if($cartItems->count() > 0)
                <form method="POST" action="{{ route('orders.store') }}">
                    @csrf
                    <div class="row">
                        <div class="col-lg-8">
                            <!-- Shipping Information -->
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h5 class="mb-0">Informasi Pengiriman</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="name" class="form-label">Nama Lengkap</label>
                                                <input type="text" 
                                                       class="form-control @error('name') is-invalid @enderror" 
                                                       id="name" 
                                                       name="name" 
                                                       value="{{ old('name', auth()->user()->name) }}" 
                                                       required>
                                                @error('name')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="phone" class="form-label">No. Telepon</label>
                                                <input type="text" 
                                                       class="form-control @error('phone') is-invalid @enderror" 
                                                       id="phone" 
                                                       name="phone" 
                                                       value="{{ old('phone', auth()->user()->phone) }}" 
                                                       required>
                                                @error('phone')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" 
                                               class="form-control @error('email') is-invalid @enderror" 
                                               id="email" 
                                               name="email" 
                                               value="{{ old('email', auth()->user()->email) }}" 
                                               required>
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="address" class="form-label">Alamat Lengkap</label>
                                        <textarea class="form-control @error('address') is-invalid @enderror" 
                                                  id="address" 
                                                  name="address" 
                                                  rows="3" 
                                                  required>{{ old('address', auth()->user()->address) }}</textarea>
                                        @error('address')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Payment Method -->
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h5 class="mb-0">Metode Pembayaran</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-check mb-3">
                                                <input class="form-check-input" type="radio" name="payment_method" id="bank_transfer" value="bank_transfer" checked>
                                                <label class="form-check-label" for="bank_transfer">
                                                    <i class="fas fa-university me-2"></i>Transfer Bank
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-check mb-3">
                                                <input class="form-check-input" type="radio" name="payment_method" id="cod" value="cod">
                                                <label class="form-check-label" for="cod">
                                                    <i class="fas fa-money-bill-wave me-2"></i>Bayar di Tempat (COD)
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Notes -->
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="mb-0">Catatan Pesanan</h5>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <textarea class="form-control" 
                                                  name="notes" 
                                                  rows="3" 
                                                  placeholder="Catatan tambahan untuk pesanan Anda (opsional)">{{ old('notes') }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-lg-4">
                            <!-- Order Summary -->
                            <div class="card sticky-top">
                                <div class="card-header">
                                    <h5 class="mb-0">Ringkasan Pesanan</h5>
                                </div>
                                <div class="card-body">
                                    @foreach($cartItems as $item)
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <div>
                                                <h6 class="mb-0">{{ $item->product->name }}</h6>
                                                <small class="text-muted">{{ $item->quantity }}x Rp {{ number_format($item->product->price, 0, ',', '.') }}</small>
                                            </div>
                                            <span>Rp {{ number_format($item->product->price * $item->quantity, 0, ',', '.') }}</span>
                                        </div>
                                    @endforeach
                                    
                                    <hr>
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
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-check me-2"></i>Buat Pesanan
                                        </button>
                                        <a href="{{ route('cart.index') }}" class="btn btn-outline-secondary">
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
                    <i class="fas fa-shopping-cart fa-3x text-muted mb-3"></i>
                    <h4>Keranjang Belanja Kosong</h4>
                    <p class="text-muted mb-4">Tidak ada produk untuk checkout</p>
                    <a href="{{ route('products.index') }}" class="btn btn-primary">
                        <i class="fas fa-shopping-bag me-2"></i>Mulai Belanja
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection