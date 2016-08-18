<?php

namespace Sms\Entity;

class Sms
{
    use Conexao;

    const CO_SITUACAO_AGUARANDO_ENVIO = 1;

    public function insert($arrDataPost)
    {
        try {
            $connection = self::getConection();
            $strQuery = 'insert into tb_sms (id_operadora, id_cliente, nu_ddd, nu_telefone, ds_mensagem, dat_cadastro, tp_situacao_envio) values ';
            $strQuery .= '(:id_operadora, :id_cliente, :nu_ddd, :nu_telefone, :ds_mensagem, :dat_cadastro, :tp_situacao)';
            $query = $connection->prepare($strQuery);
            $query->bindParam('id_operadora', $arrDataPost['operadora']);
            $query->bindParam('id_cliente', $arrDataPost['id_cliente']);
            $query->bindParam('nu_ddd', $arrDataPost['ddd']);
            $query->bindParam('nu_telefone', $arrDataPost['telefone']);
            $query->bindParam('ds_mensagem', $arrDataPost['mensagem']);
            $query->bindParam('dat_cadastro', $arrDataPost['dat_cadastro']);
            $query->bindParam('tp_situacao', $arrDataPost['tp_situacao']);
            return $query->execute();
        } catch (\Exception $excption) {
            throw new \Exception('Não foi possível salvar as informações do SMS. Erro: ' . $excption->getMessage());
        }
    }
}