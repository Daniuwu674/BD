<?php
function registrarExtractor($dni, $nombre, $apellido1, $apellido2) {
    global $conn;
    
    try {
        $checkStmt = $conn->prepare("SELECT DNI_extractor FROM extractor WHERE DNI_extractor = ?");
        $checkStmt->bind_param("i", $dni);
        $checkStmt->execute();
        $result = $checkStmt->get_result();
        
        if ($result->num_rows > 0) {
            $checkStmt->close();
            return [
                'success' => false,
                'message' => "Error: Ya existe un extractor con el DNI: $dni"
            ];
        }
        $checkStmt->close();

        $tabla = 'extractor';
        $campos = 'DNI_extractor, nombres, Prim_apellido, Seg_apellido';
        $valores = "{$dni}, '{$nombre}', '{$apellido1}', '{$apellido2}'";
        
        $stmt = $conn->prepare("CALL insertar_datos(?, ?, ?)");
        $stmt->bind_param("sss", $tabla, $campos, $valores);
        
        if ($stmt->execute()) {
            $stmt->close();
            return [
                'success' => true,
                'message' => "Extractor registrado exitosamente",
                'data' => [
                    'dni' => $dni,
                    'nombre' => $nombre,
                    'apellido1' => $apellido1,
                    'apellido2' => $apellido2
                ]
            ];
        } else {
            $stmt->close();
            return [
                'success' => false,
                'message' => "Error al registrar el extractor: " . $conn->error
            ];
        }
        
    } catch (Exception $e) {
        return [
            'success' => false,
            'message' => "Error en la operación: " . $e->getMessage()
        ];
    }
}

function registrarVendedor($dni, $nombre, $apellido1, $apellido2, $telefono) {
    global $conn;
    try {
        $checkStmt = $conn->prepare("SELECT DNI_vendedor FROM vendedor WHERE DNI_vendedor = ?");
        $checkStmt->bind_param("i", $dni);
        $checkStmt->execute();
        $result = $checkStmt->get_result();
        
        if ($result->num_rows > 0) {
            $checkStmt->close();
            return [
                'success' => false,
                'message' => "Error: Ya existe un vendedor con el DNI: $dni"
            ];
        }
        $checkStmt->close();

        $checkStmt = $conn->prepare("SELECT telefono FROM vendedor WHERE telefono = ?");
        $checkStmt->bind_param("i", $telefono);
        $checkStmt->execute();
        $result = $checkStmt->get_result();
        
        if ($result->num_rows > 0) {
            $checkStmt->close();
            return [
                'success' => false,
                'message' => "Error: Ya existe un vendedor con el telefono: $telefono"
            ];
        }
        $checkStmt->close();

        $tabla = 'vendedor';
        $campos = 'DNI_vendedor, nombres, Prim_apellido, Seg_apellido, telefono';
        $valores = "{$dni}, '{$nombre}', '{$apellido1}', '{$apellido2}', '{$telefono}'";

        $stmt = $conn->prepare("CALL insertar_datos(?, ?, ?)");
        $stmt->bind_param("sss", $tabla, $campos, $valores);
        
        if ($stmt->execute()) {
            $stmt->close();
            return [
                'success' => true,
                'message' => "Vendedor registrado exitosamente",
                'data' => [
                    'DNI_vendedor' => $dni,
                    'nombres' => $nombre,
                    'Prim_apellido' => $apellido1,
                    'Seg_apellido' => $apellido2,
                    'telefono' => $telefono
                ]
            ];
        }
    } catch (Exception $e) {
        return [
            'success' => false,
            'message' => "Error en la operacion: " . $e->getMessage()
        ];
    }
}

