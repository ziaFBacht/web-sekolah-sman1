<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>Beranda<?= $this->endSection() ?>

<?= $this->section('content') ?>
<!-- Hero Section -->
<section class="relative h-screen flex items-center justify-center overflow-hidden bg-gray-900">
    <!-- Video Background & Dark Overlay -->
    <div class="absolute inset-0 z-0">
        <video autoplay loop muted playsinline class="w-full h-full object-cover pointer-events-none">
            <source src="<?= base_url('assets/videos/hero-bg.mp4') ?>" type="video/mp4">
        </video>
        
        <!-- Overlay hitam dengan opacity 70% agar video gelap dan teks menonjol -->
        <div class="absolute inset-0 bg-black/70"></div>

        <!-- Alternatif: Gradient Overlay (Hapus tanda komentar pada baris di bawah ini dan hapus baris bg-black/70 di atas jika ingin kembali memakai gradient) -->
        <!-- <div class="absolute inset-0 bg-gradient-to-r from-blue-900/80 to-gray-900/70"></div> -->
    </div>

    <!-- Teks Konten -->
    <div class="relative z-10 text-center px-4 sm:px-6 lg:px-8 max-w-5xl mx-auto mt-20">
        <!-- span class="inline-block py-1.5 px-4 rounded-full bg-secondary/20 text-secondary border border-secondary/50 text-sm font-bold tracking-wider mb-6 backdrop-blur-sm">
            PENDAFTARAN PPDB 2026 TELAH DIBUKA
        </span -->
        
        <h1 class="text-4xl sm:text-5xl md:text-7xl font-extrabold text-white tracking-tight mb-6 leading-tight drop-shadow-lg">
            Mencetak Generasi <br>
            <span class="text-secondary">Berprestasi & Berkarakter</span>
        </h1>
        
        <p class="text-lg sm:text-xl text-gray-200 mb-10 max-w-2xl mx-auto font-light leading-relaxed drop-shadow-md">
            Menjadi lembaga pendidikan terdepan yang mengintegrasikan teknologi modern dengan nilai-nilai budaya luhur.
        </p>
        
        <!-- Tombol Aksi -->
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            
            <!--a href="#" class="bg-secondary hover:bg-yellow-500 text-gray-900 px-8 py-4 rounded-full font-bold text-lg transition transform hover:-translate-y-1 shadow-xl flex items-center justify-center gap-2">
                Daftar PPDB Sekarang
            </a-->

            <a href="https://www.youtube.com/watch?v=8yyoXurZAk0" target="_blank" class="bg-white/10 hover:bg-white/20 backdrop-blur-md border border-white/30 text-white px-8 py-4 rounded-full font-bold text-lg transition flex items-center justify-center gap-2">
                <i class="fas fa-play-circle text-2xl"></i> Tonton Profil
            </a>
        </div>
    </div>
