<?php

include '../config.php';
include '../includes/funciones.php';

$mensajeAlertaAgregar = '';
$tipoAlertaAgregar = '';
$mensajeAlertaListar = '';
$tipoAlertaListar = '';

$mensajes = [
    'actualizar_mapa' => ['mensaje' => '', 'tipo' => ''],
    'actualizar_explosivo' => ['mensaje' => '', 'tipo' => ''],
    'eliminar_mapa' => ['mensaje' => '', 'tipo' => ''],
    'general' => ['mensaje' => '', 'tipo' => '']
];

// Procesar formulario para agregar mapa
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['agregar_mapa'])) {
    try {
        $stmt = $conn->prepare("CALL Insertar_Mapa_Actualizar_Evacuacion(?, ?, ?, ?, ?, ?, ?, ?, ?)");

        $stmt->bind_param(
            "isdssiidi", 
            $_POST['id_mapa'],          
            $_POST['coordenadas'],       
            $_POST['ley_cobre'],        
            $_POST['descripcion'],      
            $_POST['dureza'],           
            $_POST['dni_extractor'],     
            $_POST['id_voladura'],       
            $_POST['radio_evacuacion'],  
            $_POST['dni_op_explosivo']  
        );

        if ($stmt->execute()) {
            $tipoAlertaAgregar = 'success';
            $mensajeAlertaAgregar = "Registro insertado y actualizado correctamente.";
        } else {
            $tipoAlertaAgregar = 'error';
            $mensajeAlertaAgregar = "Error al ejecutar el procedimiento.";
        }
        $stmt->close();
    } catch (Exception $e) {
        $tipoAlertaAgregar = 'error';
        $mensajeAlertaAgregar = "Error inesperado: " . $e->getMessage();
    }
}
// Proceso formulario para eliminar mapa
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['eliminar_mapa'])) {
    try {
        $checkStmt = $conn->prepare("SELECT COUNT(*) as count FROM Mapa WHERE ID_mapa = ?");
        $checkStmt->bind_param("i", $_POST['id_mapa']);
        $checkStmt->execute();
        $result = $checkStmt->get_result();
        $row = $result->fetch_assoc();
        
        if ($row['count'] == 0) {
            $mensajes['eliminar_mapa'] = [
                'mensaje' => "Error: El ID de mapa " . $_POST['id_mapa'] . " no existe en la base de datos.",
                'tipo' => 'error'
            ];
        } else {
            $stmt = $conn->prepare("CALL Eliminar_Mapa(?)");
            $stmt->bind_param("i", $_POST['id_mapa']);

            if ($stmt->execute()) {
                $mensajes['eliminar_mapa'] = [
                    'mensaje' => "Mapa con ID {$_POST['id_mapa']} eliminado correctamente.",
                    'tipo' => 'success'
                ];
            } else {
                $mensajes['eliminar_mapa'] = [
                    'mensaje' => "Error al eliminar el mapa: " . $stmt->error,
                    'tipo' => 'error'
                ];
            }
            $stmt->close();
        }
        $checkStmt->close();
    } catch (Exception $e) {
        $mensajes['eliminar_mapa'] = [
            'mensaje' => "Error inesperado: " . $e->getMessage(),
            'tipo' => 'error'
        ];
    }
}

