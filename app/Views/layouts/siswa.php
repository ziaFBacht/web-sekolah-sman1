<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Portal Siswa' ?> - SMAN 1 Semarang</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = { theme: { extend: { colors: { primary: '#1e3a8a', secondary: '#fbbf24' } } } }
    </script>
    
    <!-- Font Awesome & Custom CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
</head>
<body class="bg-gray-100 flex h-screen overflow-hidden text-gray-800 font-sans">

    <!-- Sidebar -->
    <?= $this->include('partials/sidebar_siswa') ?>

    <!-- Kontainer Utama -->
    <div class="flex-1 flex flex-col overflow-hidden bg-gray-50">
        
        <!-- Topbar -->
        <?= $this->include('partials/topbar_siswa') ?>

        <!-- Area Konten Utama -->
        <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50 p-6">
            <?= $this->renderSection('content') ?>
        </main>

    </div>
</body>
</html>