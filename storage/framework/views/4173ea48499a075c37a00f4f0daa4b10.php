<!doctype html>
<html lang="pt">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">

    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
    <?php echo \Livewire\Mechanisms\FrontendAssets\FrontendAssets::styles(); ?>

</head>

<body class="bg-base-200">

    <div class="bg-base-300 shadow">
        <div class="navbar max-w-7xl mx-auto px-6">
            <div class="flex-1">
                <span class="text-lg font-bold">📚 Biblioteca</span>
            </div>
            <div class="flex-none">
                <?php echo $__env->make('navigation-menu', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            </div>
        </div>
    </div>

    <main class="max-w-7xl mx-auto px-6 py-6">
        <?php echo e($slot); ?>

    </main>

    <?php echo \Livewire\Mechanisms\FrontendAssets\FrontendAssets::scripts(); ?>

</body>
</html>
<?php /**PATH C:\Users\Rafael\Herd\biblioteca\resources\views/layouts/app.blade.php ENDPATH**/ ?>