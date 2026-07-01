<?= $this->extend('templates/admin') ?>
<?= $this->section('conteudo') ?>

<h4 class="mb-4">Painéis</h4>

<!-- ================================ -->
<!-- PAINEL DE CONSUMO -->
<!-- ================================ -->
<div class="card shadow-sm mb-4">
    <div class="card-header bg-dark text-white fw-bold">📦 Painel de Consumo</div>
    <div class="card-body">

        <form method="get" action="<?= site_url('painel') ?>" class="row g-2 mb-3">
            <div class="col-md-3">
                <select name="categoria" class="form-select form-select-sm">
                    <option value="">Todas categorias</option>
                    <?php foreach ($categorias as $cat): ?>
                        <option value="<?= esc($cat['categoria']) ?>"
                            <?= $categoria === $cat['categoria'] ? 'selected' : '' ?>>
                            <?= esc($cat['categoria']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-3">
                <input type="date" name="data_inicio" class="form-control form-control-sm"
                       value="<?= esc($dataInicio ?? '') ?>" placeholder="Data início">
            </div>
            <div class="col-md-3">
                <input type="date" name="data_fim" class="form-control form-control-sm"
                       value="<?= esc($dataFim ?? '') ?>" placeholder="Data fim">
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-dark btn-sm w-100">Filtrar</button>
            </div>
            <div class="col-md-1">
                <a href="<?= site_url('painel') ?>" class="btn btn-outline-secondary btn-sm w-100">↺</a>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>Produto</th>
                        <th>Categoria</th>
                        <th>Stock atual</th>
                        <th>Quantidade vendida</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($produtos)): ?>
                        <tr><td colspan="4" class="text-center">Nenhum produto encontrado.</td></tr>
                    <?php else: ?>
                        <?php foreach ($produtos as $p): ?>
                        <tr>
                            <td><?= esc($p['nome']) ?></td>
                            <td><?= esc($p['categoria'] ?? '—') ?></td>
                            <td><?= $p['estoque'] ?></td>
                            <td><?= $p['quantidade_vendida'] ?></td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- ================================ -->
<!-- PAINEL DE VENDAS -->
<!-- ================================ -->
<div class="card shadow-sm mb-4">
    <div class="card-header bg-dark text-white fw-bold">💰 Painel de Vendas</div>
    <div class="card-body">

        <form method="get" action="<?= site_url('painel') ?>" class="row g-2 mb-3 align-items-center">
            <div class="col-auto">
                <label class="col-form-label col-form-label-sm">Últimos</label>
            </div>
            <div class="col-auto">
                <select name="dias_vendas" class="form-select form-select-sm" onchange="this.form.submit()">
                    <?php foreach ([7, 14, 30, 60, 90] as $d): ?>
                        <option value="<?= $d ?>" <?= $diasVendas == $d ? 'selected' : '' ?>><?= $d ?> dias</option>
                    <?php endforeach; ?>
                </select>
            </div>
        </form>

        <div class="row">
            <div class="col-md-5">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th>Data</th>
                                <th>Valor total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($vendas)): ?>
                                <tr><td colspan="2" class="text-center">Nenhuma venda encontrada.</td></tr>
                            <?php else: ?>
                                <?php foreach ($vendas as $v): ?>
                                <tr>
                                    <td><?= date('d/m/Y', strtotime($v['data'])) ?></td>
                                    <td>R$ <?= number_format($v['valor_total'] ?? 0, 2, ',', '.') ?></td>
                                </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="col-md-7">
                <canvas id="graficoVendas"></canvas>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('graficoVendas').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: <?= $graficoDatas ?>,
            datasets: [{
                label: 'Vendas (R$)',
                data: <?= $graficoValores ?>,
                borderColor: '#212529',
                backgroundColor: 'rgba(33,37,41,0.1)',
                tension: 0.3,
                pointRadius: 5,
                fill: true
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } },
            scales: {
                y: { beginAtZero: true }
            }
        }
    });
</script>

<?= $this->endSection() ?>