<?php
session_start();
if (!isset($_SESSION["user_name"])) {
    header("Location: index.php");
    exit();
}
$username = $_SESSION["user_name"];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Información del Proyecto</title>
    <script src="lib/tailwind.js"></script>
    <script src="lib/tailwind_config.js"></script>
</head>
<body class="bg-gray-100">
<?php require_once('./components/navbar.php') ?>
<div class="bg-violet4 text-black p-4 text-center">
    <h1 class="text-3xl font-bold">Proyecto Semestral</h1>
    <p class="text-lg">Inventario basico con php</p>
</div>

<div class="container mx-auto mt-8 p-4 bg-white shadow-lg">

    <?php
    $fechaEntrega = "12/14/2023";
    $autor = "Carlos Sanchez";
    $cedula = "8-979-2162";
    $version = "v.0.09";

    echo "<p class='text-lg'><strong>Fecha de Entrega:</strong> $fechaEntrega</p>";
    echo "<p class='text-lg'><strong>Autor:</strong> $autor</p>";
    echo "<p class='text-lg'><strong>Version:</strong> $version</p>";

    ?>

</div>

</body>
</html>
