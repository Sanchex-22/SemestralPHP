<?php
class ApiGetList{
    private $db;
    private $users;

    public function __construct() {
        $this->initialize();
        $this->getAll();
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

    public function getAll(){
        $stmt = $this->users->getAllUsers();
        $num  = $stmt->rowCount();

        if ($num > 0) {
            $p_arr = array();
            $p_arr["users"] = array();
        
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                extract($row);
                $item = array(
                    "id" => $id,
                    "user_name" => $user_name,
                );
                array_push($p_arr["users"], $item);
            }
            http_response_code(200);
            echo json_encode($p_arr);
        } else {
            http_response_code(404);
            echo json_encode(array("message" => "No se encontraron usuarios."));
        }
    }

}
$ApiGetList = new ApiGetList();
?>