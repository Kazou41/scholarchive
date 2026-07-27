<footer class="footer">
    <div class="container">
        <div class="footer-grid">
            <div class="footer-brand">
                <div style="display:flex;align-items:center;gap:0.5rem;">
                    <img src="{{ asset('images/logo-white.png') }}" alt="Scholarchive" style="height:24px;">
                </div>
                <p>Platform portofolio digital siswa untuk mendokumentasikan kompetensi dan kesiapan karier.</p>
            </div>
            <div>
                <h4>Platform</h4>
                <div class="footer-links">
                    <a href="{{ route('portfolio.search') }}">Jelajahi Portofolio</a>
                    <a href="{{ route('help') }}">Pusat Bantuan</a>
                    <a href="{{ route('login') }}">Masuk</a>
                </div>
            </div>
            <div>
                <h4>Fitur</h4>
                <div class="footer-links">
                    <a href="#">Portofolio Digital</a>
                    <a href="#">Generator CV AI</a>
                    <a href="#">Profil Siswa</a>
                </div>
            </div>
            <div>
                <h4>Kontak</h4>
                <div class="footer-links">
                    <a href="mailto:info@scholarchive.id">info@scholarchive.id</a>
                    <a href="#">SMKN 3 Yogyakarta</a>
                    <a href="#">Yogyakarta, Indonesia</a>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            &copy; {{ date('Y') }} Alzazo Khozetama. Hak cipta dilindungi.
        </div>
    </div>
</footer>
