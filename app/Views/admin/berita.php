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
                        <textarea id="raw-konten-<?= $row['id'] ?>" class="hidden"><?= esc($row['konten']) ?></textarea>
    
                        <button onclick="openEditModal(this, <?= $row['id'] ?>)" 
                            data-id="<?= $row['id'] ?>"
                            data-judul="<?= esc($row['judul'], 'attr') ?>"
                            data-kategori="<?= esc($row['kategori'], 'attr') ?>"
                            data-subteks="<?= esc($row['subteks'], 'attr') ?>"
                            data-status="<?= esc($row['status'], 'attr') ?>"
                            data-thumb="<?= esc($row['thumbnail'], 'attr') ?>"
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
        
        <!-- Form Input Berita -->
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
                    <input type="file" name="thumbnail" id="inputGambar" class="w-full border rounded px-3 py-1.5 text-sm file:mr-2 file:py-1 file:px-3 file:rounded file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100" accept="image/*">
                </div>

                <!-- Input Konten (Summernote) -->
                <div>
                    <label for="editorTambah" class="block text-sm font-semibold mb-1">Isi Berita <span class="text-red-500">*</span></label>
                    <textarea name="konten" id="editorTambah" class="w-full border rounded"></textarea>
                </div>

                <!-- Tombol Aksi Tahap 1 -->
                <div class="flex justify-between mt-6 pt-4 border-t">
                    <button type="button" onclick="document.getElementById('modalTambah').classList.add('hidden')" class="px-4 py-2 text-gray-500 hover:bg-gray-100 border border-gray-300 rounded font-semibold transition">
                        Batal
                    </button>
                    
                    <button type="button" id="btnToPreview" class="bg-gray-800 hover:bg-gray-900 text-white font-semibold py-2 px-6 rounded transition duration-200 flex items-center">
                        <i class="fas fa-eye mr-2"></i> Lihat Preview
                    </button>
                </div>
            </form>
        </div>

        <!-- Halaman Konfirmasi / Preview (Disembunyikan secara default) -->
        <div id="areaPreview" class="hidden bg-gray-50 p-2 rounded-lg border border-gray-200 max-w-4xl mx-auto">
            <div class="flex justify-between items-center mb-4 pb-2 border-b">
                <h2 class="text-lg font-bold text-gray-800">Review Publikasi Berita</h2>
                <span class="bg-yellow-100 text-yellow-800 text-xs font-semibold px-2 py-1 rounded">Mode Pratinjau</span>
            </div>
            
            <div class="bg-white p-6 rounded shadow-sm border mb-6">
                <div class="mb-3">
                    <span id="previewKategori" class="bg-indigo-50 text-indigo-700 border border-indigo-100 font-semibold px-2 py-1 rounded text-xs uppercase"></span>
                </div>

                <h1 id="previewJudul" class="text-2xl font-extrabold text-gray-900 mb-2 leading-tight"></h1>
                <p id="previewSubteks" class="text-gray-600 italic mb-4"></p>
                
                <div class="flex items-center text-xs text-gray-500 mb-6 border-b pb-4">
                    <span class="mr-4"><i class="far fa-calendar-alt mr-1"></i> <?= date('d M Y') ?></span>
                    <span><i class="far fa-user mr-1"></i> Administrator</span>
                </div>

                <div id="containerGambarPreview" class="w-full mb-6 rounded overflow-hidden flex justify-center hidden">
                    <img id="previewGambar" src="" alt="Thumbnail Berita" class="max-w-full h-auto max-h-[350px] object-contain">
                </div>
                
                <div id="previewKonten" class="konten-berita max-w-none text-gray-800 text-sm leading-relaxed text-justify"></div>
            </div>

            <div class="flex justify-between items-center bg-gray-100 p-4 rounded border">
                <button type="button" id="btnBackToEdit" class="text-gray-700 bg-white border border-gray-300 hover:bg-gray-50 font-semibold py-2 px-4 rounded transition">
                    &larr; Kembali Edit
                </button>
                
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

        <div id="areaPreviewEdit" class="hidden bg-gray-50 p-2 rounded-lg border border-gray-200 max-w-4xl mx-auto mt-4">
            <div class="flex justify-between items-center mb-4 pb-2 border-b">
                <h2 class="text-lg font-bold text-gray-800">Review Perubahan Berita</h2>
                <span class="bg-yellow-100 text-yellow-800 text-xs font-semibold px-2 py-1 rounded">Mode Pratinjau</span>
            </div>
            
            <div class="bg-white p-6 rounded shadow-sm border mb-6">
                <div class="mb-3">
                    <span id="previewKategoriEdit" class="bg-indigo-50 text-indigo-700 border border-indigo-100 font-semibold px-2 py-1 rounded text-xs uppercase"></span>
                </div>

                <h1 id="previewJudulEdit" class="text-2xl font-extrabold text-gray-900 mb-2 leading-tight"></h1>
                <p id="previewSubteksEdit" class="text-gray-600 italic mb-4"></p>
                
                <div class="flex items-center text-xs text-gray-500 mb-6 border-b pb-4">
                    <span class="mr-4"><i class="far fa-calendar-alt mr-1"></i> <?= date('d M Y') ?> (Diedit)</span>
                    <span><i class="far fa-user mr-1"></i> Administrator</span>
                </div>

                <div id="containerGambarPreviewEdit" class="w-full mb-6 rounded overflow-hidden flex justify-center hidden">
                    <img id="previewGambarEdit" src="" alt="Thumbnail Berita" class="max-w-full h-auto max-h-[350px] object-contain">
                </div>
                
               <div id="previewKontenEdit" class="konten-berita max-w-none text-gray-800 text-sm leading-relaxed text-justify"></div>
            </div>

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

