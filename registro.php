<?php

require 'database.php';

$message = '';





if (!empty($_POST['nombre']) && !empty($_POST['apellido']) && !empty($_POST['dni'])) {
	$conf_pass = $_POST['conf_pass'];
    $pass = $_POST['pass'];
    $dni = $_POST['dni'];
    $email = $_POST['email'];
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];


    $sql_dni = "SELECT * FROM clientes WHERE dni='$dni'";
    $res_dni = mysqli_query($fra31, $sql_dni);
    if (mysqli_num_rows($res_dni) > 0) {
  	  echo 'Este DNI ya esta registrado.'; 	
  	}else{




if ($pass == $conf_pass) {

$sql = "INSERT INTO clientes (dni, nombre, apellido, pass, email) VALUES (:dni, :nombre, :apellido, :pass, :email)";
$stmt = $fra30->prepare($sql);
$stmt->bindParam(':dni', $_POST['dni']);
$stmt->bindParam(':nombre', $_POST['nombre']);
$stmt->bindParam(':apellido', $_POST['apellido']);
$pass = password_hash($_POST['pass'], PASSWORD_BCRYPT);
$stmt->bindParam(':pass', $pass);
$stmt->bindParam(':email', $_POST['email']);

if($stmt->execute()){

	$message = 'Registrado con éxito';
}else{

$message = 'Error del servidor, inténtelo de nuevo mas tarde.';
}
}else {
  
  echo 'Las contraseñas no coinciden';

}

}
}




?>


<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Registro</title>
</head>
<body>

<?php require 'partes/header.php' ?>

 <?php if(!empty($message)): ?>
      <p> <?= $message ?></p>
    <?php endif; ?>

<form action="registro.php" method="POST">
<input name="nombre" type="text" placeholder="Ingrese su Nombre" required>
<input name="apellido" type="text" placeholder="Ingrese su Apellido" required>	
<input name="dni" type="number"  min="0" step="1" placeholder="Ingrese su DNI" maxlength="13" required> 
<input name="pass" type="password" placeholder="Crea una Contraseña" required>
<input name="conf_pass" type="password" placeholder="Confirmar Contraseña" required>
<input name="email" type="text" placeholder="Ingrese su email">
<input type="submit" value="Enviar">
</form>

</body>
</html>