<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

class BaseController extends Controller
{
    /**
     * An array of helpers to be loaded automatically upon class instantiation.
     * @var array
     */
    protected $helpers = [];

    /**
     * Init controller: called before each controller method.
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

        // Preload any models, libraries, or helpers here.
        // e.g. $this->session = \Config\Services::session();
    }

    /**
     * Gera um identificador estável para o totem com base no IP da máquina.
     */
    protected function getTotemData(): array
    {
        $request = service('request');
        $ip = trim((string) ($request->getIPAddress() ?: $request->getServer('REMOTE_ADDR') ?: 'unknown'));

        if ($ip === '' || $ip === '0.0.0.0' || $ip === '::1') {
            $ip = 'local';
        }

        $session = session();
        $totemId = $session->get('totem_id');

        if (empty($totemId)) {
            $totemId = 'totem-' . substr(hash('sha256', $ip . '|' . ($_SERVER['SERVER_NAME'] ?? 'localhost')), 0, 16);
            $session->set('totem_id', $totemId);
        }

        $session->set('totem_ip', $ip);

        return [
            'totem_id'   => $totemId,
            'id_totem'   => $totemId,
            'id_maquina' => $totemId,
            'maquina_id' => $totemId,
            'totem_ip'   => $ip,
        ];
    }
}
