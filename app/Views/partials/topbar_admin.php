<header class="w-full h-20 bg-white shadow-sm flex items-center justify-between px-8 z-10">
    <h1 class="text-2xl font-bold text-gray-800"><?= esc($title ?? 'Dashboard') ?></h1>
    
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