<footer class="footer bg-dark text-white mt-5">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <h5>Toko Online</h5>
                <p>Belanja online mudah dan terpercaya dengan berbagai pilihan produk berkualitas.</p>
                <div class="social-links">
                    <a href="#" class="text-white me-2"><i class="fab fa-facebook"></i></a>
                    <a href="#" class="text-white me-2"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="text-white me-2"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="text-white"><i class="fab fa-whatsapp"></i></a>
                </div>
            </div>
            
            <div class="col-md-4">
                <h5>Navigasi</h5>
                <ul class="list-unstyled">
                    <li><a href="{{ route('home') }}" class="text-white-50">Beranda</a></li>
                    <li><a href="{{ route('products.index') }}" class="text-white-50">Produk</a></li>
                    <li><a href="{{ route('about') }}" class="text-white-50">Tentang Kami</a></li>
                    <li><a href="{{ route('contact') }}" class="text-white-50">Kontak</a></li>
                </ul>
            </div>
            
            <div class="col-md-4">
                <h5>Kontak</h5>
                <p class="text-white-50">
                    <i class="fas fa-map-marker-alt me-2"></i>Jl. Contoh No. 123, Jakarta<br>
                    <i class="fas fa-phone me-2"></i>+62 123 456 7890<br>
                    <i class="fas fa-envelope me-2"></i>info@tokoonline.com
                </p>
            </div>
        </div>
        
        <hr class="my-4">
        
        <div class="row">
            <div class="col-md-12 text-center">
                <p class="mb-0">&copy; {{ date('Y') }} Toko Online. All rights reserved.</p>
            </div>
        </div>
    </div>
</footer>