<body>
    <div class="container">
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        
        <h2>Actualizar pH del Agua de Chancadora</h2>
        
            <div class="form-group">
                <label for="id_chancadora">ID de la Chancadora:</label>
                <input type="number" id="id_chancadora" name="id_chancadora" required min="1">
            </div>

            <div class="form-group">
                <label for="nuevo_ph">Nuevo pH:</label>
                <input type="number" id="nuevo_ph" name="nuevo_ph" required step="0.1" min="0" max="14">
                <div class="ph-range">El pH debe estar entre 0 y 14</div>
            </div>

            <button type="submit">Actualizar pH</button>
            <?php

        $mensaje = '';

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            require_once '../../config.php';
            try {
                $conn = new PDO("mysql:host=$host;port=$port;dbname=$dbname", $username, $password);
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                if (isset($_POST['nuevo_ph']) && isset($_POST['id_chancadora'])) {
                    $id_chancadora = $_POST['id_chancadora'];
                    $nuevo_ph = $_POST['nuevo_ph'];
    
                    $stmt = $conn->prepare("CALL actualizar_ph_chancadora(?, ?, @mensaje)");
                    $stmt->bindParam(1, $id_chancadora, PDO::PARAM_INT);
                    $stmt->bindParam(2, $nuevo_ph, PDO::PARAM_STR);
                    $stmt->execute();
    
                    $result = $conn->query("SELECT @mensaje AS mensaje")->fetch();
                    $mensaje = $result['mensaje'];
                } 
            } catch(PDOException $e) {
                $mensaje = "Error de conexión: " . $e->getMessage();
            }
            $conn = null;
        }
        ?>

        <?php if (!empty($mensaje)): ?>
            <div class="mensaje <?php echo strpos($mensaje, 'Error') !== false ? 'error' : 'exito'; ?>">
                <?php echo htmlspecialchars($mensaje); ?>
            </div>
        <?php endif; ?>
        </form>
        
    </div>

    <script>
        document.querySelector('form').addEventListener('submit', function(e) {
            const ph = parseFloat(document.getElementById('nuevo_ph').value);
            if (ph < 0 || ph > 14) {
                e.preventDefault();
                alert('El pH debe estar entre 0 y 14');
            }
        });
    </script>


</body>
