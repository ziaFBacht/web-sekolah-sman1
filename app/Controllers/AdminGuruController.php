<?php

namespace App\Controllers;

use App\Models\GuruModel;
use App\Models\AuditLogModel;

class AdminGuruController extends BaseController
{
    protected $auditLog;

    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        session(); 
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

        $guruModel = new GuruModel();
        
        $data = [
            'title' => 'Data Master Guru',
            'guru'  => $guruModel->select('guru.*, users.username')
                                 ->join('users', 'users.id = guru.user_id', 'left')
                                 ->orderBy('nama_lengkap', 'ASC')
                                 ->findAll()
        ];

        return view('admin/guru', $data);
    }

    public function store()
    {
        if (!$this->checkAccess()) return redirect()->to('/login');

        $rules = [
            'nip'            => 'required|is_unique[guru.nip]',
            'nama_lengkap'   => 'required',
            'mata_pelajaran' => 'required'
        ];

        if (!$this->validate($rules)) {
            session()->setFlashdata('error', 'Gagal menambah data. NIP mungkin sudah terdaftar.');
            return redirect()->back();
        }

        $guruModel = new GuruModel();
        $guruModel->insert($this->request->getPost());
        $newGuruId = $guruModel->getInsertID(); 

        $this->auditLog->recordLog('INSERT', 'guru', $newGuruId, $this->request->getPost('nama_lengkap'));
        
        return redirect()->to('/admin/guru')->with('success', 'Data guru berhasil ditambahkan');
    }

    public function update()
    {
        if (!$this->checkAccess()) return redirect()->to('/login');

        $guruModel = new GuruModel();
        $id = $this->request->getPost('id');
        
        $guruModel->update($id, [
            'nip'            => $this->request->getPost('nip'),
            'nama_lengkap'   => $this->request->getPost('nama_lengkap'),
            'mata_pelajaran' => $this->request->getPost('mata_pelajaran'),
        ]);

        $this->auditLog->recordLog('UPDATE', 'guru', $id, $this->request->getPost('nama_lengkap'));

        return redirect()->to('/admin/guru')->with('success', 'Data guru berhasil diupdate');
    }

    public function delete($id)
    {
        if (!$this->checkAccess()) return redirect()->to('/login');

        $guruModel = new GuruModel();
        $guru = $guruModel->find($id);
        
        if ($guru) {
            $guruModel->delete($id);
            $this->auditLog->recordLog('DELETE', 'guru', $id, $guru['nama_lengkap']);
        }

        return redirect()->to('/admin/guru')->with('success', 'Data guru berhasil dihapus');
    }
}