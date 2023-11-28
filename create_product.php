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
    </div>
</body>
</html>