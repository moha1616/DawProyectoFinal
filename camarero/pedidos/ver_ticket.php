<?php
$servername = "localhost";
$database = "id20017664_xiroeatsbd";
$username = "id20017664_mezaydyo";
$password = "Mc02032023.";

$con = mysqli_connect($servername, $username, $password, $database);

if (isset($_POST['pedidoId'])) {
    $pedidoId = $_POST['pedidoId'];
    echo "<h2>XiroEats</h2>";
    echo "<hr>";
    echo "<h3>Factura Simplificada/Ticket</h3>";

    // Consultar las líneas de pedido asociadas al ID del pedido
    $query = "SELECT * FROM linea_pedido WHERE id_pedido = '$pedidoId'";
    $result = mysqli_query($con, $query);

    if (mysqli_num_rows($result) > 0) {
        echo "<table>";
        echo "<tr><th>Producto</th><th>Precio unitario</th></tr>";

        $total = 0; // Variable para almacenar el importe total

        while ($row = mysqli_fetch_assoc($result)) {
            $productoId = $row['ref_producto'];

            // Obtener información del producto
            $query_producto = "SELECT * FROM productos WHERE referencia = '$productoId'";
            $result_producto = mysqli_query($con, $query_producto);
            $row_producto = mysqli_fetch_assoc($result_producto);
            $nombre_producto = $row_producto['nombre'];
            $precio_producto = $row_producto['precio'];

            echo "<tr>";
            echo "<td>$nombre_producto</td>";
            echo "<td>".$precio_producto." €</td>";
            echo "</tr>";

            // Sumar el precio del producto al importe total
            $total += $precio_producto;
        }

        echo "</table>";

        echo "<br/>";
        echo "<strong>Total a pagar: </strong>$total €";
    } else {
        echo "No se encontraron líneas de pedido para el ID del pedido proporcionado.";
    }
}

echo "<div class='pedidos-button'>";
echo "<center>";
echo "<br/>";
echo "<br/>";
echo "        <a href='pedidos.php'>Volver</a>";
echo "</center>";
echo "</div>";

mysqli_close($con);
?>

<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f5f5f5;
        padding: 20px;
    }

    h2 {
        color: #333;
        text-align: center;
    }

    h3 {
        color: #555;
        text-align: center;
        margin-bottom: 30px;
    }

    hr {
        border: none;
        border-top: 2px solid #ddd;
        margin-top: 10px;
        margin-bottom: 20px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 20px;
    }

    th,
    td {
        padding: 10px;
        text-align: left;
    }

    th {
        background-color: #f2f2f2;
    }

    strong {
        font-weight: bold;
    }
    
    a{
      display: inline-block;
      padding: 10px 20px;
      margin: 10px;
      font-size: 16px;
      background-color: orange;
      color: white;
      border: none;
      border-radius: 80px;
      cursor: pointer;
      text-decoration:none;
    }
    
    /* Estilos para dispositivos móviles */
    @media screen and (max-width: 480px) {
        body {
            padding: 10px;
        }
        
        table {
            font-size: 14px;
        }
    }
</style>

<meta name="viewport" content="width=device-width, initial-scale=1.0">
