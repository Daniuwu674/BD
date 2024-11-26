<?php include '../../includes/headers/header.php'; ?>
<?php include '../../includes/navs/nav1.php'; ?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Mecánicos</title>
    <style>

        <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Mecánicos</title>
    <style>

    body {
        background-color: #f5f1ec;
        font-family: Arial, sans-serif;
        color: #4e4e4e;
        margin: 0;
        padding: 0;
    }

    .container-wrapper {
        background-color: #ffffff;
        padding: 20px;
        border-radius: 10px;
        max-width: 1200px;
        margin: 20px auto;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }


    .container {
        display: flex;
        flex-wrap: wrap; 
        justify-content: center; 
        gap: 20px; 
        margin: 0 auto; 
        padding: 20px;
    }

    .section {
        flex: 1;
        min-width: 300px; 
        max-width: 400px; 
        padding: 20px;
        border-radius: 10px;
        box-sizing: border-box;
        background-color: #e6e2de;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        text-align: center; 
    }

    .section h2, .section h3 {
        text-align: center;
        color: #423e3a;
        font-weight: bold;
    }

    .form-container {
        margin: 15px 0;
        text-align: center;
        display: flex;
        flex-direction: column;
        align-items: center; 
        gap: 15px; 
    }

    .form-container input[type="number"],
    .form-container input[type="date"],
    .form-container button {
        padding: 10px;
        font-size: 14px;
        border-radius: 5px;
        border: 1px solid #ccc;
        width: 100%; 
        max-width: 300px; 
    }

    .form-container button {
        background-color: #5a5552;
        color: white;
        border: none;
        cursor: pointer;
        margin-top : 20px;
        transition: background-color 0.3s;
    }

    .form-container button:hover {
        background-color: #3b3837;
    }

    table {
        width: flex;
        border-collapse: collapse;
        margin: 2x 0;

        font-size: 14px;
    }
        .left-section table {
        margin: 0 auto; 
        width: 90%; 
    }

    th, td {
        padding: 10px;
        text-align: center;
        border: 1px solid #bdb4ab;
    }

    th {
        background-color: #878079;
        color: white;
    }

    tr:nth-child(even) {
        background-color: #f5f2ec;
    }

    tr:nth-child(odd) {
        background-color: #eae0d7;
    }

    .message {
        padding: 15px;
        margin-top: 20px;
        border-radius: 5px;
        font-size: 16px;
        font-weight: bold;
        text-align: center;
    }

    .message.error {
        background-color: #f7dada;
        color: #a94442;
        border: 1px solid #f5c6cb;
    }

    .message.success {
        background-color: #d4edda;
        color: #155724;
        border: 1px solid #c3e6cb;
    }

    .message.info {
        background-color: #d1ecf1;
        color: #0c5460;
        border: 1px solid #bee5eb;
    }
</style>

</head>


    </style>
</head>
</html>

