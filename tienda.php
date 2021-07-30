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





?>


      <br> Hola! <?= $user['nombre']; ?>




      <a href="logout.php">
        Desconectarse.
      </a>

      <?php


      if(isset($_POST["add_to_cart"]))
{
	if(isset($_SESSION["shopping_cart"]))
	{
		$item_array_id = array_column($_SESSION["shopping_cart"], "item_id");
		if(!in_array($_GET["id"], $item_array_id))
		{
			$count = count($_SESSION["shopping_cart"]);
			$item_array = array(
				'item_id'			=>	$_GET["id"],
				'item_name'			=>	$_POST["hidden_name"],
				'item_price'		=>	$_POST["hidden_price"],
				'item_quantity'		=>	$_POST["quantity"]
			);
			$_SESSION["shopping_cart"][$count] = $item_array;
		}
		else
		{
			echo 'Este Producto ya se encuentra en su carro, si desea cambiar la cantidad hágalo desde el carrito.';
		}
	}
	else
	{
		$item_array = array(
			'item_id'			=>	$_GET["id"],
			'item_name'			=>	$_POST["hidden_name"],
			'item_price'		=>	$_POST["hidden_price"],
			'item_quantity'		=>	$_POST["quantity"]
		);
		$_SESSION["shopping_cart"][0] = $item_array;
	}
}

if(isset($_GET["action"]))
{
	if($_GET["action"] == "delete")
	{
		foreach($_SESSION["shopping_cart"] as $keys => $values)
		{
			if($values["item_id"] == $_GET["id"])
			{
				unset($_SESSION["shopping_cart"][$keys]);
				echo 'Producto removido';
			}
		}
	}
}




$q = "SELECT * FROM productos ORDER BY stock ASC";
$result = mysqli_query($fra31, $q);

if(mysqli_num_rows($result) > 0)
				{
					while($row = mysqli_fetch_array($result))
					{?>


						<div>
				<form method="post" action="tienda.php?action=add&id=<?php echo $row["id"]; ?>">
					<div>
						<img src="img/<?php echo $row["id"]; ?>.png" class="img-responsive" /><br />

						<input type="hidden" name="hidden_name" value="<?php echo $row["prod"]; ?>" />

						<input type="hidden" name="hidden_price" value="<?php echo $row["precio_ven"]; ?>" />

						<h4 class="text-info"><?php echo $row["prod"]; ?></h4>

						<h4 class="text-info"><?php echo $row["descr"]; ?></h4>

						<h4 class="text-info"><?php echo $row["volum"]; ?></h4>

						<h4 class="text-danger">$ <?php echo $row["precio_ven"]; ?></h4>

						<input type="text" name="quantity" value="1" class="form-control" />


						<input type="submit" name="add_to_cart" value="Añadir a la compra" />

					</div>
				</form>
			</div>
			<?php
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
							
                          <a href="comprar.php">
                          	<button>Comprar</button>

                          </a>

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
	</body>
</html>



			<?php
			


			if ( $user['dni'] == "41669448"){

             ?>

             <a href='soloyo41.php'>Admin</a>

<?php
			}

						?>
