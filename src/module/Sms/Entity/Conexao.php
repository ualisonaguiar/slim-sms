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
            $strPath = dirname(__FILE__) . '/../../../../database/poc_sms.db';
            $pdoConnection = new \PDO('sqlite:' . $strPath);
            $pdoConnection->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            self::$conection = $pdoConnection;
        }
        return self::$conection;
    }
}