<?php $__env->startSection('content'); ?>

<div class="flex items-center justify-between mb-6">
    <h1 class="text-2xl font-bold">📚 Catálogo de Livros</h1>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->check() && auth()->user()->role === 'admin'): ?>
        <a href="<?php echo e(route('livros.create')); ?>" class="btn btn-primary btn-sm">
            + Novo Livro
        </a>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
</div>


<form method="GET"
      class="mb-4 flex flex-wrap gap-3 items-end justify-end">

    
    <div>
        <label class="label">
            <span class="label-text">Pesquisar</span>
        </label>
        <input type="text"
               name="search"
               value="<?php echo e(request('search')); ?>"
               placeholder="Nome ou ISBN"
               class="input input-bordered input-sm w-52">
    </div>

    
    <div>
        <label class="label">
            <span class="label-text">Editora</span>
        </label>
        <select name="editora" class="select select-bordered select-sm w-48">
            <option value="" selected hidden>Todas</option>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $editoras; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $editora): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($editora->id); ?>"
                    <?php if(request('editora') == $editora->id): echo 'selected'; endif; ?>>
                    <?php echo e($editora->nome); ?>

                </option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </select>
    </div>

    
    <div>
        <label class="label">
            <span class="label-text">Estado</span>
        </label>
        <select name="estado" class="select select-bordered select-sm w-40">
            <option value="" selected hidden>Todas</option>
            <option value="disponivel" <?php if(request('estado') === 'disponivel'): echo 'selected'; endif; ?>>
                Disponível
            </option>
            <option value="requisitado" <?php if(request('estado') === 'requisitado'): echo 'selected'; endif; ?>>
                Requisitado
            </option>
        </select>
    </div>

    
    <div>
        <label class="label">
            <span class="label-text">Preço min (€)</span>
        </label>
        <input type="number"
               step="0.01"
               name="preco_min"
               value="<?php echo e(request('preco_min')); ?>"
               class="input input-bordered input-sm w-32">
    </div>

    
    <div>
        <label class="label">
            <span class="label-text">Preço máx (€)</span>
        </label>
        <input type="number"
               step="0.01"
               name="preco_max"
               value="<?php echo e(request('preco_max')); ?>"
               class="input input-bordered input-sm w-32">
    </div>

    
    <div class="flex gap-2">
        <button class="btn btn-sm btn-primary">
            Filtrar
        </button>

        <a href="<?php echo e(route('livros.index')); ?>"
           class="btn btn-sm btn-ghost">
            Limpar
        </a>
    </div>

</form>


<div class="overflow-x-auto bg-base-100 rounded shadow">
    <table class="table table-zebra w-full">
        <thead>
            <tr>
                <th>Nome</th>
                <th>ISBN</th>
                <th>Editora</th>
                <th>Estado</th>

                <th class="text-right">
                    <a href="<?php echo e(route('livros.index', array_merge(request()->all(), [
                        'sort' => 'preco',
                        'direction' => request('direction') === 'asc' ? 'desc' : 'asc'
                    ]))); ?>"
                       class="flex items-center gap-1 justify-end">
                        Preço
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(request('sort') === 'preco'): ?>
                            <?php echo e(request('direction') === 'asc' ? '⬆️' : '⬇️'); ?>

                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </a>
                </th>

                <th class="text-right">Ações</th>
            </tr>
        </thead>

        <tbody>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $livros; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $livro): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td><?php echo e($livro->nome); ?></td>
                    <td><?php echo e($livro->isbn); ?></td>
                    <td><?php echo e($livro->editora->nome ?? '-'); ?></td>

                    <td>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($livro->isDisponivel()): ?>
                            <span class="badge badge-success">
                                Disponível
                            </span>
                        <?php else: ?>
                            <span class="badge badge-warning">
                                Requisitado
                            </span>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </td>

                    <td class="text-right">
                        <?php echo e(number_format($livro->preco, 2, ',', '.')); ?> €
                    </td>

                    <td class="text-right space-x-1">
                        <a href="<?php echo e(route('livros.show', $livro)); ?>"
                           class="btn btn-xs btn-outline">
                            Ver
                        </a>

                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($livro->estado === 'disponivel'): ?>
                            <form method="POST" action="<?php echo e(route('carrinho.add', $livro)); ?>">
                                <?php echo csrf_field(); ?>
                                <button class="btn btn-sm btn-primary">
                                    🛒 Adicionar
                                </button>
                            </form>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>


                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->check() && auth()->user()->role === 'admin'): ?>
                            <a href="<?php echo e(route('livros.edit', $livro)); ?>"
                               class="btn btn-xs btn-warning">
                                Editar
                            </a>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="6"
                        class="text-center text-gray-500">
                        Nenhum livro encontrado.
                    </td>
                </tr>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </tbody>
    </table>
</div>


<div class="mt-4">
    <?php echo e($livros->links()); ?>

</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.default', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Rafael\Herd\biblioteca\resources\views/livros/index.blade.php ENDPATH**/ ?>