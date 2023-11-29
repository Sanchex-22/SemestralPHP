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
    <script src="tailwind.js"></script>
    <script src="tailwind_config.js"></script>
</head>
<body>
  <div class="flex flex-col h-screen" >
  <nav class="w-full flex justify-between items-center p-2 bg-violet2 h-[60px]">
        <ul class="flex items-center">
            <li>
                <img src="img/logo.png" alt="logo" style="height: 40px; width: 40px;">
            </li>
        </ul>
        <ul class="flex text-center text-white h-full items-center">
            <li class="ml-5 hover:underline"><a href="dashboard.php">Productos</a></li>
            <li class="ml-5 hover:underline"><a href="#">Usuarios</a></li>
            <li class="hidden sm:block ml-5 hover:underline">Info</li>
            <div class="flex items-center ml-5 bg-white mr-5 rounded-r-lg">
                <li class="hidden sm:block btn-logout pl-2 text-black font-bold uppercase"><?php echo $_SESSION["user_name"]?></li>
                <form class="ml-2 " action="logout.php" method="post">
                    <button type="submit" value="Logout" class="btn-logout bg-red-500 rounded-lg pr-2 pl-2">Logout</button>
                </form>
            </div>
        </ul>
    </nav>
    <style>
      .scroll-container {
        max-height: 100vh;
        overflow-y: auto;
      }
    </style>
    <div class="scroll-container h-screen-full">
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
        <button class="bg-red-500 text-white rounded-lg p-2">Eliminar</button>
      </div>
      
    </div>
    <?php endforeach; ?>
    </div>
    
    <!-- <div class="fixed bottom-4 right-8 rounded-xl bg-violet2 w-[70px] h-[70px] text-white hover:bg-violet3 hover:text-white">
      <a href="create_user.php" class="flex justify-center items-center h-full w-full rounded-xl bg-violet2 opacity-75">
        <h1 class="text-3xl">+</h1>
      </a>
    </div> -->

  </div> 
</body>
</html>