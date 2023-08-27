<?php 

	include('config/db_connect.php');

	$expert_at = $qualification = $username = '';
	$errors = array('expert_at'=>'', 'qualification'=>'', 'username'=>'');
	
	if(isset($_GET['id'])){

		$id = mysqli_real_escape_string($conn, $_GET['id']);

		//make sql
		$sql = "SELECT * FROM portfolio WHERE id = $id";

		//get the query result
		$result = mysqli_query($conn, $sql);

		//fetch result in array
		$requirement = mysqli_fetch_assoc($result);
		//print_r($requirement);

		mysqli_free_result($result);
		mysqli_close($conn);

		//print_r($requirement);

	}

	if(isset($_POST['submit'])){


		if(empty($_POST['expert_at'])){
			$errors['expert_at'] = 'A expert_at is required <br />';
		} else{
			$expert_at = $_POST['expert_at'];
			if(!preg_match('/^([a-zA-Z\s]+)(,\s*[a-zA-Z\s]*)*$/', $expert_at)){
				$errors['expert_at'] = 'expert_at must letters and spaces only';
			}
		}

		if(empty($_POST['qualification'])){
			$errors['qualification'] = 'At least one qualification is required <br />';
		} else{
			$qualification = $_POST['qualification'];
			if(!preg_match('/^([a-zA-Z\s]+)(,\s*[a-zA-Z\s]*)*$/', $qualification)){
				$errors['qualification'] = 'qualification must letters and spaces only';
			}
		}

		if(empty($_POST['username'])){
			$errors['username'] = 'At least one username is required <br />';
		} else{
			$username = $_POST['username'];
			
		}

		if (array_filter($errors)){
			//echo 'errors in the form';
		} else{
			//echo 'form is valid';
			//save in database

			$id = mysqli_real_escape_string($conn, $_POST['id_to_update']);
			//print_r($id);

			$image1 = $_POST['image1'];
	  		$img_dir1 = "images/".basename($image1);
	  		$image2 = $_POST['image2'];
	  		$img_dir2 = "images/".basename($image2);
	  		$image3 = $_POST['image3'];
	  		$img_dir3 = "images/".basename($image3);
	  		$img_dir = $img_dir1.','.$img_dir2.','.$img_dir3;


			$email = mysqli_real_escape_string($conn, $_POST['email']);
			$expert_at = mysqli_real_escape_string($conn, $_POST['expert_at']);
			$qualification = mysqli_real_escape_string($conn, $_POST['qualification']);
			$username = mysqli_real_escape_string($conn, $_POST['username']);

			$sql = "UPDATE portfolio SET expert_at = '$expert_at', qualification = '$qualification', username = '$username', image = '$img_dir' WHERE id = $id";


			//save to db and check
			if(mysqli_query($conn, $sql)){
				//success
				header('Location: index.php');
			} else{
				echo 'query error: ' . mysqli_error($conn);
			}

			
		}
	}


?>

<!DOCTYPE html>
<html>

	<?php include('templates/header.php') ?>

	<section class="container grey-text form">
		<h4 class="center">Update Portfolio</h4>
		<form class="white" action="update_portfolio.php" method="POST">
			
			

			<label>Expert at:</label>
			<input type="text" name="expert_at" value="<?php echo htmlspecialchars($expert_at) ?>"></input>
			<div class="red-text"><?php echo $errors['expert_at'] ?></div>

			<label>Qualification (comma separated):</label>
			<input type="text" name="qualification" value="<?php echo htmlspecialchars($qualification) ?>"></input>
			<div class="red-text"><?php echo $errors['qualification'] ?></div>

			<label>Username:</label>
			<input type="text" name="username" value="<?php echo htmlspecialchars($username) ?>"></input>
			<div class="red-text"><?php echo $errors['username'] ?></div>

			<label>Example Model 1:</label>
			<div>
			<input type="file" name="image1" class="brand-text">
			</div>
			
			<label>Example Model 2:</label>
			<div>
			<input type="file" name="image2" class="brand-text">
			</div>
			
			<label>Example Model 3:</label>
			<div>
			<input type="file" name="image3" class="brand-text">
			</div>


			<div class="center">
				<input type="hidden" name="id_to_update" value="<?php echo $requirement['id']; ?>" class="btn brand z-depth-0">
				<input type="submit" name="submit" value="Update" class="btn brand z-depth-0">

			</div>

		</form>
	</section>



	<?php include('templates/footer.php') ?>



</html>