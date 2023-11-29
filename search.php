<?php
    class Consultas{

        public function Buscar($search) {
            try{
            $data = ['search' => $search];
        
            $api_url = "http://localhost/SemestralPHP/api/products/getSearch.php";
            $context = stream_context_create([
                'http' => [
                    'method' => 'POST',
                    'header' => 'Content-Type: application/json',
                    'content' => json_encode($data),
                ],
            ]);
        
            $response =  @file_get_contents($api_url, false, $context);
        
            if ($response === FALSE) {
                echo 'No se encontro Ningun producto con ese nombre ';
                return $productos =null;
            } else {
                $json_response = json_decode($response, true);
        
                if (isset($json_response['products'])) {
                    $productos = $json_response['products'];
                    return $productos;
                } else {
                    echo 'Producto no encontrado.';
                    return $productos = null;
                }
            }
            } catch (Exception $e) {
                echo 'Producto no encontrado.';
                return $productos = null;
            }
        }
        

        public function TraerTodo(){
            $api_url = "http://localhost/SemestralPHP/api/products/getAll.php";
            $context = stream_context_create([
            'http' => [
                'method' => 'GET',
                'header' => 'Content-Type: application/json',
            ],
            ]);

            $response = file_get_contents($api_url, false, $context);
            if ($response === FALSE) {
                die('Error al realizar la solicitud GET');
            }
            $json_response = json_decode($response, true);
            $productos = $json_response['products'];
            return $productos;
        }
    }
?>