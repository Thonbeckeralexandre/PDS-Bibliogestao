<?php

class db
{

    public static $dbtype = "mysql";
    public static $host = "us-cdbr-east-06.cleardb.net";
    public static $port = "3306";
    public static $user = "be4d4168a0887b";
    public static $password = "e434c4d3";
    public static $db = "heroku_82d39de6f406fe5";
    public static $conn;

    public static function getInstance()
    {

        if (!isset(self::$conn)) {

            try {
                self::$conn = new PDO(self::$dbtype . ":host=" . self::$host . ";port=" . self::$port . ";charset=UTF8;dbname=" . self::$db, self::$user, self::$password, array(PDO::MYSQL_ATTR_INIT_COMMAND =>  "SET NAMES 'utf8mb4'"));
                self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                self::$conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
                self::$conn->setAttribute(PDO::ATTR_ORACLE_NULLS, PDO::NULL_EMPTY_STRING);
            } catch (PDOException $e) {
                echo $e->getMessage();
            }
        }

        return self::$conn;
    }

    public static function prepare($sql)
    {
        return self::getInstance()->prepare($sql);
    }

    public static function prepare_sql($sql)
    {
        return self::getInstance()->prepare($sql);
    }

    public static function begin()
    {
        return self::getInstance()->beginTransaction();
    }

    public static function commit()
    {
        return self::getInstance()->commit();
    }

    public static function rollBack()
    {
        return self::getInstance()->rollBack();
    }

    public static function lastInsertId()
    {
        return self::getInstance()->lastInsertId();
    }

    public static function rowCount()
    {
        return self::getInstance()->rowCount();
    }
}