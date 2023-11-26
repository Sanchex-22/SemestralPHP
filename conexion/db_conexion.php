<?php
require_once('db_credentials.php');
class ConexionDB
{
    private $host = DB_HOST;
    private $name = DB_NAME;
    private $user = DB_USER;
    private $pass = DB_PASS;
    private $port = DB_PORT;
    public  $conn;
    public function getConexionDB()
    {
        $this->conn = null;
        try {
            $this->conn =
                new PDO('mysql:host=' . $this->host . ';port=' . $this->port . ';dbname=' . $this->name, $this->user, $this->pass);
            $this->conn->exec("set names utf8");
        } catch (PDOException $e) {
            echo "Error en conectar la base de datos";
        }
        return $this->conn;
    }
}