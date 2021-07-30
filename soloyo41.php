<?php
session_start();

require 'database.php';


if(isset($_POST['agregar']) && !empty($_POST['agregar'])){

  $id = $_POST['id'];

    

 $sql_id = "SELECT * FROM productos WHERE id='$id'";
    $res_id = mysqli_query($fra31, $sql_id);
    if (mysqli_num_rows($res_id) > 0) {
      echo 'Este Codigo de Barras ya esta registrado.';   
    }else{

    $prod = $_POST['prod'];
    $descr = $_POST['descr'];
    $precio_ven = $_POST['precio_ven'];
    $precio_cos = $_POST['precio_cos'];
    $volum = $_POST['volum'];
    $categ = implode(',',$_POST['categ']);
    $stock = $_POST['stock'];
    $venci = $_POST['venci'];
    $tag = $_POST['tag'];
    $imagen = $_FILES['imagen'];
    $filename = $_FILES['imagen']['name'];
    $filetmpname = $_FILES['imagen']['tmp_name'];
    $filesize = $_FILES['imagen']['size'];
    $fileerror = $_FILES['imagen']['error'];
    $fileext = explode('.',$filename);
    $fileactualext = strtolower(end($fileext));
    $allowed = array('jpg', 'jpeg', 'png');
    if(in_array($fileactualext, $allowed)){
        if($fileerror == 0){
            if($filesize < 50000){
                $filedestination = 'img/'.$filename;
                move_uploaded_file($filetmpname, $filedestination);
                $we =  'img/'.$id.'.png';
                rename($filedestination,$we);}else{
                echo "imagen demasiado grande";
            }

        }else{
            echo "error subiendo la imagen";
        }

    }else{
        echo "formato de la imagen erroneo";
    }
                


$sql = "INSERT INTO productos (id, prod, descr, precio_ven, precio_cos, volum, tag, categ, stock, venci) VALUES ('$id', '$prod', '$descr', '$precio_ven', '$precio_cos', '$volum', '$tag', '$categ','$stock', '$venci')";

if(mysqli_query($fra31, $sql)){

  echo 'Agregado con éxito';

}else{
  echo "ERROR: Could not able to execute $sql. " . mysqli_error($fra31);
}
                

            
}




//Separacion para el edit





  }else{
    if(isset($_POST['edit']) && !empty($_POST['edit'])) {

      $id = $_POST['id'];

    $sql_id = "SELECT * FROM productos WHERE id='$id'";
    $res_id = mysqli_query($fra31, $sql_id);
    
         if (mysqli_num_rows($res_id) == 0) {
              echo 'Este Codigo de Barras No Existe.';   

              } 
    else{


      $prod = $_POST['prod'];
    $descr = $_POST['descr'];
    $precio_ven = $_POST['precio_ven'];
    $precio_cos = $_POST['precio_cos'];
    $volum = $_POST['volum'];
    $categ = implode(',',$_POST['categ']);
    $stock = $_POST['stock'];
    $venci = $_POST['venci'];
    $tag = $_POST['tag'];
    $imagen = $_FILES['imagen'];
    $filename = $_FILES['imagen']['name'];
    $filetmpname = $_FILES['imagen']['tmp_name'];
    $filesize = $_FILES['imagen']['size'];
    $fileerror = $_FILES['imagen']['error'];
    $fileext = explode('.',$filename);
    $fileactualext = strtolower(end($fileext));
    $allowed = array('jpg', 'jpeg', 'png');
    if(in_array($fileactualext, $allowed)){
        if($fileerror == 0){
            if($filesize < 50000){
                $filedestination = 'img/'.$filename;

                

                move_uploaded_file($filetmpname, $filedestination);
                $we =  'img/'.$id.'.png';
                rename($filedestination,$we);
            }else{
                echo "imagen demasiado grande";
            }

        }else{
            echo "error subiendo la imagen";
        }

    }else{
        echo "formato de la imagen erroneo";
    }
                
                
               $sql = "UPDATE productos SET prod = '$prod', descr = '$descr',precio_ven = '$precio_ven',precio_cos = '$precio_cos',volum = '$volum',categ = '$categ',venci = '$venci',tag = '$tag' WHERE id='$id'";
   if(mysqli_query($fra31, $sql)){

  echo 'Editado con éxito';

}else{
  echo "ERROR: Could not able to execute $sql. " . mysqli_error($fra31);
}

                


   


   

}
}

  


   }







if(isset($_POST['delete']) && !empty($_POST['delete'])) {
  

  $id = $_POST['id'];

    $sql_id = "SELECT * FROM productos WHERE id='$id'";
    $res_id = mysqli_query($fra31, $sql_id);
    
         if (mysqli_num_rows($res_id) == FALSE) {
              echo 'Este Codigo de Barras No Existe.';   

              } 
    else{

     
      $sql = "DELETE FROM productos WHERE id = '$id'";

if(mysqli_query($fra31, $sql)){

  $file = 'img/'.$id.'.png';

  unlink($file);

  echo 'Eliminado con éxito';

}else{
  echo "ERROR: Could not able to execute $sql. " . mysqli_error($fra31);
}


    }
}



if(isset($_POST['hide']) && !empty($_POST['hide'])){

  $id = $_POST['id'];

    $sql_id = "SELECT * FROM productos WHERE id='$id'";
    $res_id = mysqli_query($fra31, $sql_id);

    
    
    
         if (mysqli_num_rows($res_id) == FALSE) {
              echo 'Este Codigo de Barras No Existe.';   

              } 
    else{


      $sql = "UPDATE productos SET ocul = !ocul   WHERE id='$id'";
   if(mysqli_query($fra31, $sql)){


    while($row = mysqli_fetch_array($res_id))
          {

             $ka = $row["ocul"];

          }


   if($ka == TRUE){
   
   echo 'Visible';

   }else{

   if($ka == FALSE){

    echo 'Ocultado';

   }

   }

}else{
  echo "ERROR: Could not able to execute $sql. " . mysqli_error($fra31);
}


    }



}


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

  



  if ( $user['dni'] == "41669448"){



  	?>
    <!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Registro</title>
</head>
<body>

  	<form action="soloyo41.php" method="POST" enctype="multipart/form-data">
<input name="id" type="number" placeholder="Código de Barras" required>
<input name="prod" type="text" placeholder="Nombre del Producto" required>
<input name="descr" type="text" placeholder="Descripción breve" required>
<input name="precio_ven" type="number" placeholder="Precio de Venta" required>
<input name="precio_cos" type="number" placeholder="Precio de Costo" >
<input name="volum" type="text" placeholder="Volumen">
<select name="categ[]" multiple required>
  <option value="1">cat 1</option>
  <option value="2">cat 2</option>
  <option value="3">cat 3</option>
  <option value="4">cat 4</option>
</select>
<input name="stock" type="number" placeholder="Cantidad" >
<input name="venci" type="date" placeholder="Vencimiento">
<input name="tag" type="text" placeholder="Tags" required>
<input type="file" name="imagen" placeholder="Imagen" required>



<input type="submit" name="agregar" value="Crear Nuevo Producto">
<input type="submit" name="edit" value="Editar Existente Producto">
</form>

<br><br>

<form action="soloyo41.php" method="POST">
  <input name="id" type="number" placeholder="Código de Barras" required>
  <input type="submit" name="delete" value="ELIMINAR">
  <input type="submit" name="hide" value="OCULTAR/MOSTRAR">

</form>

<a href='tienda.php'>Tienda</a>

</body>
</html>

<?php


  }else{
  	header('Location: tienda.php');
  }



     




  






?>