</section>
<!-- Section Informasi & Pengumuman -->
<section class="py-24 bg-white relative">
    <!-- Dekorasi Background Latar -->
    <div class="absolute top-0 left-0 w-full h-full overflow-hidden z-0 opacity-30 pointer-events-none">
        <div class="absolute -top-24 -right-24 w-96 h-96 rounded-full bg-blue-50 blur-3xl"></div>
        <div class="absolute top-1/2 -left-24 w-72 h-72 rounded-full bg-yellow-50 blur-3xl"></div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <!-- Section Header -->
        <div class="flex flex-col md:flex-row justify-between items-end mb-12 gap-6">
            <div class="max-w-2xl">
                <span class="text-primary font-bold tracking-wider uppercase text-sm mb-2 block">Pusat Informasi</span>
                <h2 class="text-3xl md:text-4xl font-extrabold text-gray-900">Kabar Terbaru & Agenda</h2>
            </div>
            <a href="#" class="hidden md:inline-flex items-center text-primary font-semibold hover:text-blue-900 transition group">
                Lihat Semua Mading 
                <i class="fas fa-arrow-right ml-2 transform group-hover:translate-x-1 transition"></i>
            </a>
        </div>

        <!-- Grid Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            
            <?php if(empty($berita_terbaru)): ?>
                <div class="col-span-1 md:col-span-2 lg:col-span-3 text-center py-10 text-gray-500">
                    Belum ada kabar atau agenda terbaru saat ini.
                </div>
            <?php else: ?>
                <?php foreach($berita_terbaru as $row): ?>
                    <?php 
                        // Menentukan warna dan icon badge berdasarkan kategori (Opsional)
                        $badgeClass = 'bg-blue-500 text-white';
                        $iconClass = 'fas fa-newspaper';
                        $kategori = strtolower($row['kategori']);
                        
                        if ($kategori == 'pengumuman') {
                            $badgeClass = 'bg-red-500 text-white';
                            $iconClass = 'fas fa-bell';
                        } elseif ($kategori == 'prestasi') {
                            $badgeClass = 'bg-primary text-white'; // Sesuaikan class bg-primary Anda
                            $iconClass = 'fas fa-trophy';
                        } elseif ($kategori == 'kegiatan' || $kategori == 'agenda') {
                            $badgeClass = 'bg-secondary text-gray-900'; // Sesuaikan class bg-secondary Anda
                            $iconClass = 'fas fa-calendar-check';
                        }
                    ?>
                    
                    <div class="bg-white rounded-2xl shadow-sm hover:shadow-xl border border-gray-100 overflow-hidden transition-all duration-300 hover:-translate-y-2 flex flex-col group">
                        <div class="relative h-52 bg-gray-200 overflow-hidden">
                            <!-- Menampilkan Gambar -->
                            <?php if(!empty($row['thumbnail'])): ?>
                                <img src="<?= base_url('uploads/berita/' . $row['thumbnail']) ?>" alt="<?= esc($row['judul']) ?>" class="w-full h-full object-cover transform group-hover:scale-110 transition duration-500">
                            <?php else: ?>
                                <div class="w-full h-full flex items-center justify-center bg-gray-300 text-gray-500">
                                    <i class="fas fa-image text-4xl"></i>
                                </div>
                            <?php endif; ?>
                            
                            <!-- Badge Kategori Dinamis -->
                            <div class="absolute top-4 left-4 <?= $badgeClass ?> text-xs font-bold px-3 py-1.5 rounded-full shadow-md flex items-center gap-2">
                                <i class="<?= $iconClass ?>"></i> <?= esc($row['kategori']) ?>
                            </div>
                        </div>
                        <div class="p-6 flex-grow flex flex-col">
                            <div class="text-sm text-gray-500 mb-3 flex items-center gap-2">
                                <!-- Format Tanggal -->
                                <i class="far fa-calendar-alt text-primary"></i> <?= date('d F Y', strtotime($row['created_at'])) ?>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900 mb-3 line-clamp-2 hover:text-primary transition">
                                <!-- Judul Dinamis -->
                                <?= esc($row['judul']) ?>
                            </h3>
                            <p class="text-gray-600 mb-6 line-clamp-3 text-sm flex-grow leading-relaxed">
                                <!-- Subteks Dinamis (Jika subteks kosong, ambil dari konten) -->
                                <?php 
                                    if(!empty($row['subteks'])) {
                                        echo esc($row['subteks']);
                                    }
                                ?>
                            </p>
                            <!-- Link ke Detail Berita -->
                            <a href="<?= base_url('berita/baca/' . $row['id']) ?>" class="mt-auto text-primary font-semibold hover:text-blue-800 flex items-center transition">
                                Baca Detail <i class="fas fa-chevron-right ml-2 text-xs"></i>
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
            
        </div>

        <!-- Tombol Mobile Show All -->
        <div class="mt-8 text-center md:hidden">
            <a href="#" class="inline-flex items-center justify-center px-6 py-3 border border-gray-300 rounded-full text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 transition w-full">
                Lihat Semua Kabar
            </a>
        </div>
    </div>
</section>
<?= $this->endSection() ?>