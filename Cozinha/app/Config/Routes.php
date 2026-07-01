<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */

$routes->get('/', 'CozinhaController::index');
$routes->get('pedidos/(:num)', 'CozinhaController::detalhes/$1');
$routes->post('pedidos/(:num)/status', 'CozinhaController::atualizarStatus/$1');