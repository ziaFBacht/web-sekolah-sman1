<?php $pager->setSurroundCount(2) ?>

<nav class="inline-flex items-center gap-1">
    <?php if ($pager->hasPrevious()) : ?>
        <a href="<?= $pager->getPrevious() ?>" class="p-2 w-10 h-10 flex items-center justify-center rounded-lg text-gray-500 hover:bg-gray-100 transition-colors">
            <i class="fas fa-chevron-left text-sm"></i>
        </a>
    <?php endif ?>

    <?php foreach ($pager->links() as $link) : ?>
        <a href="<?= $link['uri'] ?>" class="w-10 h-10 flex items-center justify-center rounded-lg font-medium transition-colors <?= $link['active'] ? 'bg-blue-600 text-white font-semibold shadow-sm' : 'text-gray-700 hover:bg-gray-100' ?>">
            <?= $link['title'] ?>
        </a>
    <?php endforeach ?>

    <?php if ($pager->hasNext()) : ?>
        <a href="<?= $pager->getNext() ?>" class="p-2 w-10 h-10 flex items-center justify-center rounded-lg text-gray-500 hover:bg-gray-100 transition-colors">
            <i class="fas fa-chevron-right text-sm"></i>
        </a>
    <?php endif ?>
</nav>