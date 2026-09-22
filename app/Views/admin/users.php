<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<div class="p-6 md:p-8">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Manajemen Akun Pengguna</h1>
            <p class="text-sm text-gray-500">Kelola akun admin, guru, dan siswa</p>
        </div>

        <button
            type="button"
            onclick="document.getElementById('modalTambah').classList.remove('hidden')"
            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-semibold text-sm transition shadow-sm"
        >
            <i class="fas fa-plus mr-1"></i> Buat Akun Baru
        </button>
    </div>

    <!-- Notifikasi -->
    <?php if (session()->getFlashdata('success')): ?>
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            <?= session()->getFlashdata('success') ?>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>

    <!-- Tabel -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6 border-b border-gray-100">
            <h2 class="text-lg font-bold text-gray-800">Daftar Akun Sistem</h2>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 text-gray-500 text-sm uppercase tracking-wider">
                        <th class="px-6 py-4 font-semibold">Username</th>
                        <th class="px-6 py-4 font-semibold">Role</th>
                        <th class="px-6 py-4 font-semibold">Email</th>
                        <th class="px-6 py-4 font-semibold text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-gray-700 text-sm">
                    <?php foreach ($users as $user): ?>
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 font-bold text-gray-900"><?= esc($user['username']) ?></td>
                            <td class="px-6 py-4">
                                <?php
                                    $color = 'bg-gray-100 text-gray-800';
                                    if ($user['role'] == 'admin') $color = 'bg-red-100 text-red-700';
                                    if ($user['role'] == 'guru') $color = 'bg-green-100 text-green-700';
                                    if ($user['role'] == 'siswa') $color = 'bg-blue-100 text-blue-700';
                                ?>
                                <span class="px-2 py-1 rounded text-xs font-bold uppercase <?= $color ?>">
                                    <?= esc($user['role']) ?>
                                </span>
                            </td>
                            <td class="px-6 py-4"><?= esc($user['email'] ?? '-') ?></td>
                            <td class="px-6 py-4 text-center">
                                <div class="flex justify-center gap-2">
                                    <button
                                        type="button"
                                        onclick="openEditModal(
                                            '<?= $user['id'] ?>',
                                            '<?= esc($user['username']) ?>',
                                            '<?= esc($user['role']) ?>',
                                            '<?= esc($user['email'] ?? '') ?>'
                                        )"
                                        class="text-blue-500 hover:text-blue-700 bg-blue-50 p-2 rounded"
                                        title="Edit"
                                    >
                                        <i class="fas fa-edit"></i>
                                    </button>

                                    <a
                                        href="<?= base_url('admin/users/delete/' . $user['id']) ?>"
                                        onclick="return confirm('Yakin ingin menghapus akun ini?')"
                                        class="text-red-500 hover:text-red-700 bg-red-50 p-2 rounded"
                                        title="Hapus"
                                    >
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- MODAL TAMBAH -->
<div id="modalTambah" class="hidden fixed inset-0 z-50 bg-black/50 backdrop-blur-sm flex items-center justify-center">
    <div class="bg-white rounded-xl w-full max-w-md p-6">
        <h3 class="text-xl font-bold mb-4">Buat Akun Baru</h3>

        <form action="<?= base_url('admin/users/store') ?>" method="POST" class="space-y-4">
            <div>
                <label class="block text-sm font-semibold mb-1">Username</label>
                <input type="text" name="username" required class="w-full border rounded px-3 py-2">
            </div>

            <div>
                <label class="block text-sm font-semibold mb-1">NIP/NISN</label>
                <input type="text" name="nisn" required class="w-full border rounded px-3 py-2">
            </div>

            <div>
                <label class="block text-sm font-semibold mb-1">Password</label>
                <input type="password" name="password" required class="w-full border rounded px-3 py-2">
            </div>

            <div>
                <label class="block text-sm font-semibold mb-1">Role/Hak Akses</label>
                <select name="role" required class="w-full border rounded px-3 py-2">
                    <option value="siswa">Siswa</option>
                    <option value="guru">Guru</option>
                    <option value="admin">Administrator</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-semibold mb-1">Email (Opsional)</label>
                <input type="email" name="email" class="w-full border rounded px-3 py-2">
            </div>

            <div class="flex justify-end space-x-2 mt-6">
                <button type="button" onclick="document.getElementById('modalTambah').classList.add('hidden')" class="px-4 py-2 text-gray-500 hover:bg-gray-100 rounded">
                    Batal
                </button>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 font-bold">
                    Simpan Akun
                </button>
            </div>
        </form>
    </div>
</div>

<!-- MODAL EDIT -->
<div id="modalEdit" class="hidden fixed inset-0 z-50 bg-black/50 backdrop-blur-sm flex items-center justify-center">
    <div class="bg-white rounded-xl w-full max-w-md p-6">
        <h3 class="text-xl font-bold mb-4">Edit Akun: <span id="editTitleText" class="text-blue-600"></span></h3>

        <form action="<?= base_url('admin/users/update') ?>" method="POST" class="space-y-4">
            <input type="hidden" name="id" id="editId">

            <div>
                <label class="block text-sm font-semibold mb-1">Username</label>
                <input type="text" name="username" id="editUsername" required class="w-full border rounded px-3 py-2">
            </div>

            <div>
                <label class="block text-sm font-semibold mb-1">Password (kosongkan jika tidak diubah)</label>
                <input type="password" name="password" id="editPassword" class="w-full border rounded px-3 py-2">
            </div>

            <div>
                <label class="block text-sm font-semibold mb-1">Role/Hak Akses</label>
                <select name="role" id="editRole" required class="w-full border rounded px-3 py-2">
                    <option value="siswa">Siswa</option>
                    <option value="guru">Guru</option>
                    <option value="admin">Administrator</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-semibold mb-1">Email</label>
                <input type="email" name="email" id="editEmail" class="w-full border rounded px-3 py-2">
            </div>

            <div class="flex justify-end space-x-2 mt-6">
                <button type="button" onclick="document.getElementById('modalEdit').classList.add('hidden')" class="px-4 py-2 text-gray-500 hover:bg-gray-100 rounded">
                    Batal
                </button>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 font-bold">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function openEditModal(id, username, role, email) {
        document.getElementById('editId').value = id;
        document.getElementById('editTitleText').innerText = username;
        document.getElementById('editUsername').value = username;
        document.getElementById('editRole').value = role;
        document.getElementById('editEmail').value = email;
        document.getElementById('editPassword').value = '';
        document.getElementById('modalEdit').classList.remove('hidden');
    }
</script>

<?= $this->endSection() ?>