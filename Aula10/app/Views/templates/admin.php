<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cantina</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body { background-color: #f8f9fa; }

        .sidebar-desktop {
            min-height: 100vh;
            border-right: 1px solid #dee2e6;
        }

        .menu-link {
            display: block;
            padding: 10px 12px;
            text-decoration: none;
            color: #212529;
            border-radius: 8px;
            margin-bottom: 6px;
        }

        .menu-link:hover { background-color: #e9ecef; }
        .menu-link.ativo { background-color: #dee2e6; font-weight: 600; }
    </style>
</head>
<body>

<nav class="navbar navbar-dark bg-dark px-3">
    <div class="d-flex align-items-center">
        <button class="btn btn-outline-light d-md-none me-2" type="button"
                data-bs-toggle="offcanvas" data-bs-target="#menuMobile">
            ☰
        </button>
        <a class="navbar-brand mb-0" href="<?= site_url('/') ?>">Minha Cantina</a>
    </div>
    <span class="text-white small"><?= session()->get('usuario_email') ?? '' ?></span>
</nav>

<div class="container-fluid">
    <div class="row">

        <!-- Sidebar desktop -->
        <aside class="col-md-3 col-lg-2 bg-white sidebar-desktop p-3 d-none d-md-block">
            <h6 class="text-muted mb-3">Menu</h6>

            <a href="<?= site_url('produtos') ?>" class="menu-link">📦 Produtos</a>
            <a href="<?= site_url('estoque') ?>" class="menu-link">🏪 Estoque</a>
            <a href="<?= site_url('painel') ?>" class="menu-link">📊 Painel</a>
            <a href="<?= site_url('perfil') ?>" class="menu-link">👤 Meu Perfil</a>

            <?php if (session()->get('usuario_tipo') === 'admin'): ?>
                <hr>
                <h6 class="text-muted mb-3">Admin</h6>
                <a href="<?= site_url('admin/usuarios') ?>" class="menu-link">👥 Usuários</a>
            <?php endif; ?>

            <hr>
            <a href="<?= site_url('logout') ?>" class="menu-link text-danger">🚪 Sair</a>
        </aside>

        <!-- Conteúdo -->
        <main class="col-12 col-md-9 col-lg-10 px-3 px-md-4 py-4">

            <?php if (session()->getFlashdata('sucesso')): ?>
                <div class="alert alert-success"><?= session()->getFlashdata('sucesso') ?></div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('erros')): ?>
                <div class="alert alert-danger"><?= session()->getFlashdata('erros') ?></div>
            <?php endif; ?>

            <?= $this->renderSection('conteudo') ?>
        </main>

    </div>
</div>

<!-- Sidebar mobile -->
<div class="offcanvas offcanvas-start" tabindex="-1" id="menuMobile">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title">Menu</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
    </div>
    <div class="offcanvas-body">
        <a href="<?= site_url('produtos') ?>" class="menu-link">📦 Produtos</a>
        <a href="<?= site_url('estoque') ?>" class="menu-link">🏪 Estoque</a>
        <a href="<?= site_url('painel') ?>" class="menu-link">📊 Painel</a>
        <a href="<?= site_url('perfil') ?>" class="menu-link">👤 Meu Perfil</a>

        <?php if (session()->get('usuario_tipo') === 'admin'): ?>
            <hr>
            <h6 class="text-muted mb-3">Admin</h6>
            <a href="<?= site_url('admin/usuarios') ?>" class="menu-link">👥 Usuários</a>
        <?php endif; ?>

        <hr>
        <a href="<?= site_url('logout') ?>" class="menu-link text-danger">🚪 Sair</a>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>