<aside class="w-64 bg-blue-900 text-white flex flex-col shadow-xl flex-shrink-0">
    <div class="h-20 flex items-center justify-center border-b border-blue-800">
        <span class="text-xl font-bold tracking-wider">SMAN 1 SMG</span>
    </div>
    
    <nav class="flex-grow py-6 px-4 space-y-2">
        <a href="<?= base_url('admin/dashboard') ?>" class="block py-2.5 px-4 rounded transition <?= (current_url() == base_url('admin/dashboard')) ? 'bg-blue-800 text-white font-bold' : 'hover:bg-blue-800 text-blue-200' ?>">
            <i class="fas fa-home w-6 text-center mr-2"></i> Dashboard
        </a>
        
        <div class="pt-4 pb-2">
            <p class="text-xs font-bold text-blue-400 uppercase tracking-wider px-4">Manajemen Akses</p>
        </div>
        
        <a href="<?= base_url('admin/users') ?>" class="block py-2.5 px-4 rounded transition <?= (strpos(current_url(), 'admin/users') !== false) ? 'bg-blue-800 text-white font-bold' : 'hover:bg-blue-800 text-blue-200' ?>">
            <i class="fas fa-user-shield w-6 text-center mr-2"></i> Kelola Akun Login
        </a>

        <div class="pt-4 pb-2">
            <p class="text-xs font-bold text-blue-400 uppercase tracking-wider px-4">Data Akademik</p>
        </div>

        <a href="<?= base_url('admin/siswa') ?>" class="block py-2.5 px-4 rounded transition <?= (strpos(current_url(), 'admin/siswa') !== false) ? 'bg-blue-800 text-white font-bold' : 'hover:bg-blue-800 hover:text-white text-blue-200' ?>">
            <i class="fas fa-user-graduate w-6 text-center mr-2"></i> Data Siswa
        </a>
        <a href="#" class="block py-2.5 px-4 rounded transition hover:bg-blue-800 hover:text-white text-blue-200">
            <i class="fas fa-chalkboard-teacher w-6 text-center mr-2"></i> Data Guru
        </a>
    </nav>

    <div class="p-4 border-t border-blue-800">
        <a href="<?= base_url('logout') ?>" class="block py-2 px-4 rounded text-center transition bg-red-600 hover:bg-red-700 text-white font-semibold">
            <i class="fas fa-sign-out-alt mr-2"></i> Logout
        </a>
    </div>
</aside>