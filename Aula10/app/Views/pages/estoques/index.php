<?=$this->extend('/templates/admin');?>

<?=$this->section('conteudo');?>


<h1> Gestão de Estoques </h1>

<?php if(empty($produtos)):?>
    <p> Nenhum produto cadastrado</p>
    <a href="<?=site_url('produtos/novo');?>">Cadastrar novo produto</a>
<?php else:?>
    <?php foreach($produtos as $produto):?>
        <ul>
            <li>
                <?=$produto['nome'];?> - Estoque <?=$produto['estoque'];?>
                <a href="<?=site_url('estoque/adicionar/' . $produto['id']);?>">Adicionar quantidade</a>
                <a href="<?=site_url('estoque/remover/' . $produto['id']);?>">Remover quantidade</a>
                <a href="<?=site_url('estoque/historico/' . $produto['id']);?>">Histórico</a>


            </li>
        </ul>
    <?php endforeach;?>
<?php endif;?>

<?=$this->endSection();?>