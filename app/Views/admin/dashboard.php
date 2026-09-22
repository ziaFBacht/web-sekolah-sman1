<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<!-- Statistik Card Grid -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 flex items-center">
        <div class="p-4 rounded-full bg-blue-100 text-blue-600 mr-4">
            <i class="fas fa-user-graduate text-2xl"></i>
        </div>
        <div>
            <p class="text-sm text-gray-500 font-semibold mb-1">Total Siswa</p>
            <p class="text-2xl font-bold text-gray-800">1,240</p>
        </div>
    </div>
    
    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 flex items-center">
        <div class="p-4 rounded-full bg-green-100 text-green-600 mr-4">
            <i class="fas fa-chalkboard-teacher text-2xl"></i>
        </div>
        <div>
            <p class="text-sm text-gray-500 font-semibold mb-1">Total Guru</p>
            <p class="text-2xl font-bold text-gray-800">85</p>
        </div>
    </div>
    
    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 flex items-center">
        <div class="p-4 rounded-full bg-purple-100 text-purple-600 mr-4">
            <i class="fas fa-user-shield text-2xl"></i>
        </div>
        <div>
            <p class="text-sm text-gray-500 font-semibold mb-1">Akun Admin Aktif</p>
            <p class="text-2xl font-bold text-gray-800">3</p>
        </div>
    </div>
</div>

<!-- Area Kosong untuk Tabel Data Nanti -->
<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
    <h2 class="text-lg font-bold text-gray-800 mb-4">Aktivitas Terakhir</h2>
    <div class="text-center py-10">
        <img src="https://illustrations.popsy.co/amber/freelancer.svg" alt="No data" class="w-48 mx-auto mb-4 opacity-70">
        <p class="text-gray-500">Belum ada aktivitas yang direkam.</p>
    </div>
</div>
<?= $this->endSection() ?>