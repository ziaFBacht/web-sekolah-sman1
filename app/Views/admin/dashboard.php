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
            <!-- Tampilkan variabel total_siswa -->
            <p class="text-2xl font-bold text-gray-800"><?= number_format($total_siswa, 0, ',', '.') ?></p>
        </div>
    </div>
    
    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 flex items-center">
        <div class="p-4 rounded-full bg-green-100 text-green-600 mr-4">
            <i class="fas fa-chalkboard-teacher text-2xl"></i>
        </div>
        <div>
            <p class="text-sm text-gray-500 font-semibold mb-1">Total Guru</p>
            <p class="text-2xl font-bold text-gray-800">belum</p>
        </div>
    </div>
    
    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 flex items-center">
        <div class="p-4 rounded-full bg-purple-100 text-purple-600 mr-4">
            <i class="fas fa-user-shield text-2xl"></i>
        </div>
        <div>
            <p class="text-sm text-gray-500 font-semibold mb-1">Akun Admin Aktif</p>
            <p class="text-2xl font-bold text-gray-800"><?= esc($total_admin) ?></p>
        </div>
    </div>
</div>

<!-- Riwayat Aktivitas Sistem -->
<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="px-6 py-5 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
        <h5 class="text-lg font-bold text-gray-800 m-0">Riwayat Aktivitas Sistem</h5>
    </div>
    
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50 text-xs uppercase text-gray-500 tracking-wider">
                    <th class="px-6 py-4 font-semibold">Waktu</th>
                    <th class="px-6 py-4 font-semibold">Pengguna</th>
                    <th class="px-6 py-4 font-semibold">Aksi</th>
                    <th class="px-6 py-4 font-semibold">Detail Perubahan</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 text-sm">
                <?php if (!empty($logs)): ?>
                    <?php foreach ($logs as $log): ?>
                        <tr class="hover:bg-gray-50/80 transition-colors duration-200">
                            <!-- Kolom Waktu -->
                            <td class="px-6 py-4 text-gray-500 whitespace-nowrap">
                                <div class="flex items-center">
                                    <i class="far fa-clock mr-2 text-gray-400"></i>
                                    <span><?= date('d M Y', strtotime($log['created_at'])) ?></span>
                                    <span class="mx-2 text-gray-300">•</span>
                                    <span class="font-medium"><?= date('H:i', strtotime($log['created_at'])) ?></span>
                                </div>
                            </td>
                            
                            <!-- Kolom Pengguna dengan Inisial Avatar -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center font-bold mr-3 border border-blue-100">
                                        <?= strtoupper(substr($log['username'] ?? 'S', 0, 1)) ?>
                                    </div>
                                    <span class="font-semibold text-gray-700">
                                        @<?= esc($log['username'] ?? 'Sistem') ?>
                                    </span>
                                </div>
                            </td>
                            
                            <!-- Kolom Aksi dengan Badge Pastel Modern -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                <?php 
                                    $badgeClasses = match($log['action']) {
                                        'INSERT' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                                        'UPDATE' => 'bg-amber-50 text-amber-700 border-amber-200',
                                        'DELETE' => 'bg-rose-50 text-rose-700 border-rose-200',
                                        default  => 'bg-gray-50 text-gray-700 border-gray-200'
                                    };
                                    $actionText = match($log['action']) {
                                        'INSERT' => 'Menambah',
                                        'UPDATE' => 'Memperbarui',
                                        'DELETE' => 'Menghapus',
                                        default  => $log['action']
                                    };
                                ?>
                                <span class="px-3 py-1 rounded-full text-xs font-semibold border <?= $badgeClasses ?>">
                                    <?= esc($actionText) ?>
                                </span>
                            </td>
                            
                            <!-- Kolom Detail -->
                            <td class="px-6 py-4 text-gray-600">
                                Data <strong class="text-gray-800"><?= esc($log['record_name'] ?? 'ID #' . $log['record_id']) ?></strong> 
                                di tabel 
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-indigo-50 text-indigo-700 border border-indigo-100 mx-1">
                                    <i class="fas fa-database mr-1 text-[10px] opacity-70"></i> 
                                    <?= esc(strtoupper($log['table_name'])) ?>
                                </span>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <!-- Empty State Modern -->
                    <tr>
                        <td colspan="4" class="px-6 py-16 text-center">
                            <div class="inline-flex flex-col items-center justify-center text-gray-400">
                                <div class="bg-gray-50 p-4 rounded-full mb-3">
                                    <i class="fas fa-clipboard-list text-3xl text-gray-300"></i>
                                </div>
                                <p class="text-base font-medium text-gray-500">Belum ada aktivitas tercatat</p>
                                <p class="text-sm mt-1">Aktivitas penambahan atau perubahan data akan muncul di sini.</p>
                            </div>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?= $this->endSection() ?>