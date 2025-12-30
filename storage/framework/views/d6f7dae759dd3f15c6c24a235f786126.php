<?php $__env->startSection('header'); ?>
    <div class="flex justify-between items-center">
        <h2 class="font-semibold text-xl">
            Requisição #<?php echo e($requisicao->numero); ?>

        </h2>

        <a href="<?php echo e(route('requisicoes.index')); ?>"
           class="btn btn-outline btn-sm">
            Voltar
        </a>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-3xl mx-auto space-y-6">

    
    <div class="card bg-base-100 shadow p-4">
        <h3 class="font-bold mb-2">Estado</h3>

        <span class="badge
            <?php if($requisicao->estado === 'pendente'): ?> badge-warning
            <?php elseif($requisicao->estado === 'confirmado'): ?> badge-info
            <?php elseif($requisicao->estado === 'devolucao_pedida'): ?> badge-accent
            <?php elseif($requisicao->estado === 'entregue'): ?> badge-success
            <?php else: ?> badge-neutral
            <?php endif; ?>">
            <?php echo e(ucfirst(str_replace('_', ' ', $requisicao->estado))); ?>

        </span>
    </div>

    
    <div class="card bg-base-100 shadow p-4">
        <h3 class="font-bold mb-2">Livro</h3>

        <p class="font-semibold">
            <?php echo e($requisicao->livro->nome); ?>

        </p>

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($requisicao->livro->editora): ?>
            <p class="text-sm text-gray-500">
                Editora: <?php echo e($requisicao->livro->editora->nome); ?>

            </p>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>

    
    <div class="card bg-base-100 shadow p-4">
        <h3 class="font-bold mb-2">Cidadão</h3>

        <p class="font-semibold">
            <?php echo e($requisicao->user->name); ?>

        </p>
        <p class="text-sm text-gray-500">
            <?php echo e($requisicao->user->email); ?>

        </p>
    </div>

    
    <div class="card bg-base-100 shadow p-4">
        <h3 class="font-bold mb-2">Datas</h3>

        <ul class="space-y-1 text-sm">
            <li><strong>Início:</strong> <?php echo e($requisicao->data_inicio->format('d/m/Y')); ?></li>
            <li><strong>Entrega prevista:</strong> <?php echo e($requisicao->data_fim_previsto->format('d/m/Y')); ?></li>

            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($requisicao->data_fim_real): ?>
                <li><strong>Entrega real:</strong> <?php echo e($requisicao->data_fim_real->format('d/m/Y')); ?></li>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </ul>
    </div>

<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(
    auth()->id() === $requisicao->user_id &&
    in_array($requisicao->estado, ['confirmado', 'devolucao_pedida'])
): ?>
<div class="card bg-base-100 shadow p-4">



    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($requisicao->livro->pdf_path): ?>
        <a href="<?php echo e(route('requisicoes.download', $requisicao)); ?>"
           class="btn btn-secondary btn-sm">
            📥 Download PDF
        </a>
    <?php else: ?>
        <div class="text-sm text-gray-500 italic">
            📄 Não existe PDF disponível para este livro.
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>


   </div>
