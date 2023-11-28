<?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $search = $_POST["search"];

        $data = ['id' => $search,];

            $api_url = "http://localhost/SemestralPHP/api/products/getSearch.php";
            $context = stream_context_create([
            'http' => [
              'method' => 'POST',
              'header' => 'Content-Type: application/json',
              'content' => json_encode($data),
            ],
            ]);
      
            $response = file_get_contents($api_url, false, $context);
            if ($response === FALSE) {
              die('Error al realizar la solicitud GET');
            }
            $json_response = json_decode($response, true);
            $productos = $json_response['product'];

            foreach ($productos as $producto):
                $get_name = $producto['name'];
                $get_description = $producto['description'];
                $get_category = $producto['category'];
                $get_quantity = $producto['quantity'];
                $get_create_date = $producto['create_date'];
                $get_modified_date = $producto['modified_date'];
            endforeach;
        }
?>