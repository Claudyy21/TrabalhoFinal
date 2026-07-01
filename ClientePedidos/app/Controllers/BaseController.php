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

        $totemName = $this->makeTotemLabelFromIp($ip);
        $session = session();
        $session->set([
            'totem_id'   => $totemName,
            'totem_name' => $totemName,
            'totem_ip'   => $ip,
        ]);

        return [
            'totem_id'   => $totemName,
            'id_totem'   => $totemName,
            'id_maquina' => $totemName,
            'maquina_id' => $totemName,
            'totem_ip'   => $ip,
            'totem_name' => $totemName,
        ];
    }

    /**
     * Converte um IP em um rótulo de totem simples, como "totem 01".
     */
    private function makeTotemLabelFromIp(string $ip): string
    {
        if ($ip === 'local') {
            return 'totem 01';
        }

        if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
            $parts = explode('.', $ip);
            $last = (int) end($parts);
            $last = $last > 0 ? $last : 1;
            return sprintf('totem %02d', ($last % 99) ?: 99);
        }

        $hash = sprintf('%u', crc32($ip));
        return sprintf('totem %02d', ($hash % 99) + 1);
    }
}

