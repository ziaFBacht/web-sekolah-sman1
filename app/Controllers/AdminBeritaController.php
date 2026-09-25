<?php

namespace App\Controllers;

use App\Models\BeritaModel;
use App\Models\AuditLogModel;

class AdminBeritaController extends BaseController
{
    protected $auditLog;

    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        session(); 
        $this->auditLog = new AuditLogModel();
        helper(['url', 'text']);
    }

    private function checkAccess()
    {
        if (!session()->get('isLoggedIn') || session()->get('role') !== 'admin') {
            session()->setFlashdata('error', 'Akses ditolak.');
            return false;
        }
        return true;
    }

    public function index()
    {
        if (!$this->checkAccess()) return redirect()->to('/login');

        $beritaModel = new BeritaModel();
        
        $data = [
            'title'  => 'Manajemen Berita',
            'berita' => $beritaModel->getBeritaWithAuthor()
        ];

        return view('admin/berita', $data);
    }

    public function store()
    {
        if (!$this->checkAccess()) return redirect()->to('/login');

        $beritaModel = new BeritaModel();
        $fileThumbnail = $this->request->getFile('thumbnail');
        $namaThumbnail = null;

        // Handle upload file
        if ($fileThumbnail && $fileThumbnail->isValid() && !$fileThumbnail->hasMoved()) {
            $namaThumbnail = $fileThumbnail->getRandomName();
            $fileThumbnail->move('uploads/berita', $namaThumbnail);
        }

        $judul = $this->request->getPost('judul');
        
        // Simpan ke database
        $beritaModel->insert([
            'judul'     => $judul,
            'slug'      => url_title($judul, '-', true) . '-' . time(), // Tambah time() agar slug selalu unik
            'kategori'  => $this->request->getPost('kategori'),
            'subteks'   => $this->request->getPost('subteks'),
            'konten'    => $this->request->getPost('konten'),
            'status'    => $this->request->getPost('status'),
            'thumbnail' => $namaThumbnail,
            'user_id'   => session()->get('id')
        ]);
        
        $newBeritaId = $beritaModel->getInsertID();
        $this->auditLog->recordLog('INSERT', 'berita', $newBeritaId, $judul);
        
        return redirect()->to('/admin/berita')->with('success', 'Berita berhasil diterbitkan.');
    }

    public function update()
    {
        if (!$this->checkAccess()) return redirect()->to('/login');

        $beritaModel = new BeritaModel();
        $id = $this->request->getPost('id');
        $judul = $this->request->getPost('judul');
        
        $fileThumbnail = $this->request->getFile('thumbnail');
        $oldThumbnail = $this->request->getPost('old_thumbnail');
        $namaThumbnail = $oldThumbnail;

        // Jika ada file baru yang diupload
        if ($fileThumbnail && $fileThumbnail->isValid() && !$fileThumbnail->hasMoved()) {
            // Hapus file lama jika ada
            if ($oldThumbnail && file_exists('uploads/berita/' . $oldThumbnail)) {
                unlink('uploads/berita/' . $oldThumbnail);
            }
            // Simpan file baru
            $namaThumbnail = $fileThumbnail->getRandomName();
            $fileThumbnail->move('uploads/berita', $namaThumbnail);
        }

        $beritaModel->update($id, [
            'judul'     => $judul,
            'slug'      => url_title($judul, '-', true) . '-' . time(),
            'kategori'  => $this->request->getPost('kategori'),
            'subteks'   => $this->request->getPost('subteks'),
            'konten'    => $this->request->getPost('konten'),
            'status'    => $this->request->getPost('status'),
            'thumbnail' => $namaThumbnail
        ]);

        $this->auditLog->recordLog('UPDATE', 'berita', $id, $judul);

        return redirect()->to('/admin/berita')->with('success', 'Berita berhasil diperbarui.');
    }

    public function delete($id)
    {
        if (!$this->checkAccess()) return redirect()->to('/login');

        $beritaModel = new BeritaModel();
        $berita = $beritaModel->find($id);
        
        if ($berita) {
            // Hapus file gambar dari server
            if ($berita['thumbnail'] && file_exists('uploads/berita/' . $berita['thumbnail'])) {
                unlink('uploads/berita/' . $berita['thumbnail']);
            }
            
            $beritaModel->delete($id);
            $this->auditLog->recordLog('DELETE', 'berita', $id, $berita['judul']);
        }

        return redirect()->to('/admin/berita')->with('success', 'Berita berhasil dihapus.');
    }
}