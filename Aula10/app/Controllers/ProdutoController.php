<?php

namespace App\Controllers;

use App\Controllers\BaseController;

use App\Models\ProdutoModel;


class ProdutoController extends BaseController
{

    protected ProdutoModel $model;

    public function __construct()
    {
        $this->model = new ProdutoModel();
    }

    //Listar todos os produtos
    public function index(): string
    {

        $this->verificarlogin();
        //ANTES
        //$produtos = $this->model->findAll();

        //COM BUSCA
        $busca = $this->request->getGet('busca');
        $preco = $this->request->getGet('preco');

        if ($busca) {
            $this->model->like('nome', $busca);
        }

        if (!empty($preco)) {
            if ($preco == 'baixo') {
                $this->model->where('preco <', 5);
            } elseif ($preco == 'medio') {
                $this->model->where('preco >=', 5)->where('preco <=', 10);
            } elseif ($preco == 'alto') {
                $this->model->where('preco >', 10);
            }
        }

        //AGORA
        $produtos =  $this->model->paginate(2);

        return view(
            'pages/produtos/index',
            [
                'titulo' => 'Lista de produtos',
                'produtos' => $produtos,
                'pager'   =>  $this->model->pager,
                'busca'   => $busca,
                'preco' => $preco

            ]
        );
    }

    // Listar produtos publicamente (sem autenticação)
    public function listarPublico(): string
    {
        $busca = $this->request->getGet('busca');
        $preco = $this->request->getGet('preco');

        if ($busca) {
            $this->model->like('nome', $busca);
        }

        if (!empty($preco)) {
            if ($preco == 'baixo') {
                $this->model->where('preco <', 5);
            } elseif ($preco == 'medio') {
                $this->model->where('preco >=', 5)->where('preco <=', 10);
            } elseif ($preco == 'alto') {
                $this->model->where('preco >', 10);
            }
        }

        $produtos = $this->model->paginate(2);

        return view(
            'pages/produtos/index',
            [
                'titulo' => 'Lista de produtos',
                'produtos' => $produtos,
                'pager'   =>  $this->model->pager,
                'busca'   => $busca,
                'preco' => $preco
            ]
        );
    }

    public function novo(): string
    {
        return view('pages/produtos/cadastro', [
            'titulo' => 'Novo Produto',
            'Produto' => null,
        ]);
    }

    //salva um novo Produto
    public function salvar()
    {


        $dados = [
            'nome'  => $this->request->getPost('nome'),
            'preco' => $this->request->getPost('preco'),
            'categoria' => $this->request->getPost('categoria')

        ];

        $regrasFoto = [
            'foto'  => 'is_image[foto]'
                . '|mime_in[foto,image/jpeg,image/png,image/gif]'
                . '|ext_in[foto,jpg,jpeg,png,webp]'
                . '|max_size[foto,2048]'
        ];

        $erros = [];

        if (!$this->model->validate($dados)) {
            $erros = array_merge($erros, $this->model->errors());
        }

        if (! $this->validate($regrasFoto)) {
            $erros = array_merge($erros, $this->validator->getErrors());
        }

        if (! empty($erros)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $erros);
        }


        $foto = $this->request->getFile('foto');

        if ($foto && $foto->isValid()) {
            $nomeFotoRandomico = $foto->getRandomName();
            $foto->move(FCPATH . 'uploads/produtos', $nomeFotoRandomico);
            $dados['foto'] = $nomeFotoRandomico; 
        }

        if (! $this->model->insert($dados)) {
            unlink(FCPATH . 'uploads/produtos/' . $nomeFotoRandomico);
            return redirect()->back()->withInput()
                ->with('errors', $this->model->errors());
        }

        return redirect()->to(site_url('produtos'));
    }




    //abre a página de edição
    public function editar(int $id): string
    {

        $Produto = $this->model->find($id);

        return view('pages/produtos/editar', [
            'titulo' => 'Editar Produto',
            'Produto' => $Produto
        ]);
    }


    public function atualizar(int $id)
{
    $dados = [
        'nome'      => $this->request->getPost('nome'),
        'preco'     => $this->request->getPost('preco'),
        'categoria' => $this->request->getPost('categoria')
    ];

    $foto = $this->request->getFile('foto');

    if ($foto && $foto->isValid() && !$foto->hasMoved()) {
        $nomeFotoRandomico = $foto->getRandomName();
        $foto->move(FCPATH . 'uploads/produtos', $nomeFotoRandomico);
        $dados['foto'] = $nomeFotoRandomico;

        // Remove foto antiga
        $produtoAtual = $this->model->find($id);
        if (!empty($produtoAtual['foto'])) {
            $caminho = FCPATH . 'uploads/produtos/' . $produtoAtual['foto'];
            if (file_exists($caminho)) {
                unlink($caminho);
            }
        }
    }

    if (!$this->model->update($id, $dados)) {
        return view('pages/produtos/editar', [
            'titulo'  => 'Editar Produto',
            'Produto' => $this->model->find($id),
            'errors'  => $this->model->errors(),
        ]);
    }

    return redirect()->to(site_url('produtos'));
}


    public function excluir(int $id): \CodeIgniter\HTTP\RedirectResponse{
    $Produto = $this->model->find($id);

    if (!empty($Produto['foto'])) {
        $caminho = FCPATH . 'uploads/produtos/' . $Produto['foto'];
        if (file_exists($caminho)) {
            unlink($caminho);
        }
    }
    $db = \Config\Database::connect();
    $db->table('estoques')->where('id_produto', $id)->delete();
    $db->table('pedido_produtos')->where('id_produto', $id)->delete();

    $this->model->delete($id);
    return redirect()->to(site_url('produtos'));
}
}