function registrarMecanico($dni, $nombre, $apellido1, $apellido2, $telefono) {
    global $conn;

    try {
        $checkStmt = $conn->prepare("SELECT DNI_mecanico FROM mecanico WHERE DNI_mecanico = ?");
        $checkStmt->bind_param("i", $dni);
        $checkStmt->execute();
        $result = $checkStmt->get_result();
        
        if ($result->num_rows > 0) {
            $checkStmt->close();
            return [
                'success' => false,
                'message' => "Error: Ya existe un mecanico con el DNI: $dni"
            ];
        }
        $checkStmt->close();

        $checkStmt = $conn->prepare("SELECT telefono FROM mecanico WHERE telefono = ?");
        $checkStmt->bind_param("i", $telefono);
        $checkStmt->execute();
        $result = $checkStmt->get_result();
        
        if ($result->num_rows > 0) {
            $checkStmt->close();
            return [
                'success' => false,
                'message' => "Error: Ya existe un mecanico con el telefono: $telefono"
            ];
        }
        $checkStmt->close();

        $tabla = 'mecanico';
        $campos = 'DNI_mecanico, nombres, Prim_apellido, Seg_apellido, telefono';
        $valores = "{$dni}, '{$nombre}', '{$apellido1}', '{$apellido2}', {$telefono}";
        
        $stmt = $conn->prepare("CALL insertar_datos(?, ?, ?)");
        $stmt->bind_param("sss", $tabla, $campos, $valores);
        
        if ($stmt->execute()) {
            $stmt->close();
            return [
                'success' => true,
                'message' => "Mecanico registrado exitosamente",
                'data' => [
                    'DNI_mecanico' => $dni,
                    'nombres' => $nombre,
                    'Prim_apellido' => $apellido1,
                    'Seg_apellido' => $apellido2,
                    'telefono' => $telefono
                ]
            ];
        }
    } catch (Exception $e) {
        return [
            'success' => false,
            'message' => "Error en la operacion: " . $e->getMessage()
        ];
    }
}

function registrarOperadorMaquina($dni, $nombre, $apellido1, $apellido2, $idMaquina) {
    global $conn;

    try {
        $checkStmt = $conn->prepare("SELECT DNI_operador FROM ope_maquina WHERE DNI_operador = ?");
        $checkStmt->bind_param("i", $dni);
        $checkStmt->execute();
        $result = $checkStmt->get_result();
        
        if ($result->num_rows > 0) {
            $checkStmt->close();
            return [
                'success' => false,
                'message' => "Error: Ya existe un operador de maquina con el DNI: $dni"
            ];
        }
        $checkStmt->close();
        
        $checkStmt = $conn->prepare("SELECT ID_maquina FROM maquina WHERE ID_maquina = ?");
        $checkStmt->bind_param("i", $idMaquina);
        $checkStmt->execute();
        $result = $checkStmt->get_result();
        
        if ($result->num_rows <= 0) {
            $checkStmt->close();
            return [
                'success' => false,
                'message' => "Error: No existe una maquina con el ID: $idMaquina"
            ];
        }
        $checkStmt->close();

        $tabla = 'ope_maquina';
        $campos = 'DNI_operador, nombres, Prim_apellido, Seg_apellido, ID_maquina';
        $valores = "{$dni}, '{$nombre}', '{$apellido1}', '{$apellido2}', {$idMaquina}";
        
        $stmt = $conn->prepare("CALL insertar_datos(?, ?, ?)");
        $stmt->bind_param("sss", $tabla, $campos, $valores);
        
        if ($stmt->execute()) {
            $stmt->close();
            return [
                'success' => true,
                'message' => "Operador de maquina registrado exitosamente",
                'data' => [
                    'DNI_operador' => $dni,
                    'nombre' => $nombre,
                    'Prim_apellido' => $apellido1,
                    'Seg_apellido' => $apellido2,
                    'ID_maquina' => $idMaquina
                ]
            ];
        }
    } catch (Exception $e) {
        return [
            'success' => false,
            'message' => "Error en la operacion: " . $e->getMessage()
        ];
    }
}

function registrarOperadorExplosivos($dni, $nombre, $apellido1, $apellido2, $idVoladura) {
    global $conn;

    try {
        $checkStmt = $conn->prepare("SELECT DNI_op_explo FROM ope_explosivo WHERE DNI_op_explo = ?");
        $checkStmt->bind_param("i", $dni);
        $checkStmt->execute();
        $result = $checkStmt->get_result();
        
        if ($result->num_rows > 0) {
            $checkStmt->close();
            return [
                'success' => false,
                'message' => "Error: Ya existe un operador de explosivos con el DNI: $dni"
            ];
        }
        $checkStmt->close();

        $cantExplosivo = 0;
        $radioEvacuacion = 0;

        $tabla = 'ope_explosivo';
        $campos = 'DNI_op_explo, nombres, Prim_apellido, Seg_apellido, cant_explosivo, radio_evacuacion, ID_voladura';
        $valores = "{$dni}, '{$nombre}', '{$apellido1}', '{$apellido2}', {$cantExplosivo}, {$radioEvacuacion}, {$idVoladura}";
        
        $stmt = $conn->prepare("CALL insertar_datos(?, ?, ?)");
        $stmt->bind_param("sss", $tabla, $campos, $valores);
        
        if ($stmt->execute()) {
            $stmt->close();
            return [
                'success' => true,
                'message' => "Operador de explosivos registrado exitosamente",
                'data' => [
                    'DNI_op_explo' => $dni,
                    'nombres' => $nombre,
                    'Prim_apellido' => $apellido1,
                    'Seg_apellido' => $apellido2,
                    'cant_explosivo' => $cantExplosivo,
                    'radio_evacuacion' => $radioEvacuacion,
                    'ID_voladura' => $idVoladura
                ]
            ];
        }
    } catch (Exception $e) {
        return [
            'success' => false,
            'message' => "Error en la operacion: " . $e->getMessage()
        ];
    }
}

