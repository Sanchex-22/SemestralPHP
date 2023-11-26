<?php

    class Products{
        public $conn;
        public $id;
        public $name;
        public $description;
        public $quantity;
        public $cantidad;
        public $create_date;
        public $modified_date;

        public function __construct($db)
        {
            $this->conn = $db;
        }

        public function getAllProducts(){
            $sql = "Select * from Products";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt;
        }

        public function getOneProducts($id){
            $sql = "SELECT * FROM Products WHERE cod = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt;
        }

        public function createProducts($name, $description, $category, $quantity, $create_date, $modified_date){
            try{
                $sql = "INSERT INTO Products (name, description, category, quantity,create_date, modified_date) VALUES (:name, :description, :category, :quantity, :create_date, :modified_date)";
                
                $stmt = $this->conn->prepare($sql);
                
                $stmt->bindParam(':name', $name);
                $stmt->bindParam(':description', $description);
                $stmt->bindParam(':category', $category);
                $stmt->bindParam(':quantity', $quantity);
                $stmt->bindParam(':create_date', $create_date);
                $stmt->bindParam(':modified_date', $modified_date);

                $stmt->execute();
                
                http_response_code(201);
                echo json_encode(array("message" => "El producto se agregó correctamente"));
                
                return true;
            }
            catch(PDOException $e){
                http_response_code(503);
                echo json_encode(array("message" => "Error al agregar la tarea: " . $e->getMessage()));
                return false;
            }
        }

        public function editProducts($idd,$name, $description, $category, $quantity, $create_date, $modified_date){
            try{
                $check_query = "SELECT id FROM Products WHERE id = :id";
                $check_stmt = $this->conn->prepare($check_query);
                $check_stmt->bindParam(":id", $idd);
                $check_stmt->execute();

                if ($check_stmt->rowCount() > 0) {
                    $update_query = "UPDATE tareas SET 
                    name=:name, 
                    description=:description, 
                    category=:category, 
                    quantity=:quantity,
                    -- create_date=:create_date,
                    modified_date=:modified_date
                    WHERE id=:id";

                    $update_stmt = $this->conn->prepare($update_query);
                    $name = htmlspecialchars(strip_tags($name));
                    $description = htmlspecialchars(strip_tags($description));
                    $category = htmlspecialchars(strip_tags($category));
                    $quantity = htmlspecialchars(strip_tags($quantity));
                    $create_date = htmlspecialchars(strip_tags($create_date));
                    $modified_date = htmlspecialchars(strip_tags($modified_date));

                    $update_stmt->bindParam(':name', $name);
                    $update_stmt->bindParam(':description', $description);
                    $update_stmt->bindParam(':category', $category);
                    $update_stmt->bindParam(':quantity', $quantity);
                    $update_stmt->bindParam(':create_date', $create_date);
                    $update_stmt->bindParam(':modified_date', $modified_date);
    
                    if ($update_stmt->execute()) {
                        http_response_code(200);
                        echo json_encode(array("message" => "El producto se actualizó correctamente"));
                        return true;
                    } else {
                        http_response_code(503);
                        echo json_encode(array("message" => "Error al actualizar El producto"));
                        return false; 
                    }
                }
            }
            catch(PDOException $e){
                return false;
            }
        }

        public function deleteProducts($idd){
            try{
                $check_query = "SELECT id FROM Products WHERE id = :id";
                $check_stmt = $this->conn->prepare($check_query);
                $check_stmt->bindParam(":id", $idd);
                $check_stmt->execute();

                if ($check_stmt->rowCount() > 0) {
                    $delete_query = "DELETE FROM Products WHERE id = :id";
                    $delete_stmt = $this->conn->prepare($delete_query);
        
                    $id = htmlspecialchars(strip_tags($idd));
                    $delete_stmt->bindParam(":id", $id);

                    if ($delete_stmt->execute()) {
                        return true;
                    } else {
                        return false;
                    }
                } else {
                    http_response_code(404);
                    echo json_encode(array("message" => "El producto no existe"));
                    return false;
                }
            }
            catch(PDOException $e){
                return false;
            }
        }
    }
?>