<?php 

	//connect to database
	include('config/db_connect.php');

	$sql = 'SELECT * FROM feedback ORDER BY created_at';
	$result = mysqli_query($conn, $sql);

	//fetch the resulting rows as an array
	$feedbacks = mysqli_fetch_all($result, MYSQLI_ASSOC);
	//free result from memory
	mysqli_free_result($result);
	//close connection
	

	//print_r($requirements);



	if(isset($_POST['delete'])){
		$id_to_delete = mysqli_real_escape_string($conn, $_POST['id_to_delete']);
		
		$sql = "DELETE FROM feedback WHERE id = $id_to_delete";

		if(mysqli_query($conn, $sql)){
			//success
			header('Location: feedback.php');

		}else{
			echo 'query error' . mysqli_error($conn);
		}


	}

	mysqli_close($conn);

?>


<!DOCTYPE html>
<html>
	
	<?php include('templates/header.php') ?>


	<h4 class="center grey-text">Posted Feedbacks</h4>
	<?php if($_SESSION['user_role'] == "Client"): ?>
	<h5 class="center">
	<a class="btn brand z-depth-0 center" href="add_feedback.php">Post Feedback</a></h5>
	<?php endif; ?>

		<div class="container">
			<div class="row">
				
				<?php foreach ($feedbacks as $feedback): ?>
					<?php //if($requirement['accepted'] != 'Yes'): ?>
						<div class="col s6 md3">
							<div class="card z-depth-0">
								<div class="card-content center">
									<h6><?php echo htmlspecialchars($feedback['feedback']) ?></h6>
									<div><?php echo 'Posted by: ' . htmlspecialchars($feedback['email']) ?></div>
									<?php if($_SESSION['user_role'] == "Admin"): ?>
									<div class="card-action right-align">
										<form action="feedback.php" method="POST">
											<input type="hidden" name="id_to_delete" value="<?php echo $feedback['id']; ?>">
											<input type="submit" name="delete" value="Delete" class="btn brand z-depth-0">
										</form>
									</div>
								<?php endif; ?>
								</div>
							</div>
						</div>
				<?php endforeach; ?>
			</div>
		</div>




	<?php include('templates/footer.php') ?>

</html>