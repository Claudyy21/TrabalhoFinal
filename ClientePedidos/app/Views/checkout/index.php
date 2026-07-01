<?= view('partials/header') ?>

<div class="text-center">
    <h2>Confirmar Pedido</h2>
    <p class="mb-4">Deseja enviar o pedido para a cantina?</p>

    <form method="post" action="<?= site_url('checkout/finalizar') ?>">
        <button type="submit" class="btn btn-success btn-lg me-2">Confirmar Pedido</button>
        <a href="<?= site_url('carrinho') ?>" class="btn btn-outline-secondary btn-lg">Voltar</a>
    </form>
</div>

<?= view('partials/footer') ?>