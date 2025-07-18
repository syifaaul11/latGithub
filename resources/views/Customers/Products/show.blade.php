<!-- Lanjutan dari Customer Product Detail -->
            <!-- Product Specifications -->
            <div class="row mt-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Spesifikasi Produk</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <table class="table table-borderless">
                                        <tr>
                                            <td><strong>Nama Produk:</strong></td>
                                            <td>{{ $product->name }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Kategori:</strong></td>
                                            <td>{{ $product->category->name }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Harga:</strong></td>
                                            <td>Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="col-md-6">
                                    <table class="table table-borderless">
                                        <tr>
                                            <td><strong>Stok:</strong></td>
                                            <td>{{ $product->stock }} unit</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Ditambahkan:</strong></td>
                                            <td>{{ $product->created_at->format('d M Y') }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Terakhir Update:</strong></td>
                                            <td>{{ $product->updated_at->format('d M Y') }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Related Products -->
            @if($relatedProducts->count() > 0)
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">Produk Terkait</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    @foreach($relatedProducts as $relatedProduct)
                                        <div class="col-lg-3 col-md-4 col-sm-6 mb-3">
                                            <div class="card h-100">
                                                @if($relatedProduct->image)
                                                    <img src="{{ asset('storage/' . $relatedProduct->image) }}" 
                                                         class="card-img-top" 
                                                         style="height: 150px; object-fit: cover;">
                                                @else
                                                    <div class="card-img-top bg-light d-flex align-items-center justify-content-center" 
                                                         style="height: 150px;">
                                                        <i class="fas fa-image fa-2x text-muted"></i>
                                                    </div>
                                                @endif
                                                
                                                <div class="card-body">
                                                    <h6 class="card-title">{{ $relatedProduct->name }}</h6>
                                                    <p class="card-text">
                                                        <small class="text-primary">
                                                            Rp {{ number_format($relatedProduct->price, 0, ',', '.') }}
                                                        </small>
                                                    </p>
                                                    <a href="{{ route('customers.products.show', $relatedProduct->id) }}" 
                                                       class="btn btn-outline-primary btn-sm">
                                                        Lihat Detail
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<script>
function changeQuantity(change) {
    const quantityInput = document.getElementById('quantity');
    const currentValue = parseInt(quantityInput.value);
    const newValue = currentValue + change;
    const maxStock = parseInt(quantityInput.max);
    
    if (newValue >= 1 && newValue <= maxStock) {
        quantityInput.value = newValue;
    }
}

function addToCart(productId) {
    const quantity = document.getElementById('quantity').value;
    
    fetch('/customers/cart/add', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            product_id: productId,
            quantity: quantity
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showAlert('success', `${quantity} produk berhasil ditambahkan ke keranjang!`);
        } else {
            showAlert('error', data.message || 'Gagal menambahkan produk ke keranjang');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showAlert('error', 'Terjadi kesalahan saat menambahkan produk ke keranjang');
    });
}

function buyNow(productId) {
    const quantity = document.getElementById('quantity').value;
    
    // Add to cart first
    fetch('/customers/cart/add', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            product_id: productId,
            quantity: quantity
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Redirect to checkout
            window.location.href = '/customers/cart/checkout';
        } else {
            showAlert('error', data.message || 'Gagal melakukan pembelian');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showAlert('error', 'Terjadi kesalahan saat melakukan pembelian');
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