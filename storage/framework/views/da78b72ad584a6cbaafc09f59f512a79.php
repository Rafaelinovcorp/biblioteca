

<?php $__env->startSection('header'); ?>
    <h2 class="text-xl font-semibold">
        Google Books API
    </h2>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

    <div class="p-6 space-y-6">

        
        <form method="POST"
              action="<?php echo e(route('google-books.search')); ?>"
              class="flex gap-2">
            <?php echo csrf_field(); ?>

            <input name="q"
                   value="<?php echo e($query ?? ''); ?>"
                   class="input input-bordered w-full"
                   placeholder="Pesquisar por título, autor ou ISBN"
                   required>

            <button class="btn btn-primary">
                Pesquisar
            </button>
        </form>

        
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(isset($results)): ?>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $results; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $volumeId => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <?php
                        $info = $item['volumeInfo'] ?? [];
                    ?>

                    <div class="card bg-base-100 shadow p-4 space-y-2">
                        <h3 class="font-bold">
                            <?php echo e($info['title'] ?? 'Sem título'); ?>

                        </h3>

                        <p class="text-sm text-gray-600">
                            <?php echo e(implode(', ', $info['authors'] ?? [])); ?>

                        </p>

                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(isset($info['imageLinks']['thumbnail'])): ?>
                            <img class="w-32 mt-2"
                                 src="<?php echo e($info['imageLinks']['thumbnail']); ?>"
                                 alt="Capa do livro">
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                        
                        <a href="<?php echo e(route('google-books.confirm', $volumeId)); ?>"
   class="btn btn-success btn-sm mt-2">
   Importar
</a>

                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <p class="text-gray-500">
                        Nenhum resultado encontrado.
                    </p>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.default', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Rafael\Herd\biblioteca\resources\views/google-books/index.blade.php ENDPATH**/ ?>