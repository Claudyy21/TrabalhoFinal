<?= $this->extend('templates/auth') ?>
<?= $this->section('content') ?>

<h3 class="text-center mb-3">Redefinir senha</h3>

<form method="post" action="<?= site_url('redefinir-senha') ?>">
    <?= csrf_field() ?>

    <input type="hidden" name="token" value="<?= $token ?>">

    <div class="mb-3">
        <label>Nova senha</label>
        <input type="password" name="senha" class="form-control" required>
    </div>

    <button type="submit" class="btn btn-dark w-100">Salvar senha</button>
</form>

<?= $this->endSection() ?>