<?php

namespace App\Models;

use CodeIgniter\Model;

class PedidoProdutoModel extends Model
{
    protected $table         = 'pedido_produtos';
    protected $primaryKey    = 'id';
    protected $returnType    = 'array';
    protected $allowedFields = ['id_pedido', 'id_produto', 'quantidade', 'preco_unitario'];

    protected $useTimestamps = true;
    protected $useSoftDeletes = true;

 
    // protected $validationMessages = [
    //     'nome' => [
    //         'required'   => 'O nome do Produto e obrigatorio.',
    //         'min_length' => 'O nome deve ter pelo menos 2 caracteres.',
    //         'max_length' => 'O nome deve ter no maximo 100 caracteres.',
    //     ],
    //     'preco' => [
    //         'required'      => 'O preco e obrigatorio.',
    //         'decimal'       => 'Informe um preco valido (ex: 12.50).',
    //         'greater_than'  => 'O preco deve ser maior que zero.',
    //     ],
    // ];
}
