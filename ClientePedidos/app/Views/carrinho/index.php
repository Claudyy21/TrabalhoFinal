<?= view('partials/header') ?>

<h2>Carrinho</h2>

<?php if (session()->getFlashdata('erro')): ?>
    <div class="alert alert-danger">
        <?= session()->getFlashdata('erro') ?>
    </div>
<?php endif; ?>

<?php $total = 0; ?>

<?php if (empty($carrinho)): ?>
    <div class="alert alert-info">Seu carrinho está vazio.</div>
    <a href="<?= site_url('produtos') ?>" class="btn btn-primary">Ver Produtos</a>
<?php else: ?>
    <div class="table-responsive">
        <table class="table align-middle">
            <thead>
                <tr>
                    <th>Produto</th>
                    <th style="width:160px">Quantidade</th>
                    <th style="width:120px">Valor</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($carrinho as $item): ?>
                    <?php $subtotal = $item['quantidade'] * $item['preco_unitario']; $total += $subtotal; ?>
                    <tr>
                        <td class="align-middle">
                            <div class="d-flex align-items-center">
                                <div class="me-3" style="width:64px; height:64px; background:#f8f9fa; border-radius:8px; overflow:hidden; flex-shrink:0;">
                                    <img src="<?= env('API_URL') . '/uploads/produtos/' . esc($item['foto'] ?? '') ?>" 
                                        alt="" 
                                        style="width:64px; height:64px; object-fit:cover;"
                                        onerror="this.style.display='none'">
                                </div>
                                <div>
                                    <div style="font-weight:600"><?= esc($item['nome']) ?></div>
                                </div>
                            </div>
                        </td>

                        <td>
                            <div class="d-flex align-items-center">
                                <form method="post" action="<?= site_url('carrinho/atualizar') ?>" class="d-inline me-2">
                                    <input type="hidden" name="id" value="<?= $item['id_produto'] ?>">
                                    <input type="hidden" name="action" value="inc">
                                    <button class="btn btn-sm btn-outline-secondary">+</button>
                                </form>

                                <form method="post" action="<?= site_url('carrinho/atualizar') ?>" class="d-inline me-2">
                                    <input type="hidden" name="id" value="<?= $item['id_produto'] ?>">
                                    <input type="hidden" name="action" value="set">
                                    <input type="number" name="quantity" value="<?= $item['quantidade'] ?>" min="1" class="form-control form-control-sm" style="width:72px; display:inline-block;">
                                </form>

                                <form method="post" action="<?= site_url('carrinho/atualizar') ?>" class="d-inline ms-2">
                                    <input type="hidden" name="id" value="<?= $item['id_produto'] ?>">
                                    <input type="hidden" name="action" value="dec">
                                    <button class="btn btn-sm btn-outline-secondary">-</button>
                                </form>
                            </div>
                        </td>

                        <td>
                            <div class="d-flex flex-column align-items-end">
                                <div style="font-weight:600">R$ <?= number_format($subtotal,2,',','.') ?></div>
                            </div>
                        </td>

                        <td>
                            <a href="<?= site_url('carrinho/remover/'.$item['id_produto']) ?>" class="btn btn-sm btn-outline-danger">X</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <div class="d-flex justify-content-between align-items-center mt-3">
        <form method="post" action="<?= site_url('carrinho/cancelar') ?>" onsubmit="return confirm('Deseja cancelar o pedido e limpar o carrinho?');">
            <button class="btn btn-outline-secondary">Cancelar</button>
        </form>

        <div class="text-end">
            <div class="mb-2" style="font-weight:600">Total: R$ <?= number_format($total,2,',','.') ?></div>
            <a href="<?= site_url('checkout') ?>" class="btn btn-success btn-lg">Confirmar</a>
        </div>
    </div>
<?php endif; ?>

<?= view('partials/footer') ?>