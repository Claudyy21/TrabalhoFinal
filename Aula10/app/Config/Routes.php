<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->get('/', 'Home::index');

// Auth
$routes->get('login', 'UsuarioController::login');
$routes->post('login', 'UsuarioController::autenticar');
$routes->get('logout', 'UsuarioController::logout');
$routes->get('cadastrar', 'UsuarioController::cadastrar');
$routes->post('cadastrar', 'UsuarioController::salvarUsuario');
$routes->get('esqueci-senha', 'UsuarioController::esqueciSenha');
$routes->post('esqueci-senha', 'EmailController::enviar');
$routes->get('redefinir-senha/(:any)', 'UsuarioController::redefinirSenha/$1');
$routes->post('redefinir-senha', 'UsuarioController::salvarNovaSenha');

// Área autenticada — Produtos
$routes->group('', ['filter' => 'auth'], function($routes) {
    $routes->get('produtos', 'ProdutoController::listarPublico');
    $routes->get('produtos/novo', 'ProdutoController::novo');
    $routes->post('produtos/salvar', 'ProdutoController::salvar');
    $routes->get('produtos/editar/(:num)', 'ProdutoController::editar/$1');
    $routes->post('produtos/atualizar/(:num)', 'ProdutoController::atualizar/$1');
    $routes->get('produtos/excluir/(:num)', 'ProdutoController::excluir/$1');

    // Estoque
    $routes->get('estoque', 'EstoqueController::listarPublico');
    $routes->get('estoque/adicionar/(:num)', 'EstoqueController::adicionar/$1');
    $routes->get('estoque/remover/(:num)', 'EstoqueController::remover/$1');
    $routes->post('estoque/salvar', 'EstoqueController::salvar');
    $routes->get('estoque/historico/(:num)', 'EstoqueController::historico/$1');

    // Perfil do próprio usuário
    $routes->get('perfil', 'UsuarioController::perfil');
    $routes->post('perfil/atualizar', 'UsuarioController::atualizarPerfil');
});

// Área Super Admin
$routes->group('admin', ['filter' => 'admin'], function($routes) {
    $routes->get('usuarios', 'UsuarioController::listar');
    $routes->get('usuarios/novo', 'UsuarioController::novo');
    $routes->post('usuarios/salvar', 'UsuarioController::salvarAdmin');
    $routes->get('usuarios/editar/(:num)', 'UsuarioController::editar/$1');
    $routes->post('usuarios/atualizar/(:num)', 'UsuarioController::atualizar/$1');
    $routes->get('usuarios/bloquear/(:num)', 'UsuarioController::bloquear/$1');
    $routes->get('usuarios/desbloquear/(:num)', 'UsuarioController::desbloquear/$1');
});

// API
$routes->get('api/status', 'Api\ApiController::api_status');
$routes->get('api/produtos', 'Api\ApiController::get_produtos');
$routes->post('api/checkout', 'Api\ApiController::checkout');
$routes->get('api/pedidos', 'Api\ApiController::get_pedidos');
$routes->get('api/pedidos/(:num)', 'Api\ApiController::get_pedido/$1');
$routes->patch('api/pedidos/(:num)/status', 'Api\ApiController::atualizar_status/$1');

$routes->get('painel', 'PainelController::index');