@extends('layouts.app')

@section('title', $product->name)

@section('content')
<div class="container py-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Beranda</a></li>
            <li class="breadcrumb-item"><a href="{{ route('products.index') }}">Produk</a></li>
            @if($product->category)
                <li class="breadcrumb-item">
                    <a href="{{ route('products.index', ['category' => $product->category->id]) }}">
                        {{ $product->category->name }}
                    </a>
                </li>
            @endif
            <li class="breadcrumb-item active">{{ $product->name }}</li>
        </ol>
    </nav>
    
    <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <img src="{{ $product->image ? asset('storage/' . $product->image) : asset('images/no-image.jpg') }}" 
                         class="img-fluid rounded" 
                         alt="{{ $product->name }}"
                         style="width: 100%; height: 400px; object-fit: cover;">
                </div>
            </div>
        </div>
        
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <h1 class="card-title">{{ $product->name }}</h1>
                    
                    @if($product->category)
                        <p class="text-muted">
                            <i class="fas fa-tag me-1"></i>
                            <a href="{{ route('products.index', ['category' => $product->category->id]) }}" 
                               class="text-decoration-none">
                                {{ $product->category->name }}
                            </a>
                        </p>
                    @endif
                    
                    <div class="mb-3">
                        <span class="h3 text-primary">
                            Rp {{ number_format($product->price, 0, ',', '.') }}
                        </span>
                    </div>
                    
                    <div class="mb-3">
                        <strong>Stock:</strong> 
                        @if($product->stock > 0)
                            <span class="badge bg-success">{{ $product->stock }} tersedia</span>
                        @else
                            <span class="badge bg-danger">Habis</span>
                        @endif
                    </div>
                    
                    <div class="mb-4">
                        <h6>Deskripsi:</h6>
                        <p class="text-muted">{{ $product->description }}</p>
                    </div>
                    
                    @include('components.alert')
                    
                    @auth
                        @if($product->stock > 0)
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <form method="POST" action="{{ route('cart.add', $product->id) }}" id="addToCartForm">
                                        @csrf
                                        <div class="input-group mb-3">
                                            <span class="input-group-text">Jumlah</span>
                                            <input type="number" 
                                                   class="form-control" 
                                                   name="quantity" 
                                                   value="1" 
                                                   min="1" 
                                                   max="{{ $product->stock }}">
                                        </div>
                                        <button type="submit" class="btn btn-primary w-100">
                                            <i class="fas fa-cart-plus me-2"></i>Tambah ke Keranjang
                                        </button>
                                    </form>
                                </div>
                                <div class="col-md-6">
                                    <div class="d-grid">
                                        <a href="{{ route('orders.create', ['product_id' => $product->id]) }}" 
                                           class="btn btn-success">
                                            <i class="fas fa-shopping-cart me-2"></i>Beli Sekarang
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="alert alert-warning">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                Maaf, produk ini sedang habis stok
                            </div>
                        @endif
                    @else
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>
                            <a href="{{ route('login') }}">Login</a> untuk membeli produk ini
                        </div>
                    @endauth
                </div>
            </div>
        </div>
    </div>
    
    <!-- Related Products -->
    @if($relatedProducts->count() > 0)
        <div class="row mt-5">
            <div class="col-12">
                <h4>Produk Terkait</h4>
                <div class="row">
                    @foreach($relatedProducts as $relatedProduct)
                        <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                            <div class="card product-card h-100 shadow-sm">
                                <img src="{{ $relatedProduct->image ? asset('storage/' . $relatedProduct->image) : asset('images/no-image.jpg') }}" 
                                     class="card-img-top" 
                                     alt="{{ $relatedProduct->name }}"
                                     style="height: 150px; object-fit: cover;">
                                <div class="card-body d-flex flex-column">
                                    <h6 class="card-title">{{ $relatedProduct->name }}</h6>
                                    <div class="mt-auto">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <span class="h6 mb-0 text-primary">
                                                Rp {{ number_format($relatedProduct->price, 0, ',', '.') }}
                                            </span>
                                        </div>
                                        <a href="{{ route('products.show', $relatedProduct->id) }}" 
                                           class="btn btn-outline-primary btn-sm w-100">
                                            <i class="fas fa-eye me-1"></i>Lihat Detail
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif
</div>
@endsection