<!DOCTYPE html>
<html>
<head>
  <title>PRODUCTOS</title>
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

// Función para actualizar los datos en la base de datos
function actualizarDatos($id, $precio, $stock) {
    $servername = "localhost";
    $database = "id20017664_xiroeatsbd";
    $username = "id20017664_mezaydyo";
    $password = "Mc02032023.";

    $con = mysqli_connect($servername, $username, $password, $database);

    $id = mysqli_real_escape_string($con, $id);
    $query = "UPDATE productos SET ";
    $updateFields = array();

    if ($precio !== '') {
        $nuevoPrecio = mysqli_real_escape_string($con, $precio);
        $updateFields[] = "precio='$nuevoPrecio'";
    }

    if ($stock !== '') {
        $nuevoStock = mysqli_real_escape_string($con, $stock);
        $updateFields[] = "stock='$nuevoStock'";
    }

    $updateFieldsStr = implode(", ", $updateFields);

    $query .= $updateFieldsStr;
    $query .= " WHERE referencia='$id'";

    mysqli_query($con, $query);

    mysqli_close($con);
}

// Verificar si se ha enviado el formulario de actualización
if (isset($_POST['actualizar_datos'])) {
    $productoId = $_POST['productoId'];
    $nuevoPrecio = $_POST['nuevoPrecio'];
    $nuevoStock = $_POST['nuevoStock'];

    actualizarDatos($productoId, $nuevoPrecio, $nuevoStock);
}

// Construir la consulta SQL con la cláusula WHERE según el estado seleccionado
$query = "SELECT * FROM productos";
if ($estadoFiltro != '') {
    $query .= " WHERE tipo='$estadoFiltro'";
}
$result = mysqli_query($con, $query);

echo "<header>";
echo "<h1>XiroEats | Gestión Interna</h1>";
echo "<div class='pedidos-button'>";
echo "        <a href='indexchef.php'>Pedidos</a>";
echo "        <a href='../../index.html'>Cerrar Sesión</a>";
echo "</div>";
echo "</header>";

// Botones de filtro
echo "<div class='filter-buttons'>";
echo "<p style='color:white'>Seleccione el filtro deseado: </p>";
echo "<a href='?estado='>Todos</a>";
echo "<a href='?estado=entrante'>Entrantes</a>";
echo "<a href='?estado=primero'>Primero</a>";
echo "<a href='?estado=segundo'>Segundo</a>";
echo "<a href='?estado=postre'>Postres</a>";
echo "<a href='?estado=bebida'>Bebidas</a>";
echo "</div>";

echo "<div class='menu-container'>";

while ($registro = mysqli_fetch_array($result)) {
    echo "<div class='product'>";
    echo "<h2>" . $registro[1] . "</h2>";

    echo "<p>Precio Actual: " . $registro[3] . " €</p>";
    echo "<p>Stock: " . $registro[4] . " raciones</p>";

    echo "<form action='".$_SERVER['PHP_SELF']."' method='post'>";
    echo "<input type='hidden' name='productoId' value='$registro[0]'>";
    echo "<div class='inputs'>";
        echo "<label for='nuevoPrecio'>Nuevo Precio:</label>";
        echo "<input type='number' name='nuevoPrecio' step='0.01'><br>";
        echo "<label for='nuevoStock'>Nuevo Stock:</label>";
        echo "<input type='number' name='nuevoStock'><br>";
    echo "</div>";
    echo "<input type='submit' name='actualizar_datos' value='Actualizar datos' style='background-color: #499DDF; color: white; margin-bottom: 5px;'>";
    echo "</form>";
    
    echo "</div>";

}

echo "</div>";

mysqli_close($con);
?>

</body>
</html>
