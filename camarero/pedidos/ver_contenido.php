<!DOCTYPE html>
<html>
<head>
  <title>PEDIDOS</title>
  <link rel="stylesheet" type="text/css" href="../style.css">
  <link rel="stylesheet" type="text/css" href="../style2.css">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body background='XiroEats.png'>

<?php
$servername = "localhost";
$database = "id20017664_xiroeatsbd";
$username = "id20017664_mezaydyo";
$password = "Mc02032023.";

$con = mysqli_connect($servername, $username, $password, $database);

$pedidoId = $_POST['pedidoId'];

$query = "SELECT * FROM linea_pedido WHERE id_pedido='$pedidoId'";
$result = mysqli_query($con, $query);

echo "<header>";
echo "<h1>XiroEats | Pedido $pedidoId</h1>";
echo "<div class='pedidos-button'>";
echo "        <a href='pedidos.php'>Volver</a>";
echo "</div>";
echo "</header>";
echo "<div class='menu-container'>";

while ($registro = mysqli_fetch_array($result)) {
    echo "<div class='product'>";
    echo "<h2>Producto " . $registro[0] . "</h2>";
    
    $query2 = "SELECT * FROM productos WHERE referencia='$registro[1]'";
    $result2 = mysqli_query($con, $query2);
    if ($registro2 = mysqli_fetch_array($result2)){
        $nombre=$registro2[1];
        $tipo=$registro2[2];
    }
    
    echo "<p>Nombre: " . $nombre . "</p>";
    echo "<p>Clase: " . $tipo . "</p>";
    echo "<p>Precio: " . $registro[3] . " €</p>";
    echo "</div>";

}

echo "</div>";

mysqli_close($con);
?>




</body>
</html>