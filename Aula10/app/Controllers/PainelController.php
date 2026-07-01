<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ProdutoModel;
use App\Models\PedidoModel;
use App\Models\PedidoProdutoModel;

class PainelController extends BaseController
{
    public function index()
    {
        $db = \Config\Database::connect();

        // Filtros
        $dataInicio = $this->request->getGet('data_inicio');
        $dataFim    = $this->request->getGet('data_fim');
        $categoria  = $this->request->getGet('categoria');
        $diasVendas = (int) ($this->request->getGet('dias_vendas') ?? 7);

        // -----------------------------------------------
        // PAINEL DE CONSUMO
        // -----------------------------------------------
        $queryConsumo = $db->table('produtos p')
            ->select('p.id, p.nome, p.categoria, p.estoque,
                      COALESCE(SUM(pp.quantidade), 0) as quantidade_vendida')
            ->join('pedido_produtos pp', 'pp.id_produto = p.id AND pp.deleted_at IS NULL', 'left')
            ->join('pedidos ped', 'ped.id = pp.id_pedido AND ped.deleted_at IS NULL AND ped.status != "cancelado"', 'left')
            ->groupBy('p.id');

        if ($categoria) {
            $queryConsumo->where('p.categoria', $categoria);
        }

        if ($dataInicio && $dataFim) {
            $queryConsumo->where('ped.created_at >=', $dataInicio . ' 00:00:00')
                         ->where('ped.created_at <=', $dataFim . ' 23:59:59');
        } elseif ($dataInicio) {
            $queryConsumo->where('ped.created_at >=', $dataInicio . ' 00:00:00');
        }

        $produtos = $queryConsumo->get()->getResultArray();

        // Categorias para o filtro
        $categorias = $db->table('produtos')
            ->select('categoria')
            ->where('categoria IS NOT NULL')
            ->groupBy('categoria')
            ->get()->getResultArray();

        // -----------------------------------------------
        // PAINEL DE VENDAS
        // -----------------------------------------------
        $dataInicioVendas = date('Y-m-d', strtotime("-{$diasVendas} days"));

        $vendas = $db->table('pedidos')
            ->select("DATE(created_at) as data, SUM(
                (SELECT SUM(pp2.quantidade * pp2.preco_unitario)
                 FROM pedido_produtos pp2
                 WHERE pp2.id_pedido = pedidos.id
                 AND pp2.deleted_at IS NULL)
            ) as valor_total")
            ->where('deleted_at IS NULL')
            ->where('status !=', 'cancelado')
            ->where('DATE(created_at) >=', $dataInicioVendas)
            ->groupBy('DATE(created_at)')
            ->orderBy('data', 'DESC')
            ->get()->getResultArray();

        // Dados para o gráfico
        $graficoDatas   = array_reverse(array_column($vendas, 'data'));
        $graficoValores = array_reverse(array_column($vendas, 'valor_total'));

        return view('pages/painel/index', [
            'produtos'       => $produtos,
            'categorias'     => $categorias,
            'vendas'         => $vendas,
            'graficoDatas'   => json_encode($graficoDatas),
            'graficoValores' => json_encode($graficoValores),
            'diasVendas'     => $diasVendas,
            'dataInicio'     => $dataInicio,
            'dataFim'        => $dataFim,
            'categoria'      => $categoria,
        ]);
    }
}