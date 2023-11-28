<?php
session_start();
if (!isset($_SESSION["user_name"])) {
    header("Location: index.php");
    exit();
}
$username = $_SESSION["user_name"];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
      tailwind.config = {
        theme: {
          extend: {
            colors: {
              violet1: '#B0578D',
              violet2: '#D988B9',
              violet3: '#FACBEA',
              violet4: '#FFE4D6',
            }
          }
        }
      }
    </script>
</head>
<body>
    <div class="flex flex-col h-screen" >
        <nav class="w-full flex justify-between align-center p-5 bg-violet2">
            <img src="#" alt="#">
            <ul class="flex">
                <li class="ml-5"><a href="dashboard.php">Productos</a></li>
                <li class="ml-5"><a href="users_list.php">Usuarios</a></li>
                <li class="ml-5">Info</li>
                <li class="ml-5"><?php echo $_SESSION["user_name"]?></li>
                <form class="ml-5 mr-5" action="logout.php" method="post">
                <button type="submit" value="Logout" class="btn-logout">Logout</button>
            </form>
            </ul>
        </nav>

        <div>
        <?php
            if (isset($_GET['id'])) { $product_id = $_GET['id']; }

            $data = [
                'id' => $product_id,
            ];

            $api_url = "http://localhost/SemestralPHP/api/products/getOne.php";
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
        ?>
        <form id="edit" class="bg-white formulario flex flex-col justify-center items-center p-10" action="" method="post">
                <h2 class="text-center bold mb-6">Editar (<?php echo $get_name ?>)</h2>
    
                <div class="mb-6 w-full">
                    <label for="name">Nombre</label>
                    <input class="w-full border border-violet2 p-2" type="text" id="name" name="name" value="<?php echo $get_name?>" required>
                </div>
    
                <div class="mb-6 w-full">
                    <label for="description">Descripcion</label>
                    <input class="w-full border border-violet2 p-2" type="description" id="description" name="description" required>
                </div>

                <div class="mb-6 w-full">
                    <select
                    id="category_filter"
                    name="category_filter"
                    class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    >
                    <option value="null">Selecciona una Categoria</option>
                    <option value="celular">Celular</option>
                    <option value="computo">Computadora</option>
                    <option value="linea blanca">Linea Blanca</option>
                    <option value="otros">Otra</option>
                    </select>
                </div>

                <div class="mb-6 w-full">
                    <label for="quantity">Cantidad</label>
                    <input class="w-full border border-violet2 p-2" type="number" id="quantity" name="quantity" required>
                </div>

                <!-- <div class="mb-6 w-full">
                    <label for="create_date">Fecha de creacion</label>
                    <input type="datetime-local" id="create_date" name="create_date" required class="inputs"><br>                
                </div> -->
    
                <div class="mb-6 w-full">
                    <input class="w-full p-2 rounded bg-violet1 text-white hover:bg-violet2 hover:text-black" type="submit" value="Añadir">
                </div>
            </form>
            <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $name = $_POST["name"];
                $description = $_POST["description"];
                $category = $_POST["category_filter"];
                $quantity = $_POST["quantity"];

                $fechaHoraActual = new DateTime();
                $fechaHoraString = $fechaHoraActual->format('Y-m-d H:i:s');
            

                $data = [
                    'id' => $product_id,
                    'name'=> $name,
                    'description' => $description,
                    'category' => $category,
                    'quantity' => $quantity,
                    'create_date'=>$get_create_date,
                    'modified_date'=>$fechaHoraString,
                ];
                
                $api_url = "http://localhost/SemestralPHP/api/products/edit.php";
                $context = stream_context_create([
                    'http' => [
                    'method' => 'POST',
                    'header' => 'Content-Type: application/json',
                    'content' => json_encode($data),
                    ],
                ]);

                $response = file_get_contents($api_url, false, $context);

                if ($response === FALSE) {
                    // Manejar el error de la solicitud
                    echo 'Error al realizar la solicitud POST';
                } else {
                    echo '<script>
                    setTimeout(function(){
                        window.location.href = "dashboard.php";
                    }, 3000);
                    </script>';
                }
            }
            ?>

        </div>
    </div>
</body>
</html>