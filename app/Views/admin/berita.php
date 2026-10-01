<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<!-- Custom CSS untuk mengatur tinggi minimal editor teks dan mengembalikan gaya dasar -->
<style>
    .ck-editor__editable_inline {
        min-height: 250px;
    }
    
    /* Mengembalikan gaya dasar untuk elemen di dalam CKEditor yang di-reset oleh Tailwind */
    .ck-content h1 { font-size: 2.25rem; font-weight: bold; margin-top: 1.5rem; margin-bottom: 1rem; line-height: 1.2; }
    .ck-content h2 { font-size: 1.875rem; font-weight: bold; margin-top: 1.5rem; margin-bottom: 1rem; line-height: 1.2; }
    .ck-content h3 { font-size: 1.5rem; font-weight: bold; margin-top: 1.5rem; margin-bottom: 1rem; line-height: 1.2; }
    .ck-content h4 { font-size: 1.25rem; font-weight: bold; margin-top: 1.5rem; margin-bottom: 1rem; line-height: 1.2; }
    
    .ck-content ul { list-style-type: disc; padding-left: 2rem; margin-bottom: 1rem; }
    .ck-content ol { list-style-type: decimal; padding-left: 2rem; margin-bottom: 1rem; }
    .ck-content li { margin-bottom: 0.25rem; }
    
    .ck-content blockquote { border-left: 4px solid #e5e7eb; padding-left: 1rem; color: #4b5563; font-style: italic; margin-bottom: 1rem; }
    .ck-content p { margin-bottom: 1rem; }
    .ck-content a { color: #2563eb; text-decoration: underline; }
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

<!-- MODAL TAMBAH BERITA DENGAN PREVIEW -->
<div id="modalTambah" class="hidden fixed inset-0 z-50 bg-black/50 backdrop-blur-sm flex items-center justify-center p-4">
    <div class="bg-white rounded-xl w-full max-w-4xl p-6 max-h-[90vh] overflow-y-auto">
        <h3 class="text-xl font-bold mb-4 border-b pb-2">Manajemen Berita</h3>
        
        <!-- AREA 1: Form Input Berita -->
        <div id="areaInput" class="bg-white max-w-4xl mx-auto">
            <h2 class="text-lg font-bold mb-4 text-gray-800">Tulis Berita Baru</h2>
            
            <form id="formBerita" action="<?= base_url('admin/berita/store') ?>" method="POST" enctype="multipart/form-data" class="space-y-4">
                
                <!-- Input Judul -->
                <div>
                    <label for="inputJudul" class="block text-sm font-semibold mb-1">Judul Berita <span class="text-red-500">*</span></label>
                    <input type="text" name="judul" id="inputJudul" class="w-full border rounded px-3 py-2 focus:ring focus:ring-blue-200" placeholder="Masukkan judul berita yang menarik..." required>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <!-- Input Kategori -->
                    <div>
                        <label for="inputKategori" class="block text-sm font-semibold mb-1">Kategori <span class="text-red-500">*</span></label>
                        <select name="kategori" id="inputKategori" class="w-full border rounded px-3 py-2" required>
                            <option value="">-- Pilih --</option>
                            <option value="Pendidikan">Pendidikan</option>
                            <option value="Kegiatan">Kegiatan Sekolah</option>
                            <option value="Prestasi">Prestasi</option>
                            <option value="Pengumuman">Pengumuman</option>
                        </select>
                    </div>

                    <!-- Input Subteks -->
                    <div class="md:col-span-2">
                        <label for="inputSubteks" class="block text-sm font-semibold mb-1">Subteks Singkat <span class="text-gray-400 text-xs font-normal">(Opsional)</span></label>
                        <input type="text" name="subteks" id="inputSubteks" class="w-full border rounded px-3 py-2 focus:ring focus:ring-blue-200" placeholder="Ringkasan berita...">
                    </div>

                    <!-- Input Status -->
                    <div>
                        <label for="inputStatus" class="block text-sm font-semibold mb-1">Status</label>
                        <select name="status" id="inputStatus" class="w-full border rounded px-3 py-2" required>
                            <option value="published">Publik (Published)</option>
                            <option value="draft">Simpan Draft</option>
                        </select>
                    </div>
                </div>

                <!-- Input Upload Gambar -->
                <div>
                    <label for="inputGambar" class="block text-sm font-semibold mb-1">Thumbnail/Gambar Utama <span class="text-gray-400 text-xs font-normal">(Opsional)</span></label>
                    <input type="file" name="gambar" id="inputGambar" class="w-full border rounded px-3 py-1.5 text-sm file:mr-2 file:py-1 file:px-3 file:rounded file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100" accept="image/*">
                </div>

                <!-- Input Konten (CKEditor) -->
                <div>
                    <label for="editorTambah" class="block text-sm font-semibold mb-1">Isi Berita <span class="text-red-500">*</span></label>
                    <textarea name="konten" id="editorTambah" class="w-full border rounded"></textarea>
                </div>

                <!-- Tombol Aksi Tahap 1 -->
                <div class="flex justify-between mt-6 pt-4 border-t">
                    <!-- Tombol Batal/Keluar dari Modal -->
                    <button type="button" onclick="document.getElementById('modalTambah').classList.add('hidden')" class="px-4 py-2 text-gray-500 hover:bg-gray-100 border border-gray-300 rounded font-semibold transition">
                        Batal
                    </button>
                    
                    <!-- Tombol menuju Preview -->
                    <button type="button" id="btnToPreview" class="bg-gray-800 hover:bg-gray-900 text-white font-semibold py-2 px-6 rounded transition duration-200 flex items-center">
                        <i class="fas fa-eye mr-2"></i> Lihat Preview
                    </button>
                </div>
            </form>
        </div>

        <!-- AREA 2: Halaman Konfirmasi / Preview (Disembunyikan secara default) -->
        <div id="areaPreview" class="hidden bg-gray-50 p-2 rounded-lg border border-gray-200 max-w-4xl mx-auto">
            <div class="flex justify-between items-center mb-4 pb-2 border-b">
                <h2 class="text-lg font-bold text-gray-800">Review Publikasi Berita</h2>
                <span class="bg-yellow-100 text-yellow-800 text-xs font-semibold px-2 py-1 rounded">Mode Pratinjau</span>
            </div>
            
            <!-- Tampilan Artikel Menyerupai Halaman Asli -->
            <div class="bg-white p-6 rounded shadow-sm border mb-6">
                <!-- Kategori Preview -->
                <div class="mb-3">
                    <span id="previewKategori" class="bg-indigo-50 text-indigo-700 border border-indigo-100 font-semibold px-2 py-1 rounded text-xs uppercase"></span>
                </div>

                <!-- Judul -->
                <h1 id="previewJudul" class="text-2xl font-extrabold text-gray-900 mb-2 leading-tight"></h1>
                
                <!-- Subteks Preview -->
                <p id="previewSubteks" class="text-gray-600 italic mb-4"></p>
                
                <!-- Meta -->
                <div class="flex items-center text-xs text-gray-500 mb-6 border-b pb-4">
                    <span class="mr-4"><i class="far fa-calendar-alt mr-1"></i> <?= date('d M Y') ?></span>
                    <span><i class="far fa-user mr-1"></i> Administrator</span>
                </div>

                <!-- Gambar Utama (Disembunyikan jika kosong) -->
                <div id="containerGambarPreview" class="w-full mb-6 rounded overflow-hidden flex justify-center hidden">
                    <img id="previewGambar" src="" alt="Thumbnail Berita" class="max-w-full h-auto max-h-[350px] object-contain">
                </div>
                
                <!-- Konten (Render HTML dari CKEditor) -->
                <!-- Penambahan kelas ck-content di sini -->
                <div id="previewKonten" class="ck-content max-w-none text-gray-800 text-sm leading-relaxed text-justify"></div>
            </div>

            <!-- Tombol Aksi Tahap 2 -->
            <div class="flex justify-between items-center bg-gray-100 p-4 rounded border">
                <!-- Tombol Kembali -->
                <button type="button" id="btnBackToEdit" class="text-gray-700 bg-white border border-gray-300 hover:bg-gray-50 font-semibold py-2 px-4 rounded transition">
                    &larr; Kembali Edit
                </button>
                
                <!-- Tombol Submit Sebenarnya -->
                <button type="button" id="btnSubmitFinal" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded shadow-sm transition flex items-center">
                    <i class="fas fa-paper-plane mr-2"></i> Simpan & Publikasikan
                </button>
            </div>
        </div>
    </div>
</div>

<!-- MODAL EDIT BERITA -->
<div id="modalEdit" class="hidden fixed inset-0 z-50 bg-black/50 backdrop-blur-sm flex items-center justify-center p-4">
    <div class="bg-white rounded-xl w-full max-w-4xl p-6 max-h-[90vh] overflow-y-auto">
        <h3 class="text-xl font-bold mb-4">Edit Berita</h3>
        
        <!-- AREA 1 EDIT: Form Input -->
        <div id="areaInputEdit">
            <form id="formEditBerita" action="<?= base_url('admin/berita/update') ?>" method="POST" enctype="multipart/form-data" class="space-y-4">
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
                        <input type="file" name="thumbnail" id="editGambar" accept="image/*" class="w-full border rounded px-3 py-1.5 text-sm">
                        <p class="text-[10px] text-gray-500 mt-1">Biarkan kosong jika tidak ingin mengubah gambar.</p>
                    </div>
                </div>

                <!-- Input Subteks (Edit) -->
                <div>
                    <label class="block text-sm font-semibold mb-1">Subteks Singkat <span class="text-gray-400 text-xs font-normal">(Opsional)</span></label>
                    <input type="text" name="subteks" id="editSubteks" class="w-full border rounded px-3 py-2 focus:ring focus:ring-blue-200">
                </div>

                <div>
                    <label class="block text-sm font-semibold mb-1">Konten Berita</label>
                    <textarea name="konten" id="editorEdit" class="w-full border rounded"></textarea>
                </div>

                <div class="flex justify-between space-x-2 mt-6 pt-4 border-t">
                    <button type="button" onclick="document.getElementById('modalEdit').classList.add('hidden')" class="px-4 py-2 text-gray-500 hover:bg-gray-100 rounded">Batal</button>
                    <button type="button" id="btnToPreviewEdit" class="bg-gray-800 hover:bg-gray-900 text-white font-semibold py-2 px-6 rounded transition duration-200 flex items-center">
                        <i class="fas fa-eye mr-2"></i> Lihat Preview
                    </button>
                </div>
            </form>
        </div>

        <!-- AREA 2 EDIT: Halaman Konfirmasi / Preview -->
        <div id="areaPreviewEdit" class="hidden bg-gray-50 p-2 rounded-lg border border-gray-200 max-w-4xl mx-auto mt-4">
            <div class="flex justify-between items-center mb-4 pb-2 border-b">
                <h2 class="text-lg font-bold text-gray-800">Review Perubahan Berita</h2>
                <span class="bg-yellow-100 text-yellow-800 text-xs font-semibold px-2 py-1 rounded">Mode Pratinjau</span>
            </div>
            
            <div class="bg-white p-6 rounded shadow-sm border mb-6">
                <!-- Kategori Preview -->
                <div class="mb-3">
                    <span id="previewKategoriEdit" class="bg-indigo-50 text-indigo-700 border border-indigo-100 font-semibold px-2 py-1 rounded text-xs uppercase"></span>
                </div>

                <!-- Judul -->
                <h1 id="previewJudulEdit" class="text-2xl font-extrabold text-gray-900 mb-2 leading-tight"></h1>
                
                <!-- Subteks Preview -->
                <p id="previewSubteksEdit" class="text-gray-600 italic mb-4"></p>
                
                <!-- Meta -->
                <div class="flex items-center text-xs text-gray-500 mb-6 border-b pb-4">
                    <span class="mr-4"><i class="far fa-calendar-alt mr-1"></i> <?= date('d M Y') ?> (Diedit)</span>
                    <span><i class="far fa-user mr-1"></i> Administrator</span>
                </div>

                <!-- Gambar Utama (Disembunyikan jika kosong) -->
                <div id="containerGambarPreviewEdit" class="w-full mb-6 rounded overflow-hidden flex justify-center hidden">
                    <img id="previewGambarEdit" src="" alt="Thumbnail Berita" class="max-w-full h-auto max-h-[350px] object-contain">
                </div>
                
                <!-- Konten (Render HTML dari CKEditor) -->
                <!-- Penambahan kelas ck-content di sini juga -->
                <div id="previewKontenEdit" class="ck-content max-w-none text-gray-800 text-sm leading-relaxed text-justify"></div>
            </div>

            <!-- Tombol Aksi Tahap 2 Edit -->
            <div class="flex justify-between items-center bg-gray-100 p-4 rounded border">
                <button type="button" id="btnBackToEditEdit" class="text-gray-700 bg-white border border-gray-300 hover:bg-gray-50 font-semibold py-2 px-4 rounded transition">
                    &larr; Kembali Edit
                </button>
                
                <button type="button" id="btnSubmitFinalEdit" class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-6 rounded shadow-sm transition flex items-center">
                    <i class="fas fa-save mr-2"></i> Simpan Perubahan
                </button>
            </div>
        </div>
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
        
        // Pastikan kembali ke mode form (bukan preview) saat modal dibuka kembali
        document.getElementById('areaPreviewEdit').classList.add('hidden');
        document.getElementById('areaInputEdit').classList.remove('hidden');

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

    // --- LOGIKA MULTI-STEP FORM (PREVIEW) UNTUK TAMBAH ---
    document.addEventListener('DOMContentLoaded', function() {
        const areaInput = document.getElementById('areaInput');
        const areaPreview = document.getElementById('areaPreview');
        const formBerita = document.getElementById('formBerita');

        const inputJudul = document.getElementById('inputJudul');
        const inputKategori = document.getElementById('inputKategori');
        const inputSubteks = document.getElementById('inputSubteks');
        const inputGambar = document.getElementById('inputGambar');

        const previewJudul = document.getElementById('previewJudul');
        const previewKategori = document.getElementById('previewKategori');
        const previewSubteks = document.getElementById('previewSubteks');
        const previewKonten = document.getElementById('previewKonten');
        const containerGambarPreview = document.getElementById('containerGambarPreview');
        const previewGambar = document.getElementById('previewGambar');

        const btnToPreview = document.getElementById('btnToPreview');
        const btnBackToEdit = document.getElementById('btnBackToEdit');
        const btnSubmitFinal = document.getElementById('btnSubmitFinal');

        // Aksi menuju Preview Tambah
        btnToPreview.addEventListener('click', function() {
            // Validasi Input HTML5 Sederhana
            if (!inputJudul.value || !inputKategori.value) {
                formBerita.reportValidity();
                return;
            }

            // Ambil data dari CKEditor 5
            const kontenHTML = editorTambahInstance.getData();
            
            // Validasi Konten Kosong
            const cleanText = kontenHTML.replace(/(<([^>]+)>)/gi, "").trim();
            if (cleanText === '') {
                alert("Isi berita tidak boleh kosong!");
                return;
            }

            // Set Data ke Preview
            previewJudul.textContent = inputJudul.value;
            previewKategori.textContent = inputKategori.options[inputKategori.selectedIndex].text;
            previewSubteks.textContent = inputSubteks.value;
            previewKonten.innerHTML = kontenHTML;

            // Penanganan Gambar Opsional
            const file = inputGambar.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewGambar.src = e.target.result;
                    containerGambarPreview.classList.remove('hidden');
                }
                reader.readAsDataURL(file);
            } else {
                previewGambar.src = '';
                containerGambarPreview.classList.add('hidden');
            }

            // Transisi Tampilan
            areaInput.classList.add('hidden');
            areaPreview.classList.remove('hidden');
            
            // Scroll sedikit ke atas modal agar rapi
            document.querySelector('#modalTambah > div').scrollTo({ top: 0, behavior: 'smooth' });
        });

        // Aksi Kembali Edit (Tambah)
        btnBackToEdit.addEventListener('click', function() {
            areaPreview.classList.add('hidden');
            areaInput.classList.remove('hidden');
            document.querySelector('#modalTambah > div').scrollTo({ top: 0, behavior: 'smooth' });
        });

        // Aksi Simpan Final (Tambah)
        btnSubmitFinal.addEventListener('click', function() {
            this.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Memproses...';
            this.classList.add('opacity-75', 'cursor-not-allowed');
            this.disabled = true;
            formBerita.submit();
        });

        // --- LOGIKA MULTI-STEP FORM (PREVIEW) UNTUK EDIT ---
        const areaInputEdit = document.getElementById('areaInputEdit');
        const areaPreviewEdit = document.getElementById('areaPreviewEdit');
        const formEditBerita = document.getElementById('formEditBerita');

        const editJudul = document.getElementById('editJudul');
        const editKategori = document.getElementById('editKategori');
        const editSubteks = document.getElementById('editSubteks');
        const editGambar = document.getElementById('editGambar');
        const editOldThumb = document.getElementById('editOldThumb'); // Untuk mendapatkan gambar lama

        const previewJudulEdit = document.getElementById('previewJudulEdit');
        const previewKategoriEdit = document.getElementById('previewKategoriEdit');
        const previewSubteksEdit = document.getElementById('previewSubteksEdit');
        const previewKontenEdit = document.getElementById('previewKontenEdit');
        const containerGambarPreviewEdit = document.getElementById('containerGambarPreviewEdit');
        const previewGambarEdit = document.getElementById('previewGambarEdit');

        const btnToPreviewEdit = document.getElementById('btnToPreviewEdit');
        const btnBackToEditEdit = document.getElementById('btnBackToEditEdit');
        const btnSubmitFinalEdit = document.getElementById('btnSubmitFinalEdit');

        // Aksi menuju Preview Edit
        btnToPreviewEdit.addEventListener('click', function() {
            // Validasi Input
            if (!editJudul.value || !editKategori.value) {
                formEditBerita.reportValidity();
                return;
            }

            // Ambil data dari CKEditor Edit
            const kontenHTMLEdit = editorEditInstance.getData();
            
            // Validasi Konten Kosong
            const cleanTextEdit = kontenHTMLEdit.replace(/(<([^>]+)>)/gi, "").trim();
            if (cleanTextEdit === '') {
                alert("Isi berita tidak boleh kosong!");
                return;
            }

            // Set Data ke Preview
            previewJudulEdit.textContent = editJudul.value;
            previewKategoriEdit.textContent = editKategori.options[editKategori.selectedIndex].text;
            previewSubteksEdit.textContent = editSubteks.value;
            previewKontenEdit.innerHTML = kontenHTMLEdit;

            // Logika pratinjau gambar: prioritas pada file baru, jika tidak, gunakan gambar lama
            const fileEdit = editGambar.files[0];
            if (fileEdit) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewGambarEdit.src = e.target.result;
                    containerGambarPreviewEdit.classList.remove('hidden');
                }
                reader.readAsDataURL(fileEdit);
            } else if (editOldThumb.value) {
                 // Jika tidak ada gambar baru yang diunggah, tampilkan gambar yang sudah ada
                previewGambarEdit.src = "<?= base_url('uploads/berita/') ?>" + editOldThumb.value;
                containerGambarPreviewEdit.classList.remove('hidden');
            } else {
                previewGambarEdit.src = '';
                containerGambarPreviewEdit.classList.add('hidden');
            }

            // Transisi Tampilan
            areaInputEdit.classList.add('hidden');
            areaPreviewEdit.classList.remove('hidden');
            
            // Scroll ke atas
            document.querySelector('#modalEdit > div').scrollTo({ top: 0, behavior: 'smooth' });
        });

        // Aksi Kembali Edit (Edit)
        btnBackToEditEdit.addEventListener('click', function() {
            areaPreviewEdit.classList.add('hidden');
            areaInputEdit.classList.remove('hidden');
            document.querySelector('#modalEdit > div').scrollTo({ top: 0, behavior: 'smooth' });
        });

        // Aksi Simpan Final (Edit)
        btnSubmitFinalEdit.addEventListener('click', function() {
            this.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Memproses...';
            this.classList.add('opacity-75', 'cursor-not-allowed');
            this.disabled = true;
            formEditBerita.submit();
        });
    });
</script>

<?= $this->endSection() ?>