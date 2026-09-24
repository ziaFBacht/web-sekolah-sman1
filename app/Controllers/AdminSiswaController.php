<?php

namespace App\Controllers;

use App\Models\SiswaModel;
use App\Models\AuditLogModel;

class AdminSiswaController extends BaseController
{
    protected $auditLog;

    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        session(); 
        
        // Inisialisasi model audit log di sini agar bisa diakses semua fungsi
        $this->auditLog = new AuditLogModel();
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

        $siswaModel = new SiswaModel();
        
        $data = [
            'title' => 'Data Induk Siswa',
            'siswa' => $siswaModel->select('siswa.*, users.username')
                      ->join('users', 'users.id = siswa.user_id', 'left')
                      ->orderBy('kelas', 'ASC')
                      ->findAll()
        ];

        return view('admin/siswa', $data);
    }

    public function store()
    {
        if (!$this->checkAccess()) return redirect()->to('/login');

        $rules = [
            'nisn'         => 'required|is_unique[siswa.nisn]',
            'nama_lengkap' => 'required',
            'kelas'        => 'required',
            'jurusan'      => 'required'
        ];

        if (!$this->validate($rules)) {
            session()->setFlashdata('error', 'Gagal menambahkan data. Pastikan NISN belum terdaftar.');
            return redirect()->back();
        }

        $siswaModel = new SiswaModel();
        $siswaModel->insert($this->request->getPost());
        $newSiswaId = $siswaModel->getInsertID(); 

        // Pemanggilan log untuk INSERT menggunakan $this->
        $this->auditLog->recordLog('INSERT', 'siswa', $newSiswaId, $this->request->getPost('nama_lengkap'));

        return redirect()->to('/admin/siswa')->with('success', 'Data berhasil ditambahkan');
    }

    public function update()
    {
        if (!$this->checkAccess()) return redirect()->to('/login');

        $siswaModel = new SiswaModel();
        $id = $this->request->getPost('id');
        
        $siswaModel->update($id, [
            'nisn'         => $this->request->getPost('nisn'),
            'nama_lengkap' => $this->request->getPost('nama_lengkap'),
            'kelas'        => $this->request->getPost('kelas'),
            'jurusan'      => $this->request->getPost('jurusan'),
        ]);

        // Pemanggilan log untuk UPDATE
        $this->auditLog->recordLog('UPDATE', 'siswa', $id, $this->request->getPost('nama_lengkap'));

        return redirect()->to('/admin/siswa')->with('success', 'Data berhasil diupdate');
    }

    public function delete($id)
    {
        if (!$this->checkAccess()) return redirect()->to('/login');

        $siswaModel = new SiswaModel();
        $siswa = $siswaModel->find($id);
        $siswaModel->delete($id);

        // Pemanggilan log untuk DELETE
        $this->auditLog->recordLog('DELETE', 'siswa', $id, $siswa['nama_lengkap']);

        return redirect()->to('/admin/siswa')->with('success', 'Data berhasil dihapus');
    }
}