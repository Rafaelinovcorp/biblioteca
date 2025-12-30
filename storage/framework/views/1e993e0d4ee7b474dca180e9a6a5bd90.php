

<?php $__env->startSection('header'); ?>
    <h2 class="font-semibold text-xl">Reviews Pendentes</h2>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-5xl mx-auto space-y-6">

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $reviews; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $review): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <div class="card bg-base-100 shadow p-4 space-y-3">

            <div class="text-sm text-gray-500">
                Livro: <strong><?php echo e($review->livro->nome); ?></strong><br>
                Utilizador: <?php echo e($review->user->name); ?>

            </div>

            <p><?php echo e($review->comentario); ?></p>

            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($review->rating): ?>
                <p>⭐ Classificação: <?php echo e($review->rating); ?>/5</p>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

            <div class="flex gap-2">
                
                <form method="POST"
                      action="<?php echo e(route('reviews.aprovar', $review)); ?>">
                    <?php echo csrf_field(); ?>
                    <button class="btn btn-success btn-sm">
                        Aprovar
                    </button>
                </form>

                
                <form method="POST"
                      action="<?php echo e(route('reviews.recusar', $review)); ?>">
                    <?php echo csrf_field(); ?>
                    <input type="text"
                           name="justificacao"
                           placeholder="Justificação"
                           class="input input-bordered input-sm"
                           required>

                    <button class="btn btn-error btn-sm">
                        Recusar
                    </button>
                </form>
            </div>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <p class="text-center text-gray-500">
            Não existem reviews pendentes.
        </p>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.default', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Rafael\Herd\biblioteca\resources\views/reviews/pendentes.blade.php ENDPATH**/ ?>