<?= view('partials/header') ?>


<?php
    // Normalize items
    $items = $pedido['produtos'] ?? $pedido['itens'] ?? $pedido['items'] ?? [];
    // Compute total if not provided
    $total = $pedido['total'] ?? $pedido['valor_total'] ?? null;
    if ($total === null && is_array($items)) {
        $sum = 0;
        foreach ($items as $it) {
            $price = $it['preco_unitario'] ?? $it['preco'] ?? $it['valor'] ?? 0;
            $qty = $it['quantidade'] ?? $it['qtd'] ?? 1;
            $sum += floatval($price) * intval($qty);
        }
        $total = $sum;
    }
?>

<div class="d-flex justify-content-center py-4">
    <div style="width:320px; max-width:92%;">
        <div style="border:1px solid #ddd; border-radius:18px; padding:18px; box-shadow:0 6px 18px rgba(0,0,0,0.06); background:#fff;">

            <div class="text-center mb-3">
                <div style="width:72px; height:40px; margin:0 auto; border-radius:12px; background:#f8f9fa; display:flex; align-items:center; justify-content:center; font-weight:600; letter-spacing:2px;">
                    <?= esc($pedido['id_pedido'] ?? ($pedido['id'] ?? '---')) ?>
                </div>
            </div>

            <div style="min-height:160px;">
                <?php if (!empty($items) && is_array($items)): ?>
                    <ul class="list-unstyled mb-0">
                        <?php foreach ($items as $it):
                            $qty = $it['quantidade'] ?? $it['qtd'] ?? 1;
                            $name = $it['nome'] ?? $it['produto']['nome'] ?? $it['descricao'] ?? 'Item';
                            $price = $it['preco_unitario'] ?? $it['preco'] ?? $it['valor'] ?? 0;
                            $subtotal = floatval($price) * intval($qty);
                        ?>
                            <li class="d-flex justify-content-between align-items-center py-2 border-bottom" style="font-size:0.95rem;">
                                <div>
                                    <strong style="font-weight:600"><?= intval($qty) ?>x</strong>
                                    <span class="ms-2"><?= esc($name) ?></span>
                                </div>
                                <div style="font-weight:600">R$ <?= number_format($subtotal,2,',','.') ?></div>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php else: ?>
                    <div class="text-center text-muted py-4">Nenhum item disponível.</div>
                <?php endif; ?>
            </div>

            <div class="mt-3 d-flex justify-content-between align-items-center">
                <div style="font-weight:600">Total</div>
                <div style="font-weight:700; font-size:1.1rem">R$ <?= number_format($total ?? 0,2,',','.') ?></div>
            </div>

            <div class="text-center mt-3">
                <a href="<?= site_url('/') ?>" class="btn btn-primary">Novo Pedido</a>
            </div>

        </div>
    </div>
</div>

<?= view('partials/footer') ?>