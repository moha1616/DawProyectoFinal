<?php
    $servername = "localhost";
    $database = "id20017664_xiroeatsbd";
    $username = "id20017664_mezaydyo";
    $password = "Mc02032023.";
    
    $mysqli = new mysqli($servername, $username, $password, $database);
    $mysqli->set_charset("utf8");
    
    
    //Muestra en la pagina si hay conexión
    if($mysqli){
        echo "<p style='
        display: table-cell;
        background: #cacaca00;
        bottom: 0;
        position: fixed;
        z-index: +1;
        vertical-align: middle;
        color: #5cbc04;
        opacity: 25%;
        '>0</p>";
    }
?>