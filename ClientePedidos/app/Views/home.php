<?= view('partials/header') ?>

<div class="text-center py-5">
    <h1 class="display-4 mb-3">Cantina</h1>
    <p class="lead">Peça rapidamente os melhores lanches.</p>

    <?php if (!empty($totemData['totem_id'])): ?>
        <div class="alert alert-info d-inline-block mt-3 mb-0" role="status">
            <strong>Totem:</strong> <?= esc($totemData['totem_id']) ?>
        </div>
    <?php endif; ?>

    <div class="mt-4">
        <a href="<?= site_url('produtos') ?>" class="btn btn-primary btn-lg">Iniciar Pedido</a>
    </div>
</div>

<?= view('partials/footer') ?>