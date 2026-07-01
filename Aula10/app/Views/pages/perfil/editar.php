<?= $this->extend('templates/admin') ?>
<?= $this->section('conteudo') ?>

<h4 class="mb-4">Meu Perfil</h4>

<?php if (session()->getFlashdata('sucesso')): ?>
    <div class="alert alert-success"><?= session()->getFlashdata('sucesso') ?></div>
<?php endif; ?>

<?php if (session()->getFlashdata('erros')): ?>
    <div class="alert alert-danger"><?= session()->getFlashdata('erros') ?></div>
<?php endif; ?>

<div class="card shadow-sm">
    <div class="card-body">
        <form method="post" action="<?= site_url('perfil/atualizar') ?>">
            <?= csrf_field() ?>

            <div class="mb-3">
                <label>Email</label>
                <input type="email" name="email" class="form-control"
                       value="<?= esc($usuario['email']) ?>" required>
            </div>

            <div class="mb-3">
                <label>Nova senha <small class="text-muted">(deixe em branco para não alterar)</small></label>
                <input type="password" name="senha" class="form-control" autocomplete="off">
            </div>

            <button type="submit" class="btn btn-dark w-100">Salvar</button>
        </form>
    </div>
</div>

<?= $this->endSection() ?>