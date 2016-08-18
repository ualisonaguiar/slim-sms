<?php

namespace Sms\Service;

use Sms\Entity\Cliente as ClienteEntity;

class Cliente
{
    public function getClientes($arrDataPost = array())
    {
        try {
            $entityCliente = new ClienteEntity();
            $arrResult = $entityCliente->getClientes($arrDataPost);
            if (!$arrResult) {
                throw new \Exception('Cliente não encontrado');
            }
            return array(
                'status' => true,
                'data' => $arrResult
            );
        } catch (\Exception  $exception) {
            return array(
                'status' => false,
                'message' => $exception->getMessage()
            );
        }
    }

    public function autenticar($strUser, $strPassword)
    {
        $entityCliente = new ClienteEntity();
        return $entityCliente->autenticar($strUser, $strPassword, $entityCliente::CO_SITUACAO_CLIENTE_ATIVO);
    }
}