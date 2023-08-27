<?php 

	include('config/db_connect.php');

	if(isset($_POST['delete'])){

		$id_to_delete = mysqli_real_escape_string($conn, $_POST['id_to_delete']);
		session_start();
		$sql = "DELETE FROM portfolio WHERE email = '{$_SESSION['email']}'";

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
		$sql = "SELECT * FROM portfolio WHERE id = $id";

		//get the query result
		$result = mysqli_query($conn, $sql);

		//fetch result in array
		$portfolio = mysqli_fetch_assoc($result);

		mysqli_free_result($result);
		mysqli_close($conn);

		//print_r($portfolio);

	}

	if(isset($_POST['contact'])){
		$email = mysqli_real_escape_string($conn, $_POST['email_to_contact']);
		
		mail($email, "", "");


	}


?>



<!DOCTYPE html>
<html>

	<?php include('templates/header.php') ?>

	<div class="container center">
		
		<?php if($portfolio): ?>

			<h4><?php echo htmlspecialchars($portfolio['expert_at']); ?></h4>
			<p>Name: <?php echo htmlspecialchars($portfolio['username']); ?></p>
			<p>Qualification: 
				<?php foreach(explode(',', $portfolio['qualification']) as $qual):?>

					<li>
						<?php echo htmlspecialchars($qual) ?>
					</li>

				<?php endforeach; ?>
			</p>
			<p>Contact email: <?php echo htmlspecialchars($portfolio['email']); ?></p>
			<p>Example Model:</p>
			<?php foreach(explode(',', $portfolio['image']) as $img): ?>
				
				<img src="<?php echo htmlspecialchars($img); ?>" class="image"></img>

			<?php endforeach; ?>

			<!--<p>Comments:</p>
			<p><?php echo htmlspecialchars($portfolio['feedback']."\n") ?></p>-->

			
			<form action="portfolio_details.php" method="POST">
				<?php if($_SESSION['user_role'] == "Designer"): ?>
					<input type="hidden" name="id_to_delete" value="<?php echo $requirement['id']; ?>">
					<input type="submit" name="delete" value="Delete" class="btn brand z-depth-0">
					
					<a class="btn brand z-depth-0" href="update_portfolio.php?id=<?php echo $_GET['id'] ?>">Update</a>
					
				<?php elseif($_SESSION['user_role'] == "Client"): ?>

					<a class="btn brand z-depth-0" href="mailto:<?php echo $portfolio['email'] ?>">
						Contact
					</a>
					<a class="btn brand z-depth-0" href="add_feedback.php?id=<?php echo htmlspecialchars($portfolio['id']) ?>">
						Feedback
					</a>

				<?php endif; ?>
			</form>

		<?php else: ?>

			<h5>Details are not available</h5>

		<?php endif; ?>
		

	</div>


	<?php include('templates/footer.php') ?>

</html>