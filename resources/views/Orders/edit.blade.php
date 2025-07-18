@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Edit Order - {{ $order->order_number }}</h5>
                    <div>
                        <a href="{{ route('orders.show', $order) }}" class="btn btn-info">
                            <i class="fas fa-eye"></i> View Order
                        </a>
                        <a href="{{ route('orders.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Back to Orders
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <form action="{{ route('orders.update', $order) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="user_id" class="form-label">Customer <span class="text-danger">*</span></label>
                                    <select class="form-select @error('user_id') is-invalid @enderror" 
                                            id="user_id" 
                                            name="user_id" 
                                            required>
                                        <option value="">Select Customer</option>
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}" 
                                                    {{ (old('user_id') ?? $order->user_id) == $user->id ? 'selected' : '' }}>
                                                {{ $user->name }} ({{ $user->email }})
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('user_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="total_amount" class="form-label">Total Amount <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text">Rp</span>
                                        <input type="number" 
                                               class="form-control @error('total_amount') is-invalid @enderror" 
                                               id="total_amount" 
                                               name="total_amount" 
                                               value="{{ old('total_amount') ?? $order->total_amount }}" 
                                               min="0" 
                                               step="0.01" 
                                               required>
                                    </div>
                                    @error('total_amount')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                                    <select class="form-select @error('status') is-invalid @enderror" 
                                            id="status" 
                                            name="status" 
                                            required>
                                        <option value="">Select Status</option>
                                        @foreach(['pending', 'processing', 'shipped', 'delivered', 'cancelled'] as $status)
                                            <option value="{{ $status }}" 
                                                    {{ (old('status') ?? $order->status) == $status ? 'selected' : '' }}>
                                                {{ ucfirst($status) }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="payment_method" class="form-label">Payment Method <span class="text-danger">*</span></label>
                                    <select class="form-select @error('payment_method') is-invalid @enderror" 
                                            id="payment_method" 
                                            name="payment_method" 
                                            required>
                                        <option value="">Select Payment Method</option>
                                        @foreach(['cash', 'credit_card', 'debit_card', 'bank_transfer', 'e_wallet'] as $method)
                                            <option value="{{ $method }}" 
                                                    {{ (old('payment_method') ?? $order->payment_method) == $method ? 'selected' : '' }}>
                                                {{ ucfirst(str_replace('_', ' ', $method)) }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('payment_method')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="shipping_address" class="form-label">Shipping Address <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('shipping_address') is-invalid @enderror" 
                                      id="shipping_address" 
                                      name="shipping_address" 
                                      rows="3" 
                                      required>{{ old('shipping_address') ?? $order->shipping_address }}</textarea>
                            @error('shipping_address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="order_image" class="form-label">Order Image</label>
                            
                            @if($order->order_image)
                                <div class="mb-3">
                                    <div class="d-flex align-items-center">
                                        <img src="{{ asset('storage/' . $order->order_image) }}" 
                                             alt="Current Image" 
                                             class="img-thumbnail me-3" 
                                             style="max-height: 100px;">
                                        <div>
                                            <p class="mb-1"><strong>Current Image:</strong></p>
                                            <p class="text-muted mb-0">{{ basename($order->order_image) }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            
                            <input type="file" 
                                   class="form-control @error('order_image') is-invalid @enderror" 
                                   id="order_image" 
                                   name="order_image" 
                                   accept="image/*"
                                   onchange="previewImage()">
                            <div class="form-text">
                                Maximum file size: 2MB. Supported formats: JPEG, PNG, JPG, GIF
                                @if($order->order_image)
                                    <br><em>Leave empty to keep current image</em>
                                @endif
                            </div>
                            @error('order_image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            
                            <!-- Image Preview -->
                            <div id="imagePreview" class="mt-3" style="display: none;">
                                <p class="mb-2"><strong>New Image Preview:</strong></p>
                                <img id="preview" src="#" alt="Image Preview" class="img-fluid" style="max-height: 200px;">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="notes" class="form-label">Notes</label>
                            <textarea class="form-control @error('notes') is-invalid @enderror" 
                                      id="notes" 
                                      name="notes" 
                                      rows="3" 
                                      placeholder="Additional notes or comments...">{{ old('notes') ?? $order->notes }}</textarea>
                            @error('notes')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="{{ route('orders.show', $order) }}" class="btn btn-secondary me-md-2">Cancel</a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Update Order
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function previewImage() {
    const file = document.getElementById('order_image').files[0];
    const preview = document.getElementById('preview');
    const previewContainer = document.getElementById('imagePreview');
    
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
            previewContainer.style.display = 'block';
        }
        reader.readAsDataURL(file);
    } else {
        previewContainer.style.display = 'none';
    }
}

// Format number input
document.getElementById('total_amount').addEventListener('input', function(e) {
    let value = e.target.value;
    // Remove non-numeric characters except decimal point
    value = value.replace(/[^0-9.]/g, '');
    e.target.value = value;
});
</script>
@endpush