// Procesar formulario para actualizar mapa
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['actualizar_mapa'])) {
    try {
        $checkStmt = $conn->prepare("SELECT COUNT(*) as count FROM Mapa WHERE ID_mapa = ?");
        $checkStmt->bind_param("i", $_POST['id_mapa']);
        $checkStmt->execute();
        $result = $checkStmt->get_result();
        $row = $result->fetch_assoc();
        
        if ($row['count'] == 0) {
            $mensajes['actualizar_mapa'] = [
                'mensaje' => "Error: El ID de mapa " . $_POST['id_mapa'] . " no existe en la base de datos.",
                'tipo' => 'error'
            ];
        } else {
            $stmt = $conn->prepare("CALL actualizar_mapa(?, ?, ?, ?, ?)");
            $stmt->bind_param(
                "isdss",
                $_POST['id_mapa'],
                $_POST['coordenadas'],
                $_POST['ley_cobre'],
                $_POST['descripcion'],
                $_POST['dureza']
            );

            if ($stmt->execute()) {
                $mensajes['actualizar_mapa'] = [
                    'mensaje' => "Mapa actualizado correctamente.",
                    'tipo' => 'success'
                ];
            } else {
                $mensajes['actualizar_mapa'] = [
                    'mensaje' => "Error al actualizar el mapa: " . $stmt->error,
                    'tipo' => 'error'
                ];
            }
            $stmt->close();
        }
        $checkStmt->close();
    } catch (Exception $e) {
        $mensajes['actualizar_mapa'] = [
            'mensaje' => "Error inesperado: " . $e->getMessage(),
            'tipo' => 'error'
        ];
    }
}

// Procesar formulario para actualizar explosivo
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['actualizar_explosivo'])) {
    try {
        $checkStmt = $conn->prepare("SELECT COUNT(*) as count FROM ope_explosivo WHERE DNI_op_explo = ?");
        $checkStmt->bind_param("i", $_POST['dni_op_explo']);
        $checkStmt->execute();
        $result = $checkStmt->get_result();
        $row = $result->fetch_assoc();
        
        if ($row['count'] == 0) {
            $mensajes['actualizar_explosivo'] = [
                'mensaje' => "Error: El DNI del operador explosivo " . $_POST['dni_op_explo'] . " no existe en la base de datos.",
                'tipo' => 'error'
            ];
        } else {
            $stmt = $conn->prepare("CALL actualizar_explosivo(?, ?)");
            $stmt->bind_param(
                "ii",
                $_POST['dni_op_explo'],
                $_POST['cant_explosivo']
            );

            if ($stmt->execute()) {
                $mensajes['actualizar_explosivo'] = [
                    'mensaje' => "Explosivo actualizado correctamente.",
                    'tipo' => 'success'
                ];
            } else {
                $mensajes['actualizar_explosivo'] = [
                    'mensaje' => "Error al actualizar el explosivo: " . $stmt->error,
                    'tipo' => 'error'
                ];
            }
            $stmt->close();
        }
        $checkStmt->close();
    } catch (Exception $e) {
        $mensajes['actualizar_explosivo'] = [
            'mensaje' => "Error inesperado: " . $e->getMessage(),
            'tipo' => 'error'
        ];
    }
}

