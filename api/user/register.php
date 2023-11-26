<?php
class Register{
    private $db;
    private $users;

    public function __construct() {
        $this->initialize();
        $this->register();
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
    }

    public function register(){
        $data = json_decode(file_get_contents("php://input"));
        if (!empty($data->user_name) && !empty($data->password)) {
            $user_name = $data->user_name;
            $password = $data->password;
            
            $result = $this->users->createUsers(
                $user_name,
                $password
            );
        
            // Verificar el resultado de la operación
            if ($result) {
                http_response_code(201);
                echo json_encode(array("message" => "El usuario ha sido creado"));
            } else {
                http_response_code(503);
                echo json_encode(array("message" => "No se puede crear el usuario"));
            }
        } else {
            http_response_code(400);
            echo json_encode(array("message" => "No se puede crear elusuario,porque los datos están incompletos"));
        }
    }

}
$Register = new Register();
?>