<?php $__env->startSection('content'); ?>
<div class="flex gap-6">
    <div class="w-1/3">
        <img src="<?php echo e($livro->capa ? asset('storage/'.$livro->capa) : 'https://via.placeholder.com/300'); ?>" alt="capa">
    </div>
    <div class="w-2/3">
        <h1 class="text-2xl font-bold"><?php echo e($livro->nome); ?></h1>
        <p class="text-sm">ISBN: <?php echo e($livro->isbn); ?></p>
        <p class="mt-4"><?php echo e($livro->bibliografia); ?></p>
        <p class="mt-2">Estado: <strong><?php echo e($livro->estado); ?></strong></p>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($livro->estado === 'disponivel'): ?>
            <a href="<?php echo e(route('requisicoes.create', ['livro_id' => $livro->id])); ?>" class="btn mt-4">Requisitar</a>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        <h3 class="mt-6">Histórico de Requisições</h3>
        <ul>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $livro->requisicoes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $r): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li>#<?php echo e($r->numero); ?> - <?php echo e($r->estado); ?> - <?php echo e($r->data_inicio->format('Y-m-d')); ?></li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </ul>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.default', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Rafael\Herd\biblioteca\resources\views/livros/show.blade.php ENDPATH**/ ?>