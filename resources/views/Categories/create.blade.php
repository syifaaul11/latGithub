@extends('layout.index')

@section('content')
<div class="container">
    <h2>Tambah Kategori</h2>
    
    <form method="POST" action="{{ route('categories.store') }}" enctype="multipart/form-data">
        @csrf
        
        <div class="form-group">
            <label>Nama Kategori</label>
            <input type="text" name="name" class="form-control" required>
        </div>

        <div class="form-group">
            <label>jumlah produk</label>
            <input type="number" name="products_count" class="form-control" value="0" reandoly>
</div>

        <button type="submit" class="btn btn-success">Simpan</button>
        <a href="{{ route('categories.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection