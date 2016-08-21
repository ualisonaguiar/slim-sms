<?php

namespace Sms\Entity;

class Sms
{
    use Conexao;

    const CO_SITUACAO_AGUARANDO_ENVIO = 1;

    public function listagem($arrDataPost)
    {
        try {
            $strQuery = '
            select
              cliente.ds_nome,
              operadora.no_operadora,
              sms.nu_ddd,
              sms.nu_telefone,
              sms.ds_mensagem,
              sms.dat_cadastro,
              sms.tp_situacao_envio,
              sms.ds_destinatario
            from 
                tb_sms sms
            inner join tb_cliente cliente
                on cliente.id_cliente = sms.id_cliente
            inner join tb_operadora operadora
                on operadora.id_operadora = sms.id_operadora
            where sms.id_cliente = :id_cliente';
            $connection = self::getConection();
            $query = $connection->prepare($strQuery);
            $query->bindParam('id_cliente', $arrDataPost['id_cliente']);
            $query->execute();
            return $query->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\Exception $exception) {
            throw new \Exception('Não foi possível listar as informações do SMS. Erro: ' . $exception->getMessage());
        }
    }

    public function insert($arrDataPost)
    {
        try {
            $connection = self::getConection();
            $strQuery = 'insert into tb_sms (id_operadora, id_cliente, nu_ddd, nu_telefone, ds_mensagem, dat_cadastro, tp_situacao_envio, ds_destinatario) values ';
            $strQuery .= '(:id_operadora, :id_cliente, :nu_ddd, :nu_telefone, :ds_mensagem, :dat_cadastro, :tp_situacao, :ds_destinatario)';
            $query = $connection->prepare($strQuery);
            $query->bindParam('id_operadora', $arrDataPost['id_operadora']);
            $query->bindParam('id_cliente', $arrDataPost['id_cliente']);
            $query->bindParam('nu_ddd', $arrDataPost['nu_ddd']);
            $query->bindParam('nu_telefone', $arrDataPost['nu_telefone']);
            $query->bindParam('ds_mensagem', $arrDataPost['ds_mensagem']);
            $query->bindParam('dat_cadastro', $arrDataPost['dat_cadastro']);
            $query->bindParam('tp_situacao', $arrDataPost['tp_situacao']);
            $query->bindParam('ds_destinatario', $arrDataPost['ds_destinatario']);
            return $query->execute();
        } catch (\Exception $exception) {
            throw new \Exception('Não foi possível salvar as informações do SMS. Erro: ' . $exception->getMessage());
        }
    }
}