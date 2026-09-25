<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $this->renderSection('title') ?> | SMA Negeri 1 Semarang</title>
    <!-- Tailwind CSS via CDN untuk Development -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#1e3a8a', // Biru Tua Elegan
                        secondary: '#fbbf24', // Kuning Emas
                    }
                }
            }
        }
    </script>
    <!-- Font Awesome untuk Ikon -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-50 text-gray-800 font-sans antialiased flex flex-col min-h-screen">

    <!-- Memanggil Navbar -->
    <?= $this->include('partials/navbar') ?>

    <!-- Area Konten Dinamis -->
    <main class="flex-grow">
        <?= $this->renderSection('content') ?>
    </main>

    <!-- Memanggil Footer -->
    <?= $this->include('partials/footer') ?>

</body>
</html>