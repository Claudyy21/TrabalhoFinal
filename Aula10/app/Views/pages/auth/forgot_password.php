<?= $this->extend('templates/auth') ?>
<?= $this->section('content') ?>

<h3 class="text-center mb-3">Recuperar senha</h3>

<?php if (session()->getFlashdata('erros')): ?>
    <div class="alert alert-danger"><?= session()->getFlashdata('erros') ?></div>
<?php endif; ?>

<form method="post" action="<?= site_url('esqueci-senha') ?>">
    <?= csrf_field() ?>

    <div class="mb-3">
        <label>Email</label>
        <input type="email" name="email" class="form-control" required>
    </div>

    <button type="submit" class="btn btn-dark w-100">Enviar link</button>
</form>

<div class="text-center mt-3">
    <a href="<?= site_url('login') ?>">Voltar</a>
</div>

<?= $this->endSection() ?>