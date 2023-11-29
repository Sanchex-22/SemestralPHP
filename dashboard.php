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
    <script src="tailwind.js"></script>
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
  <nav class="w-full flex justify-between items-center p-2 bg-violet2 h-[60px]">
        <ul class="flex items-center">
            <li>
                <img src="img/logo.png" alt="logo" style="height: 40px; width: 40px;">
            </li>
        </ul>
        <ul class="flex text-center text-white h-full items-center">
            <li class="ml-5 hover:underline"><a href="#">Productos</a></li>
            <li class="ml-5 hover:underline"><a href="users_list.php">Usuarios</a></li>
            <li class="hidden sm:block ml-5 hover:underline">Info</li>
            <div class="flex items-center ml-5 bg-white mr-5 rounded-r-lg">
                <li class="hidden sm:block btn-logout pl-2 text-black font-bold uppercase"><?php echo $_SESSION["user_name"]?></li>
                <form class="ml-2 " action="logout.php" method="post">
                    <button type="submit" value="Logout" class="btn-logout bg-red-500 rounded-lg pr-2 pl-2">Logout</button>
                </form>
            </div>
        </ul>
    </nav>
    
    <div class="flex flex-wrap justify-between align-center dark:text-gray-500 pr-5 pl-5 pt-2 pb-2">
        <div class="flex justify-center align-center">
        <form name="categoryform" action="" method="GET" class="flex text-gray-400 rounded-sm mr-5 bg-white p-1 justify-center border border-green-300">
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
          <button type="submit" name="submit_category" class="bg-white w-full flex justify-center items-center" title="Enviar">Enviar</button>
      </form>
        </div>
        <div class="flex justify-center align-center">
          <form name="formsearch" action="" class="flex text-gray-400 rounded-sm mr-5 bg-white p-1 justify-center border border-green-300">
              <input placeholder="search" 
                id="search" name="search" 
                type="search" defaultValue='search' 
                class="text-gray-400 rounded-sm" 
                value=''/>
              <button type="submit" value="search" class="bg-white w-full flex justify-center items-center" title="Enviar">
              </button>
          </form>
        </div>
    </div>
    <style>
      .scroll-container {
        max-height: 100vh;
        overflow-y: auto;
      }
    </style>
    <div class="scroll-container h-screen-full">
    <?php
    require_once("search.php");
    $consultas = new Consultas();
    if (isset($_GET['search'])) {
        // print("buscaste",$_GET['search']);
        $terminoBusqueda = $_GET['search'];
        $productos = $consultas->Buscar($terminoBusqueda);
    }
    elseif (isset($_GET['submit_category'])) {
      // Se envió el formulario de la categoría
      $terminoBusqueda = $_GET['category_filter'];
      $productos = $consultas->Buscar($terminoBusqueda);
    }  
    else {
      $productos = $consultas->TraerTodo();
    }
    if ($productos !== null) {
    foreach ($productos as $producto):
      $formId = "eliminate_" . $producto['id']; 
      $inputId = "id_" . $producto['id'];?>

    
      <div class="flex justify-between align-center dark:text-gray-500 hover:bg-gray-100 p-5">
        
        <div class="flex items-center">
          <div class="mr-2">
            <img class="w-10 h-10" src="" alt="" />
          </div>

          <div>
            <div class="text-black"><?php echo $producto['name']?></div>
            <div><?php echo $producto['description']?></div>
            <div>categoria (<?php echo $producto['category']?>)</div>
            <div>quedan: <?php echo $producto['quantity']?></div>
          </div>
        </div>

        <div class="flex flex-col">
          <h5>creado el <?php echo $producto['create_date']?></h5>
          <h5>modificado el <?php echo $producto['modified_date']?></h5>
          <!-- <button class="bg-red-500 text-white rounded-lg p-2">Eliminar</button> -->
          <div class="flex m-2 text-center">
            <form id="<?php echo $formId; ?>" class="bg-red-500 text-white rounded-lg p-2 w-[100px] m-2">
              <input hidden id="<?php echo $inputId; ?>" value="<?php echo $producto['id']; ?>">
              <button type="submit" class="btn-eliminar">Eliminar</button>
            </form>
            <a href="edit_product.php?id=<?php echo $producto['id']; ?>" class="bg-gray-500 text-white rounded-lg p-2  m-2">Editar</a>
          </div>
        </div>
        
      </div>
    
    <?php endforeach;}else{echo ":(";}?>
    </div>
    <script type="module">
      import { productsServices } from './products_services.js';
      const productsServiceInstance = new productsServices(); 
      document.addEventListener('DOMContentLoaded', function() {  
          <?php foreach ($productos as $producto): ?>
          const eliminateForm_<?php echo $producto['id']; ?> = document.getElementById('eliminate_<?php echo $producto['id']; ?>');
          if (eliminateForm_<?php echo $producto['id']; ?>) {
              eliminateForm_<?php echo $producto['id']; ?>.addEventListener('submit', function(event) {
                  event.preventDefault();
                  const id = document.getElementById('id_<?php echo $producto['id']; ?>').value;
                  const formData = {
                      id: id,
                  };
                  console.log(formData)
                  productsServiceInstance.deleteProducts(formData);
              });
          } else {
              console.error("Elemento 'eliminate_<?php echo $producto['id']; ?>' no encontrado");
          }
          <?php endforeach; ?>
      });
  </script>

    
    <div class="fixed bottom-4 right-8 rounded-xl bg-violet2 w-[70px] h-[70px] text-white hover:bg-violet3 hover:text-white">
      <a href="create_product.php?id=<?php echo $producto['id']; ?>" class="flex justify-center items-center h-full w-full rounded-xl bg-violet2 opacity-75">
        <h1 class="text-3xl">+</h1>
      </a>
    </div>

  </div> 
</body>
</html>