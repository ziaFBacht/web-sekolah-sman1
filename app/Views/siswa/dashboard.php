<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?> - SMAN 1 Semarang</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-slate-50 min-h-screen font-sans text-gray-800">

    <!-- Navbar Siswa -->
    <nav class="bg-blue-600 text-white shadow-md">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <div class="flex items-center gap-2">
                    <i class="fas fa-graduation-cap text-2xl"></i>
                    <span class="font-bold text-xl tracking-wide">Portal Siswa</span>
                </div>
                <a href="<?= base_url('logout') ?>" class="bg-blue-700 hover:bg-blue-800 px-4 py-2 rounded-lg text-sm font-semibold transition">
                    <i class="fas fa-sign-out-alt mr-1"></i> Keluar
                </a>
            </div>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        <!-- Banner Selamat Datang -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-8 mb-8 flex items-center justify-between relative overflow-hidden">
            <div class="absolute right-0 top-0 w-64 h-full bg-gradient-to-l from-blue-50 to-transparent pointer-events-none"></div>
            
            <div class="relative z-10">
                <p class="text-sm text-blue-600 font-bold tracking-wider uppercase mb-1">Tahun Ajaran 2026/2027</p>
                
                <?php if($profil): ?>
                    <h1 class="text-3xl font-extrabold text-gray-900 mb-2">Halo, <?= esc($profil['nama_lengkap']) ?>! 👋</h1>
                    <p class="text-gray-500">Selamat datang kembali di portal akademik. Jangan lupa cek jadwal kelasmu hari ini.</p>
                <?php else: ?>
                    <h1 class="text-3xl font-extrabold text-gray-900 mb-2">Halo, <?= esc($username) ?>! 👋</h1>
                    <p class="text-amber-600 bg-amber-50 px-3 py-1 rounded inline-block text-sm font-semibold mt-2 border border-amber-200">
                        <i class="fas fa-exclamation-triangle mr-1"></i> Data profil belum dilengkapi oleh Tata Usaha.
                    </p>
                <?php endif; ?>
            </div>
        </div>

        <!-- Grid Konten -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <!-- Kartu Identitas -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
                    <div class="bg-slate-800 h-24"></div>
                    <div class="px-6 pb-6 relative">
                        <div class="w-20 h-20 bg-white rounded-full flex items-center justify-center border-4 border-white shadow-md absolute -top-10 text-3xl text-blue-600">
                            <i class="fas fa-user-circle"></i>
                        </div>
                        
                        <div class="mt-14">
                            <h3 class="font-bold text-lg text-gray-900">Kartu Pelajar Digital</h3>
                            
                            <div class="mt-4 space-y-3">
                                <div>
                                    <p class="text-xs text-gray-400 font-semibold uppercase">NISN (Username)</p>
                                    <p class="font-medium text-gray-800"><?= esc($username) ?></p>
                                </div>
                                <?php if($profil): ?>
                                <div>
                                    <p class="text-xs text-gray-400 font-semibold uppercase">Kelas</p>
                                    <p class="font-bold text-blue-600"><?= esc($profil['kelas']) ?> <?= esc($profil['jurusan']) ?></p>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modul Menu Cepat -->
            <div class="lg:col-span-2 grid grid-cols-2 md:grid-cols-3 gap-4">
                <a href="#" class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm hover:shadow-md hover:border-blue-200 transition text-center group">
                    <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-full flex items-center justify-center mx-auto mb-3 group-hover:scale-110 transition">
                        <i class="fas fa-calendar-alt text-xl"></i>
                    </div>
                    <h4 class="font-semibold text-gray-800 text-sm">Jadwal Pelajaran</h4>
                </a>
                
                <a href="#" class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm hover:shadow-md hover:border-blue-200 transition text-center group">
                    <div class="w-12 h-12 bg-green-50 text-green-600 rounded-full flex items-center justify-center mx-auto mb-3 group-hover:scale-110 transition">
                        <i class="fas fa-file-alt text-xl"></i>
                    </div>
                    <h4 class="font-semibold text-gray-800 text-sm">Transkrip Nilai</h4>
                </a>

                <a href="#" class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm hover:shadow-md hover:border-blue-200 transition text-center group">
                    <div class="w-12 h-12 bg-purple-50 text-purple-600 rounded-full flex items-center justify-center mx-auto mb-3 group-hover:scale-110 transition">
                        <i class="fas fa-money-check-alt text-xl"></i>
                    </div>
                    <h4 class="font-semibold text-gray-800 text-sm">Status SPP</h4>
                </a>
            </div>

        </div>
    </main>
</body>
</html>