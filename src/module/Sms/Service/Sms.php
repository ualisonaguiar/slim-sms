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
    public function inserir($arrDataPost)
    {
        try {
            $smsEntity = new SmEntity();
            $smsEntity->getConection()->beginTransaction();
            if (!$arrDataPost) {
                throw new \Exception('Não veio preenchidos as informações do SMS.');
            }
            $this->validaRegistro($arrDataPost);
            $arrDataPost['dat_cadastro'] = date('Y-m-d H:i:s');
            $arrDataPost['tp_situacao'] = $smsEntity::CO_SITUACAO_AGUARANDO_ENVIO;
            $smsEntity->insert($arrDataPost);
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
}