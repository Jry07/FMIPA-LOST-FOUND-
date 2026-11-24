<footer class="site-footer">
    <div class="footer-container">
        <div class="footer-col">
            <h3 class="footer-brand">FMIPA Lost &amp; Found</h3>
            <p class="footer-desc">
                Sistem Informasi Terpusat Pengelolaan Barang Hilang dan Ditemukan di Lingkungan Fakultas Matematika dan Ilmu Pengetahuan Alam, Universitas Halu Oleo.
            </p>
        </div>
        <div class="footer-col">
            <h4 class="footer-heading">Tautan Penting</h4>
            <ul class="footer-links">
                <li><a href="{{ route('home') }}">Beranda</a></li>
                <li><a href="{{ route('cara-kerja') }}">Cara Kerja &amp; Panduan</a></li>
                <li><a href="{{ route('catalog.index') }}">Daftar Barang Temuan</a></li>
            </ul>
        </div>
        <div class="footer-col">
            <h4 class="footer-heading">Bantuan &amp; Pos Satpam</h4>
            <p class="footer-contact">
                Pos Keamanan FMIPA UHO<br>
                Gedung Perkuliahan FMIPA, Kampus Bumi Tridharma Anduonohu, Kendari.
            </p>
        </div>
    </div>
    <div class="footer-bottom">
        <p>&copy; {{ date('Y') }} Kelompok 2 (RPL) - FMIPA Universitas Halu Oleo. Hak Cipta Dilindungi.</p>
    </div>
</footer>
