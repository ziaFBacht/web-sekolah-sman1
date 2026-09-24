<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<?php if(session()->getFlashdata('success')): ?>
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4"><?= session()->getFlashdata('success') ?></div>
<?php endif; ?>
<?php if(session()->getFlashdata('error')): ?>
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4"><?= session()->getFlashdata('error') ?></div>
<?php endif; ?>

<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="p-6 border-b border-gray-100 flex justify-between items-center bg-white">
        <h2 class="text-lg font-bold text-gray-800">Daftar Induk Guru</h2>
        <button onclick="document.getElementById('modalTambah').classList.remove('hidden')" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-semibold text-sm transition shadow-sm">
            <i class="fas fa-plus mr-1"></i> Tambah Guru
        </button>
    </div>

    <!-- Baris Filter & Export -->
    <div class="px-6 py-4 bg-gray-50/80 border-b border-gray-100 flex flex-col md:flex-row gap-4 justify-between items-center">
        <div class="flex flex-col md:flex-row gap-3 w-full md:w-auto">
            <input type="text" id="searchGuru" placeholder="Cari NIP / Nama..." class="border border-gray-300 rounded-lg px-4 py-2 text-sm focus:ring focus:ring-blue-200 outline-none w-full md:w-64">
        </div>
        
        <button onclick="exportToExcel('tabelGuru', 'Data_Guru_SMAN1')" class="bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 rounded-lg font-semibold text-sm transition shadow-sm flex items-center shrink-0">
            <i class="fas fa-file-excel mr-2"></i> Export Excel
        </button>
    </div>

    <div class="overflow-x-auto">
        <table id="tabelGuru" class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-white border-b text-gray-500 text-sm uppercase tracking-wider">
                    <th class="px-6 py-4 font-semibold">NIP</th>
                    <th class="px-6 py-4 font-semibold">Nama Lengkap</th>
                    <th class="px-6 py-4 font-semibold">Mata Pelajaran</th>
                    <th class="px-6 py-4 font-semibold text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 text-gray-700 text-sm">
                <?php if(empty($guru)): ?>
                    <tr><td colspan="4" class="text-center py-8 text-gray-500">Belum ada data guru.</td></tr>
                <?php endif; ?>
                <?php foreach($guru as $row): ?>
                <tr class="hover:bg-blue-50/50 transition row-data">
                    <td class="px-6 py-4 font-bold text-gray-900"><?= esc($row['nip']) ?></td>
                    <td class="px-6 py-4">
                        <div class="font-bold text-gray-800"><?= esc($row['nama_lengkap']) ?></div>
                        <?php if($row['username']): ?>
                            <div class="text-xs mt-1 text-emerald-600 font-semibold bg-emerald-50 inline-block px-2 py-0.5 rounded border border-emerald-200">
                                <i class="fas fa-link mr-1"></i> Akun: <?= esc($row['username']) ?>
                            </div>
                        <?php else: ?>
                            <div class="text-xs mt-1 text-red-500 font-semibold bg-red-50 inline-block px-2 py-0.5 rounded border border-red-100">
                                <i class="fas fa-unlink mr-1"></i> Belum Punya Akun
                            </div>
                        <?php endif; ?>
                    </td>
                    <td class="px-6 py-4"><span class="bg-purple-100 text-purple-800 font-bold px-2 py-1 rounded text-xs"><?= esc($row['mata_pelajaran']) ?></span></td>
                    <td class="px-6 py-4 text-center space-x-2">
                        <button onclick="openEditModal('<?= $row['id'] ?>', '<?= esc($row['nip']) ?>', '<?= esc($row['nama_lengkap']) ?>', '<?= esc($row['mata_pelajaran']) ?>')" class="text-blue-500 hover:text-blue-700 bg-white shadow-sm border p-2 rounded transition">
                            <i class="fas fa-edit"></i>
                        </button>
                        <a href="<?= base_url('admin/guru/delete/'.$row['id']) ?>" onclick="return confirm('Hapus data guru ini?')" class="text-red-500 hover:text-red-700 bg-white shadow-sm border p-2 rounded transition">
                            <i class="fas fa-trash"></i>
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- MODAL TAMBAH DATA -->
<div id="modalTambah" class="hidden fixed inset-0 z-50 bg-black/50 backdrop-blur-sm flex items-center justify-center p-4">
    <div class="bg-white rounded-xl w-full max-w-md p-6">
        <h3 class="text-xl font-bold mb-4">Tambah Data Guru</h3>
        <form action="<?= base_url('admin/guru/store') ?>" method="POST" class="space-y-4">
            <div><label class="block text-sm font-semibold mb-1">NIP</label><input type="text" name="nip" required class="w-full border rounded px-3 py-2 focus:ring focus:ring-blue-200"></div>
            <div><label class="block text-sm font-semibold mb-1">Nama Lengkap</label><input type="text" name="nama_lengkap" required class="w-full border rounded px-3 py-2 focus:ring focus:ring-blue-200"></div>
            <div><label class="block text-sm font-semibold mb-1">Mata Pelajaran</label><input type="text" name="mata_pelajaran" required placeholder="Contoh: Matematika" class="w-full border rounded px-3 py-2 focus:ring focus:ring-blue-200"></div>
            <div class="flex justify-end space-x-2 mt-6">
                <button type="button" onclick="document.getElementById('modalTambah').classList.add('hidden')" class="px-4 py-2 text-gray-500 hover:bg-gray-100 rounded">Batal</button>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 font-bold">Simpan</button>
            </div>
        </form>
    </div>
