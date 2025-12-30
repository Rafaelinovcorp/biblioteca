<?php $__env->startSection('content'); ?>

<div class="flex gap-6">
    <div class="w-1/3">
        <img
            src="<?php echo e($livro->capa ? asset('storage/'.$livro->capa) : 'https://via.placeholder.com/300'); ?>"
            alt="capa"
            class="rounded shadow"
        >
    </div>

    <div class="w-2/3">
        <h1 class="text-2xl font-bold"><?php echo e($livro->nome); ?></h1>

        <p class="text-sm text-gray-500">
            ISBN: <?php echo e($livro->isbn ?? '—'); ?>

        </p>

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($livro->categoria): ?>
            <p class="mt-2">
                Categoria:
                <span class="font-semibold">
                    <?php echo e($livro->categoria->nome); ?>

                </span>
            </p>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        <p class="mt-4">
            <?php echo e($livro->bibliografia); ?>

        </p>

        <p class="mt-2">
            Estado:
            <strong><?php echo e($livro->estado); ?></strong>
        </p>

        
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($livro->estado === 'disponivel'): ?>
            <a
                href="<?php echo e(route('requisicoes.create', ['livro_id' => $livro->id])); ?>"
                class="btn mt-4"
            >
                Requisitar
            </a>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($livro->estado === 'ocupado' && auth()->check() && !$alertaJaExiste): ?>
            <form
                method="POST"
                action="<?php echo e(route('alertas.store')); ?>"
                class="mt-4"
            >
                <?php echo csrf_field(); ?>
                <input type="hidden" name="livro_id" value="<?php echo e($livro->id); ?>">

                <button class="btn btn-warning">
                    🔔 Avisar quando disponível
                </button>
            </form>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($livro->estado === 'indisponivel' && $alertaJaExiste): ?>
            <p class="mt-4 text-sm text-gray-500">
                🔔 Já estás registado para ser avisado quando este livro ficar disponível.
            </p>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        <h3 class="mt-6 font-semibold">Histórico de Requisições</h3>
        <ul class="list-disc ml-6">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $livro->requisicoes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $r): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li>
                    #<?php echo e($r->numero); ?> —
                    <?php echo e($r->estado); ?> —
                    <?php echo e($r->data_inicio->format('Y-m-d')); ?>

                </li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </ul>
    </div>
</div>


<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($livro->reviews->where('estado', 'ativa')->count()): ?>
    <div class="mt-10">
        <h3 class="text-lg font-bold mb-4">Reviews dos Leitores</h3>

        <div class="space-y-4">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $livro->reviews->where('estado', 'ativa'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $review): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="card bg-base-100 shadow p-4">
                    <p class="font-semibold">
                        <?php echo e($review->user->name); ?>

                    </p>

                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($review->rating): ?>
                        <p>⭐ <?php echo e($review->rating); ?>/5</p>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                    <p class="mt-2">
                        <?php echo e($review->comentario); ?>

                    </p>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>
    </div>
<?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>


<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($relacionados->isNotEmpty()): ?>
    <h2 class="text-xl font-semibold mt-8 mb-4">📚 Recomendações</h2>

    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $relacionados; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $r): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <a href="<?php echo e(route('livros.show', $r)); ?>"
               class="card bg-base-200 shadow hover:shadow-lg transition">
                <div class="card-body">
                    <h3 class="font-semibold"><?php echo e($r->nome); ?></h3>
                    <p class="text-sm opacity-70"><?php echo e($r->categoria->nome); ?></p>
                </div>
            </a>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>
<?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.default', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Rafael\Herd\biblioteca\resources\views/livros/show.blade.php ENDPATH**/ ?>