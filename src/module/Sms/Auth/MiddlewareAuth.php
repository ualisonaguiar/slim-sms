<?php

namespace Sms\Auth;

use Slim\Http\Request as RequestSlim;
use Slim\Http\Response as ResponseSlim;
use Sms\Service\Cliente as ClienteService;

class MiddlewareAuth
{
    public function __invoke(RequestSlim $request, ResponseSlim $response, $next)
    {
        $clienteService = new ClienteService();
        $arrResult = $clienteService->autenticar(
            reset($request->getHeader('user')),
            md5(reset($request->getHeader('password')))
        );
        if (!$arrResult) {
            return $response->withStatus(401);
        }
        $response = $next($request->withAttribute('id_cliente', $arrResult[0]['id_cliente']), $response);
        return $response;
    }
}