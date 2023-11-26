<?php
class ApiDelete{
    private $db;
    private $products;

    public function __construct() {
        $this->initialize();
        $this->delete();
    }

    public function initialize(){
        include_once('../../conexion/db_conexion.php');
        include_once('../../class/products_model.php'); 
        header("Access-Control-Allow-Origin:*");
        header("Content-Type:application/json;charset=UTF-8");
        header("Access-Control-Allow-Methods:POST");
        header("Access-Control-Max-Age:3600");
        header("Access-Control-Allow-Headers:Content-Type,Access-Control-Allow-Headers,Authorization,X-Requested-With");
        $conex = new ConexionDB();
        $this->db = $conex->getConexionDB();
        $this->products = new Products($this->db);
    }

    public function delete(){
        $data = json_decode(file_get_contents("php://input"));
        if(!empty($data->id)){
            $id = $data->id;
    
            if($this->products->deleteProducts($id)){
                http_response_code(201);
                echo json_encode(array("message"=>"El producto ha sido eliminado"));
            }
            else{
                http_response_code(503);
                echo json_encode(array("message"=>"Error al eliminar el producto"));
            }
        }else{
            http_response_code(400);
            echo json_encode(array("message"=>"No se puede eliminar el producto, faltan datos"));
        }
    }

}
$ApiDelete = new ApiDelete();
?>