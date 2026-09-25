<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<!-- Custom CSS untuk mengatur tinggi minimal editor teks -->
<style>
    .ck-editor__editable_inline {
        min-height: 250px;
    }
</style>

<?php if(session()->getFlashdata('success')): ?>
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4"><?= session()->getFlashdata('success') ?></div>
<?php endif; ?>
<?php if(session()->getFlashdata('error')): ?>
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4"><?= session()->getFlashdata('error') ?></div>
<?php endif; ?>

<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="p-6 border-b border-gray-100 flex justify-between items-center bg-white">
        <h2 class="text-lg font-bold text-gray-800">Manajemen Publikasi Berita</h2>
        <button onclick="document.getElementById('modalTambah').classList.remove('hidden')" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-semibold text-sm transition shadow-sm">
            <i class="fas fa-edit mr-1"></i> Tulis Berita
        </button>
    </div>

    <!-- Baris Filter -->
    <div class="px-6 py-4 bg-gray-50/80 border-b border-gray-100 flex flex-col md:flex-row gap-4 justify-between items-center">
        <div class="flex flex-col md:flex-row gap-3 w-full md:w-auto">
            <input type="text" id="searchBerita" placeholder="Cari Judul..." class="border border-gray-300 rounded-lg px-4 py-2 text-sm focus:ring focus:ring-blue-200 outline-none w-full md:w-64">
            
            <select id="filterKategori" class="border border-gray-300 rounded-lg px-4 py-2 text-sm focus:ring focus:ring-blue-200 outline-none">
                <option value="">Semua Kategori</option>
                <option value="Pendidikan">Pendidikan</option>
                <option value="Kegiatan">Kegiatan</option>
                <option value="Prestasi">Prestasi</option>
                <option value="Pengumuman">Pengumuman</option>
            </select>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table id="tabelBerita" class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-white border-b text-gray-500 text-sm uppercase tracking-wider">
                    <th class="px-6 py-4 font-semibold w-24">Gambar</th>
                    <th class="px-6 py-4 font-semibold">Detail Berita</th>
                    <th class="px-6 py-4 font-semibold">Kategori</th>
                    <th class="px-6 py-4 font-semibold">Status</th>
                    <th class="px-6 py-4 font-semibold text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 text-gray-700 text-sm">
                <?php if(empty($berita)): ?>
                    <tr><td colspan="5" class="text-center py-8 text-gray-500">Belum ada berita yang diterbitkan.</td></tr>
                <?php endif; ?>
                <?php foreach($berita as $row): ?>
                <tr class="hover:bg-blue-50/50 transition row-data">
                    <td class="px-6 py-4">
                        <?php if($row['thumbnail']): ?>
                            <img src="<?= base_url('uploads/berita/' . $row['thumbnail']) ?>" alt="Thumb" class="w-16 h-12 object-cover rounded shadow-sm border">
                        <?php else: ?>
                            <div class="w-16 h-12 bg-gray-200 rounded flex items-center justify-center text-gray-400 text-xs"><i class="fas fa-image"></i></div>
                        <?php endif; ?>
                    </td>
                    <td class="px-6 py-4">
                        <div class="font-bold text-gray-900 text-base mb-1 line-clamp-1"><?= esc($row['judul']) ?></div>
                        <div class="text-xs text-gray-500 flex items-center gap-3">
                            <span><i class="far fa-user mr-1"></i> <?= esc($row['penulis'] ?? 'Sistem') ?></span>
                            <span><i class="far fa-clock mr-1"></i> <?= date('d M Y', strtotime($row['created_at'])) ?></span>
                        </div>
                    </td>
                    <td class="px-6 py-4 col-kategori">
                        <span class="bg-indigo-50 text-indigo-700 border border-indigo-100 font-semibold px-2 py-1 rounded text-xs"><?= esc($row['kategori']) ?></span>
                    </td>
                    <td class="px-6 py-4">
                        <?php if($row['status'] == 'published'): ?>
                            <span class="bg-green-100 text-green-700 font-bold px-2 py-1 rounded text-xs uppercase"><i class="fas fa-check-circle mr-1"></i> Publik</span>
                        <?php else: ?>
                            <span class="bg-yellow-100 text-yellow-700 font-bold px-2 py-1 rounded text-xs uppercase"><i class="fas fa-file-alt mr-1"></i> Draft</span>
                        <?php endif; ?>
                    </td>
                    <td class="px-6 py-4 text-center space-x-2 whitespace-nowrap">
                        <button onclick="openEditModal(this)" 
                            data-id="<?= $row['id'] ?>"
                            data-judul="<?= esc($row['judul']) ?>"
                            data-kategori="<?= esc($row['kategori']) ?>"
                            data-subteks="<?= esc($row['subteks']) ?>"
                            data-status="<?= esc($row['status']) ?>"
                            data-konten="<?= esc($row['konten']) ?>"
                            data-thumb="<?= esc($row['thumbnail']) ?>"
                            class="text-blue-500 hover:text-blue-700 bg-white shadow-sm border p-2 rounded transition">
                            <i class="fas fa-edit"></i>
                        </button>
                        <a href="<?= base_url('admin/berita/delete/'.$row['id']) ?>" onclick="return confirm('Yakin ingin menghapus berita ini secara permanen?')" class="text-red-500 hover:text-red-700 bg-white shadow-sm border p-2 rounded transition">
                            <i class="fas fa-trash"></i>
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- MODAL TAMBAH BERITA -->
<div id="modalTambah" class="hidden fixed inset-0 z-50 bg-black/50 backdrop-blur-sm flex items-center justify-center p-4">
    <div class="bg-white rounded-xl w-full max-w-4xl p-6 max-h-[90vh] overflow-y-auto">
        <h3 class="text-xl font-bold mb-4">Tulis Berita Baru</h3>
        <form action="<?= base_url('admin/berita/store') ?>" method="POST" enctype="multipart/form-data" class="space-y-4">
            <div>
                <label class="block text-sm font-semibold mb-1">Judul Berita</label>
                <input type="text" name="judul" required class="w-full border rounded px-3 py-2 focus:ring focus:ring-blue-200">
            </div>
            <div>
                <label class="block text-sm font-semibold mb-1">Subteks (Deskripsi Singkat)</label>
                <textarea name="subteks" id="editSubteks" rows="2" required class="w-full border rounded px-3 py-2 focus:ring focus:ring-blue-200" placeholder="Tulis ringkasan berita..."></textarea>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-semibold mb-1">Kategori</label>
                    <select name="kategori" required class="w-full border rounded px-3 py-2">
                        <option value="Pendidikan">Pendidikan</option>
                        <option value="Kegiatan">Kegiatan Sekolah</option>
                        <option value="Prestasi">Prestasi</option>
                        <option value="Pengumuman">Pengumuman</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-semibold mb-1">Status Visibilitas</label>
                    <select name="status" required class="w-full border rounded px-3 py-2">
                        <option value="published">Publik (Published)</option>
                        <option value="draft">Simpan Draft</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-semibold mb-1">Gambar Sampul (Thumbnail)</label>
                    <input type="file" name="thumbnail" accept="image/*" class="w-full border rounded px-3 py-1.5 text-sm">
                </div>
            </div>

            <div>
                <label class="block text-sm font-semibold mb-1">Konten Berita</label>
                <textarea name="konten" id="editorTambah" class="w-full border rounded"></textarea>
            </div>

            <div class="flex justify-end space-x-2 mt-6 pt-4 border-t">
                <button type="button" onclick="document.getElementById('modalTambah').classList.add('hidden')" class="px-4 py-2 text-gray-500 hover:bg-gray-100 rounded">Batal</button>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 font-bold">Simpan & Publikasikan</button>
            </div>
        </form>
    </div>
