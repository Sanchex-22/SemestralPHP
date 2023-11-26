<?php
class CreateApi{
    private $db;
    private $products;

    public function __construct() {
        $this->initialize();
        $this->create();
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

    public function create(){
        $data = json_decode(file_get_contents("php://input"));
        if (!empty($data->name) && !empty($data->description) && !empty($data->category) && !empty($data->quantity)  && !empty($data->create_date) && !empty($data->modified_date)) {
            $name = $data->name;
            $description = $data->description;
            $category = $data->category;
            $quantity = $data->quantity;
            $create_date = $data->create_date;
            $modified_date = $data->modified_date;
            
            $result = $this->products->createProducts(
                $name,
                $description,
                $category,
                $quantity,
                $create_date,
                $modified_date
            );
        
            // Verificar el resultado de la operación
            if ($result) {
                http_response_code(201);
                echo json_encode(array("message" => "El prodcuto ha sido creada"));
            } else {
                http_response_code(503);
                echo json_encode(array("message" => "No se puede crear El producto"));
            }
        } else {
            http_response_code(400);
            echo json_encode(array("message" => "No se puede crear el producto,porque los datos están incompletos"));
        }
    }

}
$CreateApi = new CreateApi();
?>