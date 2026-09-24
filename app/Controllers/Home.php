<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index(): string
    {
        // return view('welcome_message');
        return view('pages/home');
    }

    public function profil()
    {
        $data = [
            'title' => 'Profil Sekolah'
        ];
        
        return view('pages/profil', $data);
    }

    public function berita()
    {
        $data = [
            'title' => 'Portal Berita Sekolah'
        ];
        
        return view('pages/berita', $data);
    }
}
