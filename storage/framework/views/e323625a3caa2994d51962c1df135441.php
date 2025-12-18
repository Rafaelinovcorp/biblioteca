<?php $__env->startSection('content'); ?>
    <div class="header">
        Nova Requisição #<?php echo e($requisicao->numero); ?>

    </div>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($requisicao->livro->capa): ?>
        <img src="<?php echo e(asset('storage/'.$requisicao->livro->capa)); ?>">
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <p>
        O utilizador <strong><?php echo e($requisicao->user->name); ?></strong>
        efetuou uma nova requisição.
    </p>

    <ul>
        <li><strong>Livro:</strong> <?php echo e($requisicao->livro->nome); ?></li>
        <li><strong>Email:</strong> <?php echo e($requisicao->user->email); ?></li>
        <li><strong>Entrega prevista:</strong> <?php echo e($requisicao->data_fim_previsto->format('d/m/Y')); ?></li>
    </ul>

    <a href="<?php echo e(url('/requisicoes')); ?>" class="btn">
        Gerir Requisições
    </a>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('emails.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Rafael\Herd\biblioteca\resources\views/emails/requisicao_nova_admin.blade.php ENDPATH**/ ?>