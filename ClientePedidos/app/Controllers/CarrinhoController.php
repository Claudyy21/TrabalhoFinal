<?php

namespace App\Controllers;

class CarrinhoController extends BaseController
{
    public function index()
    {
        $carrinho = session()->get('carrinho') ?? [];

        return view('carrinho/index', [
            'carrinho' => $carrinho
        ]);
    }

    public function adicionar()
    {
        $carrinho = session()->get('carrinho') ?? [];

        $id = $this->request->getPost('id');
        $nome = $this->request->getPost('nome');
        $preco = $this->request->getPost('preco');

        $encontrado = false;

        foreach ($carrinho as &$item) {

            if ($item['id_produto'] == $id) {

                $item['quantidade']++;
                $encontrado = true;
                break;
            }
        }

        if (!$encontrado) {

            $carrinho[] = [
                'id_produto' => $id,
                'nome' => $nome,
                'quantidade' => 1,
                'preco_unitario' => $preco,
                'foto'=> $this->request->getPost('foto')
            ];
        }

        session()->set('carrinho', $carrinho);

        return redirect()->to(site_url('carrinho'));
    }

    public function remover($id)
    {
        $carrinho = session()->get('carrinho') ?? [];

        foreach ($carrinho as $key => $item) {

            if ($item['id_produto'] == $id) {
                unset($carrinho[$key]);
            }
        }

        session()->set('carrinho', array_values($carrinho));

        return redirect()->back();
    }

    public function atualizar()
    {
        $carrinho = session()->get('carrinho') ?? [];

        $id = $this->request->getPost('id');
        $action = $this->request->getPost('action'); // 'inc', 'dec', 'set'
        $quantity = $this->request->getPost('quantity');

        foreach ($carrinho as $key => &$item) {
            if ($item['id_produto'] == $id) {
                if ($action === 'inc') {
                    $item['quantidade'] = intval($item['quantidade']) + 1;
                } elseif ($action === 'dec') {
                    $item['quantidade'] = max(1, intval($item['quantidade']) - 1);
                } elseif ($action === 'set') {
                    $q = intval($quantity);
                    $item['quantidade'] = max(1, $q);
                }
                break;
            }
        }

        session()->set('carrinho', $carrinho);

        return redirect()->to(site_url('carrinho'));
    }

    public function cancelar()
    {
        session()->remove('carrinho');
        return redirect()->to(site_url('produtos'));
    }
}