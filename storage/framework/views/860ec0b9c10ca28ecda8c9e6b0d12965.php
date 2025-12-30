<?php $__env->startSection('header'); ?>
    <div class="flex justify-between items-center">
        <h2 class="font-semibold text-xl">Requisições</h2>

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->guard()->check()): ?>
            <a href="<?php echo e(route('requisicoes.create')); ?>" class="btn btn-primary btn-sm">
                + Nova Requisição
            </a>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="p-6">
        <div class="overflow-x-auto bg-base-100 rounded shadow">
            <table class="table table-zebra w-full">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Livro</th>
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('admin')): ?>
                            <th>Cidadão</th>
                        <?php endif; ?>
                        <th>Início</th>
                        <th>Estado</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $requisicoes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $r): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td><?php echo e($r->numero); ?></td>
                            <td><?php echo e($r->livro->nome); ?></td>

                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('admin')): ?>
                                <td><?php echo e($r->user->name); ?></td>
                            <?php endif; ?>

                            <td><?php echo e($r->data_inicio->format('d/m/Y')); ?></td>

                            <td>
                                <span class="badge
                                    <?php if($r->estado === 'pendente'): ?> badge-warning
                                    <?php elseif($r->estado === 'confirmado'): ?> badge-info
                                    <?php elseif($r->estado === 'entregue'): ?> badge-success
                                    <?php endif; ?>">
                                    <?php echo e(ucfirst($r->estado)); ?>

                                </span>
                            </td>

                            <td class="flex gap-2">

                                <a href="<?php echo e(route('requisicoes.show', $r)); ?>"
                                   class="btn btn-outline btn-sm">
                                    Ver
                                </a>

                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('admin')): ?>

                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($r->estado === 'pendente'): ?>
                                        <form method="POST"
                                              action="<?php echo e(route('requisicoes.confirmar', $r)); ?>">
                                            <?php echo csrf_field(); ?>
                                            <button class="btn btn-info btn-sm">
                                                Confirmar
                                            </button>
                                        </form>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($r->estado === 'confirmado'): ?>
                                        <form method="POST"
                                              action="<?php echo e(route('requisicoes.devolver', $r)); ?>">
                                            <?php echo csrf_field(); ?>
                                            <button class="btn btn-success btn-sm">
                                                Entregar
                                            </button>
                                        </form>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                                <?php endif; ?>
                            </td>

                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="6" class="text-center text-gray-500">
                                Nenhuma requisição encontrada.
                            </td>
                        </tr>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            <?php echo e($requisicoes->links()); ?>

        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.default', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Rafael\Herd\biblioteca\resources\views/requisicoes/index.blade.php ENDPATH**/ ?>