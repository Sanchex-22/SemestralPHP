<?php
class ApiSearch{
    private $db;
    private $products;

    public function __construct() {
        $this->initialize();
        $this->getSearch();
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

    public function getSearch(){
        $data = json_decode(file_get_contents("php://input"));
        var_dump($data);
        if (isset($data->search)) {
            $id = $data->search;
    
            $stmt = $this->products->getSearchProducts($id);
            $num  = $stmt->rowCount();
    
            if ($num > 0) {
                $p_arr = array();
                $p_arr["products"] = array();
    
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
                    array_push($p_arr["products"], $item);
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
$ApiSearch = new ApiSearch();
?>