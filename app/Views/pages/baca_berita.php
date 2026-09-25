<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?><?= esc($berita['judul']) ?><?= $this->endSection() ?>

<?= $this->section('content') ?>

<!-- Custom CSS untuk merapikan hasil dari Rich Text Editor -->
<style>
    .konten-berita h2, .konten-berita h3 { font-weight: bold; color: #1e293b; margin-top: 1.5em; margin-bottom: 0.5em; }
    .konten-berita h2 { font-size: 1.5rem; }
    .konten-berita h3 { font-size: 1.25rem; }
    .konten-berita p { margin-bottom: 1.25em; line-height: 1.8; color: #475569; }
    .konten-berita ul { list-style-type: disc; margin-left: 1.5em; margin-bottom: 1.25em; color: #475569; }
    .konten-berita ol { list-style-type: decimal; margin-left: 1.5em; margin-bottom: 1.25em; color: #475569; }
    .konten-berita a { color: #2563eb; text-decoration: underline; }
    .konten-berita img { max-width: 100%; height: auto; border-radius: 0.5rem; margin-top: 1em; margin-bottom: 1em; }
</style>

<!-- Header Section: Judul diletakkan di dalam banner biru agar megah -->
<div class="bg-blue-900 text-white pt-32 pb-20 relative overflow-hidden">
    <div class="container mx-auto px-6 max-w-5xl relative z-10">
        <!-- Badge Kategori -->
        <div class="mb-6">
            <span class="bg-blue-600/50 border border-blue-400/50 backdrop-blur-sm text-blue-100 px-4 py-1.5 text-xs font-bold rounded-full uppercase tracking-wider">
                <?= esc($berita['kategori']) ?>
            </span>
        </div>
        
        <!-- Judul -->
        <h1 class="text-3xl md:text-5xl font-extrabold mb-6 tracking-tight leading-tight">
            <?= esc($berita['judul']) ?>
        </h1>
        
        <!-- Meta Data (Penulis & Tanggal) -->
        <div class="flex flex-wrap items-center text-blue-200 text-sm gap-6">
            <span class="flex items-center"><i class="far fa-user mr-2"></i> Oleh <?= esc($berita['penulis'] ?? 'Admin') ?></span>
            <span class="flex items-center"><i class="far fa-calendar-alt mr-2"></i> <?= date('d F Y', strtotime($berita['created_at'])) ?></span>
            <span class="flex items-center"><i class="far fa-clock mr-2"></i> <?= date('H:i', strtotime($berita['created_at'])) ?> WIB</span>
        </div>
    </div>
</div>

<!-- Layout Utama -->
<div class="container mx-auto px-6 py-12 max-w-7xl -mt-10 relative z-20">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
        
        <!-- KONTEN KIRI: Isi Berita -->
        <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-gray-100 p-6 md:p-10">
            
            <!-- Gambar Thumbnail Besar -->
            <?php if($berita['thumbnail']): ?>
                <div class="w-full aspect-video rounded-xl overflow-hidden mb-10 bg-gray-100 border border-gray-100">
                    <img src="<?= base_url('uploads/berita/' . $berita['thumbnail']) ?>" alt="<?= esc($berita['judul']) ?>" class="w-full h-full object-cover">
                </div>
            <?php endif; ?>

            <!-- Tempat Isi Berita (Ter-Render HTML-nya) -->
            <div class="konten-berita text-lg">
                <!-- INGAT: Jangan pakai esc() di sini karena akan merusak tag HTML editor -->
                <?= $berita['konten'] ?>
            </div>
            
            <div class="mt-12 pt-6 border-t border-gray-100">
                <a href="<?= base_url('berita') ?>" class="inline-flex items-center text-blue-600 font-semibold hover:text-blue-800 transition">
                    <i class="fas fa-arrow-left mr-2 text-sm"></i> Kembali ke Indeks Berita
                </a>
            </div>
        </div>

        <!-- KONTEN KANAN: Sidebar -->
        <div class="lg:col-span-1">
            
            <!-- Widget: Berita Terbaru -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sticky top-28">
                <h4 class="text-lg font-bold text-gray-900 mb-6 flex items-center">
                    <span class="w-2 h-6 bg-blue-600 rounded-full mr-3"></span>
                    Berita Terbaru
                </h4>

                <div class="space-y-6">
                    <?php if(empty($beritaTerbaru)): ?>
                        <p class="text-gray-500 text-sm">Belum ada berita lainnya.</p>
                    <?php endif; ?>

                    <?php foreach($beritaTerbaru as $recent): ?>
                    <a href="<?= base_url('berita/baca/' . $recent['slug']) ?>" class="group block border-b border-gray-50 pb-5 last:border-0 last:pb-0">
                        <div class="text-xs text-blue-600 font-bold uppercase mb-2">
                            <?= esc($recent['kategori']) ?>
                        </div>
                        <h5 class="text-gray-800 font-bold mb-2 group-hover:text-blue-600 transition-colors line-clamp-3 leading-snug">
                            <?= esc($recent['judul']) ?>
                        </h5>
                        <span class="text-xs text-gray-400 flex items-center">
                            <i class="far fa-calendar-alt mr-1"></i> <?= date('d M Y', strtotime($recent['created_at'])) ?>
                        </span>
                    </a>
                    <?php endforeach; ?>
                </div>
            </div>
            
        </div>

    </div>
</div>

<?= $this->endSection() ?>