<?php include '../../includes/headers/header.php'; ?>
<?php include '../../includes/navs/nav1.php'; ?>

<link rel="stylesheet" href="../../assets/css/style2.css">

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: Arial, sans-serif;
           
            margin: 0;
            padding: 0;
        }

                .ph-range{
            margin-bottom: 25px;
            padding: 12px;
            border-radius: 6px;
            border-radius: 10px;
            margin-top: 10px;
            font-weight: bold;
            text-align: center;
            font-family: Arial;
            background-color: #eae8e6;
        }
        .form-wrapper {
            display: flex;
            justify-content: center;
            gap: 30px;
            margin: 20px;
            
        }

        .form-container {
            background-color: #ffffff;
            padding: 50px;
            border-radius: 10px;
            width: 100%;
            margin: center;

            max-width: 480px; 
        }

        .outer-container {
            background-color: #e6e2de;
            padding: 30px;
            border-radius: 15px;
            width: 100%;
            max-width: 1040px; 
            margin: 0 auto;
        }

        h2 {
            color: #333;
            text-align: center;
            margin-bottom: 20px;
            margin: center;

        }

        .form-group {
            margin-bottom: 20px;
            margin: 0 auto;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #555;
        }

        input[type="number"] {
            width: 100%; 
            padding: 12px;
            border: 2px solid #ddd;
            border-radius: 6px;
            box-sizing: border-box;
            background-color: #eeeeee;
            font-size: 16px;
            color: #333;
            margin: center;

        }

        input[type="number"]:focus {
            outline: none;
            border-color: #040404;
            background-color: #eeeeee;
            margin: center;

        }

        button {
            background-color: #333;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            width: 100%; 
            display: block;
            margin: 0 auto;
            font-size: 16px;
            margin: center;
            margin-top: 15px;


            box-sizing: border-box; 
        }

        button:hover {
            background-color: #555;
        }

        .mensaje {
            margin-top: 20px;
            padding: 12px;
            border-radius: 6px;
            font-weight: bold;
            text-align: center;
        }

        .exito {
            background-color: #dff0d8;
            border: 1px solid #d6e9c6;
            color: #3c763d;
        }

        .error {
            background-color: #f2dede;
            border: 1px solid #ebccd1;
            color: #a94442;
        }
        

        @media (max-width: 768px) {
            .form-wrapper {
                flex-direction: column;
                align-items: center;
            }

            .form-container {
                width: 90%;
            }
        }
    </style>    
</head>

<body>
    <div class="outer-container">
        <div class="form-wrapper">
            <div class="form-container">
                <?php include 'servicios_agua.php'; ?> 
            </div>

            <div class="form-container">
                <?php include 'servicios_ele.php'; ?> 
            </div>
        </div>
    </div>
</body>
</html>

