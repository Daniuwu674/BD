<?php include '../includes/headers/header3.php'; ?>
<?php include '../includes/navs/nav2.php'; ?>

<?php
include '../config.php';
include '../includes/funciones.php';

$resultado = '';
$tipoSeleccionado = isset($_GET['tipo']) ? $_GET['tipo'] : '';
$dniFiltro = isset($_GET['dni']) ? $_GET['dni'] : '';


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $accion = $_POST['accion'];
    $tipo = $_POST['tipo'];
    $dni = $_POST['dni'];

    switch ($accion) {
        case 'registrar':
            $nombre = $_POST['nombre'];
            $apellido1 = $_POST['apellido1'];
            $apellido2 = $_POST['apellido2'];

            switch ($tipo) {
                case 'extractor':
                    $telefonos = isset($_POST['telefonos']) ? $_POST['telefonos'] : [];
                    $telefonosJSON = json_encode($telefonos);
                    $resultado = registrarExtractor($dni, $nombre, $apellido1, $apellido2);
                    if ($resultado['success'] && !empty($telefonos)) {
                        $resultado = insertarTelefonosExtractor($dni, $telefonosJSON);
                    }
                    break;
                case 'vendedor':
                    $telefono = $_POST['telefono'] ?? '';
                    $resultado = registrarVendedor($dni, $nombre, $apellido1, $apellido2, $telefono);
                    break;
                case 'mecanico':
                    $telefono = $_POST['telefono'] ?? '';
                    $resultado = registrarMecanico($dni, $nombre, $apellido1, $apellido2, $telefono);
                    break;
                case 'ope_maquina':
                    $idMaquina = $_POST['id_maquina'] ?? null;
                    $telefonos = isset($_POST['telefonos']) ? $_POST['telefonos'] : [];
                    $telefonosJSON = json_encode($telefonos);
                    $resultado = registrarOperadorMaquina($dni, $nombre, $apellido1, $apellido2, $idMaquina);
                    if ($resultado['success'] && !empty($telefonos)) {
                        $resultado = insertarTelefonosOpeMaquina($dni, $telefonosJSON);
                    }
                    break;
                case 'ope_explosivo':
                    $idVoladura = 1;
                    $telefonos = isset($_POST['telefonos']) ? $_POST['telefonos'] : [];
                    $telefonosJSON = json_encode($telefonos);
                    $resultado = registrarOperadorExplosivos($dni, $nombre, $apellido1, $apellido2, $idVoladura);
                    if ($resultado['success'] && !empty($telefonos)) {
                        $resultado = insertarTelefonosOpeExplosivo($dni, $telefonosJSON);
                    }
                    break;
            }
            break;

        case 'actualizar':
            $columna = $_POST['columna'];
            $nuevoValor = $_POST['nuevoValor'];
            
            switch ($tipo) {
                case 'extractor':
                    $resultado = actualizarDatoExtractor($dni, $columna, $nuevoValor);
                    break;
                case 'vendedor':
                    $resultado = actualizarDatoVendedor($dni, $columna, $nuevoValor);
                    break;
                case 'mecanico':
                    $resultado = actualizarDatoMecanico($dni, $columna, $nuevoValor);
                    break;
                case 'ope_maquina':
                    $resultado = actualizarDatoOperadorMaquina($dni, $columna, $nuevoValor);
                    break;
                case 'ope_explosivo':
                    $resultado = actualizarDatoOperadorExplosivos($dni, $columna, $nuevoValor);
                    break;
            }
            break;

        case 'eliminar':
            switch ($tipo) {
                case 'extractor':
                    $resultado = eliminarExtractor($dni);
                    break;
                case 'vendedor':
                    $resultado = eliminarVendedor($dni);
                    break;
                case 'mecanico':
                    $resultado = eliminarMecanico($dni);
                    break;
                case 'ope_maquina':
                    $resultado = eliminarOperadorMaquina($dni);
                    break;
                case 'ope_explosivo':
                    $resultado = eliminarOperadorExplosivos($dni);
                    break;
            }
            break;
    }
}

