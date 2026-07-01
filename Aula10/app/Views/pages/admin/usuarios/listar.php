<?= $this->extend('templates/admin') ?>
<?= $this->section('conteudo') ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0">Usuários</h4>
    <a href="<?= site_url('admin/usuarios/novo') ?>" class="btn btn-dark btn-sm">+ Novo usuário</a>
</div>

<div class="table-responsive">
    <table class="table table-bordered table-hover align-middle">
        <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>Email</th>
                <th>Tipo</th>
                <th>Status</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($usuarios as $u): ?>
            <tr>
                <td><?= $u['id'] ?></td>
                <td><?= esc($u['email']) ?></td>
                <td><span class="badge bg-secondary"><?= esc($u['tipo']) ?></span></td>
                <td>
                    <?php if ($u['bloqueado']): ?>
                        <span class="badge bg-danger">Bloqueado</span>
                    <?php else: ?>
                        <span class="badge bg-success">Ativo</span>
                    <?php endif; ?>
                </td>
                <td class="d-flex gap-2">
                    <a href="<?= site_url('admin/usuarios/editar/' . $u['id']) ?>"
                       class="btn btn-sm btn-outline-primary">Editar</a>

                    <?php if ($u['bloqueado']): ?>
                        <a href="<?= site_url('admin/usuarios/desbloquear/' . $u['id']) ?>"
                           class="btn btn-sm btn-outline-success">Desbloquear</a>
                    <?php else: ?>
                        <a href="<?= site_url('admin/usuarios/bloquear/' . $u['id']) ?>"
                           class="btn btn-sm btn-outline-danger">Bloquear</a>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?= $this->endSection() ?>