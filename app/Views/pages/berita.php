<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>Berita<?= $this->endSection() ?>

<?= $this->section('content') ?>

<!-- Header Section -->
<div class="bg-blue-900 text-white pt-32 pb-16 relative overflow-hidden">
    <div class="absolute top-0 left-0 w-full h-full overflow-hidden z-0 opacity-10">
        <svg viewBox="0 0 100 100" preserveAspectRatio="none" class="absolute w-full h-full">
            <polygon fill="white" points="0,100 100,0 100,100"/>
        </svg>
    </div>
    
    <div class="container mx-auto px-6 max-w-6xl text-center relative z-10">
        <h1 class="text-4xl font-extrabold mb-4 tracking-tight">Berita</h1>
        <p class="text-blue-200 text-lg max-w-2xl mx-auto">
            Pusat informasi, berita terkini, pengumuman resmi, dan dokumentasi kegiatan.
        </p>
    </div>
</div>

<!-- Layout Utama -->
<div class="container mx-auto px-6 py-12 max-w-7xl">
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-10">

        <!-- KONTEN KIRI: Daftar Berita -->
        <div class="lg:col-span-3">
            
            <!-- Search Bar -->
            <form action="<?= base_url('berita') ?>" method="GET" class="mb-8">
                <?php if($activeKategori): ?>
                    <input type="hidden" name="kategori" value="<?= esc($activeKategori) ?>">
                <?php endif; ?>
                
                <div class="relative flex items-center w-full max-w-2xl">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <i class="fas fa-search text-gray-400"></i>
                    </div>
                    <input type="text" name="q" value="<?= esc($keyword ?? '') ?>" placeholder="Cari berita atau pengumuman..." class="w-full pl-11 pr-24 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none shadow-sm transition-all text-gray-700">
                    <button type="submit" class="absolute inset-y-1.5 right-1.5 bg-blue-600 hover:bg-blue-700 text-white px-4 py-1.5 rounded-lg text-sm font-semibold transition">
                        Cari
                    </button>
                </div>
            </form>

            <!-- Pesan jika tidak ada hasil -->
            <div class="space-y-8">
                <?php if(empty($berita)): ?>
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-12 text-center">
                        <div class="text-gray-400 mb-3"><i class="fas fa-search text-4xl"></i></div>
                        <h3 class="text-lg font-bold text-gray-700">Berita tidak ditemukan</h3>
                        <p class="text-gray-500 mt-2">Coba gunakan kata kunci lain atau pilih kategori yang berbeda.</p>
                        <?php if($keyword || $activeKategori): ?>
                            <a href="<?= base_url('berita') ?>" class="inline-block mt-4 text-blue-600 font-semibold hover:underline">Reset Pencarian</a>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>

                <?php foreach($berita as $item): ?>
                <!-- Kartu Berita -->
                <article class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-xl hover:border-blue-100 transition-all duration-300 flex flex-col sm:flex-row group">
                    <div class="w-full sm:w-2/5 aspect-video sm:aspect-[4/3] relative overflow-hidden bg-gray-100 shrink-0">
                        <?php $imgSrc = $item['thumbnail'] ? base_url('uploads/berita/' . $item['thumbnail']) : 'https://placehold.co/600x400'; ?>
                        <img src="<?= $imgSrc ?>" alt="<?= esc($item['judul']) ?>" class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
                    </div>
                    
                    <div class="p-6 flex flex-col flex-grow w-full">
                        <div class="flex flex-wrap items-center justify-between mb-4 gap-2">
                            <?php
                                $badgeColor = match(strtolower($item['kategori'])) {
                                    'prestasi'   => 'bg-emerald-50 text-emerald-700 border-emerald-100',
                                    'pengumuman' => 'bg-red-50 text-red-700 border-red-100',
                                    'kegiatan'   => 'bg-purple-50 text-purple-700 border-purple-100',
                                    default      => 'bg-blue-50 text-blue-700 border-blue-100'
                                };
                            ?>
                            <span class="<?= $badgeColor ?> border px-3 py-1 text-xs font-bold rounded-full uppercase tracking-wider">
                                <?= esc($item['kategori']) ?>
                            </span>
                            
                            <!-- Penanda Waktu Diperbarui -->
                            <div class="flex flex-col sm:items-end text-gray-400 text-xs sm:text-sm">
                                <span><i class="far fa-calendar-alt mr-1"></i> <?= date('d M Y', strtotime($item['created_at'])) ?></span>
                                <?php if(strtotime($item['updated_at']) > strtotime($item['created_at'])): ?>
                                    <span class="mt-0.5 text-[11px] text-gray-400 italic"><i class="fas fa-pen-alt mr-1"></i> Diperbarui <?= date('d M Y, H:i', strtotime($item['updated_at'])) ?></span>
                                <?php endif; ?>
                            </div>
                        </div>
                        
                        <h3 class="text-2xl font-bold text-gray-900 mb-3 leading-snug">
                            <a href="<?= base_url('berita/baca/' . $item['slug']) ?>" class="hover:text-blue-600 transition-colors">
                                <?= esc($item['judul']) ?>
                            </a>
                        </h3>
                        
                        <p class="text-gray-600 mb-6 line-clamp-2">
                            <?= esc($item['subteks']) ?>
                        </p>
                        
                        <div class="mt-auto flex justify-between items-center">
                            <span class="text-xs text-gray-400 font-medium">Oleh: <?= esc($item['penulis'] ?? 'Admin') ?></span>
                            <a href="<?= base_url('berita/baca/' . $item['slug']) ?>" class="inline-flex items-center text-blue-600 font-semibold hover:text-blue-800 transition-colors">
                                Baca Selengkapnya 
                                <i class="fas fa-arrow-right ml-2 text-sm transform group-hover:translate-x-2 transition-transform duration-300"></i>
                            </a>
                        </div>
                    </div>
                </article>
                <?php endforeach; ?>
            </div>

            <!-- Pagination Dynamic -->
            <?php if (!empty($berita) && $pager && $pager->getPageCount('default') > 1) : ?>
                <div class="flex justify-center md:justify-start mt-10 pt-6 border-t border-gray-100">
                    <?= $pager->links('default', 'tailwind_pagination') ?>
                </div>
            <?php endif; ?>

        </div>

        <!-- KONTEN KANAN: Sidebar -->
        <div class="lg:col-span-1">
            
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sticky top-28">
                <h4 class="text-lg font-bold text-gray-900 mb-6 flex items-center">
                    <span class="w-2 h-6 bg-blue-600 rounded-full mr-3"></span>
                    Topik Berita
                </h4>

                <ul class="space-y-2">
                    <!-- Link Reset (Semua Berita) -->
                    <li>
                        <a href="<?= base_url('berita') ?>" class="<?= empty($activeKategori) ? 'bg-blue-50 text-blue-700' : 'text-gray-600 hover:bg-blue-50 hover:text-blue-700' ?> flex justify-between items-center px-4 py-3 rounded-xl font-medium transition-all group">
                            Semua Berita
                            <span class="bg-gray-100 text-gray-500 group-hover:bg-blue-100 group-hover:text-blue-700 text-xs py-1 px-2.5 rounded-full font-semibold transition-colors">
                                <?= array_sum($kategoriData) ?>
                            </span>
                        </a>
                    </li>
                    
                    <!-- Looping Daftar Kategori dari Database -->
                    <?php 
                    $listKategori = ['Pendidikan', 'Artikel', 'Prestasi', 'Kegiatan', 'Pengumuman'];
                    foreach($listKategori as $kat): 
                        // Ambil jumlah data, jika tidak ada berarti 0
                        $count = $kategoriData[$kat] ?? 0;
                        $isActive = ($activeKategori === $kat);
                    ?>
                    <li>
                        <a href="<?= base_url('berita?kategori=' . urlencode($kat)) ?>" class="<?= $isActive ? 'bg-blue-50 text-blue-700' : 'text-gray-600 hover:bg-blue-50 hover:text-blue-700' ?> flex justify-between items-center px-4 py-3 rounded-xl font-medium transition-all group">
                            <?= esc($kat) ?>
                            <span class="<?= $isActive ? 'bg-blue-100 text-blue-700' : 'bg-gray-100 text-gray-500 group-hover:bg-blue-100 group-hover:text-blue-700' ?> text-xs py-1 px-2.5 rounded-full font-semibold transition-colors">
                                <?= $count ?>
                            </span>
                        </a>
                    </li>
                    <?php endforeach; ?>
                </ul>
            </div>
            
        </div>

    </div>
</div>

<?= $this->endSection() ?>