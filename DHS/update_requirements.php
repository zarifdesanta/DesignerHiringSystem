<?php 

	include('config/db_connect.php');

	$project_type = $project_description = $deadline = '';
	$errors = array('project_type'=>'', 'project_description'=>'', 'deadline'=>'');
	
	if(isset($_GET['id'])){

		$id = mysqli_real_escape_string($conn, $_GET['id']);

		//make sql
		$sql = "SELECT * FROM requirements WHERE id = $id";

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

			$id = mysqli_real_escape_string($conn, $_POST['id_to_update']);
			//print_r($id);

			$email = mysqli_real_escape_string($conn, $_POST['email']);
			$project_type = mysqli_real_escape_string($conn, $_POST['project_type']);
			$project_description = mysqli_real_escape_string($conn, $_POST['project_description']);
			$deadline = mysqli_real_escape_string($conn, $_POST['deadline']);

			$sql = "UPDATE requirements SET project_type = '$project_type', project_description = '$project_description', deadline = '$deadline' WHERE id = $id";


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
		<h4 class="center">Update Requirements</h4>
		<form class="white" action="update_requirements.php" method="POST">
			
			

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
				<input type="hidden" name="id_to_update" value="<?php echo $requirement['id']; ?>" class="btn brand z-depth-0">
				<input type="submit" name="submit" value="Update" class="btn brand z-depth-0">

			</div>

		</form>
	</section>



	<?php include('templates/footer.php') ?>



</html>