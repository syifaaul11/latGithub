@extends('layouts.app')

@section('title', 'Beranda')

@section('content')
<!-- Hero Section -->
<section class="bg-primary text-white py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h1 class="display-4 fw-bold">Selamat Datang di Toko Online</h1>
                <p class="lead">Temukan berbagai produk berkualitas dengan harga terjangkau. Belanja mudah, aman, dan terpercaya!</p>
                <div class="mt-4">
                    <a href="{{ route('products.index') }}" class="btn btn-light btn-lg me-3">
                        <i class="fas fa-shopping-bag me-2"></i>Mulai Belanja
                    </a>
                    <a href="{{ route('about') }}" class="btn btn-outline-light btn-lg">
                        <i class="fas fa-info-circle me-2"></i>Tentang Kami
                    </a>
                </div>
            </div>
            <div class="col-lg-6">
                <img src="{{ asset('images/hero-image.jpg') }}" alt="Hero" class="img-fluid rounded shadow">
            </div>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="py-5">
    <div class="container">
        <div class="row text-center">
            <div class="col-md-4 mb-4">
                <div class="card h-100 shadow-sm">
                    <div class="card-body">
                        <i class="fas fa-shipping-fast fa-3x text-primary mb-3"></i>
                        <h5 class="card-title">Pengiriman Cepat</h5>
                        <p class="card-text">Barang sampai dalam 1-3 hari kerja ke seluruh Indonesia</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card h-100 shadow-sm">
                    <div class="card-body">
                        <i class="fas fa-shield-alt fa-3x text-success mb-3"></i>
                        <h5 class="card-title">Belanja Aman</h5>
                        <p class="card-text">Transaksi 100% aman dengan sistem keamanan terdepan</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card h-100 shadow-sm">
                    <div class="card-body">
                        <i class="fas fa-headset fa-3x text-info mb-3"></i>
                        <h5 class="card-title">Support 24/7</h5>
                        <p class="card-text">Tim customer service siap membantu Anda kapan saja</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Featured Products -->
@if($featuredProducts->count() > 0)
<section class="py-5 bg-light">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center mb-5">
                <h2 class="display-6">Produk Terlaris</h2>
                <p class="lead">Produk pilihan yang paling diminati pelanggan</p>
            </div>
        </div>
        <div class="row">
            @foreach($featuredProducts as $product)
            <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                <div class="card product-card h-100 shadow-sm">
                    <img src="{{ $product->image ? asset('storage/' . $product->image) : asset('images/no-image.jpg') }}" 
                         class="card-img-top" 
                         alt="{{ $product->name }}"
                         style="height: 200px; object-fit: cover;">
                    <div class="card-body d-flex flex-column">
                        <h6 class="card-title">{{ $product->name }}</h6>
                        <p class="card-text text-muted small flex-grow-1">
                            {{ Str::limit($product->description, 80) }}
                        </p>
                        <div class="mt-auto">
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="h6 mb-0 text-primary">
                                    Rp {{ number_format($product->price, 0, ',', '.') }}
                                </span>
                                <small class="text-muted">Stock: {{ $product->stock }}</small>
                            </div>
                            <a href="{{ route('products.show', $product->id) }}" 
                               class="btn btn-primary btn-sm mt-2 w-100">
                                <i class="fas fa-eye me-1"></i>Lihat Detail
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="row">
            <div class="col-12 text-center mt-4">
                <a href="{{ route('products.index') }}" class="btn btn-outline-primary btn-lg">
                    <i class="fas fa-arrow-right me-2"></i>Lihat Semua Produk
                </a>
            </div>
        </div>
    </div>
</section>
@endif

<!-- Categories -->
@if($categories->count() > 0)
<section class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center mb-5">
                <h2 class="display-6">Kategori Produk</h2>
                <p class="lead">Jelajahi berbagai kategori produk kami</p>
            </div>
        </div>
        <div class="row">
            @foreach($categories as $category)
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card category-card h-100 shadow-sm">
                    <div class="card-body text-center">
                        <i class="fas fa-tag fa-3x text-primary mb-3"></i>
                        <h5 class="card-title">{{ $category->name }}</h5>
                        <p class="card-text">{{ $category->products_count }} produk tersedia</p>
                        <a href="{{ route('products.index', ['category' => $category->id]) }}" 
                           class="btn btn-outline-primary">
                            <i class="fas fa-arrow-right me-1"></i>Lihat Produk
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- Call to Action -->
<section class="py-5 bg-primary text-white">
    <div class="container">
        <div class="row text-center">
            <div class="col-12">
                <h2 class="display-6 mb-4">Siap Mulai Berbelanja?</h2>
                <p class="lead mb-4">Daftar sekarang dan dapatkan penawaran menarik!</p>
                <div class="d-flex justify-content-center gap-3">
                    @guest
                        <a href="{{ route('register') }}" class="btn btn-light btn-lg">
                            <i class="fas fa-user-plus me-2"></i>Daftar Sekarang
                        </a>
                        <a href="{{ route('login') }}" class="btn btn-outline-light btn-lg">
                            <i class="fas fa-sign-in-alt me-2"></i>Login
                        </a>
                    @else
                        <a href="{{ route('products.index') }}" class="btn btn-light btn-lg">
                            <i class="fas fa-shopping-bag me-2"></i>Mulai Belanja
                        </a>
                    @endguest
                </div>
            </div>
        </div>
    </div>
</section>
@endsection