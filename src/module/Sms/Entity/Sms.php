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
            if (array_key_exists('id_sms', $arrDataPost)) {
                $strQuery .= ' and sms.id_sms = :id_sms';
            }
            $connection = self::getConection();
            $query = $connection->prepare($strQuery);
            $query->bindParam('id_cliente', $arrDataPost['id_cliente']);
            if (array_key_exists('id_sms', $arrDataPost)) {
                $query->bindParam('id_sms', $arrDataPost['id_sms']);
            }
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
            $this->setBind($query, $arrDataPost);
            $query->bindParam('dat_cadastro', $arrDataPost['dat_cadastro'], \PDO::PARAM_STR);
            return $query->execute();
        } catch (\Exception $exception) {
            throw new \Exception('Não foi possível salvar as informações do SMS. Erro: ' . $exception->getMessage());
        }
    }

    public function update($arrDataPost)
    {
        try {
            $connection = self::getConection();
            $strQuery = 'update tb_sms set id_operadora = :id_operadora, nu_ddd = :nu_ddd, nu_telefone = :nu_telefone, ds_mensagem = :ds_mensagem, tp_situacao_envio = :tp_situacao, ';
            $strQuery .= 'ds_destinatario = :ds_destinatario where id_sms = :id_sms and id_cliente = :id_cliente';
            $query = $connection->prepare($strQuery);
            $this->setBind($query, $arrDataPost);
            $query->bindParam('id_sms', $arrDataPost['id_sms'], \PDO::PARAM_INT);
            return $query->execute();
        } catch (\Exception $exception) {
            var_dump($exception->getMessage());
            die;
            throw new \Exception('Não foi possível salvar as informações do SMS. Erro: ' . $exception->getMessage());
        }
    }

    public function excluir($arrDataPost)
    {
        try {
            $connection = self::getConection();
            $strQuery = 'delete from tb_sms where id_sms = :id_sms and id_cliente = :id_cliente';
            $query = $connection->prepare($strQuery);
            $query->bindParam('id_sms', $arrDataPost['id_sms'], \PDO::PARAM_INT);
            $query->bindParam('id_cliente', $arrDataPost['id_cliente'], \PDO::PARAM_INT);
            return $query->execute();
        } catch (\Exception $exception) {
            throw new \Exception('Não foi possível excluir as informações do SMS. Erro: ' . $exception->getMessage());
        }
    }

    protected function setBind(&$query, $arrDataPost)
    {
        $query->bindParam('id_operadora', $arrDataPost['id_operadora'], \PDO::PARAM_INT);
        $query->bindParam('id_cliente', $arrDataPost['id_cliente'], \PDO::PARAM_INT);
        $query->bindParam('nu_ddd', $arrDataPost['nu_ddd'], \PDO::PARAM_INT);
        $query->bindParam('nu_telefone', $arrDataPost['nu_telefone'], \PDO::PARAM_INT);
        $query->bindParam('ds_mensagem', $arrDataPost['ds_mensagem'], \PDO::PARAM_STR);
        $query->bindParam('tp_situacao', $arrDataPost['tp_situacao'], \PDO::PARAM_INT);
        $query->bindParam('ds_destinatario', $arrDataPost['ds_destinatario'], \PDO::PARAM_STR);
    }
}