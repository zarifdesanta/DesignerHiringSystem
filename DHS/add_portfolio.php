<?php 

	include('config/db_connect.php');

	$expert_at = $qualification = $username = '';
	$errors = array('expert_at'=>'', 'qualification'=>'', 'username'=>'');
	
	
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
			session_start();
			$email = $_SESSION['email'];

			$image1 = $_POST['image1'];
	  		$img_dir1 = "images/".basename($image1);
	  		$image2 = $_POST['image2'];
	  		$img_dir2 = "images/".basename($image2);
	  		$image3 = $_POST['image3'];
	  		$img_dir3 = "images/".basename($image3);
	  		$img_dir = $img_dir1.','.$img_dir2.','.$img_dir3;

			$expert_at = mysqli_real_escape_string($conn, $_POST['expert_at']);
			$qualification = mysqli_real_escape_string($conn, $_POST['qualification']);
			$username = mysqli_real_escape_string($conn, $_POST['username']);

			$sql = "INSERT INTO portfolio(email, expert_at, qualification, username, image) VALUES('$email', '$expert_at', '$qualification', '$username', '$img_dir')";
			
			$select = mysqli_query($conn, "SELECT * FROM portfolio WHERE email = '".$_SESSION['email']."'");

			
			//save to db and check
			if(!mysqli_num_rows($select)){
				if(mysqli_query($conn, $sql)){
				//success
					header('Location: index.php');
				} else{
					echo 'query error: ' . mysqli_error($conn);
					
				}
			}else{
				echo 'email already exists';
			}

			
		}
	}


?>

<!DOCTYPE html>
<html>

	<?php include('templates/header.php') ?>

	<section class="container grey-text form">
		<h4 class="center">Post Portfolio</h4>
		<form class="white" action="add_portfolio.php" method="POST">
			
			<!--
			<label>Your Email:</label>
			<input type="text" name="email" value="<?php echo htmlspecialchars($email) ?>"></input>
			<div class="red-text"><?php echo $errors['email'] ?></div>-->
			
			<label>Expert At:</label>
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
				<input type="submit" name="submit" value="submit" class="btn brand z-depth-0">
			</div>

		</form>
	</section>



	<?php include('templates/footer.php') ?>



</html>