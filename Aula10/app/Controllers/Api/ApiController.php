<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\PedidoModel;
use App\Models\PedidoProdutoModel;
use App\Models\ProdutoModel;

class ApiController extends BaseController
{
    use ResponseTrait;

    public function api_status()
    {
        return $this->respond([], 200, "Api funcionando");
    }

    public function get_produtos()
    {
        $produtoModel = new ProdutoModel();
        $produtos = $produtoModel->findAll();
        return $this->respond($produtos, 200);
    }

    public function get_pedidos()
    {
        $pedidoModel = new PedidoModel();
        $pedidoProdutoModel = new PedidoProdutoModel();
        $produtoModel = new ProdutoModel();

        $pedidos = $pedidoModel->findAll();

        foreach ($pedidos as &$pedido) {
            $itens = $pedidoProdutoModel->where('id_pedido', $pedido['id'])->findAll();

            foreach ($itens as &$item) {
                $item['produto'] = $produtoModel->find($item['id_produto']);
            }

            $pedido['itens'] = $itens;
        }

        return $this->respond($pedidos, 200);
    }

    public function get_pedido($id)
    {
        $pedidoModel = new PedidoModel();
        $pedidoProdutoModel = new PedidoProdutoModel();
        $produtoModel = new ProdutoModel();

        $pedido = $pedidoModel->find($id);

        if (!$pedido) {
            return $this->failNotFound('Pedido não encontrado.');
        }

        $itens = $pedidoProdutoModel->where('id_pedido', $id)->findAll();

        foreach ($itens as &$item) {
            $item['produto'] = $produtoModel->find($item['id_produto']);
        }

        $pedido['itens'] = $itens;

        return $this->respond($pedido, 200);
    }

    public function atualizar_status($id)
    {
        $apiKey = $this->request->getHeaderLine('apiKey');

        if (!$apiKey || $apiKey != env('API_KEY')) {
            return $this->failUnauthorized('API Key inválida.');
        }

        $pedidoModel = new PedidoModel();

        $pedido = $pedidoModel->find($id);

        if (!$pedido) {
            return $this->failNotFound('Pedido não encontrado.');
        }

        $dados = $this->request->getJSON(true);

        $statusValidos = ['novo', 'em_preparo', 'finalizado', 'cancelado'];

        if (!isset($dados['status']) || !in_array($dados['status'], $statusValidos)) {
            return $this->failValidationErrors('Status inválido. Use: ' . implode(', ', $statusValidos));
        }

        $pedidoModel->update($id, ['status' => $dados['status']]);

        return $this->respond([
            'status'  => true,
            'message' => 'Status atualizado para: ' . $dados['status']
        ], 200);
    }

    public function checkout()
{
    $apiKey = $this->request->getHeaderLine('apiKey');

    if (!$apiKey) {
        return $this->failUnauthorized('API Key não informada.');
    }

    if ($apiKey != env('API_KEY')) {
        return $this->failUnauthorized('API Key inválida.');
    }

    $dados = $this->request->getJSON(true);

    if (!$dados) {
        return $this->failValidationErrors('JSON inválido.');
    }

    if (!isset($dados['produtos']) || empty($dados['produtos'])) {
        return $this->failValidationErrors('O pedido precisa ter pelo menos um produto.');
    }

    $pedidoModel        = new PedidoModel();
    $pedidoProdutoModel = new PedidoProdutoModel();
    $produtoModel       = new ProdutoModel();

    // Verifica estoque antes de qualquer coisa
    foreach ($dados['produtos'] as $produto) {
        $produtoAtual = $produtoModel->find($produto['id_produto']);

        if (!$produtoAtual) {
            return $this->failNotFound('Produto #' . $produto['id_produto'] . ' não encontrado.');
        }

        if ($produtoAtual['estoque'] < (int) $produto['quantidade']) {
            return $this->fail(
                'Estoque insuficiente para "' . $produtoAtual['nome'] . '". '
                . 'Disponível: ' . $produtoAtual['estoque'] . ', '
                . 'Solicitado: ' . $produto['quantidade'] . '.',
                409
            );
        }
    }

    $db = \Config\Database::connect();
    $db->transStart();

    $idPedido = $pedidoModel->insert([
        'status'     => $dados['status'] ?? 'novo',
        'totem_id'   => $dados['totem_id']   ?? null,
        'totem_name' => $dados['totem_name'] ?? null,
        'totem_ip'   => $dados['totem_ip']   ?? null,
    ]);

    foreach ($dados['produtos'] as $produto) {
        $pedidoProdutoModel->insert([
            'id_pedido'      => $idPedido,
            'id_produto'     => $produto['id_produto'],
            'quantidade'     => $produto['quantidade'],
            'preco_unitario' => $produto['preco_unitario']
        ]);

        $produtoAtual = $produtoModel->find($produto['id_produto']);
        $produtoModel->update($produto['id_produto'], [
            'estoque' => $produtoAtual['estoque'] - (int) $produto['quantidade']
        ]);
    }

    $db->transComplete();

    if ($db->transStatus() == false) {
        return $this->failServerError('Erro ao cadastrar pedido.');
    }

    return $this->respondCreated([
        'status'    => true,
        'message'   => 'Pedido cadastrado com sucesso.',
        'id_pedido' => $idPedido
    ]);
}
}