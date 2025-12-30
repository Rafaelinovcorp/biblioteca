<?php $__env->startComponent('mail::message'); ?>
# 📚 Livro disponível para requisição

Olá,

O livro que pediste para acompanhar já se encontra **disponível** na biblioteca.

**Livro:** <?php echo new \Illuminate\Support\EncodedHtmlString($livro->titulo ?? $livro->nome); ?>  
<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($livro->categoria): ?>
**Categoria:** <?php echo new \Illuminate\Support\EncodedHtmlString($livro->categoria->nome); ?>

<?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

Já podes efetuar a requisição através da plataforma.

<?php $__env->startComponent('mail::button', ['url' => route('livros.show', $livro)]); ?>
Ver livro
<?php echo $__env->renderComponent(); ?>

Obrigado pelo uso do nosso serviço.  
<?php echo $__env->renderComponent(); ?><?php /**PATH C:\Users\Rafael\Herd\biblioteca\resources\views/emails/livros/disponivel.blade.php ENDPATH**/ ?>