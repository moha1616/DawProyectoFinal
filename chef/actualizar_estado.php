<?php
$servername = "localhost";
$database = "id20017664_xiroeatsbd";
$username = "id20017664_mezaydyo";
$password = "Mc02032023.";

$con = mysqli_connect($servername, $username, $password, $database);

if (isset($_POST['pedidoId'])) {
    $pedidoId = $_POST['pedidoId'];

    if (isset($_POST['listo'])) {
        $updateQuery = "UPDATE pedidos SET estado='listo' WHERE referencia='$pedidoId'";
        mysqli_query($con, $updateQuery);
    }
}

mysqli_close($con);

// Redireccionar de vuelta a la página anterior
header("Location: ".$_SERVER['HTTP_REFERER']);
exit();
?>