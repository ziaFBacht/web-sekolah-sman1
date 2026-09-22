<?php

namespace App\Controllers;
use App\Models\SiswaModel;

class AdminSiswaController extends BaseController
{
    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        session(); 
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

        session()->setFlashdata('success', 'Data siswa berhasil ditambahkan.');
        return redirect()->to('/admin/siswa');
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

        session()->setFlashdata('success', 'Data siswa berhasil diperbarui.');
        return redirect()->to('/admin/siswa');
    }

    public function delete($id)
    {
        if (!$this->checkAccess()) return redirect()->to('/login');

        $siswaModel = new SiswaModel();
        $siswaModel->delete($id);

        session()->setFlashdata('success', 'Data siswa berhasil dihapus.');
        return redirect()->to('/admin/siswa');
    }
}