function registrarReporteMaquina($dniOpMaquina, $reporte) {
    global $conn;

    try {
        $checkStmt = $conn->prepare("SELECT DNI_operador FROM ope_maquina WHERE DNI_operador = ?");
        $checkStmt->bind_param("i", $dniOpMaquina);
        $checkStmt->execute();
        $result = $checkStmt->get_result();
        
        if ($result->num_rows <= 0) {
            $checkStmt->close();
            return [
                'success' => false,
                'message' => "Error: No existe un operador de máquina con el DNI: $dniOpMaquina"
            ];
        }
        $checkStmt->close();

        $tabla = 'ope_maquina';
        $campos = 'reporte';
        $condicion = "DNI_operador = {$dni}"; 
        
        $stmt = $conn->prepare("CALL actualizar_tabla(?, ?, ?, ?)");
        $stmt->bind_param("ssss", $tabla, $campos, $reporte, $condicion);
        
        if ($stmt->execute()) {
            $stmt->close();
            return [
                'success' => true,
                'message' => "Reporte de máquina registrado exitosamente",
                'data' => [
                    'DNI_op_maquina' => $dniOpMaquina,
                    'reporte' => $reporte
                ]
            ];
        }
    } catch (Exception $e) {
        return [
            'success' => false,
            'message' => "Error en la operación: " . $e->getMessage()
        ];
    }
}

function eliminarOperadorMaquina($dni) {
    global $conn;

    try {
        $checkStmt = $conn->prepare("SELECT DNI_operador FROM ope_maquina WHERE DNI_operador = ?");
        $checkStmt->bind_param("i", $dni);
        $checkStmt->execute();
        $result = $checkStmt->get_result();

        if ($result->num_rows <= 0) {
            $checkStmt->close();
            return [
                'success' => false,
                'message' => "Error: No existe un operador de máquina con el DNI: $dni"
            ];
        }
        $checkStmt->close();

        $tablaTelefonos = 'ope_maquina_telefono';
        $columnaDni = 'DNI_operador';   
        $condicionTelefonos = "DNI_operador = {$dni}";

        $stmtTelefonos = $conn->prepare("CALL eliminar_datos(?, ?)");
        $stmtTelefonos->bind_param("ss", $tablaTelefonos, $condicionTelefonos);
        if (!$stmtTelefonos->execute()) {
            $stmtTelefonos->close();
            return [
                'success' => false,
                'message' => "Error al eliminar los teléfonos asociados al operador de Maquina con DNI $dni."
            ];
        }
        $stmtTelefonos->close();

        $tabla = 'ope_maquina';
        $condicion = "DNI_operador = {$dni}";

        $stmt = $conn->prepare("CALL eliminar_datos(?, ?)");
        $stmt->bind_param("ss", $tabla, $condicion);

        if ($stmt->execute()) {
            $stmt->close();
            return [
                'success' => true,
                'message' => "Operador de máquina con DNI $dni eliminado exitosamente"
            ];
        } else {
            $stmt->close();
            return [
                'success' => false,
                'message' => "Error al intentar eliminar el operador de máquina con DNI $dni"
            ];
        }
    } catch (Exception $e) {
        return [
            'success' => false,
            'message' => "Error en la operación: " . $e->getMessage()
        ];
    }
}

