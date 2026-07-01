<?= view('partials/header') ?>

<?php if(isset($erro)): ?>
    <div class="alert alert-danger"><?= $erro ?></div>
<?php endif; ?>

<?php $cart = session()->get('carrinho') ?? []; $cartTotal = 0; foreach($cart as $ci){ $cartTotal += ($ci['preco_unitario']*$ci['quantidade']); } ?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <div>
        <h2 class="mb-0">Produtos</h2>
        <small class="text-muted">Escolha itens para seu pedido</small>
    </div>

    <div class="d-flex align-items-center">
        <div class="me-3">
            <button class="btn btn-sm btn-outline-secondary filter-btn" data-cat="all">Todos</button>
            <button class="btn btn-sm btn-outline-secondary filter-btn" data-cat="lanche">Lanches</button>
            <button class="btn btn-sm btn-outline-secondary filter-btn" data-cat="bebida">Bebidas</button>
        </div>

        <div>
            <a href="<?= site_url('carrinho') ?>" class="btn btn-outline-primary">Carrinho R$ <?= number_format($cartTotal,2,',','.') ?></a>
        </div>
    </div>

</div>

<div class="row" id="products-grid">
    <?php foreach($produtos as $produto): ?>
        <?php $categoria = strtolower(trim($produto['categoria'] ?? '')); ?>
        <div class="col-sm-6 col-md-4 mb-4 product-card-item" data-cat="<?= esc($categoria) ?>">
            <div class="card h-100 product-card">
                <?php
                    $placeholderSvg = '<svg xmlns="http://www.w3.org/2000/svg" width="400" height="240"><rect fill="#f8f9fa" width="100%" height="100%"/><text x="50%" y="50%" dominant-baseline="middle" text-anchor="middle" fill="#6c757d" font-family="Arial, Helvetica, sans-serif" font-size="20">Sem imagem</text></svg>';
                    $placeholder = 'data:image/svg+xml;utf8,' . rawurlencode($placeholderSvg);

                    if (!empty($produto['foto'])) {
                        $imgUrl = env('API_URL') . '/uploads/produtos/' . rawurlencode($produto['foto']);
                    } else {
                        $imgUrl = $placeholder;
                    }
                ?>

                <img src="<?= esc($imgUrl) ?>" class="card-img-top" alt="<?= esc($produto['nome']) ?>" onerror="this.onerror=null;this.src='<?= esc($placeholder) ?>'">

                <div class="card-body d-flex flex-column">
                    <h5 class="card-title"><?= esc($produto['nome']) ?></h5>
                    <p class="card-text mb-3">R$ <?= number_format($produto['preco'],2,',','.') ?></p>

                    <form method="post" action="<?= site_url('carrinho/adicionar') ?>" class="mt-auto">
                        <input type="hidden" name="id" value="<?= $produto['id'] ?>">
                        <input type="hidden" name="nome" value="<?= esc($produto['nome']) ?>">
                        <input type="hidden" name="preco" value="<?= $produto['preco'] ?>">
                        <input type="hidden" name="foto" value="<?= esc($produto['foto'] ?? '') ?>">
                        <button type="submit" class="btn btn-primary w-100">Adicionar ao carrinho</button>
                    </form>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<?= view('partials/footer') ?>

<script>
document.addEventListener('DOMContentLoaded', function(){
    const buttons = document.querySelectorAll('.filter-btn');
    const items = document.querySelectorAll('.product-card-item');

    function setActive(btn){
        buttons.forEach(b=>b.classList.remove('active'));
        btn.classList.add('active');
    }

    buttons.forEach(btn=>{
        btn.addEventListener('click', function(){
            const cat = this.dataset.cat;
            setActive(this);
            items.forEach(it=>{
                if(cat==='all') { it.style.display=''; return; }
                if(it.dataset.cat && it.dataset.cat.indexOf(cat) !== -1){
                    it.style.display='';
                } else {
                    it.style.display='none';
                }
            });
        });
    });
    // set default active
    if(buttons.length) buttons[0].classList.add('active');
});
</script>