<?= $this->extend('templates/admin') ?>

<?= $this->section('conteudo') ?>


<h1>Remover estoque 
- <?= $produto['nome'] ?? '' ?> 
- Estoque atual <?= $produto['estoque'] ?? 0 ?>
</h1>

<?php if (file_exists(FCPATH . 'uploads/produtos/' . $produto['foto'])) : ?>
    <img
        src="<?= base_url('uploads/produtos/' . esc($produto['foto'])) ?>" style="width: 100px; height: 100px; object-fit: cover;" />
<?php endif ?>

<form method="post" action="<?= site_url('estoque/salvar') ?>" >
    <?= csrf_field() ?>
    <input type="hidden" name="id_produto" value="<?= $produto['id'] ?? '' ?>">
    Quantidade: <input type="number" name="quantidade" value="<?= old('quantidade') ?? 0 ?>" step="1" min="0">
    <br />
    
    Observação:
    <input type="text" name="observacao" value="<?= old('observacao') ?? "" ?>">
    <br />

    <input type="hidden" name="tipo" value="saida">

    <button type="submit">Salvar</button>

</form>



<?= $this->endSection() ?>