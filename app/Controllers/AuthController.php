<?php

namespace App\Controllers;

use App\Models\UserModel;

class AuthController extends BaseController
{
    public function index()
    {
        // Jika sudah login, tendang ke dashboard masing-masing
        if (session()->get('isLoggedIn')) {
            return redirect()->to(session()->get('role') . '/dashboard');
        }
        return view('auth/login');
    }

    public function process()
    {
        $users = new UserModel();
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        $dataUser = $users->where('username', $username)->first();

        if ($dataUser) {
            if (password_verify($password, $dataUser['password'])) {
                session()->set([
                    'id'         => $dataUser['id'],
                    'username'   => $dataUser['username'],
                    'role'       => $dataUser['role'],
                    'isLoggedIn' => true
                ]);
                
                // Redirect berdasarkan role
                return redirect()->to($dataUser['role'] . '/dashboard');
            } else {
                session()->setFlashdata('error', 'Password salah.');
                return redirect()->back();
            }
        } else {
            session()->setFlashdata('error', 'Username tidak ditemukan.');
            return redirect()->back();
        }
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
}