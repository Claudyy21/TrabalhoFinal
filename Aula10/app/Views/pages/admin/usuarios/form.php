<?= $this->extend('templates/admin') ?>
<?= $this->section('conteudo') ?>

<h4 class="mb-4"><?= $usuario ? 'Editar Usuário' : 'Novo Usuário' ?></h4>

<?php if (session()->getFlashdata('erros')): ?>
    <div class="alert alert-danger"><?= session()->getFlashdata('erros') ?></div>
<?php endif; ?>

<div class="card shadow-sm">
    <div class="card-body">
        <form method="post" action="<?= $usuario
            ? site_url('admin/usuarios/atualizar/' . $usuario['id'])
            : site_url('admin/usuarios/salvar') ?>">
            <?= csrf_field() ?>

            <div class="mb-3">
                <label>Email</label>
                <input type="email" name="email" class="form-control"
                       value="<?= esc($usuario['email'] ?? '') ?>" required>
            </div>

            <div class="mb-3">
                <label>Senha <?= $usuario ? '<small class="text-muted">(deixe em branco para não alterar)</small>' : '' ?></label>
                <input type="password" name="senha" class="form-control"
                       autocomplete="off" <?= $usuario ? '' : 'required' ?>>
            </div>

            <div class="mb-3">
                <label>Tipo</label>
                <select name="tipo" class="form-select">
                    <option value="usuario" <?= ($usuario['tipo'] ?? '') === 'usuario' ? 'selected' : '' ?>>Usuário</option>
                    <option value="admin" <?= ($usuario['tipo'] ?? '') === 'admin' ? 'selected' : '' ?>>Admin</option>
                </select>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-dark w-100">Salvar</button>
                <a href="<?= site_url('admin/usuarios') ?>" class="btn btn-outline-secondary w-100">Cancelar</a>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>