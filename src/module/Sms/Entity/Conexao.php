<?php
/**
 * Created by PhpStorm.
 * User: ualison
 * Date: 17/08/16
 * Time: 23:40
 */

namespace Sms\Entity;

trait Conexao
{
    private static $conection;

    public function getConection()
    {
        if (!self::$conection) {
            //$pdoConnection = $this->getConnectionSqlite();
            $pdoConnection = $this->getConnectionPgSQL();
            $pdoConnection->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            self::$conection = $pdoConnection;
        }
        return self::$conection;
    }

    private function getConnectionPgSQL()
    {
        $pdoConnection = new \PDO("pgsql:dbname=poc_sms;host=127.0.0.1", 'postgres', 'abcd1234');
        return $pdoConnection;
    }

    private function getConnectionSqlite()
    {
        $strPath = dirname(__FILE__) . '/../../../../database/poc_sms.db';
        $pdoConnection = new \PDO('sqlite:' . $strPath);
        return $pdoConnection;
    }
}