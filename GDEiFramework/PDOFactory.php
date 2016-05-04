<?php
namespace GDEiFramework;

class PDOFactory
{
    public static function getMysqlConnexion()
    {
        $dataBase = new \PDO('mysql:host=localhost;dbname=tuto_news', 'root', 'moselle57');
        $dataBase->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

        return $dataBase;
    }
}
