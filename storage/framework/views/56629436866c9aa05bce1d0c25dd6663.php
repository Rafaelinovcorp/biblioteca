

<?php $__env->startSection('content'); ?>
<div class="max-w-3xl mx-auto bg-white p-6 rounded shadow">

    <h2 class="text-xl font-bold mb-4">
        Confirmar importação
    </h2>

<h3 class="font-semibold text-lg mb-2">
    <?php echo e($volume['volumeInfo']['title'] ?? 'Sem título'); ?>

</h3>

<p class="text-sm mb-2">
    <strong>Autores:</strong>
    <?php echo e(implode(', ', $volume['volumeInfo']['authors'] ?? ['Desconhecido'])); ?>

</p>

<div class="mb-4">
    <strong>Biografia:</strong>
    <p class="text-sm mt-1 whitespace-pre-line">
        <?php echo e($volume['volumeInfo']['description'] ?? 'Sem descrição.'); ?>

    </p>
</div>


    <form method="POST"
          action="<?php echo e(route('google-books.store', $volumeId)); ?>">
        <?php echo csrf_field(); ?>

        <label class="block mb-2 font-semibold">
            Categoria
        </label>

        <select name="categoria_id" required class="border rounded w-full p-2 mb-4">
            <option value="">-- Selecionar categoria --</option>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $categorias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $categoria): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($categoria->id); ?>">
                    <?php echo e($categoria->nome); ?>

                </option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </select>

        <button class="bg-blue-600 text-white px-4 py-2 rounded">
            Confirmar importação
        </button>
    </form>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Rafael\Herd\biblioteca\resources\views/google-books/confirm.blade.php ENDPATH**/ ?>