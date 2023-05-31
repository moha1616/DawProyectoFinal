<!DOCTYPE html>
<html>
<head>
  <title>PEDIDOS</title>
  <link rel="stylesheet" type="text/css" href="style.css">
  <link rel="stylesheet" type="text/css" href="style2.css">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body background='XiroEats.png'>

<?php
$servername = "localhost";
$database = "id20017664_xiroeatsbd";
$username = "id20017664_mezaydyo";
$password = "Mc02032023.";

$con = mysqli_connect($servername, $username, $password, $database);

// Obtener el estado seleccionado del filtro
$estadoFiltro = isset($_GET['estado']) ? $_GET['estado'] : '';

// Construir la consulta SQL con la cláusula WHERE según el estado seleccionado
$query = "SELECT * FROM pedidos";
if ($estadoFiltro != '') {
    $query .= " WHERE estado='$estadoFiltro'";
}
$result = mysqli_query($con, $query);

echo "<header>";
echo "<h1>XiroEats | Gestión Interna</h1>";
echo "<div class='pedidos-button'>";
echo "        <a href='productos.php'>Productos</a>";
echo "        <a href='../../index.html'>Cerrar Sesión</a>";
echo "</div>";
echo "</header>";

// Botones de filtro
echo "<div class='filter-buttons'>";
echo "<p style='color:white'>Seleccione el filtro deseado: </p>";
echo "<a href='?estado='>Todos</a>";
echo "<a href='?estado=nuevo'>Nuevos</a>";
echo "<a href='?estado=listo'>Listos</a>";
echo "<a href='?estado=servido'>Recogidos</a>";
echo "<a href='?estado=pagado'>Completados</a>";
echo "</div>";

echo "<div class='menu-container'>";

while ($registro = mysqli_fetch_array($result)) {
    echo "<div class='product'>";
    echo "<h2>Pedido " . $registro[0] . "</h2>";

    $query2 = "SELECT username FROM usuarios WHERE id='$registro[1]'";
    $result2 = mysqli_query($con, $query2);
    if ($registro2 = mysqli_fetch_array($result2))
        $username = $registro2[0];

    echo "<p>Camarero: " . $username . "</p>";
    echo "<p>Mesa: " . $registro[2] . "</p>";
    echo "<p>Importe: " . $registro[2] . " €</p>";
    echo "<p>Estado: <strong>" . $registro[3] . "</strong></p>";

    // Verificar el estado del pedido y mostrar solo el botón correspondiente
    if ($registro[3] == "nuevo") {
        echo "<form action='actualizar_estado.php' method='post'>";
        echo "<input type='hidden' name='pedidoId' value='$registro[0]'>";
        echo "<input type='submit' name='listo' value='Listo' style='background-color: #144F7A; margin-bottom: 5px;'>";
        echo "</form>";
    } elseif ($registro[3] == "listo") {

        echo "<input type='submit' name='' value='A recoger' style='background-color: grey; margin-bottom: 5px;'>";
        
    } elseif ($registro[3] == "servido") {
        echo "<input type='submit' name='' value='Recogido' style='background-color: grey; color: white; margin-bottom: 5px;'>";
    } elseif ($registro[3] == "pagado") {
        echo "<form action='ver_ticket.php' method='post'>";
        echo "<input type='hidden' name='pedidoId' value='$registro[0]'>";
        echo "<input type='submit' name='listo' value='Ver Ticket' style='background-color: #144F7A; margin-bottom: 5px;'>";
        echo "</form>";
    }
    
    echo "<form action='ver_contenido.php' method='post'>";
    echo "<input type='hidden' name='pedidoId' value='$registro[0]'>";
    echo "<input type='submit' name='ver_contenido' value='Ver contenido' style='background-color: #499DDF; color: white; margin-bottom: 5px;'>";
    echo "</form>";
    
    echo "</div>";

}

echo "</div>";

mysqli_close($con);
?>

</body>
</html>