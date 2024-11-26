<?php include '../../includes/headers/header.php'; ?>
<?php include '../../includes/navs/nav1.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Transporte</title>
    <style>
  
    .container2 {
        display: flex;
        margin-left: 200 px;
        justify-content: center;
        align-items: flex-start;
        flex-wrap: wrap;
        min-height: 100vh;
        padding: 20px;
        box-sizing: border-box;
        background-color: #f5f5f5;
        overflow-x: hidden;
    }

    .section {
        width: 30%;
        min-width: 300px;
        padding: 20px;
        box-sizing: border-box;
        border-radius: 8px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        background-color: #e8e4e1;
        border: 1px solid #d6d3d0;
        margin: 10px;
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .section h3 {
        text-align: center;
        color: #4e4e4e;
        font-size: 18px;
        width: 100%;
        margin-bottom: 20px;
    }

    .form-container {
        width: 90%;
        max-width: 400px;
    }

    .form-container form {
        display: flex;
        flex-direction: column;
        width: 100%;
    }

    .form-container label {
        width: 100%;
        margin-bottom: 5px;
    }

    .form-container input,
    .form-container select,
    .form-container button {
        padding: 10px;
        font-size: 14px;
        margin: 8px 0;
        border-radius: 4px;
        border: 1px solid #bbb;
        width: 100%;
        box-sizing: border-box;
    }

    .form-container input:focus,
    .form-container select:focus {
        border-color: #ccc;
        outline: none;
    }

    .form-container button {
        background-color: #595550;
        color: white;
        cursor: pointer;
        transition: background-color 0.3s ease;
        width: 100%;
        margin-top: 15px;
    }

    .form-container button:hover {
        background-color: #413f3b;
    }

    .success-message,
    .error-message {
        text-align: center;
        margin-top: 20px;
        font-size: 14px;
        font-weight: bold;
        width: 100%;
    }

    .success-message {
        color: #4caf50;
    }

    .error-message {
        color: #f44336;
    }

    @media (max-width: 1024px) {
        .section {
            width: 45%;
        }
    }

    @media (max-width: 768px) {
        .section {
            width: 100%;
            margin: 10px 0;
        }
    }
    </style>
</head>
<body>
    <div class="container2">
        <!-- Sección Agregar Transporte -->
        <div class="section">
            <h3>Agregar Transporte</h3>
            <div class="form-container">
                <form action="" method="POST">
                    <label for="id_transporte">ID Transporte:</label>
                    <input type="number" id="id_transporte" name="id_transporte" required min="1">

                    <label for="capacidad">Capacidad:</label>
                    <input type="number" id="capacidad" name="capacidad" required min="1">

                    <label for="cantidad">Cantidad:</label>
                    <input type="number" id="cantidad" name="cantidad" required min="0">

                    <label for="hr_entrada">Hora de Entrada:</label>
                    <input type="time" id="hr_entrada" name="hr_entrada" required>

                    <label for="hr_salida">Hora de Salida:</label>
                    <input type="time" id="hr_salida" name="hr_salida" required>

                    <label for="area">Área:</label>
                    <select id="area" name="area" required>
                        <option value="Voladura">Voladura</option>
                        <option value="Chancadora">Chancadora</option>
                    </select>

                    <button type="submit" name="add_transport">Agregar Transporte</button>
                </form>
            </div>
        </div>

        <!-- Sección Solicitar Transporte -->
        <div class="section">
            <h3>Solicitar Transporte</h3>
            <div class="form-container">
                <form action="" method="POST">
                    <label for="area_solicitar">Área:</label>
                    <select id="area_solicitar" name="area" required>
                        <option value="Chancadora">Chancadora</option>
                        <option value="Voladura">Voladura</option>
                    </select>

                    <label for="id_area">ID Área:</label>
                    <input type="number" id="id_area" name="id_area" required min="1">

                    <label for="id_transporte">ID Transporte:</label>
                    <input type="number" id="id_transporte" name="id_transporte" required min="1">

                    <label for="nueva_hr_entrada">Nueva Hora de Entrada:</label>
                    <input type="time" id="nueva_hr_entrada" name="nueva_hr_entrada" required>

                    <label for="nueva_hr_salida">Nueva Hora de Salida:</label>
                    <input type="time" id="nueva_hr_salida" name="nueva_hr_salida" required>

                    <button type="submit" name="request_transport">Solicitar Transporte</button>
                </form>
            </div>
        </div>

        <!-- Sección Actualizar Horarios -->
        <div class="section">
            <h3>Actualizar Horarios</h3>
            <div class="form-container">
                <form action="" method="POST">
                    <label for="area_actualizar">Área:</label>
                    <select id="area_actualizar" name="area" required>
                        <option value="Chancadora">Chancadora</option>
                        <option value="Voladura">Voladura</option>
                    </select>

                    <label for="id_transporte_actualizar">ID Transporte:</label>
                    <input type="number" id="id_transporte_actualizar" name="id_transporte" required min="1">

                    <label for="hr_entrada_actualizar">Hora de Entrada:</label>
                    <input type="time" id="hr_entrada_actualizar" name="hr_entrada" required>

                    <label for="hr_salida_actualizar">Hora de Salida:</label>
                    <input type="time" id="hr_salida_actualizar" name="hr_salida" required>

                    <button type="submit" name="update_schedule">Actualizar Horarios</button>
                </form>
            </div>
        </div>
    </div>

    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        require_once '../../config.php';

        try {
            if (isset($_POST['add_transport'])) {
                $id_transporte = filter_var($_POST['id_transporte'], FILTER_SANITIZE_NUMBER_INT);
                $capacidad = filter_var($_POST['capacidad'], FILTER_SANITIZE_NUMBER_INT);
                $cantidad = filter_var($_POST['cantidad'], FILTER_SANITIZE_NUMBER_INT);
                $hr_entrada = $_POST['hr_entrada'];
                $hr_salida = $_POST['hr_salida'];
                $area = $_POST['area'];

                $stmt = $conn->prepare("INSERT INTO transporte_personal (ID_transporte, capacidad, cantidad, hr_entrada, hr_salida, area) VALUES (?, ?, ?, ?, ?, ?)");
                $stmt->bind_param("iiisss", $id_transporte, $capacidad, $cantidad, $hr_entrada, $hr_salida, $area);

                if ($stmt->execute()) {
                    echo "<p class='success-message'>Transporte agregado correctamente.</p>";
                } else {
                    echo "<p class='error-message'>Error al agregar transporte.</p>";
                }
                $stmt->close();
            }

            if (isset($_POST['request_transport'])) {
                $area = $_POST['area'];
                $id_area = filter_var($_POST['id_area'], FILTER_SANITIZE_NUMBER_INT);
                $id_transporte = filter_var($_POST['id_transporte'], FILTER_SANITIZE_NUMBER_INT);
                $nueva_hr_entrada = $_POST['nueva_hr_entrada'];
                $nueva_hr_salida = $_POST['nueva_hr_salida'];

                if ($area === 'Chancadora') {
                    $stmt = $conn->prepare("CALL solicitar_transporte_chancadora(?, ?, ?, ?)");
                } else {
                    $stmt = $conn->prepare("CALL solicitar_transporte_voladura(?, ?, ?, ?)");
                }

                $stmt->bind_param("iiss", $id_area, $id_transporte, $nueva_hr_entrada, $nueva_hr_salida);

                if ($stmt->execute()) {
                    echo "<p class='success-message'>La operación se completó correctamente.</p>";
                } else {
                    echo "<p class='error-message'>Error al solicitar el transporte.</p>";
                }
                $stmt->close();
            }

            if (isset($_POST['update_schedule'])) {
                $area = $_POST['area'];
                $id_transporte = filter_var($_POST['id_transporte'], FILTER_SANITIZE_NUMBER_INT);
                $hr_entrada = $_POST['hr_entrada'];
                $hr_salida = $_POST['hr_salida'];

                if ($area === 'Chancadora') {
                    $stmt = $conn->prepare("CALL actualizar_horario_transporte_chancadora(?, ?, ?)");
                } elseif ($area === 'Voladura') {
                    $stmt = $conn->prepare("CALL actualizar_horario_transporte_voladura(?, ?, ?)");
                } else {
                    echo "<p class='error-message'>Área inválida seleccionada.</p>";
                    exit;
                }

                $stmt->bind_param("iss", $id_transporte, $hr_entrada, $hr_salida);

                if ($stmt->execute()) {
                    echo "<p class='success-message'>Horario actualizado correctamente para el área: $area y transporte ID: $id_transporte.</p>";
                } else {
                    echo "<p class='error-message'>Error al actualizar el horario para el área: $area.</p>";
                }
                $stmt->close();
            }
        } catch (Exception $e) {
            echo "<p class='error-message'>Error: " . htmlspecialchars($e->getMessage()) . "</p>";
        } finally {
            $conn->close();
        }
    }
    ?>
</body>
</html>