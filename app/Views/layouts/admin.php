<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Admin Panel' ?> - SMAN 1 Semarang</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 flex h-screen overflow-hidden text-gray-800 font-sans">

    <!-- Sidebar Master -->
    <?= $this->include('partials/sidebar_admin') ?>

    <!-- Main Content Area -->
    <div class="flex-1 flex flex-col overflow-y-auto">
        <!-- Topbar Master -->
        <header class="h-20 bg-white shadow-sm flex items-center justify-between px-8 z-10">
            <h1 class="text-2xl font-bold text-gray-800"><?= $title ?? 'Dashboard' ?></h1>
            <div class="flex items-center gap-4">
                <div class="text-right hidden md:block">
                    <p class="text-sm font-bold text-gray-800"><?= esc(session()->get('username')) ?></p>
                    <p class="text-xs text-blue-600 font-semibold uppercase">Administrator</p>
                </div>
                <div class="w-10 h-10 rounded-full bg-blue-100 border border-blue-200 flex items-center justify-center text-blue-600 font-bold text-lg">
                    <?= strtoupper(substr(session()->get('username'), 0, 1)) ?>
                </div>
            </div>
        </header>

        <!-- Disini konten spesifik per halaman akan dirender -->
        <main class="p-8">
            <?= $this->renderSection('content') ?>
        </main>
    </div>

</body>
</html>