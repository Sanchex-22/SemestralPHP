<?php

    class Users{
        public $conn;
        public $id;
        public $user_name;
        public $password;

        public function __construct($db)
        {
            $this->conn = $db;
        }

        public function getAllUsers(){
            $sql = "Select * from Users";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt;
        }

        public function getOneUsers($id){
            $sql = "SELECT * FROM Users WHERE cod = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt;
        }

        public function createUsers($user_name,$password){
            try{
                $check_query = "SELECT user_name FROM Users WHERE User_Name = :User_Name";
                $check_stmt = $this->conn->prepare($check_query);
                $check_stmt->bindParam(":user_name", $user_name);
                $check_stmt->execute();

                if ($check_stmt->rowCount() > 0) {
                    http_response_code(404);
                    echo json_encode(array("message" => "Este usuario ya existe"));
                    return true;
                } else {
                    $sql = "INSERT INTO Users (user_name, password) VALUES (:user_name, :password)";
                
                    $stmt = $this->conn->prepare($sql);
                    
                    $stmt->bindParam(':user_name', $user_name);
                    $stmt->bindParam(':password', $password);
    
                    $stmt->execute();
                    
                    http_response_code(201);
                    echo json_encode(array("message" => "El El usuario fue creado se agregó correctamente"));
                    
                    return true;
                }
            }
            catch(PDOException $e){
                http_response_code(503);
                echo json_encode(array("message" => "Error al agregar el usuario: " . $e->getMessage()));
                return false;
            }
        }

        public function deleteUsers(){}

        public function editUsers(){}
    }
?>