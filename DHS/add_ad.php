<?php 

	include('config/db_connect.php');

	$name = $link = '';
	$errors = array('name'=>'', 'link'=>'');
	
	
	if(isset($_POST['submit'])){


		if(empty($_POST['name'])){
			$errors['name'] = 'A name is required <br />';
		} else{
			$name = $_POST['name'];
			if(!preg_match('/^([a-zA-Z\s]+)(,\s*[a-zA-Z\s]*)*$/', $name)){
				$errors['name'] = 'name must letters and spaces only';
			}
		}

		if (array_filter($errors)){
			//echo 'errors in the form';
		} else{
			//echo 'form is valid';
			//save in database

			

			$name = mysqli_real_escape_string($conn, $_POST['name']);
			$link = mysqli_real_escape_string($conn, $_POST['link']);
			

			$sql = "INSERT INTO ad(name, link) VALUES('$name', '$link')";
			
			
			if($link != ''){
				if(mysqli_query($conn, $sql)){
				//success
					header('Location: ad.php');
				} else{
					echo 'query error: ' . mysqli_error($conn);
					
				}
			}else{
				echo 'please add a link';
			}
			
			//save to db and check
		
		}
	}


?>



<!DOCTYPE html>
<html>

	<?php include('templates/header.php'); ?>

	<section class="container grey-text form">
		<h4 class="center">Post Offer</h4>
		<form class="white" action="add_ad.php" method="POST">
			
			
			<label>Name:</label>
			<input type="text" name="name" value="<?php echo htmlspecialchars($name) ?>"></input>
			<div class="red-text"><?php echo $errors['name'] ?></div>

			<label>Link:</label>
			<input type="text" name="link" value="<?php echo htmlspecialchars($link) ?>"></input>

			

			<div class="center">
				<input type="submit" name="submit" value="submit" class="btn brand z-depth-0">
			</div>

		</form>
	</section>




	<?php include('templates/footer.php'); ?>



</html>
