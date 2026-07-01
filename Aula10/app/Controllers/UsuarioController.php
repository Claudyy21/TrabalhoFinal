<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UsuarioModel;

class UsuarioController extends BaseController
{
    // -------------------------
    // AUTH
    // -------------------------

    public function login()
    {
        return view('pages/auth/login');
    }

    public function autenticar()
    {
        $email = $this->request->getPost('email');
        $senha = $this->request->getPost('senha');

        $model = new UsuarioModel();
        $usuario = $model->where('email', $email)->first();

        if (!$usuario || !password_verify($senha, $usuario['senha_hash'])) {
            return redirect()->back()->with('erros', 'Login inválido');
        }

        if ($usuario['bloqueado']) {
            return redirect()->back()->with('erros', 'Sua conta está bloqueada. Entre em contato com o administrador.');
        }

        session()->set([
            'usuario_id'        => $usuario['id'],
            'usuario_email'     => $usuario['email'],
            'usuario_tipo'      => $usuario['tipo'],
            'usuario_bloqueado' => $usuario['bloqueado'],
            'logado'            => true
        ]);

        return redirect()->to(base_url('produtos'));
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to(base_url('login'));
    }

    public function cadastrar()
    {
        return view('pages/auth/cadastrar');
    }

    public function salvarUsuario()
    {
        $model = new UsuarioModel();
        $senha = $this->request->getPost('senha');

        if (!$senha) {
            return redirect()->back()->with('erros', 'Senha obrigatória');
        }

        $model->save([
            'email'      => trim($this->request->getPost('email')),
            'senha_hash' => password_hash($senha, PASSWORD_DEFAULT),
            'tipo'       => 'usuario'
        ]);

        return redirect()->to(base_url('login'))
            ->with('sucesso', 'Conta criada com sucesso!');
    }

    public function esqueciSenha()
    {
        return view('pages/auth/forgot_password');
    }

    public function redefinirSenha($token)
    {
        $model = new UsuarioModel();
        $usuario = $model->where('reset_token', $token)->first();

        if (!$usuario) {
            die('Token inválido');
        }

        if (strtotime($usuario['reset_token_date']) < time()) {
            die('Token expirado');
        }

        return view('pages/auth/reset_password', ['token' => $token]);
    }

    public function salvarNovaSenha()
    {
        $token = $this->request->getPost('token');
        $senha = password_hash($this->request->getPost('senha'), PASSWORD_DEFAULT);

        $model = new UsuarioModel();
        $usuario = $model->where('reset_token', $token)->first();

        if (!$usuario) {
            die('Token inválido');
        }

        $model->update($usuario['id'], [
            'senha_hash'        => $senha,
            'reset_token'       => null,
            'reset_token_date'  => null
        ]);

        return redirect()->to(base_url('login'))
            ->with('sucesso', 'Senha alterada com sucesso!');
    }

    // -------------------------
    // PERFIL (usuário comum)
    // -------------------------

    public function perfil()
    {
        $model = new UsuarioModel();
        $usuario = $model->find(session()->get('usuario_id'));

        return view('pages/perfil/editar', ['usuario' => $usuario]);
    }

    public function atualizarPerfil()
    {
        $id    = session()->get('usuario_id');
        $model = new UsuarioModel();

        $dados = [
            'email' => trim($this->request->getPost('email'))
        ];

        $senha = $this->request->getPost('senha');
        if ($senha) {
            $dados['senha_hash'] = password_hash($senha, PASSWORD_DEFAULT);
        }

        $model->update($id, $dados);

        session()->set('usuario_email', $dados['email']);

        return redirect()->to(base_url('perfil'))
            ->with('sucesso', 'Dados atualizados com sucesso!');
    }

    // -------------------------
    // SUPER ADMIN
    // -------------------------

    public function listar()
    {
        $model    = new UsuarioModel();
        $usuarios = $model->findAll();

        return view('pages/admin/usuarios/listar', ['usuarios' => $usuarios]);
    }

    public function novo()
    {
        return view('pages/admin/usuarios/form', ['usuario' => null]);
    }

    public function salvarAdmin()
    {
        $model = new UsuarioModel();
        $senha = $this->request->getPost('senha');

        if (!$senha) {
            return redirect()->back()->with('erros', 'Senha obrigatória');
        }

        $model->save([
            'email'      => trim($this->request->getPost('email')),
            'senha_hash' => password_hash($senha, PASSWORD_DEFAULT),
            'tipo'       => $this->request->getPost('tipo') ?? 'usuario'
        ]);

        return redirect()->to(base_url('admin/usuarios'))
            ->with('sucesso', 'Usuário cadastrado com sucesso!');
    }

    public function editar($id)
    {
        $model   = new UsuarioModel();
        $usuario = $model->find($id);

        if (!$usuario) {
            return redirect()->to(base_url('admin/usuarios'))
                ->with('erros', 'Usuário não encontrado.');
        }

        return view('pages/admin/usuarios/form', ['usuario' => $usuario]);
    }

    public function atualizar($id)
    {
        $model = new UsuarioModel();

        $dados = [
            'email' => trim($this->request->getPost('email')),
            'tipo'  => $this->request->getPost('tipo')
        ];

        $senha = $this->request->getPost('senha');
        if ($senha) {
            $dados['senha_hash'] = password_hash($senha, PASSWORD_DEFAULT);
        }

        $model->update($id, $dados);

        return redirect()->to(base_url('admin/usuarios'))
            ->with('sucesso', 'Usuário atualizado com sucesso!');
    }

    public function bloquear($id)
    {
        $model = new UsuarioModel();
        $model->update($id, ['bloqueado' => 1]);

        return redirect()->to(base_url('admin/usuarios'))
            ->with('sucesso', 'Usuário bloqueado.');
    }

    public function desbloquear($id)
    {
        $model = new UsuarioModel();
        $model->update($id, ['bloqueado' => 0]);

        return redirect()->to(base_url('admin/usuarios'))
            ->with('sucesso', 'Usuário desbloqueado.');
    }
}