if (isset($_GET['tipo']) && (!isset($_SERVER['HTTP_X_REQUESTED_WITH']) || $_SERVER['HTTP_X_REQUESTED_WITH'] !== 'XMLHttpRequest')) {
    $tipoSeleccionado = $_GET['tipo'];
}

function mostrarTablaRegistros($tipo, $dniFiltro = '', $mostrarLista = false) {
    global $conn;

    $tabla = "";
    $dniTabla = "";
    $funcionSQL = "";

    switch ($tipo) {
        case 'extractor':
            $tabla = "extractor";
            $dniTabla = "DNI_extractor";
            $funcionSQL = "obtenerTelefonosExtractor";
            break;
        case 'vendedor':
            $tabla = "vendedor";
            $dniTabla = "DNI_vendedor";
            break;
        case 'mecanico':
            $tabla = "mecanico";
            $dniTabla = "DNI_mecanico";
            break;
        case 'ope_maquina':
            $tabla = "ope_maquina";
            $dniTabla = "DNI_operador";
            $funcionSQL = "obtenerTelefonosOperadorMaquina";
            break;
        case 'ope_explosivo':
            $tabla = "ope_explosivo";
            $dniTabla = "DNI_op_explo";
            $funcionSQL = "obtenerTelefonosOperadorExplosivo";
            break;
        default:
            echo "<p class='error'>Tipo de operador no válido.</p>";
            return;
    }

    $query = "SELECT * FROM $tabla";
    if (!empty($dniFiltro)) {
        $query .= " WHERE $dniTabla = '$dniFiltro'";
    }

    $result = mysqli_query($conn, $query);

    if (!$result) {
        echo "Error en la consulta: " . mysqli_error($conn);
        return;
    }

    echo "
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            color: #333;
        }

        .tabla-registros, .tabla-telefonos {
            border-collapse: collapse;
            width: 80%;
            margin: 20px auto;
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .tabla-registros th, .tabla-registros td, .tabla-telefonos td {
            padding: 12px;
            text-align: center;
            font-size: 16px;
            border: 1px solid #ddd;
        }

        .tabla-registros th {
            background-color: #444;
            color: white;
            font-size: 18px;
            font-weight: bold;
        }

        .tabla-fila {
            background-color: #f9f9f9;
        }

        .tabla-fila:nth-child(even) {
            background-color: #f1f1f1;
        }

        .tabla-registros td {
            font-size: 14px;
            color: #555;
        }

        .tabla-registros tr:hover {
            background-color: #f0f0f0;
        }

        .lista-registros {
            margin: 20px auto;
            width: 80%;
            list-style: none;
            padding: 0;
            font-size: 16px;
        }

        .lista-registros li {
            margin: 8px 0;
            background-color: #e9ecef;
            padding: 10px;
            border-radius: 4px;
        }

        .error {
            text-align: center;
            color: #dc3545;
            font-weight: bold;
        }

        h2 {
            text-align: center;
            color: #444;
        }
    </style>";

    if (mysqli_num_rows($result) > 0) {
        echo "<table class='tabla-registros'>";
        $fields = mysqli_fetch_fields($result);
        echo "<tr class='tabla-titulo'>";
        foreach ($fields as $field) {
            echo "<th>" . htmlspecialchars($field->name) . "</th>";
        }
        echo "</tr>";

        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr class='tabla-fila'>";
            foreach ($row as $value) {
                echo "<td>" . htmlspecialchars($value) . "</td>";
            }
            echo "</tr>";
        }
        echo "</table>";

        if ($mostrarLista) {
            mysqli_data_seek($result, 0); 
            echo "<ul class='lista-registros'>";
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<li>Registro: " . implode(", ", array_map('htmlspecialchars', $row)) . "</li>";
            }
            echo "</ul>";
        }

        if (!empty($dniFiltro) && ($tipo == 'ope_maquina' || $tipo == 'ope_explosivo' || $tipo == 'extractor')) {
            $dniFiltro = mysqli_real_escape_string($conn, $dniFiltro);
            $queryTelefonos = "SELECT $funcionSQL('$dniFiltro') AS telefonos";

            $resultTelefonos = $conn->query($queryTelefonos);
            if ($resultTelefonos && $rowTelefonos = $resultTelefonos->fetch_assoc()) {
                $telefonosJson = $rowTelefonos['telefonos'];
                $telefonosArray = json_decode($telefonosJson, true);

                if (!empty($telefonosArray)) {
                    echo "<table class='tabla-telefonos'>";
                    echo "<tr><th>Número de Teléfono</th></tr>";
                    foreach ($telefonosArray as $telefono) {
                        echo "<tr><td>" . htmlspecialchars($telefono) . "</td></tr>";
                    }
                    echo "</table>";
                } else {
                    echo "<p>No se encontraron teléfonos.</p>";
                }
            } else {
                echo "<p>Error en la consulta de teléfonos: " . $conn->error . "</p>";
            }
        }
    } else {
        echo "<p class='error'>No se encontraron registros para los criterios especificados.</p>";
    }
}

