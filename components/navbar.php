
<nav class="flex justify-between items-center p-4 bg-gradient-to-r from-violet1 via-violet2 to-violet1 h-16">
<div class="flex items-center">
    <img src="img/logo.png" alt="logo" class="h-8 w-8 mr-2">
    <span class="text-white text-xl font-semibold">Inventario</span>
</div>

<!-- Menú para dispositivos móviles -->
<div class="md:hidden">
    <button id="mobile-menu-btn" class="text-white focus:outline-none">
        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
        </svg>
    </button>
</div>

<!-- Menú para pantallas medianas y grandes -->
<div class="hidden md:flex items-center space-x-4">
    <form name="formsearch" action="" class="flex items-center text-gray-400 bg-white rounded-sm border border-green-300">
        <input placeholder="Buscar" id="search" name="search" type="search" class="text-gray-400 rounded-sm p-1" value=''>
        <button type="submit" value="search" class="bg-white p-1">
            <img src="./img/lupa.png" class="h-4 w-4">
        </button>
    </form>
    <a href="dashboard.php" class="text-white hover:underline">Dashboard</a>
    <a href="products.php" class="text-white hover:underline">Productos</a>
    <a href="users_list.php" class="text-white hover:underline">Usuarios</a>
    <a href="#" class="hidden sm:inline text-white hover:underline">Info</a>

    <div class="flex items-center ml-4 bg-white rounded-full p-2">
        <span class="hidden sm:inline text-black font-bold uppercase"><?php echo $_SESSION["user_name"]?></span>
        <form class="ml-2" action="logout.php" method="post">
            <button type="submit" value="Logout" class="btn-logout bg-red-500 rounded-full p-1">
                Logout
            </button>
        </form>
    </div>
</div>
</nav>
<!-- Menú desplegable para dispositivos móviles -->
<div id="mobile-menu" class="md:hidden fixed inset-0 bg-gray-900 bg-opacity-75 z-50 hidden">
    <div class="flex justify-end p-4">
        <button id="close-mobile-menu" class="text-white focus:outline-none">
            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
    </div>
    <div class="flex flex-col items-center">
        <a href="#" class="text-white hover:underline py-2">Productos</a>
        <a href="users_list.php" class="text-white hover:underline py-2">Usuarios</a>
        <a href="#" class="text-white hover:underline py-2">Info</a>
        <!-- Agrega más enlaces según sea necesario -->
    </div>
</div>

<script>
    // JavaScript para mostrar/ocultar el menú desplegable móvil
    document.getElementById('mobile-menu-btn').addEventListener('click', function () {
        document.getElementById('mobile-menu').classList.toggle('hidden');
    });

    // JavaScript para cerrar el menú desplegable móvil al hacer clic en el botón de cierre
    document.getElementById('close-mobile-menu').addEventListener('click', function () {
        document.getElementById('mobile-menu').classList.add('hidden');
    });
</script>
