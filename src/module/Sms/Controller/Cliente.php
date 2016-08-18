<?php

namespace Sms\Controller;

use Slim\Http\Request as RequestSlim;
use Slim\Http\Response as ResponseSlim;
use Sms\Service\Cliente as ClienteService;

class Cliente
{
    public function index(RequestSlim $request, ResponseSlim $response, $args = null)
    {
        $clienteService = new ClienteService();
        $arrResult = $clienteService->getClientes();
        return json_encode($arrResult);
    }
}