?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <div class="titi">
    
    <style>
        .titi {
            font-family: Arial, sans-serif;
            margin: 40px 40px 20px 20px;
            padding: 20px;
        }
        .form-container {
            display: none;
            margin-top: 20px;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
        }
        .form-group input, .form-group select {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .extra-fields {
            display: none;
            margin-top: 10px;
        }
        .tabs {
            margin-bottom: 20px;
        }
        .tab-button {
            padding: 10px 20px;
            margin-right: 5px;
            border: none;
            background-color: #444;
            cursor: pointer;
        }
        .tab-button.active {
            background-color: #444;
            color: white;
        }
        button {
            padding: 10px 20px;
            background-color: #444;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background-color: #444;
        }
        #mensaje {
            margin: 20px 0;
            padding: 15px;
            border-radius: 4px;
            display: none;
        }
        #mensaje.success {
            background-color: #8bd150;
            border-color: #497425; 
            color: #497425;
        }
        #mensaje.error {
            background-color: #f8d7da;
            border-color: #f5c6cb;
            color: #721c24;
        }
        .telefono-container {
            margin-bottom: 10px;
        }
        .telefono-input {
            display: flex;
            gap: 10px;
            margin-bottom: 5px;
        }
        .add-telefono-btn {
            background-color: #4444;
            color: white;
            padding: 5px 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .remove-telefono-btn {
            background-color: #444;
            color: white;
            padding: 5px 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .tabla-registros, .tabla-telefonos {
            border-collapse: collapse;
            width: 100%;
            margin: 20px auto;
        }

        .tabla-registros th, .tabla-registros td, .tabla-telefonos td {
            padding: 12px;
            text-align: center;
            font-size: 16px;
        }

        .tabla-titulo {
            background-color: #444;
            color: white;
            font-size: 18px;
        }

        .tabla-fila {
            background-color: #444;
        }

        .lista-registros {
            margin: 20px auto;
            width: 80%;
            font-size: 16px;
        }

        .lista-registros li {
            margin: 5px 0;
        }

        .error {
            text-align: center;
            color: #444;
        }

    </style>
    <script>
        function filtrarPorDNI() {
            const dniFiltro = document.getElementById('dni-filtro').value;
            const tipoVer = document.getElementById('tipo-ver').value;
            
            if (!tipoVer) {
                mostrarMensajePersonalizado('Por favor, seleccione un tipo de personal', false);
                return;
            }

            if (dniFiltro && !/^\d{8}$/.test(dniFiltro)) {
                mostrarMensajePersonalizado('El DNI debe contener 8 dígitos numéricos', false);
                return;
            }

            const xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    const tempDiv = document.createElement('div');
                    tempDiv.innerHTML = xhr.responseText;
                    
                    const nuevaTabla = tempDiv.querySelector('#tabla-registros');
                    const contenedorTabla = document.getElementById('tabla-registros');
                    
                    if (nuevaTabla) {
                        contenedorTabla.innerHTML = nuevaTabla.outerHTML;
                    } else {
                        contenedorTabla.innerHTML = '<p style="text-align: center; color: gray;">No se encontraron registros.</p>';
                    }
                }
            };

            const url = `${window.location.pathname}?tipo=${tipoVer}&dni=${dniFiltro}`;
            xhr.open('GET', url, true);
            xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
            xhr.send();
        }

        function limpiarFiltro() {
            document.getElementById('dni-filtro').value = '';
            const tipoVer = document.getElementById('tipo-ver').value;
            if (tipoVer) {
                const xhr = new XMLHttpRequest();
                xhr.onreadystatechange = function() {
                    if (xhr.readyState === 4 && xhr.status === 200) {
                        const tempDiv = document.createElement('div');
                        tempDiv.innerHTML = xhr.responseText;
                        
                        const nuevaTabla = tempDiv.querySelector('#tabla-registros');
                        const contenedorTabla = document.getElementById('tabla-registros');
                        
                        if (nuevaTabla) {
                            contenedorTabla.innerHTML = nuevaTabla.outerHTML;
                        } else {
                            contenedorTabla.innerHTML = '<p style="text-align: center; color: gray;">No se encontraron registros.</p>';
                        }
                    }
                };

                const url = `${window.location.pathname}?tipo=${tipoVer}`;
                xhr.open('GET', url, true);
                xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
                xhr.send();
            }
        }

        function agregarCampoTelefono(contenedor) {
            const telefonoDiv = document.createElement('div');
            telefonoDiv.className = 'telefono-input';
            
            const input = document.createElement('input');
            input.type = 'text';
            input.name = 'telefonos[]';
            input.required = true;
            input.pattern = "\\d{9}";
            input.title = "El teléfono debe contener 9 dígitos numericos";
            
            const removeBtn = document.createElement('button');
            removeBtn.type = 'button';
            removeBtn.className = 'remove-telefono-btn';
            removeBtn.textContent = 'Eliminar';
            removeBtn.onclick = function() {
                telefonoDiv.remove();
            };
            
            telefonoDiv.appendChild(input);
            telefonoDiv.appendChild(removeBtn);
            contenedor.appendChild(telefonoDiv);
        }
        
        function mostrarFormulario(accion) {
            document.querySelectorAll('.form-container').forEach(form => {
                form.style.display = 'none';
            });
            
            document.getElementById(accion + '-form').style.display = 'block';
            
            document.querySelectorAll('.tab-button').forEach(button => {
                button.classList.remove('active');
            });
            document.querySelector(`[onclick="mostrarFormulario('${accion}')"]`).classList.add('active');

            document.getElementById('mensaje').style.display = 'none';
        }

        function actualizarCamposExtra(accion) {
            const tipo = document.querySelector(`#${accion}-form select[name="tipo"]`).value;
            const extraFields = document.querySelectorAll(`#${accion}-form .extra-fields`);
            
            extraFields.forEach(field => {
                field.style.display = 'none';
                

                const requiredInputs = field.querySelectorAll('input');
                requiredInputs.forEach(input => {
                    input.disabled = true;
                    input.required = false;
                });
            });

            if (accion === 'registrar') {
                const camposExtra = document.querySelector(`#${accion}-form .extra-fields.${tipo}`);
                if (camposExtra) {
                    camposExtra.style.display = 'block';
                    const requiredInputs = camposExtra.querySelectorAll('input');
                    requiredInputs.forEach(input => {
                        input.removeAttribute('disabled');
                        
                        if (input.hasAttribute('data-required')) {
                            input.required = true;
                        }
                    });
                }
            } else if (accion === 'actualizar') {
                actualizarColumnasActualizar(tipo);
            }
        }

        window.onload = function() {
            const tipoVer = document.getElementById('tipo-ver');
            if (tipoVer) {
                tipoVer.addEventListener('change', function() {
                    const tipoSeleccionado = this.value;
                    if (tipoSeleccionado) {
                        window.location.href = window.location.pathname + '?tipo=' + tipoSeleccionado;
                    }
                });
            }

            const extraFields = document.querySelectorAll('.extra-fields');
            extraFields.forEach(field => {
                const requiredInputs = field.querySelectorAll('input');
                requiredInputs.forEach(input => {
                    input.setAttribute('disabled', 'disabled');
                    input.required = false;
                });
            });

            const tipoRegistro = document.getElementById('tipo-registro');
            if (tipoRegistro) {
                tipoRegistro.addEventListener('change', function() {
                    actualizarCamposExtra('registrar');
                });
            }
        }
    </script>
