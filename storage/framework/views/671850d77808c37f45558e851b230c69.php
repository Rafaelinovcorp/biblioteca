<?php $__env->startSection('content'); ?>

<h1 class="text-2xl font-bold mb-6">📊 Dashboard</h1>


<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->user()->role === 'admin'): ?>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="card bg-base-100 shadow p-4">
        <div class="text-sm text-gray-500">Requisições Ativas</div>
        <div class="text-3xl font-bold"><?php echo e($requisicoesAtivas); ?></div>
    </div>

    <div class="card bg-base-100 shadow p-4">
        <div class="text-sm text-gray-500">Últimos 30 dias</div>
        <div class="text-3xl font-bold"><?php echo e($requisicoes30Dias); ?></div>
    </div>

    <div class="card bg-base-100 shadow p-4">
        <div class="text-sm text-gray-500">Entregues Hoje</div>
        <div class="text-3xl font-bold"><?php echo e($entreguesHoje); ?></div>
    </div>
</div>

<?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>


<?php if(auth()->user()->role === 'cidadao'): ?>

<div class="card bg-base-100 shadow p-6">
    <div class="text-sm text-gray-500">As tuas requisições ativas</div>
    <div class="text-3xl font-bold mb-4"><?php echo e($minhasRequisicoes); ?></div>

    <a href="<?php echo e(route('requisicoes.index')); ?>" class="btn btn-primary btn-sm">
        Ver Requisições
    </a>
</div>

<?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Rafael\Herd\biblioteca\resources\views/dashboard.blade.php ENDPATH**/ ?>