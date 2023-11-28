<?php
class ApiGetOne{
    private $db;
    private $products;

    public function __construct() {
        $this->initialize();
        $this->getOne();
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

    public function getOne(){
        $data = json_decode(file_get_contents("php://input"));
    
        if (isset($data->id) && !empty($data->id)) {
            $id = $data->id;
    
            $stmt = $this->products->getOneProducts($id);
            $num  = $stmt->rowCount();
    
            if ($num > 0) {
                $p_arr = array();
                $p_arr["product"] = array();
    
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    extract($row);
                    $item = array(
                        "id" => $id,
                        "name" => $name,
                        "description" => $description,
                        "category" => $category,
                        "quantity" => $quantity,
                        "create_date" => $create_date,
                        "modified_date" => $modified_date,
                    );
                    array_push($p_arr["product"], $item);
                }
                http_response_code(200);
                echo json_encode($p_arr);
            } else {
                http_response_code(404);
                echo json_encode(array("message" => "No se encontró este producto."));
            }
        } else {
            http_response_code(400);
            echo json_encode(array("message" => "No se puede obtener el producto, faltan datos"));
        }
    }
    

}
$ApiGetOne = new ApiGetOne();
?>