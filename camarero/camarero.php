<?php
session_start(); // Iniciamos la sesión antes de cualquier salida

$servername = "localhost";
$database = "id20017664_xiroeatsbd";
$username = "id20017664_mezaydyo";
$password = "Mc02032023.";

$con = mysqli_connect($servername, $username, $password, $database);

$query = "SELECT * FROM productos";
$tipoFilter = isset($_GET['tipo']) ? $_GET['tipo'] : ''; // Obtener el tipo de filtro seleccionado

// Aplicar filtro por tipo si se selecciona uno
if (!empty($tipoFilter)) {
  $query .= " WHERE tipo = '$tipoFilter'";
}

$result = mysqli_query($con, $query);

if (isset($_POST['remove_index'])) {
  $remove_index = $_POST['remove_index'];
  if (isset($_SESSION['cart'][$remove_index])) {
    unset($_SESSION['cart'][$remove_index]);
    $_SESSION['cart'] = array_values($_SESSION['cart']);
  }
}

// Procesar pedido
if (isset($_POST['place_order'])) {
  // Validar y obtener los datos del formulario
  $mesa = $_POST['mesa'];
  $usuario = $_POST['usuario'];

  // Insertar en tabla "pedidos"
  $estado = "nuevo";

  // Calcular el importe total de la cesta
  $importe = 0;
  if (isset($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $item) {
      $importe += $item['price'];
    }
  }
  
  // Identificamos el id del usuario que realiza el pedido.
  $id_with_username = "SELECT id FROM usuarios WHERE username='$usuario'";
  $id = mysqli_query($con, $id_with_username);
  if ($registro1 = mysqli_fetch_array($id))
    $id_usuario = $registro1[0];

  // Insertar el pedido en la base de datos
  $insert_pedido_query = "INSERT INTO pedidos (id_usuario, mesa, estado, importe) VALUES ('$id_usuario', '$mesa', '$estado', '$importe')";
  mysqli_query($con, $insert_pedido_query);

  $id_pedido = mysqli_insert_id($con); // Obtener el ID del pedido recién insertado

  // Insertar en tabla "linea_pedido" por cada producto en la cesta
  if (isset($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $item) {
      $ref_producto = $item['id'];
      $precio = $item['price'];

      $insert_linea_pedido_query = "INSERT INTO linea_pedido (ref_producto, id_pedido, precio) VALUES ('$ref_producto', '$id_pedido', '$precio')";
      mysqli_query($con, $insert_linea_pedido_query);

      // Restar stock del producto
      $update_stock_query = "UPDATE productos SET stock = stock - 1 WHERE referencia = '$ref_producto'";
      mysqli_query($con, $update_stock_query);
    }
  }

  // Limpiar la cesta después de realizar el pedido
  unset($_SESSION['cart']);
  header('Location: camarero.php'); // Redirigir a la página principal u otra página de confirmación
  exit();
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>XiroEats | Panel camareros</title>
  <link rel="stylesheet" type="text/css" href="style.css">
  <link rel="stylesheet" type="text/css" href="style2.css">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body background='XiroEats.png'>
  <header>
    <h1>XiroEats | Gestión clientes</h1>
    <div class="pedidos-button">
        <a href="pedidos/pedidos.php">Pedidos</a>
        <a href="../index.html">Cerrar Sesión</a>

    </div>
  </header>
  
  <div class="filter-buttons">
    <p style="color:white">Seleccione el filtro deseado:</p>
    <a href="camarero.php">Todos</a>
    <a href="camarero.php?tipo=Entrante">Entrante</a>
    <a href="camarero.php?tipo=Primero">Primero</a>
    <a href="camarero.php?tipo=Segundo">Segundo</a>
    <a href="camarero.php?tipo=Postre">Postre</a>
    <a href="camarero.php?tipo=Bebida">Bebida</a>
  </div>
  
  <div class='menu-container'>
        <?php
        while ($registro = mysqli_fetch_array($result)) {
          echo "<div class='product'>";
          echo "<img src='" .$registro[5]. "'alt='Producto 1'>";
          echo "<h2>" . $registro[1] . "</h2>";
          echo "<p> Clase: <strong>" . $registro[2] . "</strong></p>";
          echo "<p> Precio actual<strong>: " . $registro[3] . "€</strong></p>";
          echo "<p> Stock: <strong>" . $registro[4] . " raciones</strong></p>";
          echo "<form action='' method='post'>";
          echo "<input type='hidden' name='product_id' value='" . $registro[0] . "'>";
          echo "<input type='hidden' name='product_name' value='" . $registro[1] . "'>";
          echo "<input type='hidden' name='product_price' value='" . $registro[3] . "'>";
          
          if($registro[4]>0){
          echo "<input type='submit' name='add_to_cart' value='Añadir al pedido'>";
          echo "</form>";
          } else {
              echo "<br/>";
              echo "<p style='color:red'>Sin stock !!</p>";
          echo "</form>";
          }
          echo "</div>";
        }
        ?>
  </div>
  
  <div id="cart-container">
    <div id="cart">
      <h2>Gestión pedido actual:</h2>
      <?php
      if (isset($_POST['add_to_cart'])) {
        if (!isset($_SESSION['cart'])) {
          $_SESSION['cart'] = array();
        }
          
        $product_id = $_POST['product_id'];
        $product_name = $_POST['product_name'];
        $product_price = $_POST['product_price'];

        $_SESSION['cart'][] = array('id' => $product_id, 'name' => $product_name, 'price' => $product_price);
      }

      if (isset($_SESSION['cart'])) {
        $total = 0;
        foreach ($_SESSION['cart'] as $key => $item) {
          echo "<div class='cart-item'>";
          echo "<p><strong>" . $item['name'] . "</strong>: " . $item['price'] . " €</p>";
          echo "<form action='' method='post'>";
          echo "<input type='hidden' name='remove_index' value='" . $key . "'>";
          echo "<input type='submit' name='remove_from_cart' value='x'>";
          echo "</form>";
          echo "</div>";
          $total += $item['price'];
        }
        echo "<p><strong>Importe total:</strong>" . $total . " €</p>";
        echo "<button class='order-button' onclick='showOrderForm()'>Realizar pedido</button>";
      }
      ?>
    </div>
  </div>
  
  <div id="order-form-container" style="display: none;">
    <form action="" method="post" id="order-form">
      <h2>Realizar Pedido</h2>
      <label for="mesa">Número de Mesa:</label>
      <input type="text" id="mesa" name="mesa" required><br>
      <label for="usuario">Nombre de Usuario:</label>
      <input type="text" id="usuario" name="usuario" required><br>
      <input type="submit" name="place_order" value="Confirmar Pedido">
    </form>
  </div>
  
  <a href="#cart-container">
      <img class="floating-button" src="cesta.png"/>
  </a>
  
  <script>
    function showOrderForm() {
      var orderFormContainer = document.getElementById('order-form-container');
      orderFormContainer.style.display = 'block';
    }
  </script>
</body>
</html>
