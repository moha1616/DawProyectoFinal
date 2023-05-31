<?php
    
$usuario = $_POST["username"];
$contrasena = $_POST["pass"];

$servername = "localhost";
$database = "id20017664_xiroeatsbd";
$username = "id20017664_mezaydyo";
$password = "Mc02032023.";
  
$con = mysqli_connect($servername, $username, $password, $database);

    
$query = "SELECT * FROM usuarios WHERE username='$usuario' AND password='$contrasena'";
$result = mysqli_query($con,$query);

if($registro = mysqli_fetch_array($result)){
    if($registro[2]=="camarero")
    header('Location:../camarero/camarero.php');
    else
    header('Location:../chef/indexchef.php');

}
else{
    header('Location:../index.html');
}

?>