<?= $this->extend('templates/auth') ?>
<?= $this->section('content') ?>

<h3 class="text-center mb-3">Login</h3>

<?php if (session()->getFlashdata('sucesso')): ?>
    <div class="alert alert-success"><?= session()->getFlashdata('sucesso') ?></div>
<?php endif; ?>

<?php if (session()->getFlashdata('erros')): ?>
    <div class="alert alert-danger"><?= session()->getFlashdata('erros') ?></div>
<?php endif; ?>

<form action="<?= site_url('login') ?>" method="POST">
    <?= csrf_field() ?>

    <div class="mb-3">
        <label>Email</label>
        <input type="email" name="email" class="form-control"
               value="<?= old('email') ?>" required>
    </div>

    <div class="mb-3">
        <label>Senha</label>
        <input type="password" name="senha" class="form-control" required>
    </div>

    <button type="submit" class="btn btn-dark w-100">Entrar</button>
</form>

<div class="text-center mt-3">
    <a href="<?= site_url('esqueci-senha') ?>" class="d-block">Esqueci minha senha</a>
    <a href="<?= site_url('cadastrar') ?>" class="d-block mt-2">Criar conta</a>
</div>

<?= $this->endSection() ?>