</head>
<body>
    <h1>Sistema de Gestión de Personal</h1>

    <div id="mensaje" style="display: none; margin-top: 20px; padding: 10px; border-radius: 4px;"></div>

    <script>
        <?php if ($resultado !== null): ?>
            document.addEventListener('DOMContentLoaded', function() {

                const tipoVer = document.getElementById('tipo-ver');
    
                if (tipoVer) {
                    tipoVer.addEventListener('change', function() {
                        const tipoSeleccionado = this.value;
                        
                        if (tipoSeleccionado) {
                            fetch(`?tipo=${tipoSeleccionado}`, {
                                method: 'GET',
                                headers: {
                                    'X-Requested-With': 'XMLHttpRequest'
                                }
                            })
                            .then(response => response.text())
                            .then(html => {
                                const tempDiv = document.createElement('div');
                                tempDiv.innerHTML = html;
                            
                                const tablaRegistros = tempDiv.querySelector('#tabla-registros');
                                
                                const tablaContenedor = document.getElementById('tabla-registros');
                                if (tablaRegistros) {
                                    tablaContenedor.innerHTML = tablaRegistros.innerHTML;
                                } else {
                                    tablaContenedor.innerHTML = '<p style="text-align: center; color: gray;">No se encontraron registros.</p>';
                                }
                            })
                            .catch(error => {
                                console.error('Error:', error);
                                const tablaContenedor = document.getElementById('tabla-registros');
                                tablaContenedor.innerHTML = '<p style="text-align: center; color: red;">Error al cargar los registros.</p>';
                            });
                        }
                    });
                }

                const mensajeDiv = document.getElementById('mensaje');
                const mensaje = <?php echo json_encode($resultado); ?>;
                
                if (mensaje.message) {
                    mensajeDiv.textContent = mensaje.message;
                    mensajeDiv.className = mensaje.success ? 'success' : 'error';
                    mensajeDiv.style.display = 'block';
                    
                    if (mensaje.success) {
                        const formularioActual = document.querySelector('form');
                        if (formularioActual) {
                            formularioActual.reset();
                        }
                        
                        if (document.getElementById('ver-form').style.display === 'block') {
                            const tipoSelect = document.getElementById('tipo-ver');
                            if (tipoSelect && tipoSelect.value) {
                                fetch(window.location.href + '?tipo=' + tipoSelect.value)
                                    .then(response => response.text())
                                    .then(html => {
                                        const parser = new DOMParser();
                                        const doc = parser.parseFromString(html, 'text/html');
                                        const tablaRegistros = doc.getElementById('tabla-registros');
                                        if (tablaRegistros) {
                                            document.getElementById('tabla-registros').innerHTML = tablaRegistros.innerHTML;
                                        }
                                    });
                            }
                        }
                    }
                    
                    setTimeout(() => {
                        mensajeDiv.style.display = 'none';
                    }, 5000);
                }

                const tipoRegistro = document.getElementById('tipo-registro');
                if (tipoRegistro) {
                    tipoRegistro.addEventListener('change', function() {
                        const tipo = this.value;
                        const extraFields = document.querySelectorAll('.extra-fields');
                        
                        extraFields.forEach(field => {
                            field.style.display = 'none';
                            const requiredInputs = field.querySelectorAll('input');
                            requiredInputs.forEach(input => {
                                input.setAttribute('disabled', 'disabled');
                                input.required = false;
                            });
                        });

                        const camposExtra = document.querySelector(`.extra-fields.${tipo}`);
                        if (camposExtra) {
                            camposExtra.style.display = 'block';
                            const requiredInputs = camposExtra.querySelectorAll('input');
                            requiredInputs.forEach(input => {
                                input.removeAttribute('disabled');
                                if (input.hasAttribute('data-required')) {
                                    input.required = true;
                                }
                            });
                        }
                    });
                }
            });
        <?php endif; ?>
    </script>

    <div class="tabs">
        <button class="tab-button" onclick="mostrarFormulario('registrar')">Registrar</button>
        <button class="tab-button" onclick="mostrarFormulario('actualizar')">Actualizar</button>
        <button class="tab-button" onclick="mostrarFormulario('eliminar')">Eliminar</button>
        <button class="tab-button" onclick="mostrarFormulario('ver')">Ver Registros</button>
    </div>

    <!-- Formulario de Registro -->
    <div id="registrar-form" class="form-container">
        <h2>Registrar Personal</h2>
        <form method="POST" action="">
            <input type="hidden" name="accion" value="registrar">
            
            <div class="form-group">
                <label for="tipo-registro">Tipo de Personal:</label>
                <select id="tipo-registro" name="tipo" onchange="actualizarCamposExtra('registrar')" required>
                    <option value="">Seleccione...</option>
                    <option value="extractor">Extractor</option>
                    <option value="vendedor">Vendedor</option>
                    <option value="mecanico">Mecánico</option>
                    <option value="ope_maquina">Operador de Máquina</option>
                    <option value="ope_explosivo">Operador de Explosivos</option>
                </select>
            </div>

            <div class="form-group">
                <label for="dni-registro">DNI:</label>
                <input type="number" id="dni-registro" name="dni" required>
            </div>

            <div class="form-group">
                <label for="nombre-registro">Nombres:</label>
                <input type="text" id="nombre-registro" name="nombre" required>
            </div>

            <div class="form-group">
                <label for="apellido1-registro">Primer Apellido:</label>
                <input type="text" id="apellido1-registro" name="apellido1" required>
            </div>

            <div class="form-group">
                <label for="apellido2-registro">Segundo Apellido:</label>
                <input type="text" id="apellido2-registro" name="apellido2" required>
            </div>

            <!-- Campos adicionales para extractor -->
            <div class="extra-fields extractor">
                <div class="form-group">
                    <label>Teléfonos:</label>
                    <div id="telefonos-extractor" class="telefono-container">
                        <div class="telefono-input">
                            <input type="text" name="telefonos[]" pattern="\d{9}" title="El teléfono debe contener 9 dígitos numericos" data-required="true">
                            <button type="button" class="remove-telefono-btn" onclick="this.parentElement.remove()">Eliminar</button>
                        </div>
                    </div>
                    <button type="button" class="add-telefono-btn" onclick="agregarCampoTelefono(document.getElementById('telefonos-extractor'))">
                        Agregar otro teléfono
                    </button>
                </div>
            </div>

            <!-- Campos adicionales para Vendedor -->
            <div class="extra-fields vendedor">
                <div class="form-group">
                    <label for="telefono-vendedor">Teléfono:</label>
                    <input type="text" id="telefono-vendedor" pattern="\d{9}" title="El teléfono debe contener 9 dígitos numericos" data-required="true" name="telefono">
                </div>
            </div>

            <!-- Campos adicionales para Mecánico -->
            <div class="extra-fields mecanico">
                <div class="form-group">
                    <label for="telefono-mecanico">Teléfono:</label>
                    <input type="text" id="telefono-mecanico" pattern="\d{9}" title="El teléfono debe contener 9 dígitos numericos" data-required="true" name="telefono">
                </div>
            </div>

            <!-- Campos adicionales para Operador de Máquina -->
            <div class="extra-fields ope_maquina">
                <div class="form-group">
                    <label for="id_maquina">ID Máquina:</label>
                    <input type="number" id="id_maquina" name="id_maquina" data-required="true">
                </div>
                <div class="form-group">
                    <label>Teléfonos:</label>
                    <div id="telefonos-ope-maquina" class="telefono-container">
                        <div class="telefono-input">
                            <input type="text" name="telefonos[]" pattern="\d{9}" title="El teléfono debe contener 9 dígitos numericos" data-required="true">
                            <button type="button" class="remove-telefono-btn" onclick="this.parentElement.remove()">Eliminar</button>
                        </div>
                    </div>
                    <button type="button" class="add-telefono-btn" onclick="agregarCampoTelefono(document.getElementById('telefonos-ope-maquina'))">
                        Agregar otro teléfono
                    </button>
                </div>
            </div>

            <!-- Campos adicionales para Operador de Explosivos -->
            <div class="extra-fields ope_explosivo">
                <div class="form-group">
                    <label>Teléfonos:</label>
                    <div id="telefonos-ope-explosivo" class="telefono-container">
                        <div class="telefono-input">
                            <input type="text" name="telefonos[]" pattern="\d{9}" title="El teléfono debe contener 9 dígitos numericos" required>
                        </div>
                    </div>
                    <button type="button" class="add-telefono-btn" onclick="agregarCampoTelefono(document.getElementById('telefonos-ope-explosivo'))">
                        Agregar otro teléfono
                    </button>
                </div>
            </div>

            <button type="submit">Registrar</button>
        </form>
    </div>

    <!-- Formulario de Actualización -->
    <div id="actualizar-form" class="form-container">
        <h2>Actualizar Personal</h2>
        <form method="POST" action="">
            <input type="hidden" name="accion" value="actualizar">
            
            <div class="form-group">
                <label for="tipo-actualizacion">Tipo de Personal:</label>
                <select id="tipo-actualizacion" name="tipo" onchange="actualizarCamposExtra('actualizar')" required>
                    <option value="">Seleccione...</option>
                    <option value="extractor">Extractor</option>
                    <option value="vendedor">Vendedor</option>
                    <option value="mecanico">Mecánico</option>
                    <option value="ope_maquina">Operador de Máquina</option>
                    <option value="ope_explosivo">Operador de Explosivos</option>
                </select>
            </div>

            <div class="form-group">
                <label for="dni-actualizacion">DNI:</label>
                <input type="text" id="dni-actualizacion" name="dni" required>
            </div>

            <div class="form-group">
                <label for="columna">Columna a Actualizar:</label>
                <select id="columna" name="columna" required>
                </select>
            </div>

            <div class="form-group">
                <label for="nuevo-valor">Nuevo Valor:</label>
                <input type="text" id="nuevo-valor" name="nuevoValor" required>
            </div>

            <button type="submit">Actualizar</button>
        </form>
    </div>

    <!-- Formulario de Eliminación -->
    <div id="eliminar-form" class="form-container">
        <h2>Eliminar Personal</h2>
        <form method="POST" action="">
            <input type="hidden" name="accion" value="eliminar">
            
            <div class="form-group">
                <label for="tipo-eliminacion">Tipo de Personal:</label>
                <select id="tipo-eliminacion" name="tipo" required>
                    <option value="">Seleccione...</option>
                    <option value="extractor">Extractor</option>
                    <option value="vendedor">Vendedor</option>
                    <option value="mecanico">Mecánico</option>
                    <option value="ope_maquina">Operador de Máquina</option>
                    <option value="ope_explosivo">Operador de Explosivos</option>
                </select>
            </div>

            <div class="form-group">
                <label for="dni-eliminacion">DNI:</label>
                <input type="text" id="dni-eliminacion" name="dni" required>
            </div>

            <button type="submit" onclick="return confirm('¿Está seguro que desea eliminar este registro?')">Eliminar</button>
        </form>
    </div>

    <div id="ver-form" class="form-container">
        <h2>Ver Registros de Personal</h2>
        <div class="form-group">
            <label for="tipo-ver">Tipo de Personal:</label>
            <select id="tipo-ver" name="tipo">
                <option value="">Seleccione...</option>
                <option value="extractor">Extractor</option>
                <option value="vendedor">Vendedor</option>
                <option value="mecanico">Mecánico</option>
                <option value="ope_maquina">Operador de Máquina</option>
                <option value="ope_explosivo">Operador de Explosivos</option>
            </select>
        </div>
    
        <div class="form-group">
            <label for="dni-filtro">DNI (opcional):</label>
            <input type="text" id="dni-filtro" name="dni_filtro" pattern="\d{8}" title="El DNI debe contener 8 dígitos">
            <button type="button" onclick="filtrarPorDNI()">Filtrar</button>
            <button type="button" onclick="limpiarFiltro()">Limpiar filtro</button>
        </div>

        <div id="tabla-registros">
            <?php 
            if (!empty($tipoSeleccionado)) {
                mostrarTablaRegistros($tipoSeleccionado, $dniFiltro);
            } 
            ?>
        </div>
    </div>


    <!-- Contenedor para mensajes -->
    <div id="mensaje" style="display: none; margin-top: 20px; padding: 10px; border-radius: 4px;"></div>
    <script>
            window.onload = function() {
                mostrarFormulario('registrar');
                document.querySelector('[onclick="mostrarFormulario(\'registrar\')"]').classList.add('active');
                
                const extraFields = document.querySelectorAll('.extra-fields');
                extraFields.forEach(field => {
                    const requiredInputs = field.querySelectorAll('[required]');
                    requiredInputs.forEach(input => {
                        input.disabled = true;
                    });
                });
            }

            function validarDNI(dni) {
                return /^\d{8}$/.test(dni);
            }
            function validarTelefono(telefono) {
                return /^\d{9}$/.test(telefono);
            }

            document.querySelectorAll('form').forEach(form => {
                form.onsubmit = function(e) {
                    const dni = this.querySelector('[name="dni"]');
                    const tipo = this.querySelector('[name="tipo"]');

                    if (dni && !validarDNI(dni.value)) {
                        e.preventDefault();
                        mostrarMensajePersonalizado('El DNI debe contener 8 dígitos numéricos', false);
                        return false;
                    }

                    if (tipo && !tipo.value) {
                        e.preventDefault();
                        mostrarMensajePersonalizado('Por favor, seleccione un tipo de personal', false);
                        return false;
                    }

                    return true;
                }
            });

            function mostrarMensajePersonalizado(texto, esExito) {
                const mensajeDiv = document.getElementById('mensaje');
                mensajeDiv.textContent = texto;
                mensajeDiv.className = esExito ? 'success' : 'error';
                mensajeDiv.style.display = 'block';
                
                setTimeout(() => {
                    mensajeDiv.style.display = 'none';
                }, 5000);
            }

            function mostrarFormulario(accion) {

                document.querySelectorAll('.form-container').forEach(form => {
                    form.style.display = 'none';
                });
                
                const formSeleccionado = document.getElementById(accion + '-form');
                if (formSeleccionado) {
                    formSeleccionado.style.display = 'block';
                }
                
                document.querySelectorAll('.tab-button').forEach(button => {
                    button.classList.remove('active');
                });
                const botonSeleccionado = document.querySelector(`[onclick="mostrarFormulario('${accion}')"]`);
                if (botonSeleccionado) {
                    botonSeleccionado.classList.add('active');
                }
            }

            function actualizarCamposExtra(accion) {
                const tipo = document.querySelector(`#${accion}-form select[name="tipo"]`).value;
                const extraFields = document.querySelectorAll(`#${accion}-form .extra-fields`);
                
                extraFields.forEach(field => {
                    field.style.display = 'none';
                });

                if (accion === 'registrar') {
                    const camposExtra = document.querySelector(`#${accion}-form .extra-fields.${tipo}`);
                    if (camposExtra) {
                        camposExtra.style.display = 'block';
                    }
                } else if (accion === 'actualizar') {
                    actualizarColumnasActualizar(tipo);
                }
            }

            function actualizarColumnasActualizar(tipo) {
                const columnaSelect = document.querySelector('#actualizar-form select[name="columna"]');
                const columnas = {
                    'extractor': ['nombres', 'Prim_apellido', 'Seg_apellido'],
                    'vendedor': ['nombres', 'Prim_apellido', 'Seg_apellido', 'telefono'],
                    'mecanico': ['nombres', 'Prim_apellido', 'Seg_apellido', 'telefono'],
                    'ope_maquina': ['nombres', 'Prim_apellido', 'Seg_apellido', 'ID_maquina'],
                    'ope_explosivo': ['nombres', 'Prim_apellido', 'Seg_apellido','ID_voladura']
                };

                if (columnaSelect && columnas[tipo]) {
                    columnaSelect.innerHTML = '';
                    columnas[tipo].forEach(col => {
                        const option = document.createElement('option');
                        option.value = col;
                        option.textContent = col;
                        columnaSelect.appendChild(option);
                    });
                }
            }
        </script>
    </div>
</body>
</html>