function eliminarOperadorExplosivos($dni) {
    global $conn;

    try {
        $checkStmt = $conn->prepare("SELECT DNI_op_explo FROM ope_explosivo WHERE DNI_op_explo = ?");
        $checkStmt->bind_param("i", $dni);
        $checkStmt->execute();
        $result = $checkStmt->get_result();

        if ($result->num_rows <= 0) {
            $checkStmt->close();
            return [
                'success' => false,
                'message' => "Error: No existe un Operador de Explosivos con el DNI: $dni"
            ];
        }
        $checkStmt->close();

        $tablaTelefonos = 'ope_explosivo_telefono';
        $columnaDni = 'DNI_op_explo';
        $condicionTelefonos = "DNI_op_explo = {$dni}";

        $stmtTelefonos = $conn->prepare("CALL eliminar_datos(?, ?)");
        $stmtTelefonos->bind_param("ss", $tablaTelefonos, $condicionTelefonos);
        if (!$stmtTelefonos->execute()) {
            $stmtTelefonos->close();
            return [
                'success' => false,
                'message' => "Error al eliminar los teléfonos asociados al operador de Explosivos con DNI $dni."
            ];
        }
        $stmtTelefonos->close();

        $tabla = 'ope_explosivo';
        $condicion = "DNI_op_explo = {$dni}";

        $stmt = $conn->prepare("CALL eliminar_datos(?, ?)");
        $stmt->bind_param("ss", $tabla, $condicion);

        if ($stmt->execute()) {
            $stmt->close();
            return [
                'success' => true,
                'message' => "Operador de Explosivos con DNI $dni eliminado exitosamente"
            ];
        } else {
            $stmt->close();
            return [
                'success' => false,
                'message' => "Error al intentar eliminar el operador de Explosivos con DNI $dni"
            ];
        }
    } catch (Exception $e) {
        return [
            'success' => false,
            'message' => "Error en la operación: " . $e->getMessage()
        ];
    }
}

function eliminarMecanico($dni) {
    global $conn;

    try {
        $checkStmt = $conn->prepare("SELECT DNI_mecanico FROM mecanico WHERE DNI_mecanico = ?");
        $checkStmt->bind_param("i", $dni);
        $checkStmt->execute();
        $result = $checkStmt->get_result();

        if ($result->num_rows <= 0) {
            $checkStmt->close();
            return [
                'success' => false,
                'message' => "Error: No existe un mecanico con el DNI: $dni"
            ];
        }
        $checkStmt->close();

        $tabla = 'mecanico';
        $condicion = "DNI_mecanico = {$dni}";

        $stmt = $conn->prepare("CALL eliminar_datos(?, ?)");
        $stmt->bind_param("ss", $tabla, $condicion);

        if ($stmt->execute()) {
            $stmt->close();
            return [
                'success' => true,
                'message' => "Mecanico con DNI $dni eliminado exitosamente"
            ];
        } else {
            $stmt->close();
            return [
                'success' => false,
                'message' => "Error al intentar eliminar el Mecanico con DNI $dni"
            ];
        }
    } catch (Exception $e) {
        return [
            'success' => false,
            'message' => "Error en la operación: " . $e->getMessage()
        ];
    }
}

function eliminarVendedor($dni) {
    global $conn;

    try {
        $checkStmt = $conn->prepare("SELECT DNI_vendedor FROM vendedor WHERE DNI_vendedor = ?");
        $checkStmt->bind_param("i", $dni);
        $checkStmt->execute();
        $result = $checkStmt->get_result();

        if ($result->num_rows <= 0) {
            $checkStmt->close();
            return [
                'success' => false,
                'message' => "Error: No existe un vendedor con el DNI: $dni"
            ];
        }
        $checkStmt->close();

        $stmt = $conn->prepare("CALL eliminar_vendedor(?)");
        $stmt->bind_param("s", $dni);

        if ($stmt->execute()) {
            $stmt->close();
            return [
                'success' => true,
                'message' => "Vendedor con DNI $dni eliminado"
            ];
        } else {
            $stmt->close();
            return [
                'success' => false,
                'message' => "Error al intentar marcar como inactivo el Vendedor con DNI $dni"
            ];
        }
    } catch (Exception $e) {
        return [
            'success' => false,
            'message' => "Error en la operación: " . $e->getMessage()
        ];
    }
}

function eliminarExtractor($dni) {
    global $conn;

    try {
        $checkStmt = $conn->prepare("SELECT DNI_extractor FROM extractor WHERE DNI_extractor = ?");
        $checkStmt->bind_param("i", $dni);
        $checkStmt->execute();
        $result = $checkStmt->get_result();

        if ($result->num_rows <= 0) {
            $checkStmt->close();
            return [
                'success' => false,
                'message' => "Error: No existe un extractor con el DNI: $dni"
            ];
        }
        $checkStmt->close();

        $tablaTelefonos = 'extractor_telefono';
        $columnaDni = 'DNI_extractor';
        $condicionTelefonos = "DNI_extractor = {$dni}";

        $stmtTelefonos = $conn->prepare("CALL eliminar_datos(?, ?)");
        $stmtTelefonos->bind_param("ss", $tablaTelefonos, $condicionTelefonos);
        if (!$stmtTelefonos->execute()) {
            $stmtTelefonos->close();
            return [
                'success' => false,
                'message' => "Error al eliminar los teléfonos asociados al extractor con DNI $dni."
            ];
        }
        $stmtTelefonos->close();

        $tabla = 'extractor';
        $condicion = "DNI_extractor = {$dni}";

        $stmt = $conn->prepare("CALL eliminar_datos(?, ?)");
        $stmt->bind_param("ss", $tabla, $condicion);

        if ($stmt->execute()) {
            $stmt->close();
            return [
                'success' => true,
                'message' => "Extractor con DNI $dni eliminado exitosamente"
            ];
        } else {
            $stmt->close();
            return [
                'success' => false,
                'message' => "Error al intentar eliminar el Extractor con DNI $dni"
            ];
        }
    } catch (Exception $e) {
        return [
            'success' => false,
            'message' => "Error en la operación: " . $e->getMessage()
        ];
    }
}

