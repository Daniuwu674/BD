<?php include '../../includes/headers/header.php'; ?>
<?php include '../../includes/navs/nav1.php'; ?>

<style>
.container {
    max-width: 1200px;
    margin: 0 auto;
    margin-top: 35px;
    background-color: #e6e2de; 
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    font-family: 'Poppins', sans-serif;
}

h3 {
    color: #333;
    text-align: center;
    margin-bottom: 20px;
    font-size: 1.4rem;
    font-weight: bold;
}

h2 {
    color: #333; 
    text-align: center;
    margin-bottom: 20px;
    font-size: 1.6rem;
    font-weight: bold;
}

.column-layout {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
    justify-content: space-between;
}

.column {
    flex: 1;
    min-width: 300px;
    background-color: #fff; 
    padding: 15px;
    border: 1px solid #ccc;
    border-radius: 8px;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
}

label {
    display: block;
    margin-bottom: 8px;
    color: #555; 
    font-weight: bold;
}

input[type="date"], 
input[type="number"] {
    width: calc(100% - 20px);
    padding: 10px;
    border: 1px solid #ccc; 
    border-radius: 5px;
    font-size: 1rem;
    color: #333; 
    background-color: #fff; 
    outline: none;
    transition: border-color 0.3s;
}

/* Cambios al enfocar un campo */
input[type="date"]:focus, 
input[type="number"]:focus {
    border-color: #6c757d; 
}

.button {
    display: inline-block;
    padding: 10px 20px;
    background-color: #333; 
    color: #fff; 
    text-decoration: none;
    border-radius: 5px;
    font-size: 1rem;
    text-align: center;
    transition: background-color 0.3s, box-shadow 0.3s;
    cursor: pointer;
    border: none;
    width: 100%;
    margin-top: 20px;
    
}

.button:hover {
    background-color: #555; 
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.button2 {
    display: inline-block;
    padding: 10px 20px;
    background-color: #333; 
    color: #fff; 
    text-decoration: none;
    border-radius: 5px;
    font-size: 1rem;
    text-align: center;
    transition: background-color 0.3s, box-shadow 0.3s;
    cursor: pointer;
    border: none;
    width: 100%;
    margin-top: 20px;
    margin-bottom: 25px;
    
}

.button2:hover {
    background-color: #555; 
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.button1 {
    display: inline-block;
    padding: 10px 20px;
    background-color: #333; 
    color: #fff; 
    text-decoration: none;
    border-radius: 5px;
    font-size: 1rem;
    text-align: center;
    transition: background-color 0.3s, box-shadow 0.3s;
    cursor: pointer;
    border: none;
    width: 89%;
    margin-top: 10px;
}

.button1:hover {
    background-color: #555; 
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

</style>

<div class="container">
    <?php
        include '../../config.php';

        $sql_vendedores = "SELECT * FROM vendedor";
        $result_vendedores = $conn->query($sql_vendedores);
    ?>

    <h2>Gestión de Ventas y Consultas</h2>

    <div class="column-layout">
        <div class="column">
            <h3>Gestión de Ventas</h3>
            <a href="registrar_venta.php" class="button1">Registrar una venta</a>
        </div>

        <!-- Formulario para buscar cantidad de compras de empresa por fecha -->
        <div class="column">
            <h3>Buscar compras por fecha</h3>
            <form action="empresa_segun_fecha.php" method="get">
                <label for="fecha_venta">Fecha de venta:</label>
                <input type="date" id="fecha_venta" name="fecha_venta" required>
                <button type="submit" class="button">    Buscar  </button>
            </form>
        </div>

        <!-- Formulario para buscar vendedores por cantidad de ventas -->
        <div class="column">
            <h3>Buscar vendedores por ventas</h3>
            <form action="vendedores_segun_ventas.php" method="get">
                <label for="cantidad_ventas">Cantidad de compras:</label>
                <input type="number" id="cantidad_ventas" name="cantidad_ventas" min="0" required>
                <button type="submit" class="button2">Buscar</button>
            </form>
        </div>
    </div>
</div>
