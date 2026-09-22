<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login Portal - SMAN 1 Semarang</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 h-screen flex items-center justify-center">

    <div class="bg-white p-8 rounded-xl shadow-lg w-full max-w-md">
        <div class="text-center mb-8">
            <!-- Gunakan logo yang sudah kamu simpan sebelumnya -->
            <img src="<?= base_url('assets/images/logo.png') ?>" alt="Logo" class="w-16 h-16 mx-auto mb-4">
            <h2 class="text-2xl font-bold text-gray-800">Portal Akademik</h2>
            <p class="text-gray-500 text-sm">Masuk dengan Username Anda</p>
        </div>

        <?php if(session()->getFlashdata('error')): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4 text-sm">
                <?= session()->getFlashdata('error') ?>
            </div>
        <?php endif; ?>

        <form action="<?= base_url('login/process') ?>" method="POST" class="space-y-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Username</label>
                <input type="text" name="username" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                <input type="password" name="password" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition">
            </div>

            <button type="submit" class="w-full bg-blue-900 hover:bg-blue-800 text-white font-bold py-3 px-4 rounded-lg transition duration-300">
                Masuk
            </button>
        </form>
        
        <p class="text-center text-xs text-gray-400 mt-6">Hanya Admin yang dapat membuat akun baru.</p>
    </div>

</body>
</html>