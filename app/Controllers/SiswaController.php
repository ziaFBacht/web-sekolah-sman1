<?php

namespace App\Controllers;
use App\Models\SiswaModel;

class SiswaController extends BaseController
{
    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        session();
    }

    public function index()
    {
        // Pastikan yang login benar-benar siswa
        if (!session()->get('isLoggedIn') || session()->get('role') !== 'siswa') {
            return redirect()->to('/login');
        }

        $siswaModel = new SiswaModel();
        
        // Username yang dipakai login (diasumsikan sebagai NISN)
        $nisn = session()->get('username'); 

        // Cari data master siswa yang NISN-nya cocok dengan username
        $profilSiswa = $siswaModel->where('nisn', $nisn)->first();

        $data = [
            'title' => 'Portal Siswa',
            'username' => $nisn,
            'profil' => $profilSiswa // Kirim profil lengkap ke view
        ];

        return view('siswa/dashboard', $data);
    }
}