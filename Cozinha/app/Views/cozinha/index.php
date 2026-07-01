<?= view('partials/header') ?>

<h4 class="mb-4">Pedidos</h4>

<?php if (empty($pedidos)): ?>
    <div class="alert alert-info">Nenhum pedido no momento.</div>
<?php else: ?>
    <div class="accordion" id="pedidosAccordion">
        <?php foreach ($pedidos as $pedido):
            $status = $pedido['status'] ?? 'novo';
            $badgeColor = match($status) {
                'novo'       => 'primary',
                'em_preparo' => 'warning',
                'finalizado' => 'success',
                'cancelado'  => 'danger',
                default      => 'secondary'
            };
        ?>
        <div class="accordion-item mb-2 border rounded">
            <h2 class="accordion-header">
                <button class="accordion-button collapsed" type="button"
                        data-bs-toggle="collapse"
                        data-bs-target="#pedido<?= $pedido['id'] ?>">
                    <?php $totemLabel = $pedido['totem_name'] ?? $pedido['totem_id'] ?? $pedido['id_totem'] ?? $pedido['id_maquina'] ?? $pedido['maquina_id'] ?? null; ?>
                    <div class="d-flex justify-content-between align-items-center w-100 me-3">
                    <div>
                        <span><strong>Pedido #<?= $pedido['id'] ?></strong></span>
                        <?php if (!empty($totemLabel)): ?>
                            <div class="text-muted small">Totem: <?= esc($totemLabel) ?></div>
                        <?php endif; ?>
                    </div>
                    <span class="badge bg-<?= $badgeColor ?>"><?= ucfirst(str_replace('_', ' ', $status)) ?></span>
                </div>
                </button>
            </h2>
            <div id="pedido<?= $pedido['id'] ?>" class="accordion-collapse collapse">
                <div class="accordion-body">
                    <ul class="list-unstyled mb-3">
                        <?php foreach ($pedido['itens'] ?? [] as $item): ?>
                            <li class="d-flex justify-content-between border-bottom py-1">
                                <span><?= $item['quantidade'] ?>x <?= esc($item['produto']['nome'] ?? 'Produto') ?></span>
                                <span>R$ <?= number_format($item['preco_unitario'] * $item['quantidade'], 2, ',', '.') ?></span>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                    <a href="<?= site_url('pedidos/' . $pedido['id']) ?>" class="btn btn-sm btn-outline-primary">
                        Ver detalhes
                    </a>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<?= view('partials/footer') ?>