function actualizarDatoOperadorMaquina($dni, $columna, $nuevoValor) {
    global $conn;

    try {
        $checkStmt = $conn->prepare("SELECT DNI_operador FROM ope_maquina WHERE DNI_operador = ?");
        $checkStmt->bind_param("i", $dni);
        $checkStmt->execute();
        $result = $checkStmt->get_result();

        if ($result->num_rows <= 0) {
            $checkStmt->close();
            return [
                'success' => false,
                'message' => "Error: No existe un operador de máquina con el DNI: $dni"
            ];
        }
        $checkStmt->close();

        $tablaTelefonos = 'ope_maquina_telefono';
        $columnaDni = 'DNI_operador';
        $condicionTelefonos = "DNI_operador = {$dni}";

        $stmtTelefonos = $conn->prepare("CALL eliminar_datos(?, ?)");
        $stmtTelefonos->bind_param("ss", $tablaTelefonos, $condicionTelefonos);
        if (!$stmtTelefonos->execute()) {
            $stmtTelefonos->close();
            return [
                'success' => false,
                'message' => "Error al eliminar los teléfonos asociados al operador de maquina con DNI $dni."
            ];
        }
        $stmtTelefonos->close();

        $nombre_tabla = 'ope_maquina';
        $columna_a_actualizar = $columna;
        $condicion = "DNI_operador = {$dni}";

        $stmt = $conn->prepare("CALL actualizar_tabla(?, ?, ?, ?)");
        $stmt->bind_param("ssss", $nombre_tabla, $columna_a_actualizar, $nuevoValor, $condicion);

        if ($stmt->execute()) {
            $stmt->close();
            return [
                'success' => true,
                'message' => "El operador de máquina con DNI $dni ha sido actualizado exitosamente en la columna $columna",
                'data' => [
                    'DNI_operador' => $dni,
                    'columna' => $columna,
                    'nuevo_valor' => $nuevoValor
                ]
            ];
        } else {
            $stmt->close();
            return [
                'success' => false,
                'message' => "Error al intentar actualizar el operador de máquina con DNI $dni en la columna $columna"
            ];
        }
    } catch (Exception $e) {
        return [
            'success' => false,
            'message' => "Error en la operación: " . $e->getMessage()
        ];
    }
}

function actualizarDatoOperadorExplosivos($dni, $columna, $nuevoValor) {
    global $conn;

    try {
        $checkStmt = $conn->prepare("SELECT DNI_op_explo FROM ope_explosivo WHERE DNI_op_explo = ?");
        $checkStmt->bind_param("i", $dni);
        $checkStmt->execute();
        $result = $checkStmt->get_result();

        if ($result->num_rows <= 0) {
            $checkStmt->close();
            return [
                'success' => false,
                'message' => "Error: No existe un operador de máquina con el DNI: $dni"
            ];
        }
        $checkStmt->close();

        $tablaTelefonos = 'ope_explosivo_telefono';
        $columnaDni = 'DNI_op_explo';
        $condicionTelefonos = "DNI_op_explo = {$dni}";

        $stmtTelefonos = $conn->prepare("CALL eliminar_datos(?, ?)");
        $stmtTelefonos->bind_param("ss", $tablaTelefonos, $condicionTelefonos);
        if (!$stmtTelefonos->execute()) {
            $stmtTelefonos->close();
            return [
                'success' => false,
                'message' => "Error al eliminar los teléfonos asociados al operador de maquina con DNI $dni."
            ];
        }
        $stmtTelefonos->close();

        $nombre_tabla = 'ope_explosivo';
        $columna_a_actualizar = $columna;
        $condicion = "DNI_op_explo = {$dni}";

        $stmt = $conn->prepare("CALL actualizar_tabla(?, ?, ?, ?)");
        $stmt->bind_param("ssss", $nombre_tabla, $columna_a_actualizar, $nuevoValor, $condicion);

        if ($stmt->execute()) {
            $stmt->close();
            return [
                'success' => true,
                'message' => "El Operador de Explosivos con DNI $dni ha sido actualizado exitosamente en la columna $columna",
                'data' => [
                    'DNI_op_explo' => $dni,
                    'columna' => $columna,
                    'nuevo_valor' => $nuevoValor
                ]
            ];
        } else {
            $stmt->close();
            return [
                'success' => false,
                'message' => "Error al intentar actualizar el Operador de Explosivos con DNI $dni en la columna $columna"
            ];
        }
    } catch (Exception $e) {
        return [
            'success' => false,
            'message' => "Error en la operación: " . $e->getMessage()
        ];
    }
}

