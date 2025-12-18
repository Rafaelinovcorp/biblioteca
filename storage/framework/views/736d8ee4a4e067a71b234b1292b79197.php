

<?php $__env->startSection('header'); ?>
    <div class="flex justify-between items-center">
        <h2 class="text-xl font-semibold">Utilizadores</h2>

        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('admin')): ?>
            <a href="<?php echo e(route('users.create')); ?>" class="btn btn-primary">
                + Novo Utilizador
            </a>
        <?php endif; ?>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

        <div class="p-6">
            <div class="overflow-x-auto bg-base-100 shadow rounded">
                <table class="table table-zebra w-full">
                    <thead>
                        <tr>
                            <th>Foto</th>
                            <th>Nome</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td>
                                    <img class="w-12 h-12 rounded-full object-cover"
                                         src="<?php echo e($user->foto_perfil
                                            ? asset('storage/'.$user->foto_perfil)
                                            : 'https://ui-avatars.com/api/?name='.$user->name); ?>">
                                </td>
                                <td><?php echo e($user->name); ?></td>
                                <td><?php echo e($user->email); ?></td>
                                <td>
                                    <span class="badge <?php echo e($user->role === 'admin' ? 'badge-error' : 'badge-info'); ?>">
                                        <?php echo e(ucfirst($user->role)); ?>

                                    </span>
                                </td>
                                <td class="flex gap-2">
                                    <a href="<?php echo e(route('users.show', $user)); ?>"
                                       class="btn btn-sm">
                                        Ver
                                    </a>

                                    <a href="<?php echo e(route('users.edit', $user)); ?>"
                                       class="btn btn-sm btn-warning">
                                        Editar
                                    </a>

                                    <form method="POST"
                                          action="<?php echo e(route('users.destroy', $user)); ?>">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>

                                        <button class="btn btn-sm btn-error"
                                                onclick="return confirm('Eliminar utilizador?')">
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
                <?php echo e($users->links()); ?>

            </div>
        </div>


<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.default', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Rafael\Herd\biblioteca\resources\views/users/index.blade.php ENDPATH**/ ?>