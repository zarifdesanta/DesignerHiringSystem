<?php 

	include('config/db_connect.php');

	if(isset($_POST['delete'])){

		$id_to_delete = mysqli_real_escape_string($conn, $_POST['id_to_delete']);
		session_start();
		$sql = "DELETE FROM requirements WHERE email = '{$_SESSION['email']}'";

		if(mysqli_query($conn, $sql)){
			//success
			header('Location: index.php');

		}else{
			echo 'query error' . mysqli_error($conn);
		}

	}


	//check GET request id param
	if(isset($_GET['id'])){

		$id = mysqli_real_escape_string($conn, $_GET['id']);

		//make sql
		$sql = "SELECT * FROM requirements WHERE id = $id";

		//get the query result
		$result = mysqli_query($conn, $sql);

		//fetch result in array
		$requirement = mysqli_fetch_assoc($result);

		mysqli_free_result($result);
		mysqli_close($conn);

		//print_r($requirement);

	}

	if(isset($_POST['accept'])){
		$id = mysqli_real_escape_string($conn, $_POST['id_to_accept']);
		session_start();
		$sql = "UPDATE requirements SET accepted = 'Yes', des_email = '{$_SESSION['email']}' WHERE id = $id";

		$select = mysqli_query($conn, "SELECT * FROM requirements WHERE des_email = '".$_SESSION['email']."'");


 			if(!mysqli_num_rows($select)){
 		
	 				if(mysqli_query($conn, $sql)){
					//success
						header('Location: index.php');
					} else{
						echo 'query error: ' . mysqli_error($conn);
						
					
 				}
				
			}else{
				echo 'you have already accepted a job';
			}




	}


?>



<!DOCTYPE html>
<html>

	<?php include('templates/header.php') ?>

	<div class="container center">
		
		<?php if($requirement): ?>

			<h4><?php echo htmlspecialchars($requirement['project_type']); ?></h4>
			<p>Posted at: <?php echo htmlspecialchars($requirement['created_at']); ?></p>
			<p>Project Description: 
				<?php foreach(explode(',', $requirement['project_description']) as $des):?>

					<li>
						<?php echo htmlspecialchars($des) ?>
					</li>

				<?php endforeach; ?>
			</p>
			<p>Deadline: <?php echo htmlspecialchars($requirement['deadline']); ?></p>
			<p>Client Contact email: <?php echo htmlspecialchars($requirement['email']); ?></p>
			<p>Accepted: <?php echo htmlspecialchars($requirement['accepted']); ?></p>
			<p>Designer Email: <?php echo htmlspecialchars($requirement['des_email']); ?></p>

			
			<form action="requirements_details.php" method="POST">
				<?php if($_SESSION['user_role'] == "Designer"): ?>
					<?php if($requirement['accepted'] == "No"): ?>
						<input type="hidden" name="id_to_accept" value="<?php echo $requirement['id']; ?>">
						<input type="submit" name="accept" value="Accept" class="btn brand z-depth-0">
					<?php endif; ?>
				<?php elseif($_SESSION['user_role'] == "Client"): ?>
					<input type="hidden" name="id_to_delete" value="<?php echo $requirement['id']; ?>">
					<input type="submit" name="delete" value="Delete" class="btn brand z-depth-0">
					
					<a class="btn brand z-depth-0" href="update_requirements.php?id=<?php echo $_GET['id'] ?>">Update</a>
				<?php endif; ?>
			</form>

		<?php else: ?>

			<h5>Details are not available</h5>

		<?php endif; ?>

	</div>


	<?php include('templates/footer.php') ?>

</html>