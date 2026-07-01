<?php

namespace App\Controllers;

class ProdutoController extends BaseController
{
    public function index()
    {
        try {

            $client = \Config\Services::curlrequest();

            $response = $client->get(
                env('API_URL') . '/api/produtos',
                [
                    'http_errors' => false,
                ]
            );

            $status = $response->getStatusCode();

            if ($status < 200 || $status >= 300) {
                throw new \Exception('API retornou status ' . $status . ': ' . $response->getBody());
            }

            $produtos = json_decode($response->getBody(), true) ?: [];

            return view('produtos/index', [
                'produtos' => $produtos
            ]);

        } catch (\Exception $e) {

            return view('produtos/index', [
                'produtos' => [],
                'erro' => 'Não foi possível conectar à API.'
            ]);
        }
    }
}