<?php
class Conexion
{

    private $server = "localhost";
    private $database = "mocambo";
    private $port = 3306;
    private $charset = "utf8";
    private $user = "root";
    private $password = "";
    public  $pdo = null;
    private $atributos = [
        PDO::ATTR_CASE => PDO::CASE_LOWER,
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_ORACLE_NULLS => PDO::NULL_EMPTY_STRING,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
    ];

    function __construct()
    {
        $this->pdo = new PDO(
            "mysql:dbname={$this->database};
         host = {$this->server}; 
         port={$this->port};
         charset ={$this->charset}",
            $this->user,
            $this->password,
            $this->atributos
        );
    }
}
