@extends('Layout.customer')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Buat Pesanan Baru</h3>
                    <div class="card-tools">
                        <a href="{{ route('customers.orders') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>
                <form action="{{ route('customers.orders.store') }}" method="POST" id="orderForm">
                    @csrf
                    <div class="card-body">
                        @if($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <!-- Pilih Produk -->
                        <div class="row">
                            <div class="col-md-8">
                                <div class="card">
                                    <div class="card-header">
                                        <h5>Pilih Produk</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            @foreach($products as $product)
                                            <div class="col-md-6 mb-3">
                                                <div class="card product-card" data-product-id="{{ $product->id }}">
                                                    <div class="card-body">
                                                        <h6 class="card-title">{{ $product->name }}</h6>
                                                        <p class="card-text">
                                                            <strong>Rp {{ number_format($product->price, 0, ',', '.') }}</strong><br>
                                                            <small class="text-muted">Stock: {{ $product->stock }}</small>
                                                        </p>
                                                        <div class="form-group">
                                                            <label>Jumlah:</label>
                                                            <input type="number" 
                                                                   class="form-control quantity-input" 
                                                                   min="0" 
                                                                   max="{{ $product->stock }}"
                                                                   value="0"
                                                                   data-price="{{ $product->price }}"
                                                                   data-name="{{ $product->name }}">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Keranjang & Info Pengiriman -->
                            <div class="col-md-4">
                                <!-- Keranjang -->
                                <div class="card">
                                    <div class="card-header">
                                        <h5>Keranjang Belanja</h5>
                                    </div>
                                    <div class="card-body">
                                        <div id="cart-items">
                                            <p class="text-muted text-center">Keranjang kosong</p>
                                        </div>
                                        <hr>
                                        <div class="d-flex justify-content-between">
                                            <strong>Total: </strong>
                                            <strong id="total-amount">Rp 0</strong>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Info Pengiriman -->
                                <div class="card mt-3">
                                    <div class="card-header">
                                        <h5>Info Pengiriman</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label>Nomor Telepon <span class="text-danger">*</span></label>
                                            <input type="text" 
                                                   name="phone" 
                                                   class="form-control @error('phone') is-invalid @enderror"
                                                   value="{{ old('phone') }}"
                                                   placeholder="08xxxxxxxxxx">
                                            @error('phone')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        
                                        <div class="form-group">
                                            <label>Alamat Pengiriman <span class="text-danger">*</span></label>
                                            <textarea name="shipping_address" 
                                                      class="form-control @error('shipping_address') is-invalid @enderror"
                                                      rows="3"
                                                      placeholder="Masukkan alamat lengkap">{{ old('shipping_address') }}</textarea>
                                            @error('shipping_address')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary" id="submitBtn" disabled>
                            <i class="fas fa-shopping-cart"></i> Buat Pesanan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    let cart = [];
    let totalAmount = 0;
    
    // Handle quantity change
    $('.quantity-input').on('input', function() {
        const productId = $(this).closest('.product-card').data('product-id');
        const quantity = parseInt($(this).val()) || 0;
        const price = parseFloat($(this).data('price'));
        const name = $(this).data('name');
        
        // Update cart
        const existingIndex = cart.findIndex(item => item.id === productId);
        
        if (quantity > 0) {
            if (existingIndex !== -1) {
                cart[existingIndex].quantity = quantity;
                cart[existingIndex].subtotal = price * quantity;
            } else {
                cart.push({
                    id: productId,
                    name: name,
                    price: price,
                    quantity: quantity,
                    subtotal: price * quantity
                });
            }
        } else {
            if (existingIndex !== -1) {
                cart.splice(existingIndex, 1);
            }
        }
        
        updateCartDisplay();
        updateSubmitButton();
    });
    
    function updateCartDisplay() {
        const cartContainer = $('#cart-items');
        cartContainer.empty();
        
        totalAmount = 0;
        
        if (cart.length === 0) {
            cartContainer.html('<p class="text-muted text-center">Keranjang kosong</p>');
        } else {
            cart.forEach(item => {
                totalAmount += item.subtotal;
                cartContainer.append(`
                    <div class="cart-item mb-2">
                        <small><strong>${item.name}</strong></small><br>
                        <small>${item.quantity} x Rp ${item.price.toLocaleString('id-ID')}</small><br>
                        <small><strong>Rp ${item.subtotal.toLocaleString('id-ID')}</strong></small>
                        <hr>
                    </div>
                `);
            });
        }
        
        $('#total-amount').text('Rp ' + totalAmount.toLocaleString('id-ID'));
    }
    
    function updateSubmitButton() {
        const hasItems = cart.length > 0;
        const hasAddress = $('textarea[name="shipping_address"]').val().trim() !== '';
        const hasPhone = $('input[name="phone"]').val().trim() !== '';
        
        $('#submitBtn').prop('disabled', !(hasItems && hasAddress && hasPhone));
    }
    
    // Check form validity on input
    $('textarea[name="shipping_address"], input[name="phone"]').on('input', updateSubmitButton);
    
    // Handle form submission
    $('#orderForm').on('submit', function(e) {
        // Add cart items to form
        cart.forEach((item, index) => {
            $(this).append(`
                <input type="hidden" name="products[${index}][id]" value="${item.id}">
                <input type="hidden" name="products[${index}][quantity]" value="${item.quantity}">
            `);
        });
    });
});
</script>
@endpush

@push('styles')
<style>
.product-card {
    border: 1px solid #ddd;
    transition: border-color 0.3s;
}

.product-card:hover {
    border-color: #007bff;
}

.cart-item {
    border-left: 3px solid #007bff;
    padding-left: 10px;
}

.quantity-input {
    width: 80px;
}
</style>
@endpush