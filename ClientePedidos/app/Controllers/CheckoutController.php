<?php

namespace App\Controllers;

class CheckoutController extends BaseController
{
    public function index()
    {
        return view('checkout/index');
    }

    public function finalizar()
    {
        $carrinho = session()->get('carrinho') ?? [];

        if (empty($carrinho)) {
            return redirect()->to(site_url('carrinho'));
        }

        $totemData = $this->getTotemData();

        $pedido = [
            'status'   => 'novo',
            'produtos' => [],
            ...$totemData,
        ];

        foreach ($carrinho as $item) {
            $pedido['produtos'][] = [
                'id_produto'     => $item['id_produto'],
                'quantidade'     => $item['quantidade'],
                'preco_unitario' => $item['preco_unitario']
            ];
        }

        $client = \Config\Services::curlrequest();

        try {
            // 1. Envia o pedido
            $response = $client->post(
                env('API_URL') . '/api/checkout',
                [
                    'headers'     => ['apiKey' => env('API_KEY')],
                    'json'        => $pedido,
                    'http_errors' => false,
                ]
            );

            $status = $response->getStatusCode();

            // Estoque insuficiente ou outro erro da API
            if ($status < 200 || $status >= 300) {
                $bodyRaw = $response->getBody();
                $body = json_decode($bodyRaw, true);
    
                $mensagem = $body['messages']['error'][0]
                    ?? $body['message']
                    ?? $body['error']
                    ?? $bodyRaw;

             return redirect()->to(site_url('carrinho'))
                ->with('erro', $mensagem);
            }

            $resultado = json_decode($response->getBody(), true) ?: [];

            // 2. Busca o pedido completo com os itens
            $responsePedido = $client->get(
                env('API_URL') . '/api/pedidos/' . $resultado['id_pedido'],
                ['http_errors' => false]
            );

            $pedidoCompleto = json_decode($responsePedido->getBody(), true) ?: [];

        } catch (\Exception $e) {
            return redirect()->to(site_url('carrinho'))
                ->with('erro', 'Não foi possível enviar o pedido: ' . $e->getMessage());
        }

        session()->remove('carrinho');

        return view('pedido/nota', [
            'pedido' => $pedidoCompleto
        ]);
    }
}