<?php

namespace App\Controllers;
use App\Models\UserModel;
use App\Models\AuditLogModel;

class AdminController extends BaseController
{
    protected $auditLog;

    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        session(); 
        
        $this->auditLog = new AuditLogModel();
    }

    public function index()
    {
        if (!session()->get('isLoggedIn') || session()->get('role') !== 'admin') {
            session()->setFlashdata('error', 'Akses ditolak. Silakan login sebagai Admin.');
            return redirect()->to('/login');
        }

        $siswaModel = new \App\Models\SiswaModel();
        $userModel  = new \App\Models\UserModel();
        $guruModel  = new \App\Models\GuruModel();

        // Tangkap parameter filter dari URL
        $search       = $this->request->getGet('search');
        $action       = $this->request->getGet('action');
        $table        = $this->request->getGet('table');
        $dateOperator = $this->request->getGet('date_operator'); // before, exact, after
        $dateValue    = $this->request->getGet('date_value');    // Format: YYYY-MM-DD

        // Mulai susun query
        $logQuery = $this->auditLog->select('audit_logs.*, users.username')
                                   ->join('users', 'users.id = audit_logs.user_id', 'left');

        // Terapkan Filter Teks & Dropdown
        if (!empty($search)) {
            $logQuery->groupStart()
                     ->like('audit_logs.record_name', $search)
                     ->orLike('users.username', $search)
                     ->groupEnd();
        }

        if (!empty($action)) {
            $logQuery->where('audit_logs.action', $action);
        }

        if (!empty($table)) {
            $logQuery->where('audit_logs.table_name', $table);
        }

        // Terapkan Filter Tanggal Spesifik
        if (!empty($dateValue)) {
            if ($dateOperator === 'before') {
                // Sebelum tanggal (hingga 23:59:59 hari sebelumnya)
                $logQuery->where('audit_logs.created_at <', $dateValue . ' 00:00:00');
            } elseif ($dateOperator === 'after') {
                // Setelah tanggal (mulai 00:00:00 hari berikutnya)
                $logQuery->where('audit_logs.created_at >', $dateValue . ' 23:59:59');
            } else {
                // Tepat pada tanggal yang dipilih (00:00:00 s.d. 23:59:59)
                $logQuery->groupStart()
                         ->where('audit_logs.created_at >=', $dateValue . ' 00:00:00')
                         ->where('audit_logs.created_at <=', $dateValue . ' 23:59:59')
                         ->groupEnd();
            }
        }

        // Urutan default selalu terbaru di atas
        $logQuery->orderBy('audit_logs.created_at', 'DESC');

        $data = [
            'title'       => 'Dashboard Admin',
            'username'    => session()->get('username'),
            'total_siswa' => $siswaModel->countAllResults(), 
            'total_guru'  => $guruModel->countAllResults(), 
            'total_admin' => $userModel->where('role', 'admin')->countAllResults(),
                        
            'logs'        => $logQuery->paginate(10),
            'pager'       => $this->auditLog->pager,
            
            // Kirim filter ke view agar form tidak ter-reset
            'filters'     => [
                'search'        => $search,
                'action'        => $action,
                'table'         => $table,
                'date_operator' => $dateOperator,
                'date_value'    => $dateValue
            ]
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

    public function storeUser()
    {
        if (session()->get('role') !== 'admin') return redirect()->to('/login');

        $userModel = new UserModel();
        $siswaModel = new \App\Models\SiswaModel(); 
        // Tambahkan pemanggilan GuruModel
        $guruModel = new \App\Models\GuruModel(); 

        $role = $this->request->getPost('role');
        // Input dari form bernama 'nisn' digunakan untuk NISN maupun NIP
        $nomorInduk = trim($this->request->getPost('nisn'));

        // Pengecekan & Validasi Data Master berdasarkan Role
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
        } elseif ($role === 'guru') {
            // Cek ke tabel guru berdasarkan NIP
            $guru = $guruModel->where('nip', $nomorInduk)->first();
            
            if (!$guru) {
                session()->setFlashdata('error', 'Gagal! NIP tidak ditemukan di Data Master Guru.');
                return redirect()->back();
            }
            if (!empty($guru['user_id'])) {
                session()->setFlashdata('error', 'Gagal! Guru ini sudah memiliki akun tertaut.');
                return redirect()->back();
            }
        }

        // Data untuk disimpan ke tabel users
        $dataUser = [
            'username' => $this->request->getPost('username'), 
            'password' => password_hash($this->request->getPost('password'), PASSWORD_BCRYPT),
            'role'     => $role,
            'email'    => $this->request->getPost('email'),
        ];
        
        $userModel->insert($dataUser);
        $newUserId = $userModel->getInsertID(); 

        $this->auditLog->recordLog('INSERT', 'users', $newUserId, $this->request->getPost('username'));

        // Menautkan user_id yang baru dibuat ke tabel master masing-masing
        if ($role === 'siswa') {
            $siswaModel->update($siswa['id'], ['user_id' => $newUserId]);
            $this->auditLog->recordLog('UPDATE', 'siswa', $siswa['id'], $siswa['nama_lengkap']);
        } elseif ($role === 'guru') {
            $guruModel->update($guru['id'], ['user_id' => $newUserId]);
            $this->auditLog->recordLog('UPDATE', 'guru', $guru['id'], $guru['nama_lengkap']);
        }

        session()->setFlashdata('success', 'Akun berhasil dibuat dan ditautkan.');
        return redirect()->to('/admin/users');
    }

    public function updateUser()
    {
        if (session()->get('role') !== 'admin') return redirect()->to('/login');

        $userModel = new UserModel();
        $id = $this->request->getPost('id');
        $user = $userModel->find($id);

        $data = [
            // Tambahkan baris ini untuk menyimpan perubahan username
            'username' => $this->request->getPost('username'), 
            
            'role'  => $this->request->getPost('role'),
            'email' => $this->request->getPost('email'),
        ];

        $newPassword = $this->request->getPost('password');
        if (!empty($newPassword)) {
            $data['password'] = password_hash($newPassword, PASSWORD_BCRYPT);
        }

        $userModel->update($id, $data);
        
        // Memperbarui nama username di log jika ada perubahan
        $this->auditLog->recordLog('UPDATE', 'users', $id, $this->request->getPost('username'));

        session()->setFlashdata('success', 'Data akun berhasil diperbarui.');
        return redirect()->to('/admin/users');
    }

   public function deleteUser($id)
    {
        if (session()->get('role') !== 'admin') return redirect()->to('/login');

        $userModel = new UserModel();
        $siswaModel = new \App\Models\SiswaModel();
        // Tambahkan pemanggilan GuruModel
        $guruModel = new \App\Models\GuruModel();
        
        $user = $userModel->find($id);
        
        if ($id == session()->get('id')) {
            session()->setFlashdata('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
            return redirect()->back();
        }

        // Lepas tautan (set null) di tabel siswa DAN guru sebelum akun dihapus
        $siswaModel->where('user_id', $id)->set(['user_id' => null])->update();
        $guruModel->where('user_id', $id)->set(['user_id' => null])->update();
        
        $userModel->delete($id);
        
        $this->auditLog->recordLog('DELETE', 'users', $id, $user['username']);

        session()->setFlashdata('success', 'Akun berhasil dihapus dan tautan dilepas.');
        return redirect()->to('/admin/users');
    }

    public function searchNomorInduk()
    {
        if (!session()->get('isLoggedIn') || session()->get('role') !== 'admin') {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Unauthorized']);
        }

        $keyword = $this->request->getGet('q');
        $role = $this->request->getGet('role'); // 'siswa' atau 'guru'

        $results = [];

        if (strlen($keyword) >= 2) { 
            if ($role === 'siswa') {
                $siswaModel = new \App\Models\SiswaModel();
                $data = $siswaModel->select('nisn as id, nama_lengkap as nama')
                                   ->like('nisn', $keyword)
                                   // Gunakan array atau string raw untuk IS NULL
                                   ->where('user_id IS NULL') 
                                   ->limit(10)
                                   ->findAll();
                $results = $data;
            } elseif ($role === 'guru') {
                $guruModel = new \App\Models\GuruModel();
                $data = $guruModel->select('nip as id, nama_lengkap as nama')
                                  ->like('nip', $keyword)
                                  // Gunakan string raw untuk IS NULL
                                  ->where('user_id IS NULL') 
                                  ->limit(10)
                                  ->findAll();
                $results = $data;
            }
        }

        return $this->response->setJSON($results);

        return $this->response->setJSON($results);
    }
}