<?php

namespace Sms\Entity;

class Cliente
{
    use Conexao;

    const CO_SITUACAO_CLIENTE_ATIVO = 1;

    public function getClientes($arrDataPost = array())
    {
        $connection = self::getConection();
        $strQuery = 'select * from tb_cliente ';
        $arrResultDb = $connection->query($strQuery, \PDO::FETCH_ASSOC)->fetchAll();
        return $arrResultDb;
    }

    public function autenticar($strUser, $strPassword, $intTpSituacao)
    {
        $strQuery = 'select id_cliente, ds_nome, in_ativo from tb_cliente where ds_login = :ds_login and ds_password = :ds_password';
        $strQuery .= ' and in_ativo = :in_ativo';
        $connection = self::getConection();
        $query = $connection->prepare($strQuery);
        $query->execute([
            'ds_login' => $strUser,
            'ds_password' => $strPassword,
            'in_ativo' => $intTpSituacao
        ]);
        return $query->fetchAll(\PDO::FETCH_ASSOC);
    }
}