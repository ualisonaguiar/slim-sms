<?php

namespace Sms\Auth;

use Slim\Http\Request as RequestSlim;
use Slim\Http\Response as ResponseSlim;
use Sms\Service\Cliente as ClienteService;

class MiddlewareAuth
{
    public function __invoke(RequestSlim $request, ResponseSlim $response, $next)
    {
        try {
            $clienteService = new ClienteService();
            $strAuthorization = base64_decode(reset(str_replace(['Basic', ' '], '', $request->getHeader('Authorization'))));
            if (!$strAuthorization) {
                throw new \Exception('Deverá ser informado as credencias');
            }
            $arrInfoAuthorization = explode('@', $strAuthorization);
            $arrResult = $clienteService->autenticar(
                $arrInfoAuthorization[0],
                md5($arrInfoAuthorization[1])
            );
            if (!$arrResult) {
                throw new \Exception('Usuário/Senha inválido');
            }
            $response = $next($request->withAttribute('id_cliente', $arrResult[0]['id_cliente']), $response);
        } catch (\Exception $exception) {
            $response->withStatus(403)
                ->write($exception->getMessage());
        }
        return $response;
    }
}