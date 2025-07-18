@extends('layouts.app')

@section('title', 'Tentang Kami')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="text-center mb-5">
                <h1 class="display-4">Tentang Toko Online</h1>
                <p class="lead">Cerita perjalanan kami dalam melayani kebutuhan belanja Anda</p>
            </div>
            
            <div class="row">
                <div class="col-md-6">
                    <img src="{{ asset('images/about-us.jpg') }}" alt="About Us" class="img-fluid rounded shadow mb-4">
                </div>
                <div class="col-md-6">
                    <h3>Visi Kami</h3>
                    <p>Menjadi platform e-commerce terdepan yang menyediakan produk berkualitas dengan pelayanan terbaik untuk seluruh masyarakat Indonesia.</p>
                    
                    <h3>Misi Kami</h3>
                    <ul>
                        <li>Menyediakan produk berkualitas dengan harga terjangkau</li>
                        <li>Memberikan pengalaman belanja yang mudah dan menyenangkan</li>
                        <li>Melayani pelanggan dengan sepenuh hati</li>
                        <li>Mendukung pertumbuhan ekonomi digital Indonesia</li>
                    </ul>
                </div>
            </div>
            
            <div class="row mt-5">
                <div class="col-12">
                    <h3>Mengapa Memilih Kami?</h3>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="d-flex mb-3">
                                <i class="fas fa-check-circle text-success me-3 mt-1"></i>
                                <div>
                                    <h6>Produk Berkualitas</h6>
                                    <p class="text-muted">Semua produk telah melewati quality control ketat</p>
                                </div>
                            </div>
                            <div class="d-flex mb-3">
                                <i class="fas fa-check-circle text-success me-3 mt-1"></i>
                                <div>
                                    <h6>Harga Kompetitif</h6>
                                    <p class="text-muted">Dapatkan harga terbaik untuk setiap produk</p>
                                </div>
                            </div>
                            <div class="d-flex mb-3">
                                <i class="fas fa-check-circle text-success me-3 mt-1"></i>
                                <div>
                                    <h6>Pengiriman Cepat</h6>
                                    <p class="text-muted">Barang sampai dalam 1-3 hari kerja</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex mb-3">
                                <i class="fas fa-check-circle text-success me-3 mt-1"></i>
                                <div>
                                    <h6>Garansi Produk</h6>
                                    <p class="text-muted">Jaminan kualitas dan garansi resmi</p>
                                </div>
                            </div>
                            <div class="d-flex mb-3">
                                <i class="fas fa-check-circle text-success me-3 mt-1"></i>
                                <div>
                                    <h6>Customer Service</h6>
                                    <p class="text-muted">Tim support siap membantu 24/7</p>
                                </div>
                            </div>
                            <div class="d-flex mb-3">
                                <i class="fas fa-check-circle text-success me-3 mt-1"></i>
                                <div>
                                    <h6>Pembayaran Aman</h6>
                                    <p class="text-muted">Sistem pembayaran yang aman dan terpercaya</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="row mt-5">
                <div class="col-12">
                    <h3>Tim Kami</h3>
                    <div class="row">
                        <div class="col-md-4 text-center mb-4">
                            <div class="card shadow-sm">
                                <div class="card-body">
                                    <i class="fas fa-user-circle fa-4x text-primary mb-3"></i>
                                    <h5>John Doe</h5>
                                    <p class="text-muted">CEO & Founder</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 text-center mb-4">
                            <div class="card shadow-sm">
                                <div class="card-body">
                                    <i class="fas fa-user-circle fa-4x text-success mb-3"></i>
                                    <h5>Jane Smith</h5>
                                    <p class="text-muted">CTO</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 text-center mb-4">
                            <div class="card shadow-sm">
                                <div class="card-body">
                                    <i class="fas fa-user-circle fa-4x text-info mb-3"></i>
                                    <h5>Mike Johnson</h5>
                                    <p class="text-muted">Head of Marketing</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection