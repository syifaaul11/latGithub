@extends('layout.index')

@section('title', 'Detail Pelanggan')
@section('page-title', 'Detail Pelanggan')

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5>Detail Pelanggan: {{ $customer->name }}</h5>
                <div>
                    <a href="{{ route('customers.edit', $customer->id) }}" class="btn btn-warning btn-sm">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                    <a href="{{ route('customers.index') }}" class="btn btn-secondary btn-sm">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <th width="150">Nama Lengkap:</th>
                                <td>{{ $customer->name }}</td>
                            </tr>
                            <tr>
                                <th>Email:</th>
                                <td>{{ $customer->email }}</td>
                            </tr>
                            <tr>
                                <th>Telepon:</th>
                                <td>{{ $customer->phone }}</td>
                            </tr>
                            <tr>
                                <th>Alamat:</th>
                                <td>{{ $customer->address }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <th width="150">Total Order:</th>
                                <td>
                                    <span class="badge bg-info">{{ $customer->orders->count() }} order</span>
                                </td>
                            </tr>
                            <tr>
                                <th>Total Belanja:</th>
                                <td>
                                    <strong class="text-success">
                                        Rp {{ number_format($customer->orders->sum('total_amount'), 0, ',', '.') }}
                                    </strong>
                                </td>
                            </tr>
                            <tr>
                                <th>Bergabung:</th>
                                <td>{{ $customer->created_at->format('d/m/Y H:i') }}</td>
                            </tr>
                            <tr>
                                <th>Diupdate:</th>
                                <td>{{ $customer->updated_at->format('d/m/Y H:i') }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Riwayat Order Pelanggan -->
<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5>Riwayat Order</h5>
                <a href="{{ route('orders.create', ['customer_id' => $customer->id]) }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus"></i> Buat Order Baru
                </a>
            </div>
            <div class="card-body">
                @if($customer->orders->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>No Order</th>
                                    <th>Tanggal</th>
                                    <th>Total Item</th>
                                    <th>Total Amount</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($customer->orders as $order)
                                <tr>
                                    <td>{{ $order->order_number }}</td>
                                    <td>{{ $order->created_at->format('d/m/Y') }}</td>
                                    <td>
                                        <span class="badge bg-secondary">{{ $order->orderItems->sum('quantity') }} item</span>
                                    </td>
                                    <td>
                                        <strong>Rp {{ number_format($order->total_amount, 0, ',', '.') }}</strong>
                                    </td>
                                    <td>
                                        <span class="badge bg-{{ $order->status == 'pending' ? 'warning' : ($order->status == 'completed' ? 'success' : 'info') }}">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('orders.show', $order->id) }}" 
                                           class="btn btn-info btn-sm">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i> Pelanggan ini belum pernah melakukan order.
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
```"
                                   {{ old('status') ? 'checked' : '' }}>
                            <label class="form-check-label" for="status">
                                Aktif
                            </label>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('categories.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection