

<?php $__env->startSection('content'); ?>

<div class="max-w-4xl mx-auto">

    <h1 class="text-2xl font-bold mb-6">
        ✏️ Editar Livro
    </h1>

    <form method="POST"
          action="<?php echo e(route('livros.update', $livro)); ?>"
          enctype="multipart/form-data"
          class="space-y-6">

        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>

        
        <div>
            <label class="label">
                <span class="label-text">Nome</span>
            </label>
            <input type="text"
                   name="nome"
                   value="<?php echo e(old('nome', $livro->nome)); ?>"
                   class="input input-bordered w-full"
                   required>
        </div>

        
        <div>
            <label class="label">
                <span class="label-text">ISBN</span>
            </label>
            <input type="text"
                   name="isbn"
                   value="<?php echo e(old('isbn', $livro->isbn)); ?>"
                   class="input input-bordered w-full">
        </div>
        
<div>
    <label class="label">
        <span class="label-text">Biografia / Descrição</span>
    </label>

    <textarea name="bibliografia"
              rows="6"
              class="textarea textarea-bordered w-full"><?php echo e(old('bibliografia', $livro->bibliografia)); ?></textarea>
</div>


        
        <div>
            <label class="label">
                <span class="label-text">Editora</span>
            </label>
            <select name="editora_id"
                    class="select select-bordered w-full"
                    required>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $editoras; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $editora): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($editora->id); ?>"
                        <?php if(old('editora_id', $livro->editora_id) == $editora->id): echo 'selected'; endif; ?>>
                        <?php echo e($editora->nome); ?>

                    </option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </select>
        </div>

        
        <div>
            <label class="label">
                <span class="label-text">Autores</span>
            </label>
            <select name="autores[]"
                    multiple
                    class="select select-bordered w-full min-h-[120px]">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $autores; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $autor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($autor->id); ?>"
                        <?php if(
                            in_array(
                                $autor->id,
                                old('autores', $livro->autores->pluck('id')->toArray())
                            )
                        ): echo 'selected'; endif; ?>>
                        <?php echo e($autor->nome); ?>

                    </option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </select>
        </div>
            <div>
        <label>Categoria</label>
        <select name="categoria_id" required>
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $categorias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $categoria): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <option value="<?php echo e($categoria->id); ?>">
            <?php echo e($categoria->nome); ?>

        </option>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
</select>

    </div>

        
        <div>
            <label class="label">
                <span class="label-text">Preço (€)</span>
            </label>
            <input type="number"
                   name="preco"
                   step="0.01"
                   min="0"
                   value="<?php echo e(old('preco', $livro->preco)); ?>"
                   class="input input-bordered w-full"
                   required>
        </div>

        
        <div>
            <label class="label">
                <span class="label-text">Estado</span>
            </label>
            <select name="estado"
                    class="select select-bordered w-full"
                    required>
                <option value="disponivel"
                    <?php if(old('estado', $livro->estado) === 'disponivel'): echo 'selected'; endif; ?>>
                    Disponível
                </option>
                <option value="requisitado"
                    <?php if(old('estado', $livro->estado) === 'requisitado'): echo 'selected'; endif; ?>>
                    Requisitado
                </option>
            </select>
        </div>

        
        <div>
            <label class="label">
                <span class="label-text">Capa</span>
            </label>
            <input type="file"
                   name="capa"
                   class="file-input file-input-bordered w-full">

            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($livro->capa): ?>
                <img src="<?php echo e(asset('storage/'.$livro->capa)); ?>"
                     class="mt-2 w-32 rounded shadow">
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>

        
        <div>
            <label class="label">
                <span class="label-text">PDF</span>
            </label>
            <input type="file"
                   name="pdf"
                   class="file-input file-input-bordered w-full">

            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($livro->pdf): ?>
                <p class="mt-2">
                    <a href="<?php echo e(asset('storage/'.$livro->pdf)); ?>"
                       class="link"
                       target="_blank">
                        📄 Ver PDF atual
                    </a>
                </p>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>

        
        <div class="flex justify-end gap-2">
            <a href="<?php echo e(route('livros.show', $livro)); ?>"
               class="btn btn-ghost">
                Cancelar
            </a>

            <button type="submit"
                    class="btn btn-primary">
                Guardar Alterações
            </button>
        </div>

    </form>

</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.default', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Rafael\Herd\biblioteca\resources\views/livros/edit.blade.php ENDPATH**/ ?>