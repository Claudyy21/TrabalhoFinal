<?= $this->extend('templates/admin') ?>

<?= $this->section('conteudo') ?>

<h1>Editar Produto</h1>

<?php $errors = session()->getFlashdata('errors') ?? [] ?>

<?php if (!empty($errors)): ?>
    <ul style="color:red">
        <?php foreach ($errors as $e): ?>
            <li><?= esc($e); ?></li>
        <?php endforeach ?>
    </ul>
<?php endif ?>

<form method="post"
      action="<?= site_url('produtos/atualizar/' . $Produto['id']) ?>"
      enctype="multipart/form-data">

    <?= csrf_field() ?>

    <label>Nome:</label><br>

    <input type="text"
           name="nome"
           value="<?= esc(old('nome', $Produto['nome'])) ?>"
           required><br><br>

    <label>Preço (R$):</label><br>

    <input type="number"
           name="preco"
           step="0.01"
           value="<?= esc(old('preco', $Produto['preco'])) ?>"
           required><br><br>

    <!-- Foto atual -->
    <?php if (!empty($Produto['foto'])): ?>

        <img src="<?= base_url('uploads/produtos/' . esc($Produto['foto'])) ?>"
             style="width:80px; height:80px; object-fit:cover;"><br>

        <small>Deixe em branco para manter a foto atual</small><br><br>

    <?php endif ?>

    <label>Nova foto (opcional):</label><br>

    <input 
        type="file"
        name="foto"
        accept="image/*"
    >
    <br><br>

    <label>Categoria:</label><br>
    <select name="categoria" required>
        <option value="">Selecione...</option>
        <option value="Lanche" <?= old('categoria', $Produto['categoria']) === 'Lanche' ? 'selected' : '' ?>>Lanche</option>
        <option value="Bebida" <?= old('categoria', $Produto['categoria']) === 'Bebida' ? 'selected' : '' ?>>Bebida</option>
    </select>
    <br><br>

    <button type="submit">Salvar Alterações</button>

    <a href="<?= site_url('produtos') ?>">
        Cancelar
    </a>

</form>

<?= $this->endSection() ?>