</div>

<!-- MODAL EDIT BERITA -->
<div id="modalEdit" class="hidden fixed inset-0 z-50 bg-black/50 backdrop-blur-sm flex items-center justify-center p-4">
    <div class="bg-white rounded-xl w-full max-w-4xl p-6 max-h-[90vh] overflow-y-auto">
        <h3 class="text-xl font-bold mb-4">Edit Berita</h3>
        <form action="<?= base_url('admin/berita/update') ?>" method="POST" enctype="multipart/form-data" class="space-y-4">
            <input type="hidden" name="id" id="editId">
            <input type="hidden" name="old_thumbnail" id="editOldThumb">
            
            <div>
                <label class="block text-sm font-semibold mb-1">Judul Berita</label>
                <input type="text" name="judul" id="editJudul" required class="w-full border rounded px-3 py-2 focus:ring focus:ring-blue-200">
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-semibold mb-1">Kategori</label>
                    <select name="kategori" id="editKategori" required class="w-full border rounded px-3 py-2">
                        <option value="Pendidikan">Pendidikan</option>
                        <option value="Kegiatan">Kegiatan Sekolah</option>
                        <option value="Prestasi">Prestasi</option>
                        <option value="Pengumuman">Pengumuman</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-semibold mb-1">Status Visibilitas</label>
                    <select name="status" id="editStatus" required class="w-full border rounded px-3 py-2">
                        <option value="published">Publik (Published)</option>
                        <option value="draft">Simpan Draft</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-semibold mb-1">Ganti Gambar (Opsional)</label>
                    <input type="file" name="thumbnail" accept="image/*" class="w-full border rounded px-3 py-1.5 text-sm">
                    <p class="text-[10px] text-gray-500 mt-1">Biarkan kosong jika tidak ingin mengubah gambar.</p>
                </div>
            </div>

            <div>
                <label class="block text-sm font-semibold mb-1">Konten Berita</label>
                <textarea name="konten" id="editorEdit" class="w-full border rounded"></textarea>
            </div>

            <div class="flex justify-end space-x-2 mt-6 pt-4 border-t">
                <button type="button" onclick="document.getElementById('modalEdit').classList.add('hidden')" class="px-4 py-2 text-gray-500 hover:bg-gray-100 rounded">Batal</button>
                <button type="submit" class="px-4 py-2 bg-yellow-500 text-white rounded hover:bg-yellow-600 font-bold">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>

