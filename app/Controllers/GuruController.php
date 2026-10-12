<?php

namespace App\Controllers;
use App\Models\GuruModel;

class GuruController extends BaseController
{
    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        session();
    }

    public function index()
    {
        // Pastikan yang login benar-benar guru
        if (!session()->get('isLoggedIn') || session()->get('role') !== 'guru') {
            return redirect()->to('/login');
        }

        $guruModel = new GuruModel();
        
        // Username yang dipakai login (diasumsikan sebagai NIP)
        $nip = session()->get('username'); 

        // Cari data master guru yang NIP-nya cocok dengan username
        $profilGuru = $guruModel->where('nip', $nip)->first();

        $data = [
            'title'    => 'Portal Guru',
            'username' => $nip,
            'profil'   => $profilGuru // Kirim profil lengkap ke view
        ];

        return view('guru/dashboard', $data);
    }
}