<style>
label {
            display: block;
            margin-bottom: 15px;
            margin-top: 15px;

            font-weight: bold;
            color: #555;
            font-size: 20px;
        }

</style>


<body>
    <div class="container">
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            
        <h2>Actualizar Voltaje de Chancadora</h2>

        <div class="form-group">
            <label for="id_chancadora">ID de la Chancadora:</label>
            <input type="number" id="id_chancadora" name="id_chancadora" required min="1">
        </div>

        <div class="form-group">
            
            <label for="nuevo_voltaje">Nuevo Voltaje:</label>
            <input type="number" id="nuevo_voltaje" name="nuevo_voltaje" required step="0.01" min="0">
        </div>

        <button type="submit">Actualizar Voltaje</button>

        <?php
        $mensaje = '';

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            require_once '../../config.php';
            try {
                $conn = new PDO("mysql:host=$host;port=$port;dbname=$dbname", $username, $password);
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                if (isset($_POST['id_chancadora']) && isset($_POST['nuevo_voltaje'])) {

                    $id_chancadora = $_POST['id_chancadora'];
                    $nuevo_voltaje = $_POST['nuevo_voltaje'];


                    $stmt = $conn->prepare("CALL actualizar_voltaje_chancadora(?, ?, @mensaje)");
                    $stmt->bindParam(1, $id_chancadora, PDO::PARAM_INT);
                    $stmt->bindParam(2, $nuevo_voltaje, PDO::PARAM_STR);
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
            const voltaje = parseFloat(document.getElementById('nuevo_voltaje').value);
            if (voltaje < 0) {
                e.preventDefault();
                alert('El voltaje debe ser mayor o igual a 0');
            }
        });
    </script>

    
</body>
