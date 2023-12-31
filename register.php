<?php
    session_start();
    if (isset($_SESSION["user_name"])) {
        header("Location: dashboard.php");
        exit();
    }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Registrar usuario</title>
        <script src="lib/tailwind.js"></script>
        <script src="lib/tailwind_config.js"></script>
    </head>
    <body class="bg-violet4 flex items-center justify-center h-screen p-5">
        <div class="font-bold text-black">
    
            <form id="registerForm" class="bg-white formulario flex flex-col justify-center items-center p-10" action="" method="post">
                <h2 class="text-center mb-6">Resgitra un usuario</h2>

                <div class="mb-6 w-full flex justify-center items-center">
                    <img src="./img/logo.png" alt="" class="w-[50px] h-[50px]">
                </div>
    
                <div class="mb-6 w-full">
                    <label for="username">Ingresa un nombre de usuario</label>
                    <input class="w-full border border-violet2 p-2" type="text" id="username" name="username" required>
                </div>
    
                <div class="mb-6 w-full">
                    <label for="password">ingresa una contraseña</label>
                    <input class="w-full border border-violet2 p-2" type="password" id="password" name="password" required>
                </div>
    
                <div class="mb-6 w-full">
                    <input class="w-full p-2 rounded bg-violet1 text-white hover:bg-violet2 hover:text-black" type="submit" value="Crear Cuenta">
                </div>

                <div class="mb-6 w-full">
                   Quieres volver al login? <a href="index.php" class="text-blue-500">ir al login</a>
                </div>
            </form>

            <script>
                document.getElementById('registerForm').addEventListener('submit', function(event) {
                    event.preventDefault();
        
                    const username = document.getElementById('username').value; 
                    const password = document.getElementById('password').value; 
                    console.log(username,password)
                    fetch('http://localhost/SemestralPHP/api/user/register.php', {
                        method: 'POST',
                        body: JSON.stringify({user_name:username,password:password})
                        })
                        .then(response => response.text())
                        .then(data => {
                            alert('Cuenta creada')
                            window.location.href = 'index.php';
                        })
                        .catch(error => {
                            console.error('Error:', error);
                        });
                });
            </script>
    
        </div>
    </body>
</html>