function actualizarDatoMecanico($dni, $columna, $nuevoValor) {
    global $conn;

    try {
        $checkStmt = $conn->prepare("SELECT DNI_mecanico FROM mecanico WHERE DNI_mecanico = ?");
        $checkStmt->bind_param("i", $dni);
        $checkStmt->execute();
        $result = $checkStmt->get_result();

        if ($result->num_rows <= 0) {
            $checkStmt->close();
            return [
                'success' => false,
                'message' => "Error: No existe un Mecanico con el DNI: $dni"
            ];
        }
        $checkStmt->close();

        $nombre_tabla = 'mecanico';
        $columna_a_actualizar = $columna;
        $condicion = "DNI_mecanico = {$dni}";

        $stmt = $conn->prepare("CALL actualizar_tabla(?, ?, ?, ?)");
        $stmt->bind_param("ssss", $nombre_tabla, $columna_a_actualizar, $nuevoValor, $condicion);

        if ($stmt->execute()) {
            $stmt->close();
            return [
                'success' => true,
                'message' => "El Mecanico con DNI $dni ha sido actualizado exitosamente en la columna $columna",
                'data' => [
                    'DNI_mecanico' => $dni,
                    'columna' => $columna,
                    'nuevo_valor' => $nuevoValor
                ]
            ];
        } else {
            $stmt->close();
            return [
                'success' => false,
                'message' => "Error al intentar actualizar el Mecanico con DNI $dni en la columna $columna"
            ];
        }
    } catch (Exception $e) {
        return [
            'success' => false,
            'message' => "Error en la operación: " . $e->getMessage()
        ];
    }
}

function actualizarDatoVendedor($dni, $columna, $nuevoValor) {
    global $conn;

    try {
        $checkStmt = $conn->prepare("SELECT DNI_vendedor FROM vendedor WHERE DNI_vendedor = ?");
        $checkStmt->bind_param("i", $dni);
        $checkStmt->execute();
        $result = $checkStmt->get_result();

        if ($result->num_rows <= 0) {
            $checkStmt->close();
            return [
                'success' => false,
                'message' => "Error: No existe un Vendedor con el DNI: $dni"
            ];
        }
        $checkStmt->close();

        $nombre_tabla = 'vendedor';
        $columna_a_actualizar = $columna;
        $condicion = "DNI_vendedor = {$dni}";

        $stmt = $conn->prepare("CALL actualizar_tabla(?, ?, ?, ?)");
        $stmt->bind_param("ssss", $nombre_tabla, $columna_a_actualizar, $nuevoValor, $condicion);

        if ($stmt->execute()) {
            $stmt->close();
            return [
                'success' => true,
                'message' => "El Vendedor con DNI $dni ha sido actualizado exitosamente en la columna $columna",
                'data' => [
                    'DNI_vendedor' => $dni,
                    'columna' => $columna,
                    'nuevo_valor' => $nuevoValor
                ]
            ];
        } else {
            $stmt->close();
            return [
                'success' => false,
                'message' => "Error al intentar actualizar el Vendedor con DNI $dni en la columna $columna"
            ];
        }
    } catch (Exception $e) {
        return [
            'success' => false,
            'message' => "Error en la operación: " . $e->getMessage()
        ];
    }
}