<?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    
    <div class="card bg-base-100 shadow p-6">
        <h3 class="font-bold text-lg mb-4">Ações</h3>

        <div class="flex flex-wrap gap-3">

            
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->id() === $requisicao->user_id): ?>

                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($requisicao->estado === 'pendente'): ?>
                    <form method="POST" action="<?php echo e(route('requisicoes.cancelar', $requisicao)); ?>">
                        <?php echo csrf_field(); ?>
                        <button class="btn btn-outline btn-error btn-sm">
                            Cancelar
                        </button>
                    </form>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($requisicao->estado === 'confirmado'): ?>
                    <form method="POST"
                          action="<?php echo e(route('requisicoes.pedirDevolucao', $requisicao)); ?>">
                        <?php echo csrf_field(); ?>
                        <button class="btn btn-primary btn-sm">
                            Pedir Devolução
                        </button>
                    </form>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

            
            <?php if(auth()->user()->role === 'admin'): ?>

                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($requisicao->estado === 'pendente'): ?>
                    <form method="POST" action="<?php echo e(route('requisicoes.confirmar', $requisicao)); ?>">
                        <?php echo csrf_field(); ?>
                        <button class="btn btn-success btn-sm">
                            Confirmar
                        </button>
                    </form>

                    <form method="POST" action="<?php echo e(route('requisicoes.negar', $requisicao)); ?>">
                        <?php echo csrf_field(); ?>
                        <button class="btn btn-error btn-sm">
                            Negar
                        </button>
                    </form>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($requisicao->estado === 'devolucao_pedida'): ?>
                    <form method="POST"
                          action="<?php echo e(route('requisicoes.aceitarDevolucao', $requisicao)); ?>">
                        <?php echo csrf_field(); ?>
                        <button class="btn btn-warning btn-sm">
                            Aceitar Devolução
                        </button>
                    </form>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>

        
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(
            !(
                (auth()->id() === $requisicao->user_id && in_array($requisicao->estado, ['pendente','confirmado']))
                ||
                (auth()->user()->role === 'admin' && in_array($requisicao->estado, ['pendente','devolucao_pedida']))
            )
        ): ?>
            <p class="text-sm text-gray-500 mt-3">
                Não existem ações disponíveis para esta requisição.
            </p>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>

    
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(
        auth()->id() === $requisicao->user_id &&
        $requisicao->estado === 'entregue' &&
        ! $requisicao->review
    ): ?>
        <div class="card bg-base-100 shadow p-6">
            <h3 class="font-bold text-lg mb-4">Avaliar Livro</h3>

            <form method="POST"
                  action="<?php echo e(route('reviews.store', $requisicao)); ?>"
                  class="space-y-4">
                <?php echo csrf_field(); ?>

                <div>
                    <label class="label">
                        <span class="label-text">Comentário</span>
                    </label>
                    <textarea
                        name="comentario"
                        class="textarea textarea-bordered w-full"
                        rows="4"
                        required
                    ></textarea>
                </div>

                <div>
                    <label class="label">
                        <span class="label-text">Classificação</span>
                    </label>
                    <select name="rating" class="select select-bordered w-full">
                        <option value="">Sem classificação</option>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php for($i = 1; $i <= 5; $i++): ?>
                            <option value="<?php echo e($i); ?>"><?php echo e($i); ?> ⭐</option>
                        <?php endfor; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </select>
                </div>

                <div class="flex justify-end">
                    <button class="btn btn-primary btn-sm">
                        Enviar Review
                    </button>
                </div>
            </form>
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    

    
<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($requisicao->review): ?>
    <div class="card bg-base-100 shadow p-6">
        <h3 class="font-bold text-lg mb-2">Review</h3>

        <p class="text-sm text-gray-500 mb-2">
            Estado:
            <span class="badge
                <?php if($requisicao->review->estado === 'pendente'): ?> badge-warning
                <?php elseif($requisicao->review->estado === 'ativa'): ?> badge-success
                <?php else: ?> badge-error
                <?php endif; ?>">
                <?php echo e(ucfirst($requisicao->review->estado)); ?>

            </span>
        </p>

        <p class="mb-2">
            <?php echo e($requisicao->review->comentario); ?>

        </p>

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($requisicao->review->rating): ?>
            <p class="text-sm">
                Classificação:
                <strong><?php echo e($requisicao->review->rating); ?> ⭐</strong>
            </p>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(
            $requisicao->review->estado === 'recusada' &&
            $requisicao->review->justificacao &&
            auth()->user()->role === 'admin'
        ): ?>
            <div class="mt-3 text-sm text-error">
                <strong>Justificação:</strong>
                <?php echo e($requisicao->review->justificacao); ?>

            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>
<?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>


</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.default', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Rafael\Herd\biblioteca\resources\views/requisicoes/show.blade.php ENDPATH**/ ?>