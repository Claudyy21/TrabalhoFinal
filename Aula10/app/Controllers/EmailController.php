<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UsuarioModel;

class EmailController extends BaseController
{
    public function enviar()
    {
        $emailUser = trim($this->request->getPost('email'));

        if (!$emailUser) {
            return redirect()->back()->with('erros', 'Informe o email');
        }

        $model = new UsuarioModel();

        // busca usuário
        $usuario = $model->where('email', $emailUser)->first();

        if (!$usuario) {
            return redirect()->back()->with('erros', 'Usuário não encontrado');
        }

        // gera token seguro
        $token = bin2hex(random_bytes(50));

        // expiração (1 hora)
        $dataExpiracao = date('Y-m-d H:i:s', strtotime('+1 hour'));

        // salva token no banco
        $model->update($usuario['id'], [
            'reset_token' => $token,
            'reset_token_date' => $dataExpiracao
        ]);

        // link de reset
        $link = base_url('admin/redefinirsenha/' . $token);

        // EMAIL
        $email = \Config\Services::email();

        $email->setFrom('cantina@teste.com', 'Minha Cantina');
        $email->setTo($emailUser);
        $email->setSubject('Recuperação de senha');

        // 🔥 ESSENCIAL: ativar HTML
        $email->setMailType('html');

        $message = "
            <h2>Recuperação de senha</h2>
            <p>Você solicitou a redefinição de senha.</p>

            <p>Clique no botão abaixo:</p>

            <p>
                <a href='{$link}' style='
                    display:inline-block;
                    padding:10px 15px;
                    background:#222;
                    color:#fff;
                    text-decoration:none;
                    border-radius:5px;
                '>
                    Redefinir senha
                </a>
            </p>

            <p><small>Este link expira em 1 hora.</small></p>
        ";

        $email->setMessage($message);

        if ($email->send()) {
            return redirect()->to('admin/login')
                ->with('sucesso', 'Email enviado com sucesso!');
        }

        // debug caso falhe
        return redirect()->back()->with('erros', 'Erro ao enviar email. Verifique SMTP.');
    }
}