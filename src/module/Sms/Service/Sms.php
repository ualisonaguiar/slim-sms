<?php
/**
 * Created by PhpStorm.
 * User: ualison
 * Date: 18/08/16
 * Time: 00:06
 */

namespace Sms\Service;

use Sms\Entity\Sms as SmEntity;

class Sms
{
    public function listagem($arrDataPost)
    {
        try {
            $smsEntity = new SmEntity();
            $arrResult = $smsEntity->listagem($arrDataPost);
            return $arrResult;
        } catch (\Exception $exception) {
            throw $exception;
        }
    }

    public function inserir($arrDataPost)
    {
        try {
            $smsEntity = new SmEntity();
            $smsEntity->getConection()->beginTransaction();
            if (!$arrDataPost) {
                throw new \Exception('Não veio preenchidos as informações do SMS.');
            }
            $this->validaRegistro($arrDataPost);
            $arrInformacaoTelefone = $this->getInforTelefone($arrDataPost['to']);
            $arrInfoSms = array(
                'id_operadora' => $arrInformacaoTelefone['operadora'],
                'id_cliente' => $arrDataPost['id_cliente'],
                'nu_ddd' => $arrInformacaoTelefone['ddd'],
                'nu_telefone' => $arrInformacaoTelefone['telefone'],
                'ds_mensagem' => $arrDataPost['text'],
                'dat_cadastro' => date('Y-m-d H:i:s'),
                'tp_situacao' => $smsEntity::CO_SITUACAO_AGUARANDO_ENVIO,
                'ds_destinatario' => $arrDataPost['from']
            );
            $smsEntity->insert($arrInfoSms);
            $smsEntity->getConection()->commit();
            return array(
                'status' => true,
                'message' => 'SMS inserindo com sucesso.'
            );
        } catch (\Exception $exception) {
            $smsEntity->getConection()->rollBack();
            return array(
                'status' => false,
                'message' => $exception->getMessage()
            );
        }
    }

    protected function validaRegistro($arrData)
    {
        $arrError = array();
        foreach ($arrData as $strIndice => $strValue) {
            if (!trim($strValue) && strlen($strValue) < 2) {
                $arrError[$strIndice];
            }
        }
        if ($arrError) {
            throw new \Exception('O(s) seguinte(s) campo(s) são inválido: ' . implode($arrError));
        }
    }

    protected function  getInforTelefone($strNumero)
    {
        $intDdd = substr($strNumero, 0 , 2);
        $intTelefone = substr($strNumero, 2);
        #@TODO mock da operadora, implementar a logica de verificar.
        $intOperadora = 3;
        return array(
            'ddd' => $intDdd,
            'telefone' => $intTelefone,
            'operadora' => $intOperadora
        );
    }
}