<!-- Tambahan CSS Khusus Fullscreen Summernote -->
<style>
    .note-editor.note-frame.fullscreen {
        background-color: #ffffff !important;
        position: fixed !important;
        inset: 0 !important;
        z-index: 1050 !important;
    }
    .note-editor.note-frame.fullscreen .note-editing-area {
        background-color: #ffffff !important;
    }
</style>

<!-- Load Library jQuery & Summernote -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>

<script>
    // Fungsi Global untuk AJAX Upload Gambar (Tombol Picture)
    function uploadImage(file, editor) {
        let data = new FormData();
        data.append("image", file);
        
        let csrfName = '<?= csrf_token() ?>';
        let csrfHash = '<?= csrf_hash() ?>';
        data.append(csrfName, csrfHash);

        $.ajax({
            url: "<?= base_url('admin/berita/uploadImage') ?>",
            cache: false,
            contentType: false,
            processData: false,
            data: data,
            type: "POST",
            dataType: "json",
            success: function(response) {
                if(response && response.url) {
                    $(editor).summernote('insertImage', response.url);
                } else {
                    alert("Gagal membaca URL gambar.");
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error("Error Detail:", jqXHR.responseText);
                alert("Upload gambar gagal! Cek console (F12) untuk detailnya.");
            }
        });
    }

    // Fungsi Pembersih Sampah Variabel Tailwind dengan DOM Parser
    function cleanSummernoteHTML(html) {
        if (!html) return '';
        let tempDiv = document.createElement('div');
        tempDiv.innerHTML = html;
        let elements = tempDiv.getElementsByTagName('*');
        for (let i = 0; i < elements.length; i++) {
            let el = elements[i];
            if (el.hasAttribute('style')) {
                let styleStr = el.getAttribute('style');
                let cleanStyle = styleStr.replace(/--tw-[a-zA-Z0-9\-]+:\s*[^;]+;?\s*/g, '').trim();
                if (cleanStyle === '') {
                    el.removeAttribute('style');
                } else {
                    el.setAttribute('style', cleanStyle);
                }
            }
        }
        return tempDiv.innerHTML;
    }

    // Inisialisasi Summernote
    $(document).ready(function() {
        $('#editorTambah, #editorEdit').summernote({
            height: 300,
            dialogsInBody: true,
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'italic', 'underline', 'clear']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['insert', ['link', 'picture']],
                ['view', ['fullscreen', 'codeview']]
            ],
            callbacks: {
                onImageUpload: function(files) {
                    for (let i = 0; i < files.length; i++) {
                        uploadImage(files[i], this);
                    }
                }
            }
        });
    });

    // Fungsi Ekstraksi Data ke Modal Edit
    function openEditModal(btn, id) {
        document.getElementById('editId').value = btn.getAttribute('data-id');
        document.getElementById('editJudul').value = btn.getAttribute('data-judul');
        document.getElementById('editKategori').value = btn.getAttribute('data-kategori');
        document.getElementById('editSubteks').value = btn.getAttribute('data-subteks');
        document.getElementById('editStatus').value = btn.getAttribute('data-status');
        document.getElementById('editOldThumb').value = btn.getAttribute('data-thumb');
        
        let konten = document.getElementById('raw-konten-' + id).value;
        $('#editorEdit').summernote('code', konten);
        
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

    // --- LOGIKA MULTI-STEP FORM (PREVIEW) ---
    document.addEventListener('DOMContentLoaded', function() {
        // [Variabel Tambah]
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

        // [Variabel Edit]
        const areaInputEdit = document.getElementById('areaInputEdit');
        const areaPreviewEdit = document.getElementById('areaPreviewEdit');
        const formEditBerita = document.getElementById('formEditBerita');
        const editJudul = document.getElementById('editJudul');
        const editKategori = document.getElementById('editKategori');
        const editSubteks = document.getElementById('editSubteks');
        const editGambar = document.getElementById('editGambar');
        const editOldThumb = document.getElementById('editOldThumb');
        const previewJudulEdit = document.getElementById('previewJudulEdit');
        const previewKategoriEdit = document.getElementById('previewKategoriEdit');
        const previewSubteksEdit = document.getElementById('previewSubteksEdit');
        const previewKontenEdit = document.getElementById('previewKontenEdit');
        const containerGambarPreviewEdit = document.getElementById('containerGambarPreviewEdit');
        const previewGambarEdit = document.getElementById('previewGambarEdit');
        const btnToPreviewEdit = document.getElementById('btnToPreviewEdit');
        const btnBackToEditEdit = document.getElementById('btnBackToEditEdit');
        const btnSubmitFinalEdit = document.getElementById('btnSubmitFinalEdit');

        // Aksi menuju Preview Tambah
        btnToPreview.addEventListener('click', function() {
            if (!inputJudul.value || !inputKategori.value) {
                formBerita.reportValidity(); return;
            }
            let kontenHTML = cleanSummernoteHTML($('#editorTambah').summernote('code'));
            $('#editorTambah').summernote('code', kontenHTML); 
            
            const cleanText = kontenHTML.replace(/(<([^>]+)>)/gi, "").trim();
            if (cleanText === '') { alert("Isi berita tidak boleh kosong!"); return; }

            previewJudul.textContent = inputJudul.value;
            previewKategori.textContent = inputKategori.options[inputKategori.selectedIndex].text;
            previewSubteks.textContent = inputSubteks.value;
            previewKonten.innerHTML = kontenHTML;

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

            areaInput.classList.add('hidden');
            areaPreview.classList.remove('hidden');
            document.querySelector('#modalTambah > div').scrollTo({ top: 0, behavior: 'smooth' });
        });

        btnBackToEdit.addEventListener('click', function() {
            areaPreview.classList.add('hidden');
            areaInput.classList.remove('hidden');
        });

        // Aksi Simpan Final (Tambah)
        btnSubmitFinal.addEventListener('click', function() {
            let finalHTML = cleanSummernoteHTML($('#editorTambah').summernote('code'));
            $('#editorTambah').val(finalHTML); 

            this.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Memproses...';
            this.classList.add('opacity-75', 'cursor-not-allowed');
            this.disabled = true;
            formBerita.submit();
        });

        // Aksi menuju Preview Edit
        btnToPreviewEdit.addEventListener('click', function() {
            if (!editJudul.value || !editKategori.value) {
                formEditBerita.reportValidity(); return;
            }
            
            let kontenHTMLEdit = cleanSummernoteHTML($('#editorEdit').summernote('code'));
            $('#editorEdit').summernote('code', kontenHTMLEdit); 
            
            const cleanTextEdit = kontenHTMLEdit.replace(/(<([^>]+)>)/gi, "").trim();
            if (cleanTextEdit === '') { alert("Isi berita tidak boleh kosong!"); return; }

            previewJudulEdit.textContent = editJudul.value;
            previewKategoriEdit.textContent = editKategori.options[editKategori.selectedIndex].text;
            previewSubteksEdit.textContent = editSubteks.value;
            previewKontenEdit.innerHTML = kontenHTMLEdit;

            const fileEdit = editGambar.files[0];
            if (fileEdit) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewGambarEdit.src = e.target.result;
                    containerGambarPreviewEdit.classList.remove('hidden');
                }
                reader.readAsDataURL(fileEdit);
            } else if (editOldThumb.value) {
                previewGambarEdit.src = "<?= base_url('uploads/berita/') ?>" + editOldThumb.value;
                containerGambarPreviewEdit.classList.remove('hidden');
            } else {
                previewGambarEdit.src = '';
                containerGambarPreviewEdit.classList.add('hidden');
            }

            areaInputEdit.classList.add('hidden');
            areaPreviewEdit.classList.remove('hidden');
            document.querySelector('#modalEdit > div').scrollTo({ top: 0, behavior: 'smooth' });
        });

        btnBackToEditEdit.addEventListener('click', function() {
            areaPreviewEdit.classList.add('hidden');
            areaInputEdit.classList.remove('hidden');
        });

        // Aksi Simpan Final (Edit)
        btnSubmitFinalEdit.addEventListener('click', function() {
            let finalHTML = cleanSummernoteHTML($('#editorEdit').summernote('code'));
            $('#editorEdit').val(finalHTML); 

            this.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Memproses...';
            this.classList.add('opacity-75', 'cursor-not-allowed');
            this.disabled = true;
            formEditBerita.submit();
        });
    });
</script>

<?= $this->endSection() ?>