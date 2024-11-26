<?php
// Configuración de la conexión a la base de datos
$host = "localhost";  
$username = "root";   
$password = "";       
$dbname = "minera";  

$port = 3307;        

$conexionStatus = [
    'success' => false,
    'message' => ''
];

try {
    $conn = new mysqli($host, $username, $password, $dbname, $port);

    if ($conn->connect_error) {
        $conexionStatus = [
            'success' => false,
            'message' => "Error de conexión: " . $conn->connect_error
        ];
    } else {
        $conexionStatus = [
            'success' => true,
            'message' => "Conexión exitosa a la base de datos"
        ];
    }
} catch (Exception $e) {
    $conexionStatus = [
        'success' => false,
        'message' => "Error inesperado: " . $e->getMessage()
    ];
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Configuración DB</title>
    <style>
        .popup {
            display: none;
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 15px 25px;
            border-radius: 5px;
            color: white;
            font-family: Arial, sans-serif;
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
            animation: slideIn 0.5s ease-out;
            z-index: 1000;
        }

        .popup.success {
            background-color: #4caf50;
        }

        .popup.error {
            background-color: #f44336;
        }

        @keyframes slideIn {
            from {
                transform: translateX(100%);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        @keyframes fadeOut {
            from {
                opacity: 1;
            }
            to {
                opacity: 0;
            }
        }
    </style>
</head>
<body>
    <div id="popup" class="popup">
        <?php echo $conexionStatus['message']; ?>
    </div>

    <script>
        function showPopup(success) {
            const popup = document.getElementById('popup');
            popup.className = 'popup ' + (success ? 'success' : 'error');
            popup.style.display = 'block';
            setTimeout(() => {
                popup.style.animation = 'fadeOut 0.5s ease-out';
                setTimeout(() => {
                    popup.style.display = 'none';
                    popup.style.animation = '';
                }, 500);
            }, 3000);
        }

        window.onload = function() {
            showPopup(<?php echo json_encode($conexionStatus['success']); ?>);
        };
    </script>
</body>
</html>