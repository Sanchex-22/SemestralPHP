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
            echo $product_Id
        ?>
        <form id="create" class="bg-white formulario flex flex-col justify-center items-center p-10" action="" method="post">
                <h2 class="text-center mb-6">Añadir Producto</h2>
    
                <div class="mb-6 w-full">
                    <label for="name">Nombre</label>
                    <input class="w-full border border-violet2 p-2" type="text" id="name" name="name" required>
                </div>
    
                <div class="mb-6 w-full">
                    <label for="description">Descripcion</label>
                    <input class="w-full border border-violet2 p-2" type="description" id="description" name="description" required>
                </div>

                <div class="mb-6 w-full">
                    <select
                    id="category_filter"
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
        </div>
    </div>
</body>
</html>