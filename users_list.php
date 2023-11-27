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
    <title>Users</title>
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
        <li class="ml-5"><a href="#">Usuarios</a></li>
        <li class="ml-5">Info</li>
        <li class="ml-5"><?php echo $_SESSION["user_name"]?></li>
        <form class="ml-5 mr-5" action="logout.php" method="post">
        <button type="submit" value="Logout" class="btn-logout">Logout</button>
      </form>
      </ul>
    </nav>
    
    <div class="flex justify-between align-center dark:text-gray-500 pr-5 pl-5 pt-2 pb-2">
        <div>
        <select
          id="category_filter"
          class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
        >
          <option value="null">Selecciona una Categoria</option>
          <option value="cocina">Sustituto</option>
          <option value="computo">Jefe</option>
          <option value="celulares">Gerente</option>
          <option value="">Otra</option>
        </select>
        </div>
        <div>
          <form name="formsearch" action="" class="flex text-gray-400 rounded-sm mr-5 bg-white p-1 justify-center border border-green-300">
              <input placeholder="search" 
                id="search" name="search" 
                type="search" defaultValue='search' 
                class="text-gray-400 rounded-sm" 
                value=''/>
              <button type="submit" value="search" class="bg-white w-full flex justify-center items-center" title="null">
              </button>
          </form>
        </div>
    </div>

    <?php
      $api_url = "http://localhost/SemestralPHP/api/user/getList.php";
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
      $productos = $json_response['users'];
            // echo '<pre>';
            // print_r($productos);
            // echo '</pre>';

    foreach ($productos as $producto):?>
    <div class="flex justify-between align-center dark:text-gray-500 hover:bg-gray-100 p-5">
      
      <div class="flex items-center">
        <div class="mr-2">
          <img class="w-10 h-10" src="" alt="" />
        </div>

        <div>
            <div><?php echo $producto['id']?></div>
            <div><?php echo $producto['user_name']?></div>
        </div>
      </div>

      <div>
        <button>Eliminar</button>
      </div>
      
    </div>
    <?php endforeach; ?>
    
    <div class="fixed bottom-4 right-4 rounded-xl bg-violet2 w-[70px] h-[70px] text-white hover:bg-violet3 hover:text-white">
      <a class="flex justify-center items-center h-full w-full rounded-sm bg-violet2 opacity-75">
        <h1 class="text-3xl">+</h1>
      </a>
    </div>
  </div> 
</body>
</html>