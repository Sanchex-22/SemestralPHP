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
        <title>Inventario</title>
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
    <body class="bg-violet4 flex items-center justify-center h-screen p-5">
        <div class="font-bold text-black">
    
            <form id="loginForm" class="bg-white formulario flex flex-col justify-center items-center p-10" action="" method="post">
                <h2 class="text-center mb-6">Login</h2>
    
                <div class="mb-6 w-full">
                    <label for="username">Usuario</label>
                    <input class="w-full border border-violet2 p-2" type="text" id="username" name="username" required>
                </div>
    
                <div class="mb-6 w-full">
                    <label for="password">Contraseña</label>
                    <input class="w-full border border-violet2 p-2" type="password" id="password" name="password" required>
                </div>
    
                <div class="mb-6 w-full">
                    <input class="w-full p-2 rounded bg-violet1 text-white hover:bg-violet2 hover:text-black" type="submit" value="Iniciar Sesión">
                </div>
            </form>

            <script>
                document.getElementById('loginForm').addEventListener('submit', function(event) {
                    event.preventDefault();
        
                    const username = document.getElementById('username').value; 
                    const password = document.getElementById('password').value; 
                    console.log(username,password)
                    fetch('api/user/login.php', {
                        method: 'POST',
                        body: JSON.stringify({user_name:username,password:password})
                        })
                        .then(response => response.text())
                        .then(data => {
                            window.location.href = 'dashboard.php';
                        })
                        .catch(error => {
                            console.error('Error:', error);
                        });
                });
            </script>
    
        </div>
    </body>
</html>