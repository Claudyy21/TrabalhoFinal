<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AdminMiddleware implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        if (!session()->get('logado')) {
            return redirect()->to('login')
                ->with('erros', 'Faça login para continuar.');
        }

        if (session()->get('usuario_tipo') !== 'admin') {
            return redirect()->to('produtos')
                ->with('erros', 'Acesso negado.');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
    }
}