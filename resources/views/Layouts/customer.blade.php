<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Customer Panel')</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    
    <style>
        .customer-sidebar {
            background-color: #f8f9fa;
            min-height: 80vh;
            padding: 20px;
        }
        .customer-sidebar .nav-link {
            color: #495057;
            margin-bottom: 10px;
        }
        .customer-sidebar .nav-link:hover {
            color: #0d6efd;
            background-color: #e9ecef;
        }
        .customer-sidebar .nav-link.active {
            color: #fff;
            background-color: #0d6efd;
        }
    </style>
</head>
<body>
    @include('components.navbar')
    
    <div class="container-fluid mt-4">
        <div class="row">
            <div class="col-md-3">
                <div class="customer-sidebar">
                    <div class="nav flex-column nav-pills">
                        <a class="nav-link {{ request()->routeIs('customer.dashboard') ? 'active' : '' }}" 
                           href="{{ route('customer.dashboard') }}">
                            <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                        </a>
                        <a class="nav-link {{ request()->routeIs('customer.profile') ? 'active' : '' }}" 
                           href="{{ route('customer.profile') }}">
                            <i class="fas fa-user me-2"></i>Profile
                        </a>
                        <a class="nav-link {{ request()->routeIs('customers.orders.*') ? 'active' : '' }}" 
                           href="{{ route('customers.orders.index') }}">
                            <i class="fas fa-shopping-bag me-2"></i>Pesanan Saya
                        </a>
                        <a class="nav-link {{ request()->routeIs('customers.cart.*') ? 'active' : '' }}" 
                           href="{{ route('customers.cart.index') }}">
                            <i class="fas fa-shopping-cart me-2"></i>Keranjang
                        </a>
                        <a class="nav-link" href="{{ route('products.index') }}">
                            <i class="fas fa-store me-2"></i>Belanja
                        </a>
                    </div>
                </div>
            </div>
            
            <div class="col-md-9">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif
                
                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif
                
                @yield('content')
            </div>
        </div>
    </div>
    
    @include('components.footer')
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    @stack('scripts')
</body>
</html>