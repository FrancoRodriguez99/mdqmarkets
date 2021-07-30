<?php

require 'database.php';

session_start();
 if (isset($_SESSION['user_log'])) {
   $records = $fra30->prepare('SELECT dni, nombre, pass FROM clientes WHERE dni = :dni');
   $records->bindParam(':dni', $_SESSION['user_log']);
    $records->execute();
    $results = $records->fetch(PDO::FETCH_ASSOC);
   $user = null;

    if (count($results) > 0) {
      $user = $results;
  }

  	
  
  }else{
  	header('Location: index.php');
  }

  $nose = $user['dni'];



  if(isset($_POST['agregardirec']) && !empty($_POST['agregardirec'])){




  	$direcc = $_POST['direcc'];
    $entrecall = $_POST['entrecall'];
    $telef = $_POST['telef'];


  	$sql = "INSERT INTO domicilios (direcc, entrecall, telef) VALUES ('$direcc', '$entrecall', '$telef')";

if(mysqli_query($fra31, $sql)){


	$last_id = $fra31->insert_id;

	$sql = "UPDATE clientes SET domicid = CONCAT_WS(',' , domicid , $last_id ) WHERE dni = '$nose'";

	if(mysqli_query($fra31, $sql)){

		}else{
  echo "ERROR: Could not able to execute $sql. " . mysqli_error($fra31);
}

}else{
  echo "ERROR: Could not able to execute $sql. " . mysqli_error($fra31);
}
  }



if(isset($_POST['comprar']) && !empty($_POST['comprar'])){

	foreach($_SESSION["shopping_cart"] as $keys => $values)
						{
                            $listaprod = "";
                            $listacant = '';
                            $listaprec = '';

                            echo $listaprod;

							$listprod = $listaprod . ',' . $values["item_name"];
							$listcant = $listacant . ',' . $values["item_quantity"];
							$listprec = $listaprec . ',' . $values["item_price"]; 
							$metopag = $_POST['metodo'];
							$direcc = $_POST['direcoption'];
							$total = $values["item_price"]; 

							}


						


	$sql = "INSERT INTO tickets (prods, cantidads, precios, total, metopag, direcc) VALUES ('$listprod', '$listcant', '$listprec', '$total', '$metopag', '$direcc')";


if(mysqli_query($fra31, $sql)){

  echo 'Agregado con éxito';

}else{
  echo "ERROR: Could not able to execute $sql. " . mysqli_error($fra31);
}


}




  ?>




<div></div>
			<br />
			<h3>Carro de Compras</h3>
			<div>
				<table>
					<tr>
						<th >Producto</th>
						<th >Cantidad</th>
						<th >Precio</th>
						<th >Total</th>
						<th >Eliminar</th>
					</tr>
					<?php
					if(!empty($_SESSION["shopping_cart"]))
					{
						$total = 0;
						foreach($_SESSION["shopping_cart"] as $keys => $values)
						{
					?>
					<tr>
						<td><?php echo $values["item_name"]; ?></td>
						<td><?php echo $values["item_quantity"]; ?></td>
						<td>$ <?php echo $values["item_price"]; ?></td>
						<td>$ <?php echo number_format($values["item_quantity"] * $values["item_price"], 2);?></td>
						<td><a href="tienda.php?action=delete&id=<?php echo $values["item_id"]; ?>"><span >Eliminar</span></a></td>
					</tr>
					<?php
							$total = $total + ($values["item_quantity"] * $values["item_price"]);
						}
					?>
					<tr>
						<td >Total</td>
						<td >$ <?php echo number_format($total, 2); ?></td>
						<td>
							
                          <form method="post" action="comprar.php">

                          	<select name="metodo" required>
                            <option value="1">Efectivo</option>
                            <option value="2">Debito (Recurde tener DNI)</option>
                            </select>


                          	<input type="submit" name="comprar" value="Comprar">
                          	

                          





						</td>
					</tr>



					<?php
					}
					?>
						
				</table>
			</div>
		</div>
	</div>
	<br />



	<select name="direcoption" required>

		
		
 
<?php


     $q = "SELECT domicid FROM clientes WHERE dni = '$nose'";
$result = mysqli_query($fra31, $q);
if(mysqli_num_rows($result) > 0)
				{
					while($row = mysqli_fetch_array($result))
					{
$id=$row['domicid']; 
}

}

$id=explode(",",$id); 
$t=count($id);


$i = 0;
while($i <= $t){

	$q = "SELECT * FROM domicilios WHERE domicid = '$id[$i]'";
   $result = mysqli_query($fra31, $q);
	if(mysqli_num_rows($result) > 0)
				{
					while($row = mysqli_fetch_array($result))
					{

                        ?>
                        <option value="<?php echo $row["domicid"]; ?>"><?php

						echo $row["direcc"];

						echo " ";


						echo $row["telef"];



						?></option><?php
    
    }
    

    }
   

   $i++;

    ?>

    
    <?php

}
    ?>






			</select>
 
	</form>
 <form method="post" action="comprar.php">
     <input name="direcc" type="text" placeholder="Direccion + Altura" required>
     <input name="entrecall" type="text" placeholder="Entre Calles" required>
     <input name="telef" type="tel" placeholder="Numero de Contacto" required>
     <input type="submit" name="agregardirec" value="Agregar Dirección">

 </form>


	<a href="tienda.php">
   <button>Volver a La tienda</button>
</a>
	</body>
</html>