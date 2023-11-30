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
    <title>Crear</title>
    <script src="lib/tailwind.js"></script>
    <script src="lib/tailwind_config.js"></script>
</head>
<body>
    <?php require_once("navbar.php")?>
    <div class="flex flex-col h-screen" >

        <div>

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

            <script type="module">
                import { productsServices } from './products_services.js';
                const productsServiceInstance = new productsServices();

                document.getElementById('create').addEventListener('submit', function(event) {
                event.preventDefault();
                
                var fechaHoraActual = new Date();
                var horaActual = fechaHoraActual.toISOString().split('T')[1].split('.')[0];
                var fechaHoraString = fechaHoraActual.toISOString().split('T')[0] + ' ' + horaActual;

                const name = document.getElementById('name').value;
                const description = document.getElementById('description').value;
                const category = document.getElementById('category_filter').value;
                const quantity = document.getElementById('quantity').value;
                const create_date = fechaHoraString
                const modified_date = fechaHoraString
                // const etiqueta = '()';
                const formData = {
                    name: name,
                    description: description,
                    category: category,
                    quantity: quantity,
                    create_date: create_date,
                    modified_date: modified_date,
                };

                productsServiceInstance.createProducts(formData)
                .then(response => {
                console.log('Respuesta del servidor:', response);
                })
                .catch(error => {
                console.error('Error al enviar la solicitud:', error);
                });
            });
        </script>

        </div>
    </div>
</body>
</html>