<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AuthMiddleware implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        if (!session()->get('logado')) {
            return redirect()->to('login')
                ->with('erros', 'Faça login para continuar.');
        }

        if (session()->get('usuario_bloqueado')) {
            session()->destroy();
            return redirect()->to('login')
                ->with('erros', 'Sua conta está bloqueada.');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
    }
}