<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<!-- 1. Foto Borderless (Hero Banner) -->
<div class="w-full h-64 md:h-[400px] bg-gray-700 relative">
    <!-- Ganti src dengan foto asli lingkungan atau gedung sekolah -->
    <img src="<?= base_url('assets/images/sman_1_semarang.jpg') ?>" alt="Banner Sekolah" class="w-full h-full object-cover">
</div>

<!-- 2. Teks Sejarah Sekolah (Rata Tengah) -->
<div class="container mx-auto px-6 py-16 max-w-4xl text-center">
    <h2 class="text-3xl font-bold text-gray-900 mb-6">PRIMA DALAM PRESTASI, SANTUN DALAM PERILAKU</h2>
    <p class="text-lg text-gray-600 leading-relaxed">
        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore.
    </p>
</div>

<!-- 3. Layout Zig-Zag -->
<div class="container mx-auto px-6 pb-24 max-w-5xl">
    
    <!-- Baris Zig-Zag 1: Teks Kiri, Gambar Kanan -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center mb-20">
        <div class="order-2 md:order-1">
            <h3 class="text-2xl font-bold text-gray-900 mb-4">Visi & Misi</h3>
            <p class="text-gray-600 leading-relaxed">
                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur vel risus mauris. Phasellus tristique viverra sapien ut venenatis. Suspendisse euismod risus eget libero varius, sit amet interdum lorem interdum.
            </p>
        </div>
        <div class="order-1 md:order-2">
            <!-- Ganti dengan tag img asli saat foto sudah tersedia -->
            <div class="w-full aspect-video bg-black rounded shadow-lg flex items-center justify-center">
                <span class="text-white/50 font-semibold">Placeholder Gambar</span>
            </div>
        </div>
    </div>

    <!-- Baris Zig-Zag 2: Gambar Kiri, Teks Kanan -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
        <!-- class order-1 pada mobile agar gambar tampil lebih dulu di layar kecil, namun di layar besar (md) urutannya dikembalikan ke kiri -->
        <div class="order-1">
            <!-- Ganti dengan tag img asli saat foto sudah tersedia -->
            <div class="w-full aspect-video bg-black rounded shadow-lg flex items-center justify-center">
                <span class="text-white/50 font-semibold">Placeholder Gambar</span>
            </div>
        </div>
        <div class="order-2">
            <h3 class="text-2xl font-bold text-gray-900 mb-4">Fasilitas Unggulan</h3>
            <p class="text-gray-600 leading-relaxed">
                Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. Praesent sit amet est vel eros semper vestibulum. Integer at tellus velit.
            </p>
        </div>
    </div>

</div>

<?= $this->endSection() ?>