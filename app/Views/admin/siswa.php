<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<!-- Flashdata Notifikasi -->
<?php if(session()->getFlashdata('success')): ?>
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4"><?= session()->getFlashdata('success') ?></div>
<?php endif; ?>
<?php if(session()->getFlashdata('error')): ?>
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4"><?= session()->getFlashdata('error') ?></div>
<?php endif; ?>

<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="p-6 border-b border-gray-100 flex justify-between items-center bg-gray-50">
        <h2 class="text-lg font-bold text-gray-800">Daftar Induk Siswa</h2>
        <button onclick="document.getElementById('modalTambah').classList.remove('hidden')" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-semibold text-sm transition shadow-sm">
            <i class="fas fa-plus mr-1"></i> Tambah Siswa
        </button>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-white border-b text-gray-500 text-sm uppercase tracking-wider">
                    <th class="px-6 py-4 font-semibold">NISN</th>
                    <th class="px-6 py-4 font-semibold">Nama Lengkap</th>
                    <th class="px-6 py-4 font-semibold">Kelas</th>
                    <th class="px-6 py-4 font-semibold">Jurusan</th>
                    <th class="px-6 py-4 font-semibold text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 text-gray-700 text-sm">
                <?php if(empty($siswa)): ?>
                    <tr><td colspan="5" class="text-center py-8 text-gray-500">Belum ada data siswa.</td></tr>
                <?php endif; ?>
                <?php foreach($siswa as $row): ?>
                <tr class="hover:bg-blue-50/50 transition">
                    <td class="px-6 py-4 font-bold text-gray-900"><?= esc($row['nisn']) ?></td>
                    <td class="px-6 py-4">
                    <div class="font-bold text-gray-800"><?= esc($row['nama_lengkap']) ?></div>
                        <?php if($row['username']): ?>
                            <div class="text-xs mt-1 text-green-600 font-semibold bg-green-50 inline-block px-2 py-0.5 rounded border border-green-200">
                                <i class="fas fa-link mr-1"></i> Akun: <?= esc($row['username']) ?>
                            </div>
                        <?php else: ?>
                            <div class="text-xs mt-1 text-red-500 font-semibold bg-red-50 inline-block px-2 py-0.5 rounded border border-red-100">
                                <i class="fas fa-unlink mr-1"></i> Belum Punya Akun
                            </div>
                        <?php endif; ?>
                    </td>
                    <td class="px-6 py-4"><span class="bg-blue-100 text-blue-800 font-bold px-2 py-1 rounded text-xs"><?= esc($row['kelas']) ?></span></td>
                    <td class="px-6 py-4"><?= esc($row['jurusan']) ?></td>
                    <td class="px-6 py-4 text-center space-x-2">
                        <button onclick="openEditModal('<?= $row['id'] ?>', '<?= esc($row['nisn']) ?>', '<?= esc($row['nama_lengkap']) ?>', '<?= esc($row['kelas']) ?>', '<?= esc($row['jurusan']) ?>')" class="text-blue-500 hover:text-blue-700 bg-white shadow-sm border p-2 rounded transition">
                            <i class="fas fa-edit"></i>
                        </button>
                        <a href="<?= base_url('admin/siswa/delete/'.$row['id']) ?>" onclick="return confirm('Hapus data siswa ini?')" class="text-red-500 hover:text-red-700 bg-white shadow-sm border p-2 rounded transition">
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
        <h3 class="text-xl font-bold mb-4">Tambah Data Siswa</h3>
        <form action="<?= base_url('admin/siswa/store') ?>" method="POST" class="space-y-4">
            <div><label class="block text-sm font-semibold mb-1">NISN</label><input type="text" name="nisn" required class="w-full border rounded px-3 py-2 focus:ring focus:ring-blue-200"></div>
            <div><label class="block text-sm font-semibold mb-1">Nama Lengkap</label><input type="text" name="nama_lengkap" required class="w-full border rounded px-3 py-2 focus:ring focus:ring-blue-200"></div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold mb-1">Kelas</label>
                    <select name="kelas" required class="w-full border rounded px-3 py-2"><option value="X">X</option><option value="XI">XI</option><option value="XII">XII</option></select>
                </div>
                <div>
                    <label class="block text-sm font-semibold mb-1">Jurusan</label>
                    <select name="jurusan" required class="w-full border rounded px-3 py-2"><option value="MIPA">MIPA</option><option value="IPS">IPS</option><option value="Bahasa">Bahasa</option></select>
                </div>
            </div>
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
        <h3 class="text-xl font-bold mb-4">Edit Siswa</h3>
        <form action="<?= base_url('admin/siswa/update') ?>" method="POST" class="space-y-4">
            <input type="hidden" name="id" id="editId">
            <div><label class="block text-sm font-semibold mb-1">NISN</label><input type="text" name="nisn" id="editNisn" required class="w-full border rounded px-3 py-2 bg-gray-50" readonly></div>
            <div><label class="block text-sm font-semibold mb-1">Nama Lengkap</label><input type="text" name="nama_lengkap" id="editNama" required class="w-full border rounded px-3 py-2 focus:ring focus:ring-blue-200"></div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold mb-1">Kelas</label>
                    <select name="kelas" id="editKelas" required class="w-full border rounded px-3 py-2"><option value="X">X</option><option value="XI">XI</option><option value="XII">XII</option></select>
                </div>
                <div>
                    <label class="block text-sm font-semibold mb-1">Jurusan</label>
                    <select name="jurusan" id="editJurusan" required class="w-full border rounded px-3 py-2"><option value="MIPA">MIPA</option><option value="IPS">IPS</option><option value="Bahasa">Bahasa</option></select>
                </div>
            </div>
            <div class="flex justify-end space-x-2 mt-6">
                <button type="button" onclick="document.getElementById('modalEdit').classList.add('hidden')" class="px-4 py-2 text-gray-500 hover:bg-gray-100 rounded">Batal</button>
                <button type="submit" class="px-4 py-2 bg-yellow-500 text-white rounded hover:bg-yellow-600 font-bold">Update</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openEditModal(id, nisn, nama, kelas, jurusan) {
        document.getElementById('editId').value = id;
        document.getElementById('editNisn').value = nisn;
        document.getElementById('editNama').value = nama;
        document.getElementById('editKelas').value = kelas;
        document.getElementById('editJurusan').value = jurusan;
        document.getElementById('modalEdit').classList.remove('hidden');
    }
</script>
<?= $this->endSection() ?>