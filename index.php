<?php
  session_start();

  require 'database.php';

  if (isset($_SESSION['user_log'])) {
   $records = $fra30->prepare('SELECT dni, nombre, pass FROM clientes WHERE dni = :dni');
   $records->bindParam(':dni', $_SESSION['user_log']);
    $records->execute();
    $results = $records->fetch(PDO::FETCH_ASSOC);
   $user = null;

    if (count($results) > 0) {
      $user = $results;
  }
  }


?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title> Bienvenido!</title>
</head>
<body>

<?php require 'partes/header.php' ?>
<?php if(!empty($user)): ?>
      <br> Hola! <?= $user['nombre']; ?>
      <a href="logout.php">
        Desconectarse.
      </a>
    <?php 
   // header('Location: tienda.php');

    else: ?>
      


<h1> Por Favor, Ingrese o Regístrese<h1>

<a href="login.php">Ingresar</a>

<a href="registro.php">Registrarse</a>

<?php endif; ?>

</body>
</html>