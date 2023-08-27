<?php 

	include('config/db_connect.php');

	$email = $project_type = $project_description = $deadline = '';
	$errors = array('project_type'=>'', 'project_description'=>'', 'deadline'=>'');
	
	
	if(isset($_POST['submit'])){

		

		if(empty($_POST['project_type'])){
			$errors['project_type'] = 'A project_type is required <br />';
		} else{
			$project_type = $_POST['project_type'];
			if(!preg_match('/^[a-zA-Z\s]+$/', $project_type)){
				$errors['project_type'] = 'project_type must letters and spaces only';
			}
		}

		if(empty($_POST['project_description'])){
			$errors['project_description'] = 'At least one project_description is required <br />';
		} else{
			$project_description = $_POST['project_description'];
			if(!preg_match('/^([a-zA-Z\s]+)(,\s*[a-zA-Z\s]*)*$/', $project_description)){
				$errors['project_description'] = 'project_description must letters and spaces only';
			}
		}

		if(empty($_POST['deadline'])){
			$errors['deadline'] = 'At least one deadline is required <br />';
		} else{
			$deadline = $_POST['deadline'];
			
		}

		if (array_filter($errors)){
			//echo 'errors in the form';
		} else{
			//echo 'form is valid';
			//save in database
			session_start();
			$email = $_SESSION['email'];

			$project_type = mysqli_real_escape_string($conn, $_POST['project_type']);
			$project_description = mysqli_real_escape_string($conn, $_POST['project_description']);
			$deadline = mysqli_real_escape_string($conn, $_POST['deadline']);

			$sql = "INSERT INTO requirements(email, project_type, project_description, deadline) VALUES('$email', '$project_type', '$project_description', '$deadline')";
			
			$select = mysqli_query($conn, "SELECT * FROM requirements WHERE email = '".$_SESSION['email']."'");

			
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
		<h4 class="center">Post Requirements</h4>
		<form class="white" action="add_requirements.php" method="POST">
			
			<!--
			<label>Your Email:</label>
			<input type="text" name="email" value="<?php echo htmlspecialchars($email) ?>"></input>
			<div class="red-text"><?php echo $errors['email'] ?></div>-->
			
			<label>Project Type:</label>
			<input type="text" name="project_type" value="<?php echo htmlspecialchars($project_type) ?>"></input>
			<div class="red-text"><?php echo $errors['project_type'] ?></div>

			<label>Project Description (comma separated):</label>
			<input type="text" name="project_description" value="<?php echo htmlspecialchars($project_description) ?>"></input>
			<div class="red-text"><?php echo $errors['project_description'] ?></div>

			<label>Deadline:</label>
			<input type="date" name="deadline" value="<?php echo htmlspecialchars($deadline) ?>"></input>
			<div class="red-text"><?php echo $errors['deadline'] ?></div>

			<div class="center">
				<input type="submit" name="submit" value="submit" class="btn brand z-depth-0">
			</div>

		</form>
	</section>



	<?php include('templates/footer.php') ?>



</html>