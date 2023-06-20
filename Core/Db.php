<?php

namespace App\Core;
use PDO;
use PDOException;

Class Db extends \PDO
{
    // Instance unique de la classe
    private static $instance;

    // Constante de connexion à la BDD
    private const DBHOST = "127.0.0.1";
    private const DBNAME = "intro_bulma";
    private const DBUSER = "root";
    private const DBPASS = "";


    public function __construct()
    {
        try
        {
            // Connexion à la base de donnée
            $dsn = "mysql:host=".self::DBHOST.";dbname=".self::DBNAME;
            parent::__construct($dsn, self::DBUSER, self::DBPASS);

            // Paramètre les infos que l'on transmet et reçoit de la BDD
            $this->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, "SET NAMES utf8");
            $this->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
            $this->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }

        catch (PDOException $e)
        {
            die("Connexion à la bdd impossible -> ".$e->getMessage());
        }
    }

    public static function getInstance()
    {
        if (self::$instance === null)
        {
            self::$instance = new self();
        }
        return self::$instance;
    }
}