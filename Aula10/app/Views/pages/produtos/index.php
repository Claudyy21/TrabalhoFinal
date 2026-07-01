<?= $this->extend('templates/admin') ?>

<?= $this->section('conteudo') ?>

<h1>Produtos</h1>

<div class="card shadow-sm">
    <div class="card-body">


        <a href='<?= site_url('produtos/novo') ?>'>Cadastrar novo Produto</a>

        <?php if (!empty($produtos)) : ?>

            <!-- filtros -->
            <form method='get' action='<?= site_url('produtos') ?>' class="mb-5">
                <div class="row">
                    <div class="col-md-4">
                        <input type='text' name='busca' value='<?= esc($busca ?? '') ?>' placeholder='Buscar Produto por nome...' class="form-control">
                    </div>
                    <div class="col-md-4">
                        <select name="preco" class="form-select">
                            <option value="">Todos</option>
                            <option value="baixo">Abaixo de R$ 5</option>
                            <option value="medio">Entre R$ 5 e R$ 10</option>
                            <option value="alto">Acima de R$ 10</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button type='submit' class="btn btn-primary">Buscar</button>
                        <?php if ($busca): ?>
                            <a href='<?= site_url('produtos') ?>'>Limpar</a>
                        <?php endif ?>
                    </div>
            </form>

            <!-- tabela -->

            <div class="table-responsive mt-1">
                <table class="table table-bordered table-hover align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>Id</th>
                            <th>Nome</th>
                            <th>Preço</th>
                            <th>Foto</th>
                            <th>Acoes</th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($produtos as $Produto) : ?>
                            <tr>
                                <td><?= esc($Produto['id']) ?></td>
                                <td><?= esc($Produto['nome']) ?></td>
                                <td>R$ <?= number_format($Produto['preco'], 2, ',', '.') ?></td>
                                <td>
                                    <?php if (!empty($Produto['foto'])): ?>
                                        <a href="<?= base_url('uploads/produtos/' . esc($Produto['foto'])) ?>" target="_blank">
                                            <img src='<?= base_url('uploads/produtos/' . esc($Produto['foto'])) ?>'
                                            alt='<?= esc($Produto['nome']) ?>'
                                            style='width:60px; height:60px;'>
                                    </a>
                                    <?php else: ?>
                                        <span >Sem foto</span>
                                    <?php endif ?>
                                </td>

                                <td>
                                    <a href='<?= site_url('produtos/editar/' . $Produto['id']) ?>'>Editar</a>
                                    <a href='<?= site_url('produtos/excluir/' . $Produto['id']) ?>'
                                        onclick='return confirm("Excluir?")'>Excluir</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>


            <!-- PAGINAÇÃO -->
            <p>
                Pagina <?= $pager->getCurrentPage() ?> de <?= $pager->getPageCount() ?> - mostrando <?= count($produtos) ?>
                de <?= $pager->getTotal() ?> registros
            </p>

            <?= $pager->links('default', 'template_pager') ?>







        <?php else : ?>

            <div class="alert alert-warning">
                <p>Nenhum Produto cadastrado.</p>
            </div>

        <?php endif; ?>

    </div>
</div>

<?= $this->endSection() ?>