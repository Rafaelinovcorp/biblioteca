

<?php $__env->startSection('header'); ?>
    <div class="flex justify-between items-center">
        <h2 class="text-xl font-semibold">Editoras</h2>

       
            <a href="<?php echo e(route('editoras.create')); ?>" class="btn btn-primary">
                + Nova Editora
            </a>
     
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>


        <div class="p-6">

            <div class="overflow-x-auto bg-base-100 shadow rounded">
                <table class="table table-zebra w-full">
                    <thead>
                        <tr>
                            <th>Logótipo</th>
                            <th>Nome</th>
                            <th>Livros</th>
                            <th></th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $editoras; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $editora): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td>
                                    <img
                                        src="<?php echo e($editora->logotipo
                                            ? Storage::url($editora->logotipo)
                                            : 'https://via.placeholder.com/80x80?text=Editora'); ?>"
                                        class="w-16 h-16 object-contain"
                                        alt="Logótipo <?php echo e($editora->nome); ?>"
                                    >
                                </td>

                                <td><?php echo e($editora->nome); ?></td>
                                <td><?php echo e($editora->livros_count); ?></td>

                                <td class="flex gap-2">
                                    <a href="<?php echo e(route('editoras.show', $editora)); ?>"
                                       class="btn btn-sm">
                                        Ver
                                    </a>

                                    <a href="<?php echo e(route('editoras.edit', $editora)); ?>"
                                       class="btn btn-sm btn-warning">
                                        Editar
                                    </a>

                                    <form method="POST"
                                          action="<?php echo e(route('editoras.destroy', $editora)); ?>">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>

                                        <button class="btn btn-sm btn-error"
                                                onclick="return confirm('Eliminar editora?')">
                                            Apagar
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="4" class="text-center text-gray-500 py-6">
                                    Nenhuma editora registada.
                                </td>
                            </tr>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                <?php echo e($editoras->links()); ?>

            </div>

        </div>


   
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.default', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Rafael\Herd\biblioteca\resources\views/editoras/index.blade.php ENDPATH**/ ?>