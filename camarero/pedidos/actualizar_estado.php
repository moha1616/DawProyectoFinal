<?php
$servername = "localhost";
$database = "id20017664_xiroeatsbd";
$username = "id20017664_mezaydyo";
$password = "Mc02032023.";

$con = mysqli_connect($servername, $username, $password, $database);

if (isset($_POST['pedidoId'])) {
    $pedidoId = $_POST['pedidoId'];

    if (isset($_POST['servido'])) {
        $updateQuery = "UPDATE pedidos SET estado='servido' WHERE referencia='$pedidoId'";
        mysqli_query($con, $updateQuery);
    } elseif (isset($_POST['pagado'])) {
        $updateQuery = "UPDATE pedidos SET estado='pagado' WHERE referencia='$pedidoId'";
        mysqli_query($con, $updateQuery);
    }
}

mysqli_close($con);

// Redireccionar de vuelta a la página anterior
header("Location: ".$_SERVER['HTTP_REFERER']);
exit();
?>
