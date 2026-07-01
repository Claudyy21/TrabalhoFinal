<?=$this->extend('/templates/admin');?>

<?=$this->section('conteudo');?>

<h1> Gestão de Estoques - Adicionar </h1>

<p><?=$produto['nome'];?> - Estoque atual: <?=$produto['estoque'];?> </p>


<form action="<?=site_url('estoque/salvar');?>" method="post">
    <?=csrf_field();?>
    <input type="hidden" name="id_produto" value="<?=$produto['id'];?>">

    <br/>
    Quantidade:
    <input type="number" name="quantidade" value="<?=old('quantidade') ?? 0;?>">
    
    <br/>
    Fornecedor:
    <input type="text" name="fornecedor">
    
    <br/>
    Observação:
    <input type="text" name="observacao">

    <input type="hidden" name="tipo" value="entrada">

    <button type"submit">Salvar</button>

</form>
<?=$this->endSection();?>