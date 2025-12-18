<?php $__env->startSection('content'); ?>

<div class="flex items-center justify-between mb-6">
    <h1 class="text-2xl font-bold">📚 Catálogo de Livros</h1>

<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->check() && auth()->user()->role === 'admin'): ?>
    <a href="<?php echo e(route('livros.create')); ?>" class="btn btn-primary btn-sm">
        + Novo Livro
    </a>
<?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>


</div>

<div class="overflow-x-auto bg-base-100 rounded shadow">
    <table class="table table-zebra w-full">
        <thead>
            <tr>
                <th>Nome</th>
                <th>ISBN</th>
                <th>Editora</th>
                <th>Estado</th>
                <th class="text-right"></th>
            </tr>
        </thead>
        <tbody>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $livros; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $livro): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($livro->nome); ?></td>
                    <td><?php echo e($livro->isbn); ?></td>
                    <td><?php echo e($livro->editora->nome ?? '-'); ?></td>
                    <td>
                        <span class="badge badge-success">Disponível</span>
                    </td>
                    <td class="text-right">
                        <a href="<?php echo e(route('livros.show', $livro)); ?>" class="btn btn-xs btn-outline">
                            Ver
                        </a>
                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </tbody>
    </table>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.default', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Rafael\Herd\biblioteca\resources\views/livros/index.blade.php ENDPATH**/ ?>