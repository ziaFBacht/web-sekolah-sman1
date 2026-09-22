<?php
use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('/', 'Home::index');

// Routing Auth
$routes->get('login', 'AuthController::index');
$routes->post('login/process', 'AuthController::process');
$routes->get('logout', 'AuthController::logout');

// Kelompok rute khusus Admin
$routes->group('admin', function($routes) {
    $routes->get('dashboard', 'AdminController::index');
    
    // Kelola Akun
    $routes->get('users', 'AdminController::users');
    $routes->post('users/store', 'AdminController::storeUser');
    $routes->post('users/update', 'AdminController::updateUser');
    $routes->get('users/delete/(:num)', 'AdminController::deleteUser/$1');

    // PASTIKAN BARIS INI ADA DI SINI:
    $routes->get('siswa', 'AdminSiswaController::index');
    $routes->post('siswa/store', 'AdminSiswaController::store');
    $routes->post('siswa/update', 'AdminSiswaController::update');
    $routes->get('siswa/delete/(:num)', 'AdminSiswaController::delete/$1');
});

// Rute sementara untuk Guru & Siswa
$routes->get('guru/dashboard', 'GuruController::index');

$routes->group('siswa', function($routes) {
    $routes->get('dashboard', 'SiswaController::index');
});