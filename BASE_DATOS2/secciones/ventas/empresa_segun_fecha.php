<?php include '../../includes/headers/header.php'; ?>
<?php include '../../includes/navs/nav1.php'; ?>

<div class="container" style="width: 90%; margin: 0 auto; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #eae8e6; padding: 20px; border-radius: 12px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
    <h2 style="text-align: center; color: #4e4e4e; font-size: 24px; margin-bottom: 20px;">Búsqueda de compras por Empresa</h2>

    <form action="empresa_segun_fecha.php" method="get" style="text-align: center; margin-bottom: 20px;">
        <label for="fecha_venta" style="color: #4e4e4e; font-size: 16px; margin-right: 10px;">Fecha de Venta:</label>
        <input type="date" id="fecha_venta" name="fecha_venta" required style="padding: 8px; border: 1px solid #bbb; border-radius: 6px; background-color: #f7f6f4; color: #4e4e4e;">

        <button type="submit" style="padding: 10px 20px; background-color: #a8978b; color: #fff; border: none; border-radius: 8px; font-size: 16px; cursor: pointer; transition: background-color 0.3s ease;">Buscar</button>
    </form>

    <?php
    include '../../config.php';

    if (isset($_GET['fecha_venta'])) {
        $fecha_venta = $_GET['fecha_venta'];

        $sql = "CALL obtener_ventas_por_empresa_fecha('$fecha_venta')";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo "<table style='width: 100%; margin: 20px auto; border-collapse: separate; border-spacing: 0; font-family: inherit; background-color: #eae8e6; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);'>
                    <tr style='background-color: #4e4e4e; color: #fff; font-size: 18px; text-align: center;'>
                        <th style='padding: 14px 20px; border: 1px solid #bbb; font-size: 16px; font-weight: 600;'>ID Empresa</th>
                        <th style='padding: 14px 20px; border: 1px solid #bbb; font-size: 16px; font-weight: 600;'>Nombre Empresa</th>
                        <th style='padding: 14px 20px; border: 1px solid #bbb; font-size: 16px; font-weight: 600;'>Cantidad de Ventas</th>
                    </tr>";

            while ($row = $result->fetch_assoc()) {
                echo "<tr style='background-color: #f7f6f4; transition: background-color 0.3s ease;'>
                        <td style='padding: 14px 20px; text-align: center; border: 1px solid #ddd; font-size: 16px; font-weight: 500;'>{$row['ID_empresa']}</td>
                        <td style='padding: 14px 20px; text-align: center; border: 1px solid #ddd; font-size: 16px; font-weight: 500;'>{$row['nombre_empresa']}</td>
                        <td style='padding: 14px 20px; text-align: center; border: 1px solid #ddd; font-size: 16px; font-weight: 500;'>{$row['cantidad_ventas']}</td>
                    </tr>";
            }

            echo "</table>";
        } else {
            echo "<p style='text-align: center; color: #a94d4d; font-size: 18px; font-weight: 500;'>No se encontraron ventas para la fecha seleccionada.</p>";
        }
    }
    ?>

<div style="margin-top: 20px; text-align: center;">
    <a href="venta.php" style="display: inline-block; padding: 12px 20px; background-color: #a8978b; color: #fff; text-decoration: none; border-radius: 8px; font-size: 16px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); transition: background-color 0.3s ease;">Regresar a Ventas</a>
</div>


</body>
</html>

