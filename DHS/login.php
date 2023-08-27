<?php
	
	//session_start();

	if(isset($_SESSION['email'])){
		header('Location: index.php');
	}

	$errors = array('email'=>'','password'=>'');

	
	if(isset($_POST['login'])){
		include('config/db_connect.php');
		$email = mysqli_real_escape_string($conn, $_POST['email']);
		$password = $_POST['password'];
				
		$sql = "SELECT id, email, user_role FROM user WHERE email='{$email}' AND password='{$password}'";

		$result = mysqli_query($conn, $sql) or die('query failed');

		if(mysqli_num_rows($result) > 0){
			while ($row = mysqli_fetch_assoc($result)) {
				
				session_start();
				
				$_SESSION['email'] = $row['email'];
				$_SESSION['id'] = $row['id'];
				$_SESSION['user_role'] = $row['user_role'];

				header('Location: index.php');
			}
		}else{
			echo '<div class="red-text">email and Password are not matched</div>';
		}
	}

?>



<!DOCTYPE html>
<html>
	
	<?php include('templates/login_header.php') ?>


	<section class="center grey-text">

		<h2 class="center">Login</h2>

		<form class="white form" action="<?php $_SERVER['PHP_SELF']; ?>" method="POST">
			

			<div class="input-field">
			<i class="material-icons prefix">email</i>
			<input type="email" name='email'>
			<label class="left">Email:</label>
			</div>
			<div class="red-text"><?php echo $errors['email'] ?></div>
			<div class="input-field">
			<i class="material-icons prefix">password</i>
			<input type="password" name="password">
			<label class="left">Password:</label>
			</div>
			<div class="red-text"><?php echo $errors['password'] ?></div>
				
			<div class="center">

				<input type="submit" name="login" value="login" class="btn brand z-depth-0">
				<a href="register.php" class="btn brand z-depth-0">Register</a>

  				</a>
			</div>
		</form>

	</section>


	<?php include('templates/footer.php') ?>
</html>