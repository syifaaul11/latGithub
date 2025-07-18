@extends('layout.index')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4>Detail Kategori: {{ $category->name }}</h4>
                    <div class="btn-group">
                        <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-warning">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <form method="POST" 
                              action="{{ route('categories.destroy', $category->id) }}" 
                              class="d-inline"
                              onsubmit="return confirm('Yakin ingin menghapus kategori ini? Semua produk dalam kategori ini akan ikut terhapus!')">
                            @csrf 
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">
                                <i class="fas fa-trash"></i> Hapus
                            </button>
                        </form>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            @if($category->image)
                                <img src="{{ asset('storage/' . $category->image) }}" 
                                     alt="{{ $category->name }}" 
                                     class="img-fluid rounded">
                            @else
                                <div class="bg-light p-5 text-center rounded">
                                    <i class="fas fa-image fa-3x text-muted"></i>
                                    <p class="text-muted mt-2">Tidak ada gambar</p>
                                </div>
                            @endif
                        </div>
                        <div class="col-md-8">
                            <table class="table table-borderless">
                                <tr>
                                    <th width="30%">Nama:</th>
                                    <td>{{ $category->name }}</td>
                                </tr>
                                <tr>
                                    <th>Deskripsi:</th>
                                    <td>{{ $category->description ?: 'Tidak ada deskripsi' }}</td>
                                </tr>
                                <tr>
                                    <th>Status:</th>
                                    <td>
                                        @if($category->is_active)
                                            <span class="badge bg-success">Aktif</span>
                                        @else
                                            <span class="badge bg-secondary">Nonaktif</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Jumlah Produk:</th>
                                    <td>
                                        <span class="badge bg-info">{{ $category->products_count }} produk</span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Dibuat:</th>
                                    <td>{{ $category->created_at->format('d M Y, H:i') }}</td>
                                </tr>
                                <tr>
                                    <th>Diupdate:</th>
                                    <td>{{ $category->updated_at->format('d M Y, H:i') }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5>Produk dalam Kategori</h5>
                    <a href="{{ route('products.create', ['category_id' => $category->id]) }}" 
                       class="btn btn-sm btn-primary">
                        <i class="fas fa-plus"></i> Tambah Produk
                    </a>
                </div>
                <div class="card-body">
                    @forelse($category->products as $product)
                        <div class="d-flex justify-content-between align-items-center mb-2 p-2 bg-light rounded">
                            <div>
                                <strong>{{ $product->name }}</strong><br>
                                <small class="text-muted">Rp {{ number_format($product->price, 0, ',', '.') }}</small>
                            </div>
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('products.show', $product->id) }}" 
                                   class="btn btn-info btn-sm">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('products.edit', $product->id) }}" 
                                   class="btn btn-warning btn-sm">
                                    <i class="fas fa-edit"></i>
                                </a>
                            </div>
                        </div>
                    @empty
                        <div class="text-center text-muted py-4">
                            <i class="fas fa-box-open fa-2x mb-2"></i>
                            <p>Belum ada produk dalam kategori ini</p>
                            <a href="{{ route('products.create', ['category_id' => $category->id]) }}" 
                               class="btn btn-sm btn-primary">
                                Tambah Produk Pertama
                            </a>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
    
    <div class="mt-3">
        <a href="{{ route('categories.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali ke Daftar Kategori
        </a>
    </div>
</div>
<h3>Produk dalam kategori ini:</h3>
@foreach($category->products as $product)
    <div class="product-item">
        <a href="{{ route('products.show', $product->id) }}">
            {{ $product->name }}
        </a>
    </div>
@endforeach
@endsection