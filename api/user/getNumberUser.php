<?php
class ApiGetNumberU{
    private $db;
    private $users;

    public function __construct() {
        $this->initialize();
        $this->getNumberU();
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

    public function getNumberU() {
        $numberUsers = $this->users->getNumberUsers();
    
        if ($numberUsers > 0) {
            $response = array("number_u" => $numberUsers);
            http_response_code(200);
            echo json_encode($response);
        } else {
            http_response_code(404);
            echo json_encode(array("message" => "No se encontraron usuarios."));
        }
    }    

}
$ApiGetNumberU = new ApiGetNumberU();
?>