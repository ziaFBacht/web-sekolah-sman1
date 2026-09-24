<nav class="fixed w-full z-50 bg-white/80 backdrop-blur-md border-b border-gray-200 transition-all duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-20">
            <!-- Logo -->
            <div class="flex-shrink-0 flex items-center gap-3">
                <a href="<?= base_url('/') ?>">
                    <img src="<?= base_url('assets/images/logo.png') ?>" alt="Logo SMAN 1" class="w-10 h-10 object-contain">
                </a>
                <span class="font-bold text-2xl tracking-tight text-primary">SMA NEGERI 1 <span class="text-secondary">SEMARANG</span></span>
            </div>

            <!-- Menu Desktop -->
            <div class="hidden md:flex space-x-8 items-center">
                <a href="<?= base_url('/') ?>" class="text-gray-900 hover:text-primary font-medium transition">Beranda</a>
                <a href="<?= base_url('/profil') ?>" class="text-gray-700 hover:text-primary font-medium transition">Profil</a>
                <a href="#" class="text-gray-700 hover:text-primary font-medium transition">Akademik</a>
                <a href="<?= base_url('/berita') ?>" class="text-gray-700 hover:text-primary font-medium transition">Berita</a>
                <!-- Tombol CTA -->
                <a href="#" class="bg-primary hover:bg-blue-900 text-white px-6 py-2.5 rounded-full font-semibold transition shadow-lg shadow-blue-900/30">
                    Portal Siswa <i class="fas fa-arrow-right ml-2 text-sm"></i>
                </a>
            </div>
        </div>
    </div>
</nav>