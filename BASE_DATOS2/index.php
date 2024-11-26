<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión del Personal en la Mina</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f4f4f4; 
            margin: 0;
            padding: 0;
            color: #333;
            line-height: 1.6;
        }

        .container {
            max-width: 1200px;
            margin: 50px auto;
            padding: 40px;
            background-color: #fff; 
            border-radius: 15px;
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        h2 {
            font-size: 2.5rem;
            color: #444;
            margin-bottom: 20px;
            font-weight: 700;
            text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.1); 
            letter-spacing: 2px;
        }

        p {
            font-size: 1.2rem;
            color: #555;
            margin-bottom: 40px;
            line-height: 1.7;
            font-style: italic; 
        }


        img {
            display: block;
            margin: 40px auto;
            max-width: 100%;
            height: auto;
            border: 8px solid #a0a0a0;
            border-radius: 20px;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0);
            transition: transform 0.4s ease-in-out, box-shadow 0.4s ease-in-out;
        }

        img:hover {
            transform: scale(1.05); 
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0); 
        }

        header {
            background-color: #333;
            color: #fff;
            padding: 20px 0;
            text-align: center;
            font-size: 1.4rem;
            text-transform: uppercase;
            letter-spacing: 3px;
            border-bottom: 5px solid #f4e1d2; 
        }

        nav {
            background-color: #444;
            padding: 15px;
            text-align: center;
            margin-bottom: 30px;
            border-radius: 10px;
        }

        nav a {
            color: #fff;
            text-decoration: none;
            padding: 12px 30px;
            margin: 0 15px;
            font-size: 1.1rem;
            border-radius: 25px;
            background-color: #6c757d;
            transition: background-color 0.3s, transform 0.3s;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        nav a:hover {
            background-color: #5a6268;
            transform: translateY(-2px); 
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.2);
        }

        footer {
            background-color: #333;
            color: #fff;
            text-align: center;
            padding: 15px;
            margin-top: 40px;
            font-size: 1rem;
            letter-spacing: 1px;
        }

        footer a {
            color: #f4e1d2;
            text-decoration: none;
            font-weight: bold;
            transition: color 0.3s;
        }

        footer a:hover {
            color: #fff;
        }
    </style>
</head>
<body>
    <?php 
        include 'includes/headers/header2.php';
        include 'includes/nav.php';
    ?>
    
    <div class="container">
        <h2>Bienvenido a la Gestión de Personal en la Mina</h2>
        <p>Sección dedicada a los Pixies Inc. por la inspiración al momento de realizar este proyecto.</p>

        <img src="assets/imagenes/pixies" alt="Imagen de la Mina">
    </div>
    
    <footer>
        <p>&copy; 2024 Gestión del Personal en la Mina | <a href="#">Términos y Condiciones</a> | <a href="#">Política de Privacidad</a></p>
    </footer>
</body>
</html>
