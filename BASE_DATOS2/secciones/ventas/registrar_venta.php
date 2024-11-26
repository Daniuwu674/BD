<?php include '../../includes/headers/header.php'; ?>
<?php include '../../includes/navs/nav1.php'; ?>

<?php
include '../../config.php'; 

$mensaje = ""; 

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $descripcion = $_POST['descripcion'];
    $fecha_venta = $_POST['fecha_venta'];
    $ID_empresa = $_POST['ID_empresa'];
    $DNI_vendedor = $_POST['DNI_vendedor'];

    try {

        $sql = "CALL registrar_venta_cobre(?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);

        $stmt->bind_param('ssii', $descripcion, $fecha_venta, $ID_empresa, $DNI_vendedor);

        $stmt->execute();

        $mensaje = "La venta ha sido registrada exitosamente.";
    } catch (mysqli_sql_exception $e) {
        $mensaje = "Error al registrar la venta: " . $e->getMessage();
    }
}
?>

<div class="container">
    <h2 class="form-title">
    <?php echo "Registrar una Venta"; ?>
    </h2>

    <form action="registrar_venta.php" method="post" class="styled-form">
        <div class="form-group">
            <label for="descripcion">Descripción:</label>
            <input type="text" name="descripcion" value="<?php echo isset($descripcion) ? $descripcion : ''; ?>" required>
        </div>

        <div class="form-group">
            <label for="fecha_venta">Fecha de Venta:</label>
            <input type="date" name="fecha_venta" value="<?php echo isset($fecha_venta) ? $fecha_venta : ''; ?>" required>
        </div>

        <div class="form-group">
            <label for="ID_empresa">ID de la Empresa:</label>
            <input type="number" name="ID_empresa" value="<?php echo isset($ID_empresa) ? $ID_empresa : ''; ?>" required>
        </div>

        <div class="form-group">
            <label for="DNI_vendedor">DNI del Vendedor:</label>
            <input type="number" name="DNI_vendedor" value="<?php echo isset($DNI_vendedor) ? $DNI_vendedor : ''; ?>" required>
        </div>

        <div class="form-group">
            <input type="submit" value="Registrar Venta" class="submit-button">
        </div>
    </form>

    <?php if (!empty($mensaje)): ?>
        <div class="error-message" style="color: red; font-weight: bold; margin-top: 20px;">
            <?php echo $mensaje; ?>
        </div>
    <?php endif; ?>

    <div style="margin-top: 20px;">
        <a href="venta.php" class="back-button">Regresar a Ventas</a>
    </div>
</div>

<style>
.container {
    max-width: 600px;
    margin: 0 auto;
    background-color: #e6e2de; 
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    font-family: 'Poppins', sans-serif;
}

.form-title {
    text-align: center;
    color: #333; 
    margin-bottom: 20px;
    font-size: 1.8rem;
    font-weight: bold;
}

.styled-form .form-group {
    margin-bottom: 15px;
}

.styled-form label {
    display: block;
    margin-bottom: 5px;
    color: #555;
    font-weight: bold;
}

.styled-form input[type="text"],
.styled-form input[type="date"],
.styled-form input[type="number"] {
    width: 96.5%;
    padding: 10px;
    border: 1px solid #ccc; 
    border-radius: 5px;
    font-size: 1rem;
    color: #333; 
    outline: none;
    background-color: #fff; 
    transition: border-color 0.3s;
}

.styled-form input[type="text"]:focus,
.styled-form input[type="date"]:focus,
.styled-form input[type="number"]:focus {
    border-color: #6c757d; 
}

.submit-button {
    width: 100%;
    padding: 12px;
    background-color: #333; 
    color: #fff; 
    border: none;
    border-radius: 5px;
    font-size: 1rem;
    cursor: pointer;
    transition: background-color 0.3s;
}

.submit-button:hover {
    background-color: #555; 
}

.back-button {
    display: inline-block;
    padding: 10px 15px;
    background-color: #a8978b; 
    color: #fff; 
    text-decoration: none;
    border-radius: 5px;
    text-align: center;
    font-size: 1rem;
    transition: background-color 0.3s;
}

.back-button:hover {
    background-color: #555; 
}
</style>