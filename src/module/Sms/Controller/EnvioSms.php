<?php

namespace Sms\Controller;

use Slim\Http\Request as RequestSlim;
use Slim\Http\Response as ResponseSlim;
use Sms\Service\Sms as SmsService;

class EnvioSms
{
    public function registrar(RequestSlim $request, ResponseSlim $response, $args = null)
    {
        $smsService = new SmsService();
        $arrDataPost = $request->getParams();
        $arrDataPost['id_cliente'] = $request->getAttribute('id_cliente');
        $arrResult = $smsService->inserir($arrDataPost);
        return $arrResult;
    }
}