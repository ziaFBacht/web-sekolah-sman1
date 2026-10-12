<?= $this->extend('layouts/siswa') ?>

<?= $this->section('content') ?>

    <!-- Kontainer Kosong (Placeholder) -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8 h-full flex flex-col items-center justify-center min-h-[60vh]">
        <div class="text-gray-200 mb-4">
            <i class="fas fa-cube text-6xl"></i>
        </div>
        <h2 class="text-2xl font-bold text-gray-700 mb-2">Selamat Datang, <?= esc($username ?? 'Siswa') ?>!</h2>
        <p class="text-gray-500">Konten dashboard saat ini sedang dipersiapkan dan dikosongkan sementara.</p>
    </div>

<?= $this->endSection() ?>