</div>

<!-- MODAL EDIT DATA -->
<div id="modalEdit" class="hidden fixed inset-0 z-50 bg-black/50 backdrop-blur-sm flex items-center justify-center p-4">
    <div class="bg-white rounded-xl w-full max-w-md p-6">
        <h3 class="text-xl font-bold mb-4">Edit Guru</h3>
        <form action="<?= base_url('admin/guru/update') ?>" method="POST" class="space-y-4">
            <input type="hidden" name="id" id="editId">
            <div><label class="block text-sm font-semibold mb-1">NIP</label><input type="text" name="nip" id="editNip" required class="w-full border rounded px-3 py-2 bg-gray-50" readonly></div>
            <div><label class="block text-sm font-semibold mb-1">Nama Lengkap</label><input type="text" name="nama_lengkap" id="editNama" required class="w-full border rounded px-3 py-2 focus:ring focus:ring-blue-200"></div>
            <div><label class="block text-sm font-semibold mb-1">Mata Pelajaran</label><input type="text" name="mata_pelajaran" id="editMapel" required class="w-full border rounded px-3 py-2 focus:ring focus:ring-blue-200"></div>
            <div class="flex justify-end space-x-2 mt-6">
                <button type="button" onclick="document.getElementById('modalEdit').classList.add('hidden')" class="px-4 py-2 text-gray-500 hover:bg-gray-100 rounded">Batal</button>
                <button type="submit" class="px-4 py-2 bg-yellow-500 text-white rounded hover:bg-yellow-600 font-bold">Update</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openEditModal(id, nip, nama, mapel) {
        document.getElementById('editId').value = id;
        document.getElementById('editNip').value = nip;
        document.getElementById('editNama').value = nama;
        document.getElementById('editMapel').value = mapel;
        document.getElementById('modalEdit').classList.remove('hidden');
    }

    // Fungsi Filter Sederhana
    document.getElementById('searchGuru').addEventListener('keyup', function() {
        let search = this.value.toLowerCase();
        let rows = document.querySelectorAll('#tabelGuru tbody tr.row-data');
        rows.forEach(row => {
            row.style.display = row.innerText.toLowerCase().includes(search) ? '' : 'none';
        });
    });
</script>
<?= $this->endSection() ?>