<div class="container">
    <!-- Sección Máquinas en Reparación por Mecánico -->
    <div class="section left-section">
        <h2>Máquinas en Reparación por Mecánico</h2>

        <div class="form-container">
            <form action="" method="GET">
                <label for="dni_mecanico">DNI del Mecánico:</label>
                <input type="number" id="dni_mecanico" name="dni_mecanico" required min="1">
                <button type="submit">Buscar Máquinas</button>


            </form> 
        </div>

        <?php
        if (isset($_GET['dni_mecanico'])) {
            require_once '../../config.php';

            $dni = filter_var($_GET['dni_mecanico'], FILTER_SANITIZE_NUMBER_INT);

            try {
                $stmt = $conn->prepare("CALL mecanico_repara_maquinas(?)");
                $stmt->bind_param("i", $dni);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    echo "<table>
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Apellido Paterno</th>
                                    <th>Apellido Materno</th>
                                    <th>ID Máquina</th>
                                    <th>ID Chanca</th>
                                </tr>
                            </thead>
                            <tbody>";

                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>" . htmlspecialchars($row['nombres']) . "</td>
                                <td>" . htmlspecialchars($row['Prim_apellido']) . "</td>
                                <td>" . htmlspecialchars($row['Seg_apellido']) . "</td>
                                <td>" . htmlspecialchars($row['ID_maquina']) . "</td>
                                <td>" . htmlspecialchars($row['ID_chancadora']) . "</td>
                              </tr>";
                    }

                    echo "</tbody></table>";
                } else {
                    echo "<p class='message error'>No se encontraron máquinas para este mecánico.</p>";
                }
                $stmt->close();
            } catch (Exception $e) {
                echo "<p>Error: " . htmlspecialchars($e->getMessage()) . "</p>";
            }
            $conn->close();
        }
        ?>
    </div>
        
    <!-- Sección Proveedores por Mecánico -->
    <div class="section right-section">
        <h2>Proveedores por Mecánico</h2>

        <div class="form-container">
            <form action="" method="GET">
                <label for="DNI_mecanico">DNI del Mecánico:</label>
                <input type="number" id="DNI_mecanico" name="DNI_mecanico" required>
                <button type="submit">Buscar Proveedores</button>
            </form>
        </div>

        <?php
        if (isset($_GET['DNI_mecanico'])) {
            require_once '../../config.php';

            $DNI_mecanico = filter_var($_GET['DNI_mecanico'], FILTER_SANITIZE_NUMBER_INT);

            try {
                $stmt = $conn->prepare("CALL contar_proveedores_por_mecanico(?)");
                $stmt->bind_param("i", $DNI_mecanico);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    echo "<table>
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Apellido Paterno</th>
                                    <th>Apellido Materno</th>
                                    <th>Total Proveedores</th>
                                </tr>
                            </thead>
                            <tbody>";

                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>" . htmlspecialchars($row['nombres']) . "</td>
                                <td>" . htmlspecialchars($row['Prim_apellido']) . "</td>
                                <td>" . htmlspecialchars($row['Seg_apellido']) . "</td>
                                <td>" . htmlspecialchars($row['total_proveedores']) . "</td>
                              </tr>";
                    }

                    echo "</tbody></table>";
                } else {
                    echo "<p class='message error'>No se encontraron proveedores para este mecánico.</p>";
                }
                $stmt->close();
            } catch (Exception $e) {
                echo "<p>Error: " . htmlspecialchars($e->getMessage()) . "</p>";
            }
            $conn->close();
        }
        ?>

        
    </div>

    <div class="section new-section">
        <h2>Obtener Artículos</h2>

        <div class="form-container">
            <form action="" method="GET">
                <label for="cantidad_minima">Cantidad Mínima:</label>
                <input type="number" id="cantidad_minima" name="cantidad_minima" required min="0">

                <label for="fecha_consulta">Fecha de Consulta:</label>
                <input type="date" id="fecha_consulta" name="fecha_consulta" required>

                <button type="submit">Obtener Artículos</button>


            </form>
        </div>

        <?php
        if (isset($_GET['cantidad_minima']) && isset($_GET['fecha_consulta'])) {
            require_once '../../config.php';

            $cantidad_minima = filter_var($_GET['cantidad_minima'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
            $fecha_consulta = filter_var($_GET['fecha_consulta'], FILTER_SANITIZE_STRING);

            try {
                $stmt = $conn->prepare("CALL Obtener_Repuestos_Costo_Fecha(?, ?)");
                $stmt->bind_param("ds", $cantidad_minima, $fecha_consulta);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    echo "<table>
                            <thead>
                                <tr>
                                    <th>Nombre Repuesto</th>
                                    <th>Costo</th>
                                    <th>Nombre Mecánico</th>
                                    <th>Apellido Mecánico</th>
                                </tr>
                            </thead>
                            <tbody>";

                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>" . htmlspecialchars($row['nombre_repuesto']) . "</td>
                                <td>" . htmlspecialchars($row['costo']) . "</td>
                                <td>" . htmlspecialchars($row['nombre_mecanico']) . "</td>
                                <td>" . htmlspecialchars($row['apellido_mecanico']) . "</td>
                            </tr>";
                    }

                    echo "</tbody></table>";
                } else {
                    echo "<p class='message error'>No se encontraron artículos que coincidan con los criterios.</p>";
                }
                $stmt->close();
            } catch (Exception $e) {
                echo "<p>Error: " . htmlspecialchars($e->getMessage()) . "</p>";
            }
            $conn->close();
        }
        ?>
    </div>
    <div class="section new-section">
    <h2>Gestión de Proveedores</h2>

    <div class="form-container">
        <!-- Formulario para agregar un proveedor -->
        <h3>Agregar Proveedor</h3>
        <form action="" method="POST">
            <label for="id_empresa_agregar">ID de la Empresa:</label>
            <input type="number" id="id_empresa_agregar" name="id_empresa_agregar" required>
            <button type="submit" name="agregar_proveedor">Agregar Proveedor</button>
        </form>

        <!-- Formulario para cambiar el estado de un proveedor -->
        <h3>Cambiar Estado de Proveedor</h3>
        <form action="" method="POST">
            <label for="id_empresa_estado">ID de la Empresa:</label>
            <input type="number" id="id_empresa_estado" name="id_empresa_estado" required>
            <button type="submit" name="cambiar_estado">Cambiar Estado</button>
        </form>
    </div>

    <?php
    require_once '../../config.php';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['agregar_proveedor'])) {
            $id_empresa = filter_var($_POST['id_empresa_agregar'], FILTER_SANITIZE_NUMBER_INT);

            try {
                $stmt = $conn->prepare("CALL agregar_proveedor(?)");
                $stmt->bind_param("i", $id_empresa);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result && $row = $result->fetch_assoc()) {
                    echo "<p class='message success'>" . htmlspecialchars($row['mensaje']) . "</p>";
                }

                $stmt->close();
            } catch (Exception $e) {
                echo "<p class='message error'>Error: " . htmlspecialchars($e->getMessage()) . "</p>";
            }
        }

        if (isset($_POST['cambiar_estado'])) {
            $id_empresa = filter_var($_POST['id_empresa_estado'], FILTER_SANITIZE_NUMBER_INT);

            try {
                $stmt = $conn->prepare("CALL cambiar_estado_proveedor(?)");
                $stmt->bind_param("i", $id_empresa);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result && $row = $result->fetch_assoc()) {
                    echo "<p class='message success'>Estado actualizado: " . htmlspecialchars($row['nuevo_estado']) . "</p>";
                }

                $stmt->close();
            } catch (Exception $e) {
                echo "<p class='message error'>Error: " . htmlspecialchars($e->getMessage()) . "</p>";
            }
        }

        $conn->close();
    }
    ?>
</div>

    


</div>
</html>