<!-- Load CKEditor 5 melalui CDN -->
<script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>

<script>
    let editorTambahInstance;
    let editorEditInstance;

    // Inisialisasi CKEditor untuk Modal Tambah
    ClassicEditor
        .create(document.querySelector('#editorTambah'), {
            toolbar: [ 'heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote', '|', 'undo', 'redo' ]
        })
        .then(editor => {
            editorTambahInstance = editor;
        })
        .catch(error => {
            console.error(error);
        });

    // Inisialisasi CKEditor untuk Modal Edit
    ClassicEditor
        .create(document.querySelector('#editorEdit'), {
            toolbar: [ 'heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote', '|', 'undo', 'redo' ]
        })
        .then(editor => {
            editorEditInstance = editor;
        })
        .catch(error => {
            console.error(error);
        });

    // Fungsi Ekstraksi Data ke Modal Edit
    function openEditModal(btn) {
        document.getElementById('editId').value = btn.getAttribute('data-id');
        document.getElementById('editJudul').value = btn.getAttribute('data-judul');
        document.getElementById('editKategori').value = btn.getAttribute('data-kategori');
        document.getElementById('editSubteks').value = btn.getAttribute('data-subteks');
        document.getElementById('editStatus').value = btn.getAttribute('data-status');
        document.getElementById('editOldThumb').value = btn.getAttribute('data-thumb');
        
        // Memasukkan konten HTML dari database ke dalam CKEditor
        let konten = btn.getAttribute('data-konten');
        editorEditInstance.setData(konten);
        
        document.getElementById('modalEdit').classList.remove('hidden');
    }

    // Fungsi Filter Pencarian Sederhana
    function filterBerita() {
        let search = document.getElementById('searchBerita').value.toLowerCase();
        let filterKategori = document.getElementById('filterKategori').value.toLowerCase();
        let rows = document.querySelectorAll('#tabelBerita tbody tr.row-data');

        rows.forEach(row => {
            let text = row.innerText.toLowerCase();
            let kategori = row.querySelector('.col-kategori').innerText.toLowerCase();

            let matchSearch = text.includes(search);
            let matchKategori = filterKategori === "" || kategori.includes(filterKategori);

            row.style.display = (matchSearch && matchKategori) ? '' : 'none';
        });
    }

    document.getElementById('searchBerita').addEventListener('keyup', filterBerita);
    document.getElementById('filterKategori').addEventListener('change', filterBerita);
</script>

<?= $this->endSection() ?>