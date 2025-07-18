@extends('layouts.app')

@section('title', 'Produk')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-lg-3">
            <!-- Filter Sidebar -->
            <div class="card shadow-sm mb-4">
                <div class="card-header">
                    <h6 class="mb-0">Filter Produk</h6>
                </div>
                <div class="card-body">
                    <form method="GET" action="{{ route('products.index') }}">
                        <!-- Search -->
                        <div class="mb-3">
                            <label for="search" class="form-label">Cari Produk</label>
                            <input type="text" 
                                   class="form-control" 
                                   id="search" 
                                   name="search" 
                                   value="{{ request('search') }}" 
                                   placeholder="Nama produk...">
                        </div>
                        
                        <!-- Category Filter -->
                        <div class="mb-3">
                            <label for="category" class="form-label">Kategori</label>
                            <select class="form-select" id="category" name="category">
                                <option value="">Semua Kategori</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" 
                                            {{ request('category') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        
                        <!-- Price Range -->
                        <div class="mb-3">
                            <label class="form-label">Rentang Harga</label>
                            <div class="row">
                                <div class="col-6">
                                    <input type="number" 
                                           class="form-control" 
                                           name="min_price" 
                                           value="{{ request('min_price') }}" 
                                           placeholder="Min">
                                </div>
                                <div class="col-6">
                                    <input type="number" 
                                           class="form-control" 
                                           name="max_price" 
                                           value="{{ request('max_price') }}" 
                                           placeholder="Max">
                                </div>
                            </div>
                        </div>
                        
                        <!-- Sort -->
                        <div class="mb-3">
                            <label for="sort" class="form-label">Urutkan</label>
                            <select class="form-select" id="sort" name="sort">
                                <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>
                                    Nama A-Z
                                </option>
                                <option value="name_desc" {{ request('sort') == 'name_desc' ? 'selected' : '' }}>
                                    Nama Z-A
                                </option>
                                <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>
                                    Harga Terendah
                                </option>
                                <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>
                                    Harga Tertinggi
                                </option>
                                <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>
                                    Terbaru
                                </option>
                            </select>
                        </div>
                        
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-search me-2"></i>Filter
                            </button>
                        </div>
                        
                        @if(request()->hasAny(['search', 'category', 'min_price', 'max_price', 'sort']))
                            <div class="d-grid mt-2">
                                <a href="{{ route('products.index') }}" class="btn btn-outline-secondary">
                                    <i class="fas fa-times me-2"></i>Reset Filter
                                </a>
                            </div>
                        @endif
                    </form>
                </div>
            </div>
        </div>
        
        <div class="col-lg-9">
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2>Produk</h2>
                    <p class="text-muted">Ditemukan {{ $products->total() }} produk</p>
                </div>
                
                <div class="d-flex gap-2">
                    <button class="btn btn-outline-secondary" id="gridView">
                        <i class="fas fa-th"></i>
                    </button>
                    <button class="btn btn-outline-secondary" id="listView">
                        <i class="fas fa-list"></i>
                    </button>
                </div>
            </div>
            
            <!-- Products Grid -->
            <div class="row" id="productsContainer">
                @forelse($products as $product)
                    <div class="col-lg-4 col-md-6 mb-4 product-item">
                        <div class="card product-card h-100 shadow-sm">
                            <div class="position-relative">
                                <img src="{{ $product->image ? asset('storage/' . $product->image) : asset('images/no-image.jpg') }}" 
                                     class="card-img-top" 
                                     alt="{{ $product->name }}"
                                     style="height: 200px; object-fit: cover;">
                                @if($product->stock <= 5)
                                    <span class="position-absolute top-0 start-0 badge bg-warning m-2">
                                        Stock Terbatas
                                    </span>
                                @endif
                            </div>
                            
                            <div class="card-body d-flex flex-column">
                                <h6 class="card-title">{{ $product->name }}</h6>
                                <p class="card-text text-muted small flex-grow-1">
                                    {{ Str::limit($product->description, 100) }}
                                </p>
                                <div class="mt-auto">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <span class="h6 mb-0 text-primary">
                                            Rp {{ number_format($product->price, 0, ',', '.') }}
                                        </span>
                                        <small class="text-muted">Stock: {{ $product->stock }}</small>
                                    </div>
                                    
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('products.show', $product->id) }}" 
                                           class="btn btn-outline-primary btn-sm flex-fill">
                                            <i class="fas fa-eye me-1"></i>Detail
                                        </a>
                                        @auth
                                            @if($product->stock > 0)
                                                <form method="POST" action="{{ route('cart.add', $product->id) }}" class="flex-fill">
                                                    @csrf
                                                    <button type="submit" class="btn btn-primary btn-sm w-100">
                                                        <i class="fas fa-cart-plus me-1"></i>Keranjang
                                                    </button>
                                                </form>
                                            @else
                                                <button class="btn btn-secondary btn-sm flex-fill" disabled>
                                                    <i class="fas fa-times me-1"></i>Habis
                                                </button>
                                            @endif
                                        @endauth
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="text-center py-5">
                            <i class="fas fa-search fa-3x text-muted mb-3"></i>
                            <h5>Produk tidak ditemukan</h5>
                            <p class="text-muted">Coba ubah filter pencarian Anda</p>
                            <a href="{{ route('products.index') }}" class="btn btn-primary">
                                <i class="fas fa-refresh me-2"></i>Lihat Semua Produk
                            </a>
                        </div>
                    </div>
                @endforelse
            </div>
            
            <!-- Pagination -->
            @if($products->hasPages())
                <div class="d-flex justify-content-center mt-4">
                    {{ $products->appends(request()->query())->links() }}
                </div>
            @endif
        </div>
    </div>
</div>

<script>
// Grid/List View Toggle
document.getElementById('gridView').addEventListener('click', function() {
    document.getElementById('productsContainer').className = 'row';
    document.querySelectorAll('.product-item').forEach(item => {
        item.className = 'col-lg-4 col-md-6 mb-4 product-item';
    });
});

document.getElementById('listView').addEventListener('click', function() {
    document.getElementById('productsContainer').className = 'row';
    document.querySelectorAll('.product-item').forEach(item => {
        item.className = 'col-12 mb-4 product-item';
    });
});
</script>
@endsection