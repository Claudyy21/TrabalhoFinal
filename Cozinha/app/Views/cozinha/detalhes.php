<?= view('partials/header') ?>

<div class="row justify-content-center">
    <div class="col-md-6">

        <a href="<?= site_url('/') ?>" class="btn btn-outline-secondary btn-sm mb-3">← Voltar</a>

        <div class="card shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Pedido #<?= $pedido['id'] ?></h5>
                <?php
                    $status = $pedido['status'] ?? 'novo';
                    $badgeColor = match($status) {
                        'novo'       => 'primary',
                        'em_preparo' => 'warning',
                        'finalizado' => 'success',
                        'cancelado'  => 'danger',
                        default      => 'secondary'
                    };
                ?>
                <span class="badge bg-<?= $badgeColor ?>"><?= ucfirst(str_replace('_', ' ', $status)) ?></span>
            </div>

            <div class="card-body">
                <ul class="list-unstyled mb-4">
                    <?php
                        $total = 0;
                        foreach ($pedido['itens'] ?? [] as $item):
                            $subtotal = $item['preco_unitario'] * $item['quantidade'];
                            $total += $subtotal;
                    ?>
                        <li class="d-flex justify-content-between border-bottom py-2">
                            <span><?= $item['quantidade'] ?>x <?= esc($item['produto']['nome'] ?? 'Produto') ?></span>
                            <span>R$ <?= number_format($subtotal, 2, ',', '.') ?></span>
                        </li>
                    <?php endforeach; ?>
                </ul>

                <div class="d-flex justify-content-between fw-bold mb-4">
                    <span>Total</span>
                    <span>R$ <?= number_format($total, 2, ',', '.') ?></span>
                </div>

                <?php if (!in_array($status, ['finalizado', 'cancelado'])): ?>
                <div class="d-flex gap-2">
                    <form action="<?= site_url('pedidos/' . $pedido['id'] . '/status') ?>" method="post" class="w-50">
                        <?= csrf_field() ?>
                        <input type="hidden" name="status" value="finalizado">
                        <button type="submit" class="btn btn-success w-100">✅ Finalizar</button>
                    </form>

                    <form action="<?= site_url('pedidos/' . $pedido['id'] . '/status') ?>" method="post" class="w-50">
                        <?= csrf_field() ?>
                        <input type="hidden" name="status" value="cancelado">
                        <button type="submit" class="btn btn-danger w-100">❌ Cancelar</button>
                    </form>
                </div>
                <?php else: ?>
                    <div class="alert alert-secondary text-center mb-0">
                        Este pedido já foi <strong><?= $status ?></strong>.
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?= view('partials/footer') ?>