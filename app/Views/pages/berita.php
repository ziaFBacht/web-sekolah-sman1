<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<!-- Header Section -->
<div class="bg-blue-900 text-white pt-32 pb-16 relative overflow-hidden">
    <!-- Aksen background dekoratif -->
    <div class="absolute top-0 left-0 w-full h-full overflow-hidden z-0 opacity-10">
        <svg viewBox="0 0 100 100" preserveAspectRatio="none" class="absolute w-full h-full">
            <polygon fill="white" points="0,100 100,0 100,100"/>
        </svg>
    </div>
    
    <div class="container mx-auto px-6 max-w-6xl text-center relative z-10">
        <h1 class="text-4xl font-extrabold mb-4 tracking-tight">Portal Berita</h1>
        <p class="text-blue-200 text-lg max-w-2xl mx-auto">
            Pusat informasi, berita terkini, pengumuman resmi, dan dokumentasi kegiatan SMAN 1.
        </p>
    </div>
</div>

<!-- Layout Utama: Konten Kiri (Daftar Berita) & Kanan (Sidebar) -->
<div class="container mx-auto px-6 py-12 max-w-7xl">
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-10">

        <!-- KONTEN KIRI: Daftar Berita (Lebih lebar) -->
        <div class="lg:col-span-3 space-y-8">
            
            <!-- Kartu Berita 1 -->
            <article class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-xl hover:border-blue-100 transition-all duration-300 flex flex-col sm:flex-row group">
                <!-- Thumbnail -->
                <div class="w-full sm:w-2/5 aspect-video sm:aspect-auto relative overflow-hidden bg-gray-100 shrink-0">
                    <img src="https://via.placeholder.com/600x400/1e3a8a/FFFFFF?text=Pengumuman+Kelulusan" alt="Thumbnail" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
                </div>
                
                <!-- Konten Teks -->
                <div class="p-6 flex flex-col flex-grow w-full">
                    <div class="flex items-center justify-between mb-4">
                        <span class="bg-blue-50 text-blue-700 border border-blue-100 px-3 py-1 text-xs font-bold rounded-full uppercase tracking-wider">
                            Pendidikan
                        </span>
                        <span class="text-gray-400 text-sm flex items-center">
                            <i class="far fa-calendar-alt mr-2"></i> 05 Mei 2025
                        </span>
                    </div>
                    
                    <h3 class="text-2xl font-bold text-gray-900 mb-3 leading-snug hover:text-blue-600 transition-colors cursor-pointer">
                        Saatnya Pengumuman Kelulusan Siswa Tahun Ajaran 2024/2025
                    </h3>
                    
                    <p class="text-gray-600 mb-6 line-clamp-2">
                        Pengumuman Kelulusan Siswa Tahun Ajaran 2024/2025 beserta panduan pengambilan Surat Keterangan Lulus (SKL) yang akan dilaksanakan secara bertahap di sekolah.
                    </p>
                    
                    <!-- Tombol Selengkapnya (Teks dengan animasi panah) -->
                    <div class="mt-auto">
                        <a href="#" class="inline-flex items-center text-blue-600 font-semibold hover:text-blue-800 transition-colors">
                            Baca Selengkapnya 
                            <i class="fas fa-arrow-right ml-2 text-sm transform group-hover:translate-x-2 transition-transform duration-300"></i>
                        </a>
                    </div>
                </div>
            </article>

            <!-- Kartu Berita 2 -->
            <article class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-xl hover:border-blue-100 transition-all duration-300 flex flex-col sm:flex-row group">
                <div class="w-full sm:w-2/5 aspect-video sm:aspect-auto relative overflow-hidden bg-gray-100 shrink-0">
                    <img src="https://via.placeholder.com/600x400/10b981/FFFFFF?text=Olimpiade+Sains" alt="Thumbnail" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                </div>
                <div class="p-6 flex flex-col flex-grow w-full">
                    <div class="flex items-center justify-between mb-4">
                        <span class="bg-emerald-50 text-emerald-700 border border-emerald-100 px-3 py-1 text-xs font-bold rounded-full uppercase tracking-wider">
                            Prestasi
                        </span>
                        <span class="text-gray-400 text-sm flex items-center">
                            <i class="far fa-calendar-alt mr-2"></i> 02 April 2025
                        </span>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-3 leading-snug hover:text-blue-600 transition-colors cursor-pointer">
                        Siswa SMAN 1 Raih Medali Emas OSN Tingkat Provinsi
                    </h3>
                    <p class="text-gray-600 mb-6 line-clamp-2">
                        Prestasi membanggakan kembali diraih oleh perwakilan sekolah dalam ajang Olimpiade Sains Nasional (OSN) 2025 cabang Fisika dan Biologi.
                    </p>
                    <div class="mt-auto">
                        <a href="#" class="inline-flex items-center text-blue-600 font-semibold hover:text-blue-800 transition-colors">
                            Baca Selengkapnya 
                            <i class="fas fa-arrow-right ml-2 text-sm transform group-hover:translate-x-2 transition-transform duration-300"></i>
                        </a>
                    </div>
                </div>
            </article>

            <!-- Pagination Modern -->
            <div class="flex justify-center md:justify-start mt-10 pt-6 border-t border-gray-100">
                <nav class="inline-flex items-center gap-1">
                    <a href="#" class="p-2 w-10 h-10 flex items-center justify-center rounded-lg text-gray-500 hover:bg-gray-100 transition-colors">
                        <i class="fas fa-chevron-left text-sm"></i>
                    </a>
                    <a href="#" aria-current="page" class="w-10 h-10 flex items-center justify-center rounded-lg bg-blue-600 text-white font-semibold shadow-sm">1</a>
                    <a href="#" class="w-10 h-10 flex items-center justify-center rounded-lg text-gray-700 hover:bg-gray-100 font-medium transition-colors">2</a>
                    <a href="#" class="w-10 h-10 flex items-center justify-center rounded-lg text-gray-700 hover:bg-gray-100 font-medium transition-colors">3</a>
                    <span class="px-2 text-gray-400">...</span>
                    <a href="#" class="p-2 w-10 h-10 flex items-center justify-center rounded-lg text-gray-500 hover:bg-gray-100 transition-colors">
                        <i class="fas fa-chevron-right text-sm"></i>
                    </a>
                </nav>
            </div>

        </div>

        <!-- KONTEN KANAN: Sidebar -->
        <div class="lg:col-span-1">
            
            <!-- Widget: Kategori Berita -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sticky top-28">
                <!-- Judul Widget Modern -->
                <h4 class="text-lg font-bold text-gray-900 mb-6 flex items-center">
                    <span class="w-2 h-6 bg-blue-600 rounded-full mr-3"></span>
                    Topik Berita
                </h4>

                <!-- List Kategori Bersih -->
                <ul class="space-y-2">
                    <li>
                        <a href="#" class="flex justify-between items-center px-4 py-3 rounded-xl text-gray-600 hover:bg-blue-50 hover:text-blue-700 font-medium transition-all group">
                            Pendidikan
                            <span class="bg-gray-100 text-gray-500 group-hover:bg-blue-100 group-hover:text-blue-700 text-xs py-1 px-2.5 rounded-full font-semibold transition-colors">12</span>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="flex justify-between items-center px-4 py-3 rounded-xl text-gray-600 hover:bg-blue-50 hover:text-blue-700 font-medium transition-all group">
                            Artikel
                            <span class="bg-gray-100 text-gray-500 group-hover:bg-blue-100 group-hover:text-blue-700 text-xs py-1 px-2.5 rounded-full font-semibold transition-colors">8</span>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="flex justify-between items-center px-4 py-3 rounded-xl text-gray-600 hover:bg-blue-50 hover:text-blue-700 font-medium transition-all group">
                            Prestasi
                            <span class="bg-gray-100 text-gray-500 group-hover:bg-blue-100 group-hover:text-blue-700 text-xs py-1 px-2.5 rounded-full font-semibold transition-colors">24</span>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="flex justify-between items-center px-4 py-3 rounded-xl text-gray-600 hover:bg-blue-50 hover:text-blue-700 font-medium transition-all group">
                            Kegiatan
                            <span class="bg-gray-100 text-gray-500 group-hover:bg-blue-100 group-hover:text-blue-700 text-xs py-1 px-2.5 rounded-full font-semibold transition-colors">15</span>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="flex justify-between items-center px-4 py-3 rounded-xl text-gray-600 hover:bg-blue-50 hover:text-blue-700 font-medium transition-all group">
                            Pengumuman
                            <span class="bg-gray-100 text-gray-500 group-hover:bg-blue-100 group-hover:text-blue-700 text-xs py-1 px-2.5 rounded-full font-semibold transition-colors">5</span>
                        </a>
                    </li>
                </ul>
            </div>
            
        </div>

    </div>
</div>

<?= $this->endSection() ?>