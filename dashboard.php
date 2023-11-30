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
    <title>Dashboard</title>
    <script src="lib/tailwind.js"></script>
    <script src="lib/tailwind_config.js"></script>
    <script src="lib/grafics.js"></script>
    <!-- <script src="grafica.js"></script> -->
</head>
<body>
  <style>
      .scroll-container {
        max-height: 100vh;
        overflow-y: auto;
      }
      .arc text {
        font: 10px sans-serif;
        text-anchor: middle;
      }

      .arc path {
        stroke: #fff;
      }
      .scroll-container {
          max-height: calc(100vh - 135px);
          overflow-y: auto;
          margin-bottom: 20px;
      }

  </style>
  <?php require_once("navbar.php")?>
  <div class="flex flex-col p-2">

    <script type="module">
            import { Graficas } from './graficas.js';
            const graficasI = new Graficas(); 
            graficasI.xCategoria();
            graficasI.xNombre();
    </script>
    
    <div><h1 class="text-2xl font-bold">Bienvenido <?php echo  $_SESSION["user_name"];?></h1></div>

    <div class="col md:flex justify-between">

      <!-- BOX1 -->
      <div class="w-full flex flex-col shadow-xl shadow-violet2 text-center pt-2">
        <div class="">
          <h2 class="pb-2">Productos en Stock</h2>
          <div id="miGrafica" class="flex justify-center items-center pt-5 pr-2 pl-2"></div>
        </div>
        <div>
          <h2 class="pt-2 pb-2">Productos por Categoria</h2>
          <div id="miGraficaPastel" class="flex justify-center items-center pt-5 pb-5"></div>
        </div>
      </div>

      <!-- BOX2 -->
      <div class="w-full flex flex-col shadow-xl shadow-violet2 text-center pt-2">
        <div class="flex flex-col justify-center items-center">
          <div><h2 class="pb-2">Calendario</h2></div>
          <div class="w-full md:w-[500px]">
            <?php require_once('calendar.php')?>
          </div>
        </div>
      </div>

  <!-- </div>
    
    <div class="fixed bottom-4 right-8 rounded-xl bg-violet2 w-[70px] h-[70px] text-white hover:bg-violet3 hover:text-white">
      <a href="create_product.php?id=<?php echo $producto['id']; ?>" class="flex justify-center items-center h-full w-full rounded-xl bg-violet2 opacity-75">
        <h1 class="text-3xl">+</h1>
      </a>
    </div>

  </div>  -->
</body>
</html>