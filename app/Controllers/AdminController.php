<?php

namespace App\Controllers;
use App\Models\UserModel; // Wajib dipanggil untuk fitur Users

class AdminController extends BaseController
{
    // Fitur ini otomatis dipanggil pertama kali saat Controller ini diakses
    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        // Panggil fungsi bawaan CI4
        parent::initController($request, $response, $logger);
        
        // AKTIFKAN SESSION DI SINI AGAR BISA DIPAKAI DI SEMUA FUNGSI ADMIN
        session(); 
    }

    public function index()
    {
        // Proteksi: Pastikan user sudah login dan memiliki role 'admin'
        if (!session()->get('isLoggedIn') || session()->get('role') !== 'admin') {
            session()->setFlashdata('error', 'Akses ditolak. Silakan login sebagai Admin.');
            return redirect()->to('/login');
        }

        // Kirim data username ke View
        $data = [
            'title'    => 'Dashboard Admin',
            'username' => session()->get('username')
        ];

        return view('admin/dashboard', $data);
    }

    public function users()
    {
        if (!session()->get('isLoggedIn') || session()->get('role') !== 'admin') {
            return redirect()->to('/login');
        }

        $userModel = new UserModel();
        
        $data = [
            'title'    => 'Kelola Pengguna',
            'username' => session()->get('username'),
            'users'    => $userModel->orderBy('created_at', 'DESC')->findAll()
        ];

        return view('admin/users', $data);
    }
    // 2. Proses Tambah Akun Baru
    public function storeUser()
    {
        if (session()->get('role') !== 'admin') return redirect()->to('/login');

        $userModel = new UserModel();
        $siswaModel = new \App\Models\SiswaModel(); // Panggil model siswa

        $role = $this->request->getPost('role');
        $nomorInduk = trim($this->request->getPost('nisn'));

        // LOGIKA VERIFIKASI SISWA
        if ($role === 'siswa') {
            $siswa = $siswaModel->where('nisn', $nomorInduk)->first();
            
            if (!$siswa) {
                session()->setFlashdata('error', 'Gagal! NISN tidak ditemukan di Data Master Siswa.');
                return redirect()->back();
            }
            if (!empty($siswa['user_id'])) {
                session()->setFlashdata('error', 'Gagal! Siswa ini sudah memiliki akun tertaut.');
                return redirect()->back();
            }
        }

        // Lanjut simpan ke tabel users
        $dataUser = [
            'username' => $this->request->getPost('username'), // Username sekarang bebas
            'password' => password_hash($this->request->getPost('password'), PASSWORD_BCRYPT),
            'role'     => $role,
            'email'    => $this->request->getPost('email'),
        ];
        
        $userModel->insert($dataUser);
        $newUserId = $userModel->getInsertID(); // Ambil ID user yang baru saja dibuat

        // TAUTKAN ID USER KE TABEL SISWA
        if ($role === 'siswa') {
            $siswaModel->update($siswa['id'], ['user_id' => $newUserId]);
        }

        session()->setFlashdata('success', 'Akun berhasil dibuat dan ditautkan.');
        return redirect()->to('/admin/users');
    }

    // 3. Proses Update Akun
    public function updateUser()
    {
        if (session()->get('role') !== 'admin') return redirect()->to('/login');

        $userModel = new UserModel();
        $id = $this->request->getPost('id');

        $data = [
            'role'  => $this->request->getPost('role'),
            'email' => $this->request->getPost('email'),
        ];

        // Jika admin mengisi field password baru, maka update hash passwordnya
        $newPassword = $this->request->getPost('password');
        if (!empty($newPassword)) {
            $data['password'] = password_hash($newPassword, PASSWORD_BCRYPT);
        }

        $userModel->update($id, $data);
        session()->setFlashdata('success', 'Data akun berhasil diperbarui.');
        return redirect()->to('/admin/users');
    }

    // 4. Proses Hapus Akun
   public function deleteUser($id)
    {
        if (session()->get('role') !== 'admin') return redirect()->to('/login');

        $userModel = new UserModel();
        $siswaModel = new \App\Models\SiswaModel();
        
        if ($id == session()->get('id')) {
            session()->setFlashdata('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
            return redirect()->back();
        }

        // Putuskan tautan di tabel siswa terlebih dahulu sebelum akun dihapus
        $siswaModel->where('user_id', $id)->set(['user_id' => null])->update();
        
        $userModel->delete($id);
        session()->setFlashdata('success', 'Akun berhasil dihapus dan tautan dilepas.');
        return redirect()->to('/admin/users');
    }
}