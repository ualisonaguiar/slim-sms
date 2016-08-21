<?php

namespace Sms\Controller;

use Slim\Http\Request as RequestSlim;
use Slim\Http\Response as ResponseSlim;
use Sms\Service\Sms as SmsService;

class EnvioSms
{
    public function listagem(RequestSlim $request, ResponseSlim $response, $next = null)
    {
        $smsService = new SmsService();
        $arrDataPost = array(
            'id_cliente' => $request->getAttribute('id_cliente')
        );
        try {
            return json_encode(array('data' => $smsService->listagem($arrDataPost)));
        } catch (\Exception $exception) {
            return $response->withStatus(500, $exception->getMessage());
        }
    }

    public function registrar(RequestSlim $request, ResponseSlim $response, $next = null)
    {
        $smsService = new SmsService();
        $arrDataPost = $request->getParams();
        $arrDataPost['id_cliente'] = $request->getAttribute('id_cliente');
        $arrResult = $smsService->inserir($arrDataPost);
        $intCodeStatus = 200;
        if (!$arrResult['status']) {
            $intCodeStatus = 500;
        }
        return $response->withStatus($intCodeStatus, $arrResult['message']);
    }
}