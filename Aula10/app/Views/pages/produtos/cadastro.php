<?= $this->extend('templates/admin') ?>

<?= $this->section('conteudo') ?>

<h1>Novo Produto</h1>

<?php $errors = session()->getFlashdata('errors') ?? [] ?>

<?php if (!empty($errors)): ?>
    <ul style='color:red'>
        <?php foreach ($errors as $e): ?>
            <li><?= esc($e) ?></li>
        <?php endforeach ?>
    </ul>
<?php endif ?>


<form method='post' action='<?= site_url('produtos/salvar') ?>' enctype='multipart/form-data'>
    <?= csrf_field() ?>
    <label>Nome:</label><br>
    <input type='text' name='nome' value='<?= esc(old('nome')) ?>'
        required><br><br>


    <label>Preco (R$):</label><br>
    <input type='number' name='preco' step='0.01' value='<?= esc(old('preco')) ?>' required><br><br>

    <label>Foto do Produto:</label><br>
    <input type='file' name='foto' accept='image/*' onchange="previewImagem(event)">

    <img id="preview"
        src=""
        class=" d-none"
        style="max-height:100px;">

    <br><br>

    <label>Categoria:</label><br>
    <select name="categoria" required>
        <option value="">Selecione...</option>
        <option value="Lanche" <?= old('categoria') === 'Lanche' ? 'selected' : '' ?>>Lanche</option>
        <option value="Bebida" <?= old('categoria') === 'Bebida' ? 'selected' : '' ?>>Bebida</option>
    </select>
    <br><br>

    <button type='submit'>Cadastrar</button>
    <a href='<?= site_url('produtos') ?>'>Cancelar</a>

</form>

<script>
    function previewImagem(event) {
        const file = event.target.files[0];

        if (!file) return;

        const preview = document.getElementById('preview');
        preview.src = URL.createObjectURL(file);
        preview.classList.remove('d-none');
    }
</script>

<?= $this->endSection() ?>