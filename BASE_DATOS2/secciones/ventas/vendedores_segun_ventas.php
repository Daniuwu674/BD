<?php include '../../includes/headers/header.php'; ?>
<?php include '../../includes/navs/nav1.php'; ?>

<div class="container" style="width: 90%; margin: 0 auto; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #eae8e6; border-radius: 12px; padding: 20px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
    <h2 style="text-align: center; color: #333; font-size: 24px; margin-bottom: 20px;">Resultado de la búsqueda</h2>

    <?php
    include '../../config.php';

    if (isset($_GET['cantidad_ventas'])) {
        $cantidad_ventas = $_GET['cantidad_ventas'];

        $sql = "CALL obtener_ventas_por_vendedores($cantidad_ventas)";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo "<table style='width: 100%; margin-top: 20px; border-collapse: collapse; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);'>
                    <tr style='background-color: #3c3c3c; color: white; font-size: 18px; text-align: center;'>
                        <th style='padding: 14px 20px; border: 1px solid #bbb; text-align: center; font-weight: 600;'>DNI</th>
                        <th style='padding: 14px 20px; border: 1px solid #bbb; text-align: center; font-weight: 600;'>Nombre</th>
                        <th style='padding: 14px 20px; border: 1px solid #bbb; text-align: center; font-weight: 600;'>Primer Apellido</th>
                        <th style='padding: 14px 20px; border: 1px solid #bbb; text-align: center; font-weight: 600;'>Segundo Apellido</th>
                        <th style='padding: 14px 20px; border: 1px solid #bbb; text-align: center; font-weight: 600;'>Teléfono</th>
                        <th style='padding: 14px 20px; border: 1px solid #bbb; text-align: center; font-weight: 600;'>Número de ventas</th>
                    </tr>";
            while ($row = $result->fetch_assoc()) {
                echo "<tr style='background-color: #ffffff; transition: background-color 0.3s ease;'>
                        <td style='padding: 12px 20px; border: 1px solid #ddd; text-align: center; font-size: 16px; font-weight: 500;'>{$row['DNI_vendedor']}</td>
                        <td style='padding: 12px 20px; border: 1px solid #ddd; text-align: center; font-size: 16px; font-weight: 500;'>{$row['nombres']}</td>
                        <td style='padding: 12px 20px; border: 1px solid #ddd; text-align: center; font-size: 16px; font-weight: 500;'>{$row['Prim_apellido']}</td>
                        <td style='padding: 12px 20px; border: 1px solid #ddd; text-align: center; font-size: 16px; font-weight: 500;'>{$row['Seg_apellido']}</td>
                        <td style='padding: 12px 20px; border: 1px solid #ddd; text-align: center; font-size: 16px; font-weight: 500;'>{$row['telefono']}</td>
                        <td style='padding: 12px 20px; border: 1px solid #ddd; text-align: center; font-size: 16px; font-weight: 500;'>{$row['cantidad_ventas']}</td>
                    </tr>";
            }
            echo "</table>";
        } else {
            echo "<p style='text-align: center; color: #a94442; background-color: #f2dede; padding: 12px; border-radius: 8px; margin-top: 20px;'>No se encontraron vendedores con la cantidad de ventas ingresada.</p>";
        }
    } else {
        echo "<p style='text-align: center; color: #a94442; background-color: #f2dede; padding: 12px; border-radius: 8px; margin-top: 20px;'>Por favor, ingrese una cantidad de ventas en el formulario.</p>";
    }

    $conn->close();
    ?>


    <div style="margin-top: 20px; text-align: center;">
        <a href="venta.php" style="display: inline-block; padding: 12px 20px; background-color: #575351; color: #fff; text-decoration: none; border-radius: 8px; font-size: 16px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); transition: background-color 0.3s ease;">
            Regresar a Ventas
        </a>
    </div>
</div>


</body>
</html>

