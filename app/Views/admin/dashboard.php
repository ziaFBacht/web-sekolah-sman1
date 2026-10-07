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
            <p class="text-2xl font-bold text-gray-800"><?= number_format($total_siswa, 0, ',', '.') ?></p>
        </div>
    </div>
    
    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 flex items-center">
        <div class="p-4 rounded-full bg-green-100 text-green-600 mr-4">
            <i class="fas fa-chalkboard-teacher text-2xl"></i>
        </div>
        <div>
            <p class="text-sm text-gray-500 font-semibold mb-1">Total Guru</p>
            <p class="text-2xl font-bold text-gray-800"><?= number_format($total_guru, 0, ',', '.') ?></p>
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
    
    <!-- Filter -->
    <div class="px-6 py-4 bg-white border-b border-gray-100">
        <form action="<?= base_url('admin/dashboard') ?>" method="GET" class="flex flex-col lg:flex-row gap-3 items-center">
            
            <!-- Pencarian Teks -->
            <div class="w-full lg:w-auto flex-1">
                <input type="text" name="search" value="<?= esc($filters['search'] ?? '') ?>" placeholder="Cari nama data / pengguna..." class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:ring focus:ring-blue-200 outline-none">
            </div>

            <!-- Filter Aksi & Tabel -->
            <div class="w-full lg:w-auto flex gap-2">
                <select name="action" class="w-full lg:w-36 border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring focus:ring-blue-200 outline-none">
                    <option value="">Semua Aksi</option>
                    <option value="INSERT" <?= ($filters['action'] ?? '') == 'INSERT' ? 'selected' : '' ?>>INSERT</option>
                    <option value="UPDATE" <?= ($filters['action'] ?? '') == 'UPDATE' ? 'selected' : '' ?>>UPDATE</option>
                    <option value="DELETE" <?= ($filters['action'] ?? '') == 'DELETE' ? 'selected' : '' ?>>DELETE</option>
                </select>
                
                <select name="table" class="w-full lg:w-36 border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring focus:ring-blue-200 outline-none">
                    <option value="">Semua Tabel</option>
                    <option value="users" <?= ($filters['table'] ?? '') == 'users' ? 'selected' : '' ?>>Akun (Users)</option>
                    <option value="berita" <?= ($filters['table'] ?? '') == 'berita' ? 'selected' : '' ?>>Berita</option>
                    <option value="siswa" <?= ($filters['table'] ?? '') == 'siswa' ? 'selected' : '' ?>>Siswa</option>
                    <option value="guru" <?= ($filters['table'] ?? '') == 'guru' ? 'selected' : '' ?>>Guru</option>
                </select>
            </div>

            <!-- Filter Tanggal Spesifik (Operator & Kalender) -->
            <div class="w-full lg:w-auto flex gap-2">
                <select name="date_operator" class="w-1/3 lg:w-auto border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring focus:ring-blue-200 outline-none bg-gray-50">
                    <option value="exact" <?= ($filters['date_operator'] ?? '') == 'exact' ? 'selected' : '' ?>>Saat</option>
                    <option value="before" <?= ($filters['date_operator'] ?? '') == 'before' ? 'selected' : '' ?>>Sebelum</option>
                    <option value="after" <?= ($filters['date_operator'] ?? '') == 'after' ? 'selected' : '' ?>>Setelah</option>
                </select>
                
                <input type="date" name="date_value" value="<?= esc($filters['date_value'] ?? '') ?>" class="w-2/3 lg:w-auto border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring focus:ring-blue-200 outline-none">
            </div>

            <!-- Tombol Submit & Reset -->
            <div class="flex gap-2 w-full lg:w-auto">
                <button type="submit" class="w-full lg:w-auto bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-semibold transition">
                    <i class="fas fa-filter mr-1"></i> Filter
                </button>
                <?php if (!empty($filters['search']) || !empty($filters['action']) || !empty($filters['table']) || !empty($filters['date_value'])): ?>
                    <a href="<?= base_url('admin/dashboard') ?>" class="w-full lg:w-auto bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-lg text-sm font-semibold transition text-center flex items-center justify-center" title="Reset Filter">
                        <i class="fas fa-undo"></i>
                    </a>
                <?php endif; ?>
            </div>
        </form>
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
                    <!-- Empty State -->
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
    <?php if (isset($pager)): ?>
    <div class="px-6 py-4 bg-gray-50/50 border-t border-gray-100 flex justify-center md:justify-end items-center">
        <?= $pager->links('default', 'tailwind_pagination') ?>
    </div>
    <?php endif; ?>
</div>
<?= $this->endSection() ?>