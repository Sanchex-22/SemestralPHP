<?php

    class Users{
        public $conn;
        public $id;
        public $user_name;
        public $password;

        public function __construct($db){
            $this->conn = $db;
        }

        public function getAllUsers(){
            $sql = "Select * from User";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt;
        }

        public function getNumberUsers(){
            try {
                $sql = "CALL CountUsers()";
                $stmt = $this->conn->prepare($sql);
                $stmt->execute();
                
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                
                return $result['TotalUsers'];
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
        }

        public function getOneUsers($id){
            $sql = "SELECT * FROM User WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt;
        }

        public function loginUsers($user_name,$password){
            try{
                $query = "SELECT user_name, password FROM user WHERE user_name = :user_name";
                $stmt = $this->conn->prepare($query);
                $stmt->bindParam(":user_name", $user_name);
                $stmt->execute();
        
                if ($stmt->rowCount() > 0) {
                    $row = $stmt->fetch(PDO::FETCH_ASSOC);
                    $hashed_password = substr(hash('sha256', $password), 0, 19);
                    $c=password_verify($hashed_password, $row['password']);

                    if ($hashed_password == $row['password']) {
                        return true;
                    } else {
                        return false;
                    }
                } else {
                    return false;
                }
            }
            catch(PDOException $e){
                http_response_code(503);
                echo json_encode(array("message" => "Error al logearse: " . $e->getMessage()));
                return false;
            }
        }

        public function createUsers($user_name,$password){
            try{
                $check_query = "SELECT user_name FROM User WHERE user_name = :user_name";
                $check_stmt = $this->conn->prepare($check_query);
                $check_stmt->bindParam(":user_name", $user_name);
                $check_stmt->execute();

                if ($check_stmt->rowCount() > 0) {
                    http_response_code(404);
                    echo json_encode(array("message" => "Este usuario ya existe"));
                    return false;
                } else {
                    $hashed_password = substr(hash('sha256', $password), 0, 19);
                    $sql = "INSERT INTO User (user_name, password) VALUES (:user_name, :password)";
                    $stmt = $this->conn->prepare($sql);

                    $stmt->bindParam(":user_name", $user_name);
                    $stmt->bindParam(":password", $hashed_password);
    
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