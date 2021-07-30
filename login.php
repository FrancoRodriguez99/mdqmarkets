  
<?php

  session_start();

   require 'database.php';

  if (isset($_SESSION['user_log'])) {
    header('Location: index.php');
  }
 

  if (!empty($_POST['dni']) && !empty($_POST['pass'])) {
    $records = $fra30->prepare('SELECT dni, nombre, pass FROM clientes WHERE dni = :dni');
    $records->bindParam(':dni', $_POST['dni']);
    $records->execute();
    $results = $records->fetch(PDO::FETCH_ASSOC);

    $message = '';

    if (count($results) > 0 && password_verify($_POST['pass'], $results['pass'])) {
      header("Location: tienda.php");
      $_SESSION['user_log'] = $results['dni'];
    } else {
      $message = 'El DNI o La Contraseña son incorrectas';
    }
  }

?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Ingreso</title>
</head>
<body>

<?php require 'partes/header.php' ?>

 <?php if(!empty($message)): ?>
      <p> <?= $message ?></p>
    <?php endif; ?>

<form action="login.php" method="post">
<input type="text" name="dni" placeholder="Ingrese su DNI">
<input type="password" name="pass" placeholder="Contraseña">
<input type="submit" value="send">
</form>

</body>
</html>