

<?php $__env->startSection('content'); ?>

<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold">Autores</h1>

    <a href="<?php echo e(route('autores.create')); ?>" class="btn btn-primary">
        + Novo Autor
    </a>
</div>

<div class="overflow-x-auto bg-base-100 shadow rounded">
    <table class="table table-zebra w-full">
        <thead>
            <tr>
                <th>Foto</th>
                <th>Nome</th>
                <th>Livros</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $autores; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $autor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td>
                        <img class="w-12 h-12 rounded-full object-cover"
                             src="<?php echo e($autor->foto
                                ? asset('storage/'.$autor->foto)
                                : 'https://ui-avatars.com/api/?name='.urlencode($autor->nome)); ?>">
                    </td>
                    <td><?php echo e($autor->nome); ?></td>
                    <td><?php echo e($autor->livros_count); ?></td>
                    <td class="flex gap-2">
                        <a href="<?php echo e(route('autores.show', $autor)); ?>" class="btn btn-sm">
                            Ver
                        </a>

                        <a href="<?php echo e(route('autores.edit', $autor)); ?>" class="btn btn-sm btn-warning">
                            Editar
                        </a>

                        <form method="POST" action="<?php echo e(route('autores.destroy', $autor)); ?>">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <button class="btn btn-sm btn-error"
                                    onclick="return confirm('Eliminar autor?')">
                                Apagar
                            </button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </tbody>
    </table>
</div>

<div class="mt-4">
    <?php echo e($autores->links()); ?>

</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.default', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Rafael\Herd\biblioteca\resources\views/autores/index.blade.php ENDPATH**/ ?>