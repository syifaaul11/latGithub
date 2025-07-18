<div class="py-3">
    <h5 class="text-center text-white">TOKO ONLINE</h5>
    <hr class="bg-white">
    
    <nav class="nav flex-column">
        <a class="nav-link text-white {{ request()->routeIs('dashboard') ? 'bg-primary' : '' }}" 
           href="{{ route('dashboard') }}">
            <i class="fas fa-tachometer-alt"></i> Dashboard
        </a>
        
        <a class="nav-link text-white {{ request()->routeIs('categories.*') ? 'bg-primary' : '' }}" 
           href="{{ route('categories.index') }}">
            <i class="fas fa-tags"></i> Kategori
        </a>
        
        <a class="nav-link text-white {{ request()->routeIs('products.*') ? 'bg-primary' : '' }}" 
           href="{{ route('products.index') }}">
            <i class="fas fa-box"></i> Produk
        </a>
        
        <a class="nav-link text-white {{ request()->routeIs('customers.*') ? 'bg-primary' : '' }}" 
           href="{{ route('customers.index') }}">
            <i class="fas fa-users"></i> Pelanggan
        </a>
        
        <a class="nav-link text-white {{ request()->routeIs('orders.*') ? 'bg-primary' : '' }}" 
           href="{{ route('orders.index') }}">
            <i class="fas fa-shopping-cart"></i> Order
        </a>
    </nav>
</div>