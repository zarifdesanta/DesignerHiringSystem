<?php 

	include('config/db_connect.php');

	$feedback = '';
	$errors = array('feedback'=>'');
	
	
	if(isset($_POST['submit'])){


		if(empty($_POST['feedback'])){
			$errors['feedback'] = 'A feedback is required <br />';
		} else{
			$feedback = $_POST['feedback'];
		}

		if (array_filter($errors)){
			//echo 'errors in the form';
		} else{
			//echo 'form is valid';
			//save in database
			session_start();
			$email = $_SESSION['email'];

			

			$feedback = mysqli_real_escape_string($conn, $_POST['feedback']);
			

			$sql = "INSERT INTO feedback(email, feedback) VALUES('$email', '$feedback')";
			
			$select = mysqli_query($conn, "SELECT * FROM feedback WHERE email = '".$_SESSION['email']."'");

			
			//save to db and check
			if(!mysqli_num_rows($select)){
				if(mysqli_query($conn, $sql)){
				//success
					header('Location: feedback.php');
				} else{
					echo 'query error: ' . mysqli_error($conn);
					
				}
			}else{
				echo 'email already exists';
			}
		}
	}


?>

<script>
        $(document).ready(function(){
         $('#modal1').modal();
        });
</script>


<!DOCTYPE html>
<html>

	<?php include('templates/header.php'); ?>

	<section class="container grey-text form">
		<h4 class="center">Post Feedback</h4>
		<form class="white" action="add_feedback.php" method="POST">
			
			
			<label>Feedback:</label>
			<input type="text" name="feedback" value="<?php echo htmlspecialchars($feedback) ?>"></input>
			<div class="red-text"><?php echo $errors['feedback'] ?></div>

			

			<div class="center">
				<input type="submit" name="submit" value="submit" class="btn brand z-depth-0">
			</div>

		</form>
	</section>




	<?php include('templates/footer.php'); ?>



</html>
