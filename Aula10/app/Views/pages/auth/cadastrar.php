<?= $this->extend('templates/auth') ?>
<?= $this->section('content') ?>

<h3 class="text-center mb-3">Cadastro</h3>

<?php if (session()->getFlashdata('erros')): ?>
    <div class="alert alert-danger"><?= session()->getFlashdata('erros') ?></div>
<?php endif; ?>

<form method="post" action="<?= site_url('cadastrar') ?>">
    <?= csrf_field() ?>

    <div class="mb-3">
        <label>Email</label>
        <input type="email" name="email" class="form-control" required>
    </div>

    <div class="mb-3">
        <label>Senha</label>
        <input type="password" name="senha" class="form-control" required autocomplete="off">
    </div>

    <button class="btn btn-dark w-100">Cadastrar</button>
</form>

<div class="text-center mt-3">
    <a href="<?= site_url('login') ?>">Já tenho conta</a>
</div>

<?= $this->endSection() ?>