function actualizarDatoExtractor($dni, $columna, $nuevoValor) {
    global $conn;

    try {
        $checkStmt = $conn->prepare("SELECT DNI_extractor FROM extractor WHERE DNI_extractor = ?");
        $checkStmt->bind_param("i", $dni);
        $checkStmt->execute();
        $result = $checkStmt->get_result();

        if ($result->num_rows <= 0) {
            $checkStmt->close();
            return [
                'success' => false,
                'message' => "Error: No existe un Extractor con el DNI: $dni"
            ];
        }
        $checkStmt->close();

        $nombre_tabla = 'extractor';
        $columna_a_actualizar = $columna;
        $condicion = "DNI_extractor = {$dni}";

        $stmt = $conn->prepare("CALL actualizar_tabla(?, ?, ?, ?)");
        $stmt->bind_param("ssss", $nombre_tabla, $columna_a_actualizar, $nuevoValor, $condicion);

        if ($stmt->execute()) {
            $stmt->close();
            return [
                'success' => true,
                'message' => "El extractor con DNI $dni ha sido actualizado exitosamente en la columna $columna",
                'data' => [
                    'DNI_vendedor' => $dni,
                    'columna' => $columna,
                    'nuevo_valor' => $nuevoValor
                ]
            ];
        } else {
            $stmt->close();
            return [
                'success' => false,
                'message' => "Error al intentar actualizar el extractor con DNI $dni en la columna $columna"
            ];
        }
    } catch (Exception $e) {
        return [
            'success' => false,
            'message' => "Error en la operación: " . $e->getMessage()
        ];
    }
}

function insertarTelefonosExtractor($dni, $telefonosJSON) {
    global $conn;

    try {
        if (empty($telefonosJSON)) {
            return [
                'success' => false,
                'message' => "Error: No se proporcionaron teléfonos para insertar."
            ];
        }

        $telefonosArray = json_decode($telefonosJSON, true);
        if (!is_array($telefonosArray)) {
            return [
                'success' => false,
                'message' => "Error: Formato de teléfonos inválido."
            ];
        }

        $telefonosArray = array_filter($telefonosArray, function($telefono) {
            return !empty($telefono) && $telefono !== '0';
        });

        if (empty($telefonosArray)) {
            return [
                'success' => false,
                'message' => "Error: No hay teléfonos válidos para insertar."
            ];
        }

        $telefonosArray = array_values($telefonosArray);
        $telefonosJSON = json_encode($telefonosArray);

        $checkDniStmt = $conn->prepare("SELECT DNI_extractor FROM extractor WHERE DNI_extractor = ?");
        $checkDniStmt->bind_param("i", $dni);
        $checkDniStmt->execute();
        $dniResult = $checkDniStmt->get_result();

        if ($dniResult->num_rows <= 0) {
            $checkDniStmt->close();
            return [
                'success' => false,
                'message' => "Error: No existe un Extractor con el DNI: $dni"
            ];
        }
        $checkDniStmt->close();

        foreach ($telefonosArray as $telefono) {
            $checkTelefonoStmt = $conn->prepare("SELECT DNI_extractor FROM extractor_telefono WHERE telefono = ?");
            $checkTelefonoStmt->bind_param("s", $telefono);
            $checkTelefonoStmt->execute();
            $telefonoResult = $checkTelefonoStmt->get_result();

            if ($telefonoResult->num_rows > 0) {
                $checkTelefonoStmt->close();
                return [
                    'success' => false,
                    'message' => "Error: El teléfono $telefono ya está asignado a otro trabajador."
                ];
            }
            $checkTelefonoStmt->close();
        }

        $stmt = $conn->prepare("CALL insertar_telefonos_extractor(?, ?)");
        $stmt->bind_param("is", $dni, $telefonosJSON);

        if ($stmt->execute()) {
            $stmt->close();
            return [
                'success' => true,
                'message' => "Teléfonos insertados exitosamente para el extractor con DNI $dni."
            ];
        } else {
            $stmt->close();
            return [
                'success' => false,
                'message' => "Error al insertar teléfonos para el extractor con DNI $dni."
            ];
        }
    } catch (Exception $e) {
        return [
            'success' => false,
            'message' => "Error en la operación: " . $e->getMessage()
        ];
    }
}

