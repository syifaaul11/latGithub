@extends('layouts.customer')

@section('title', 'Katalog Produk')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2>Katalog Produk</h2>
                <div class="d-flex gap-2">
                    <a href="{{ route('customers.cart.index') }}" class="btn btn-outline-primary">
                        <i class="fas fa-shopping-cart me-2"></i>Keranjang
                        @if(session('cart') && count(session('cart')) > 0)
                            <span class="badge bg-danger">{{ count(session('cart')) }}</span>
                        @endif
                    </a>
                </div>
            </div>
            
            @include('components.alert')
            
            <!-- Filter & Search -->
            <div class="card mb-4">
                <div class="card-body">
                    <form method="GET" action="{{ route('customers.products.index') }}">
                        <div class="row align-items-end">
                            <div class="col-md-3">
                                <label for="search" class="form-label">Cari Produk</label>
                                <input type="text" 
                                       class="form-control" 
                                       id="search" 
                                       name="search" 
                                       value="{{ request('search') }}" 
                                       placeholder="Nama produk...">
                            </div>
                            <div class="col-md-3">
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
                            <div class="col-md-3">
                                <label for="sort" class="form-label">Urutkan</label>
                                <select class="form-select" id="sort" name="sort">
                                    <option value="">Default</option>
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
                                </select>
                            </div>
                            <div class="col-md-3">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-search me-2"></i>Cari
                                </button>
                                <a href="{{ route('customers.products.index') }}" class="btn btn-outline-secondary">
                                    <i class="fas fa-times me-2"></i>Reset
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            
            <!-- Products Grid -->
            @if($products->count() > 0)
                <div class="row">
                    @foreach($products as $product)
                        <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                            <div class="card h-100">
                                <div class="position-relative">
                                    @if($product->image)
                                        <img src="{{ asset('storage/' . $product->image) }}" 
                                             class="card-img-top" 
                                             style="height: 200px; object-fit: cover;">
                                    @else
                                        <div class="card-img-top bg-light d-flex align-items-center justify-content-center" 
                                             style="height: 200px;">
                                            <i class="fas fa-image fa-3x text-muted"></i>
                                        </div>
                                    @endif
                                    
                                    @if($product->stock <= 0)
                                        <div class="position-absolute top-0 start-0 m-2">
                                            <span class="badge bg-danger">Habis</span>
                                        </div>
                                    @elseif($product->stock <= 5)
                                        <div class="position-absolute top-0 start-0 m-2">
                                            <span class="badge bg-warning">Stok Sedikit</span>
                                        </div>
                                    @endif
                                </div>
                                
                                <div class="card-body d-flex flex-column">
                                    <h6 class="card-title">{{ $product->name }}</h6>
                                    <p class="card-text text-muted small">{{ $product->category->name }}</p>
                                    <p class="card-text">
                                        <small class="text-muted">
                                            {{ Str::limit($product->description, 60) }}
                                        </small>
                                    </p>
                                    
                                    <div class="mt-auto">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <span class="h5 mb-0 text-primary">
                                                Rp {{ number_format($product->price, 0, ',', '.') }}
                                            </span>
                                            <small class="text-muted">Stok: {{ $product->stock }}</small>
                                        </div>
                                        
                                        <div class="d-grid gap-2">
                                            <a href="{{ route('customers.products.show', $product->id) }}" 
                                               class="btn btn-outline-primary btn-sm">
                                                <i class="fas fa-eye me-1"></i>Detail
                                            </a>
                                            
                                            @if($product->stock > 0)
                                                <button class="btn btn-primary btn-sm" 
                                                        onclick="addToCart('{{ $product->id }}')">
                                                    <i class="fas fa-shopping-cart me-1"></i>Tambah ke Keranjang
                                                </button>
                                            @else
                                                <button class="btn btn-secondary btn-sm" disabled>
                                                    <i class="fas fa-times me-1"></i>Stok Habis
                                                </button>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <!-- Pagination -->
                <div class="d-flex justify-content-center mt-4">
                    {{ $products->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-search fa-4x text-muted mb-3"></i>
                    <h4>Produk Tidak Ditemukan</h4>
                    <p class="text-muted">Tidak ada produk yang sesuai dengan pencarian Anda</p>
                    <a href="{{ route('customers.products.index') }}" class="btn btn-primary">
                        <i class="fas fa-refresh me-2"></i>Lihat Semua Produk
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>

<script>
function addToCart(productId) {
    fetch('/customers/cart/add', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            product_id: productId,
            quantity: 1
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Update cart badge
            const cartBadge = document.querySelector('.badge');
            if (cartBadge) {
                cartBadge.textContent = data.cart_count;
            }
            
            // Show success message
            showAlert('success', 'Produk berhasil ditambahkan ke keranjang!');
        } else {
            showAlert('error', data.message || 'Gagal menambahkan produk ke keranjang');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showAlert('error', 'Terjadi kesalahan saat menambahkan produk ke keranjang');
    });
}

function showAlert(type, message) {
    const alertDiv = document.createElement('div');
    alertDiv.className = `alert alert-${type === 'success' ? 'success' : 'danger'} alert-dismissible fade show`;
    alertDiv.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;
    
    const container = document.querySelector('.container');
    container.insertBefore(alertDiv, container.firstChild);
    
    // Auto dismiss after 3 seconds
    setTimeout(() => {
        alertDiv.remove();
    }, 3000);
}
</script>
@endsection