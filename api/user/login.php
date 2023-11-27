<?php
class Login{
    private $db;
    private $users;

    public function __construct() {
        $this->initialize();
        $this->login();
    }

    public function initialize(){
        include_once('../../conexion/db_conexion.php');
        include_once('../../class/user_model.php'); 
        header("Access-Control-Allow-Origin:*");
        header("Content-Type:application/json;charset=UTF-8");
        header("Access-Control-Allow-Methods:POST");
        header("Access-Control-Max-Age:3600");
        header("Access-Control-Allow-Headers:Content-Type,Access-Control-Allow-Headers,Authorization,X-Requested-With");
        $conex = new ConexionDB();
        $this->db = $conex->getConexionDB();
        $this->users = new Users($this->db);
        session_start();
    }

    public function login(){
        $data = json_decode(file_get_contents("php://input"));
        if (!empty($data->user_name) && !empty($data->password)) {
            $user_name = $data->user_name;
            $password = $data->password;
            
            $result = $this->users->loginUsers(
                $user_name,
                $password
            );
        
            if ($result) {
                $_SESSION["user_name"] = $user_name;
                $hola=$this->getSessionInfo();
                http_response_code(201);
                echo json_encode(array("message" => "Bienvenido ".$_SESSION["user_name"]." has sido logueado"));
            } else {
                http_response_code(503);
                echo json_encode(array("message" => "No se puede loguear el usuario"));
            }
        } else {
            http_response_code(400);
            echo json_encode(array("message" => "No se puede loguear el usuario,porque los datos están incompletos"));
        }
    }

    public function getSessionInfo() {
        if (isset($_SESSION["user_name"])) {
            return $_SESSION["user_name"];
        } else {
            return null;
        }
    }

}
$Login = new Login();
$sessionInfo = $Login->getSessionInfo();
?>