function insertarTelefonosOpeExplosivo($dni, $telefonosJSON) {
    global $conn;

    try {
        if (empty($telefonosJSON)) {
            return [
                'success' => false,
                'message' => "Error: No se proporcionaron teléfonos para insertar."
            ];
        }

        $telefonosArray = json_decode($telefonosJSON, true);
        if (!is_array($telefonosArray)) {
            return [
                'success' => false,
                'message' => "Error: Formato de teléfonos inválido."
            ];
        }

        $telefonosArray = array_filter($telefonosArray, function($telefono) {
            return !empty($telefono) && $telefono !== '0';
        });

        if (empty($telefonosArray)) {
            return [
                'success' => false,
                'message' => "Error: No hay teléfonos válidos para insertar."
            ];
        }

        $telefonosArray = array_values($telefonosArray);
        $telefonosJSON = json_encode($telefonosArray);

        $checkDniStmt = $conn->prepare("SELECT DNI_op_explo FROM ope_explosivo WHERE DNI_op_explo = ?");
        $checkDniStmt->bind_param("i", $dni);
        $checkDniStmt->execute();
        $dniResult = $checkDniStmt->get_result();

        if ($dniResult->num_rows <= 0) {
            $checkDniStmt->close();
            return [
                'success' => false,
                'message' => "Error: No existe un Operador de Explosivos con el DNI: $dni"
            ];
        }
        $checkDniStmt->close();

        foreach ($telefonosArray as $telefono) {
            $checkTelefonoStmt = $conn->prepare("SELECT DNI_op_explo FROM ope_explosivo_telefono WHERE telefono = ?");
            $checkTelefonoStmt->bind_param("s", $telefono);
            $checkTelefonoStmt->execute();
            $telefonoResult = $checkTelefonoStmt->get_result();

            if ($telefonoResult->num_rows > 0) {
                $checkTelefonoStmt->close();
                return [
                    'success' => false,
                    'message' => "Error: El teléfono $telefono ya está asignado a otro trabajador."
                ];
            }
            $checkTelefonoStmt->close();
        }

        $stmt = $conn->prepare("CALL insertar_telefonos_ope_explosivo(?, ?)");
        $stmt->bind_param("is", $dni, $telefonosJSON);

        if ($stmt->execute()) {
            $stmt->close();
            return [
                'success' => true,
                'message' => "Teléfonos insertados exitosamente para el operador de explosivos con DNI $dni."
            ];
        } else {
            $stmt->close();
            return [
                'success' => false,
                'message' => "Error al insertar teléfonos para el operador de explosivos con DNI $dni."
            ];
        }
    } catch (Exception $e) {
        return [
            'success' => false,
            'message' => "Error en la operación: " . $e->getMessage()
        ];
    }
}

function insertarTelefonosOpeMaquina($dni, $telefonosJSON) {
    global $conn;

    try {
        if (empty($telefonosJSON)) {
            return [
                'success' => false,
                'message' => "Error: No se proporcionaron teléfonos para insertar."
            ];
        }

        $telefonosArray = json_decode($telefonosJSON, true);
        if (!is_array($telefonosArray)) {
            return [
                'success' => false,
                'message' => "Error: Formato de teléfonos inválido."
            ];
        }

        $telefonosArray = array_filter($telefonosArray, function($telefono) {
            return !empty($telefono) && $telefono !== '0';
        });

        if (empty($telefonosArray)) {
            return [
                'success' => false,
                'message' => "Error: No hay teléfonos válidos para insertar."
            ];
        }

        $telefonosArray = array_values($telefonosArray);
        $telefonosJSON = json_encode($telefonosArray);

        $checkDniStmt = $conn->prepare("SELECT DNI_operador FROM ope_maquina WHERE DNI_operador = ?");
        $checkDniStmt->bind_param("i", $dni);
        $checkDniStmt->execute();
        $dniResult = $checkDniStmt->get_result();

        if ($dniResult->num_rows <= 0) {
            $checkDniStmt->close();
            return [
                'success' => false,
                'message' => "Error: No existe un Operador de Máquinas con el DNI: $dni"
            ];
        }
        $checkDniStmt->close();

        foreach ($telefonosArray as $telefono) {
            $checkTelefonoStmt = $conn->prepare("SELECT DNI_operador FROM ope_maquina_telefono WHERE telefono = ?");
            $checkTelefonoStmt->bind_param("s", $telefono);
            $checkTelefonoStmt->execute();
            $telefonoResult = $checkTelefonoStmt->get_result();

            if ($telefonoResult->num_rows > 0) {
                $checkTelefonoStmt->close();
                return [
                    'success' => false,
                    'message' => "Error: El teléfono $telefono ya está asignado a otro trabajador."
                ];
            }
            $checkTelefonoStmt->close();
        }

        $stmt = $conn->prepare("CALL insertar_telefonos_ope_maquina(?, ?)");
        $stmt->bind_param("is", $dni, $telefonosJSON);

        if ($stmt->execute()) {
            $stmt->close();
            return [
                'success' => true,
                'message' => "Teléfonos insertados exitosamente para el operador de máquinas con DNI $dni."
            ];
        } else {
            $stmt->close();
            return [
                'success' => false,
                'message' => "Error al insertar teléfonos para el operador de máquinas con DNI $dni."
            ];
        }
    } catch (Exception $e) {
        return [
            'success' => false,
            'message' => "Error en la operación: " . $e->getMessage()
        ];
    }
}

?>