// Procesar la solicitud de mostrar mapas
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['mostrar_mapas'])) {
    try {
        $stmt = $conn->prepare("CALL listar_mapas()");
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $tablaHTML = '<table border="1" style="width: 100%; margin-top: 20px;">
                            <tr>
                                <th>ID Mapa</th>
                                <th>Coordenadas</th>
                                <th>Ley Cobre</th>
                                <th>Dureza</th>
                                <th>DNI Extractor</th>
                                <th>ID Voladura</th>
                            </tr>';
            
            while ($row = $result->fetch_assoc()) {
                $tablaHTML .= '<tr>
                                <td>' . htmlspecialchars($row['ID_mapa']) . '</td>
                                <td>' . htmlspecialchars($row['coords']) . '</td>
                                <td>' . htmlspecialchars($row['ley_cobre']) . '</td>
                                <td>' . htmlspecialchars($row['dureza']) . '</td>
                                <td>' . htmlspecialchars($row['DNI_extractor']) . '</td>
                                <td>' . htmlspecialchars($row['ID_voladura']) . '</td>
                              </tr>';
            }
            $tablaHTML .= '</table>';
        } else {
            $tablaHTML = '<p>No hay mapas registrados.</p>';
        }
        
        $stmt->close();
    } catch (Exception $e) {
        $tipoAlertaListar = 'error';
        $mensajeAlertaListar = "Error al listar los mapas: " . $e->getMessage();
    }
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Extracción y Mapas</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>

        body {
            background-color: #f5f1ec;
            font-family: Arial, sans-serif;
            color: #4e4e4e;
            margin: 0;
            padding: 0;
        }

        .container {
            display: grid;
            flex-direction: column;
            grid-template-columns: repeat(2, 1fr);

            gap: 20px;
            margin-left: 290px;
            padding: 20px;
            max-width: 1200px;
        }

        .form-section {
            width: 100%; 
            max-width: 600px; 
            background-color: #e6e2de;
            padding: 20px;
            border-radius: 10px;
            box-sizing: border-box;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            margin: 20px auto; 
        }


        h2, h3 {
            text-align: center;
            color: #423e3a;
            font-weight: bold;
            margin-bottom: 20px;
        }

        form {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 15px;
            margin-top: 20px;
        }

        label {
            font-weight: bold;
            font-size: 16px;
            color: #5d4d3e;
            margin-bottom: 5px;
            text-align: left;
            width: 90%;
            max-width: 500px;
        }

        input[type="text"],
        input[type="number"],
        textarea {
            padding: 10px;
            font-size: 14px;
            border: 1px solid #ccc;
            border-radius: 5px;
            width: 90%;
            max-width: 500px;
        }

        input:focus,
        textarea:focus {
            outline: none;
            border-color: #888;
        }

        button {
            background-color: #5a5552;
            color: white;
            padding: 10px;
            font-size: 14px;
            border-radius: 5px;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s;
            width: 90%;
            max-width: 500px;
            margin-top: 25px;
        }

        button:hover {
            background-color: #3b3837;
        }

        .alert {
            padding: 15px;
            margin: 15px 0;
            border-radius: 5px;
            font-size: 16px;
            text-align: center;
            width: 90%;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .alert-error {
            background-color: #f7dada;
            color: #a94442;
            border: 1px solid #f5c6cb;
        }

        .message {
            padding: 1px;
            margin: 1px 0;
            border-radius: 5px;
            font-size: 16px;
            font-weight: bold;
            text-align: center;
            width: 50%;
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
        .close-alert {
            font-size: 16px;  
            padding: 0;  
            background: none;  
            border: none; 
            color: #333; 
            cursor: pointer;  
            position: absolute;  
            top: 10px;  
            right: 10px; 
        }

        .close-alert:hover {
        color: #ff0000;  
        font-size: 18px;  
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background-color: #fff;
        }
        
        th, td {
            padding: 12px;
            text-align: left;
            border: 1px solid #ddd;
        }
        
        th {
            background-color: #5a5552;
            color: white;
        }
        
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        
        tr:hover {
            background-color: #f5f5f5;
        }
    </style>
</head>
<body>

<?php include '../includes/headers/header3.php'; ?>
<?php include '../includes/navs/nav2.php'; ?>
<h2>Gestión de Extracción y Mapas</h2>
<div class="container"> 
    
    
    

    <!-- Seccion de Agregar Mapa -->
    <div class="form-section">
        <h3>Agregar Mapa</h3>
        <?php if ($mensajeAlertaAgregar): ?>
            <div class="alert alert-<?php echo $tipoAlertaAgregar; ?>">
                <?php echo $mensajeAlertaAgregar; ?>
            </div>
        <?php endif; ?>
        <form method="POST">
            <input type="hidden" name="agregar_mapa" value="1">
            <label for="id_mapa">ID Mapa:</label>
            <input type="number" name="id_mapa" required>
            <label for="coordenadas">Coordenadas:</label>
            <input type="text" name="coordenadas" required>
            <label for="ley_cobre">Ley de Cobre:</label>
            <input type="number" step="0.01" name="ley_cobre" required>
            <label for="descripcion">Descripción:</label>
            <textarea name="descripcion" required></textarea>
            <label for="dureza">Dureza:</label>
            <input type="text" name="dureza" required>
            <label for="dni_extractor">DNI Extractor:</label>
            <input type="number" name="dni_extractor" required>
            <label for="id_voladura">ID Voladura:</label>
            <input type="number" name="id_voladura" required>
            <label for="radio_evacuacion">Radio Evacuación:</label>
            <input type="number" name="radio_evacuacion" required>
            <label for="dni_op_explosivo">DNI Operador Explosivo:</label>
            <input type="number" name="dni_op_explosivo" required>
            <button type="submit">Agregar Mapa</button>
        </form>
    </div>
    
    <div class="form-section">
        <h3>Listar Mapas</h3>
        <form method="GET">
            <input type="hidden" name="mostrar_mapas" value="1">
            <button type="submit">Ver Mapas</button>
        </form>
        
        <?php if ($mensajeAlertaListar): ?>
            <div class="alert alert-<?php echo $tipoAlertaListar; ?>">
                <?php echo $mensajeAlertaListar; ?>
            </div>
        <?php endif; ?>
        
        <?php if (!empty($tablaHTML)): ?>
            <div class="tabla-resultados">
                <?php echo $tablaHTML; ?>
            </div>
        <?php endif; ?>
    </div>
    
    <!-- Seccion de Eliminar Mapa -->
    <div class="form-section">
        <h3>Eliminar Mapa</h3>
        <?php if (!empty($mensajes['eliminar_mapa']['mensaje'])): ?>
            <div class="alert alert-<?php echo $mensajes['eliminar_mapa']['tipo']; ?>">
                <?php echo $mensajes['eliminar_mapa']['mensaje']; ?>
            </div>
        <?php endif; ?>
        <form method="POST" onsubmit="return confirm('¿Está seguro de eliminar este mapa?');">
            <input type="hidden" name="eliminar_mapa" value="1">
            <label for="id_mapa">ID Mapa:</label>
            <input type="number" name="id_mapa" required>
            <button type="submit">Eliminar Mapa</button>
        </form>
    </div>

    <div class="form-section">
        <h3>Actualizar Mapa</h3>
        <?php if (!empty($mensajes['actualizar_mapa']['mensaje'])): ?>
            <div class="alert alert-<?php echo $mensajes['actualizar_mapa']['tipo']; ?>">
                <?php echo $mensajes['actualizar_mapa']['mensaje']; ?>
            </div>
        <?php endif; ?>
        <form method="POST" onsubmit="return confirm('¿Está seguro de actualizar este mapa?');">
            <input type="hidden" name="actualizar_mapa" value="1">
            <label for="id_mapa">ID del Mapa:</label>
            <input type="number" name="id_mapa" required>
            
            <label for="coordenadas">Coordenadas:</label>
            <input type="text" name="coordenadas" required>
            
            <label for="ley_cobre">Ley de Cobre:</label>
            <input type="number" step="0.01" name="ley_cobre" required>
            
            <label for="descripcion">Descripción:</label>
            <textarea name="descripcion" required></textarea>
            
            <label for="dureza">Dureza:</label>
            <input type="text" name="dureza" required>
            
            <button type="submit">Actualizar Mapa</button>
        </form>
    </div>

    <!-- Seccion de Actualizar Explosivo -->
    <div class="form-section">
        <h3>Actualizar Explosivo</h3>
        <?php if (!empty($mensajes['actualizar_explosivo']['mensaje'])): ?>
            <div class="alert alert-<?php echo $mensajes['actualizar_explosivo']['tipo']; ?>">
                <?php echo $mensajes['actualizar_explosivo']['mensaje']; ?>
            </div>
        <?php endif; ?>
        <form method="POST" onsubmit="return confirm('¿Está seguro de actualizar este explosivo?');">
            <input type="hidden" name="actualizar_explosivo" value="1">
            <label for="dni_op_explo">DNI Operador Explosivo:</label>
            <input type="number" name="dni_op_explo" required>
            <label for="cant_explosivo">Cantidad de Explosivo:</label>
            <input type="number" name="cant_explosivo" required>
            <button type="submit">Actualizar Explosivo</button>
        </form>
    </div>
</div>

</body>
</html>