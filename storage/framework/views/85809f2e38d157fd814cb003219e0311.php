<?php $__env->startSection('content'); ?>
    <div class="header">
        Requisição #<?php echo e($requisicao->numero); ?> confirmada
    </div>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($requisicao->livro->capa): ?>
        <img src="<?php echo e(asset('storage/'.$requisicao->livro->capa)); ?>">
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <p>Olá <strong><?php echo e($requisicao->user->name); ?></strong>,</p>

    <p>
        A tua requisição do livro
        <strong><?php echo e($requisicao->livro->nome); ?></strong>
        foi registada com sucesso.
    </p>

    <ul>
        <li><strong>Data início:</strong> <?php echo e($requisicao->data_inicio->format('d/m/Y')); ?></li>
        <li><strong>Entrega prevista:</strong> <?php echo e($requisicao->data_fim_previsto->format('d/m/Y')); ?></li>
    </ul>

    <a href="<?php echo e(url('/requisicoes')); ?>" class="btn">
        Ver Requisição
    </a>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('emails.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Rafael\Herd\biblioteca\resources\views/emails/requisicao_confirmada.blade.php ENDPATH**/ ?>