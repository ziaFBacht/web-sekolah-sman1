<?= $this->extend('layouts/guru') ?>

<?= $this->section('content') ?>

    <!-- Kontainer Kosong (Placeholder) -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8 h-full flex flex-col items-center justify-center min-h-[60vh]">
        <div class="text-gray-200 mb-4">
            <i class="fas fa-chalkboard-teacher text-6xl"></i>
        </div>
        <h2 class="text-2xl font-bold text-gray-700 mb-2">Selamat Datang, <?= esc($username ?? 'Guru') ?>!</h2>
        <p class="text-gray-500">Konten dashboard manajemen pengajaran saat ini sedang dipersiapkan.</p>
    </div>

<?= $this->endSection() ?>