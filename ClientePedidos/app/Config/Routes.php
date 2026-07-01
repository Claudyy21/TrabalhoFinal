<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->get('/', 'HomeController::index');

$routes->get('produtos', 'ProdutoController::index');

// Rotas com prefixo admin/ para compatibilidade com o projeto Aula10
# (removido) rota admin/produtos

$routes->get('carrinho', 'CarrinhoController::index');
$routes->post('carrinho/adicionar', 'CarrinhoController::adicionar');
$routes->get('carrinho/remover/(:num)', 'CarrinhoController::remover/$1');
// Atualizar quantidade do carrinho (inc/dec/set)
$routes->post('carrinho/atualizar', 'CarrinhoController::atualizar');
// Cancelar (limpar) carrinho
$routes->post('carrinho/cancelar', 'CarrinhoController::cancelar');

// Versões admin/ das rotas do carrinho
# (removidas) rotas admin/carrinho

$routes->get('checkout', 'CheckoutController::index');
$routes->post('checkout/finalizar', 'CheckoutController::finalizar');

// Versões admin/ das rotas de checkout
# (removidas) rotas admin/checkout

$routes->get('pedido', 'PedidoController::index');

// Versão admin/ da rota de pedidos
# (removida) rota admin/pedido