<?php

namespace App\Controllers;

class CozinhaController extends BaseController
{
    private function getClient()
    {
        return \Config\Services::curlrequest();
    }

    public function index()
    {
        $client = $this->getClient();

        try {
            $response = $client->get(env('API_URL') . '/api/pedidos', [
                'http_errors' => false
            ]);
            $pedidos = json_decode($response->getBody(), true) ?: [];
        } catch (\Exception $e) {
            $pedidos = [];
        }

        return view('cozinha/index', ['pedidos' => $pedidos]);
    }

    public function detalhes($id)
    {
        $client = $this->getClient();

        try {
            $response = $client->get(env('API_URL') . '/api/pedidos/' . $id, [
                'http_errors' => false
            ]);
            $pedido = json_decode($response->getBody(), true) ?: [];
        } catch (\Exception $e) {
            $pedido = [];
        }

        return view('cozinha/detalhes', ['pedido' => $pedido]);
    }

    public function atualizarStatus($id)
    {
        $status = $this->request->getPost('status');
        $client = $this->getClient();

        try {
            $client->patch(env('API_URL') . '/api/pedidos/' . $id . '/status', [
                'headers'     => ['apiKey' => env('API_KEY')],
                'json'        => ['status' => $status],
                'http_errors' => false
            ]);
        } catch (\Exception $e) {
            // silencioso
        }

        return redirect()->to(site_url('/'));
    }
}