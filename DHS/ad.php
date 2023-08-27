<?php 

	//connect to database
	include('config/db_connect.php');

	$sql = 'SELECT * FROM ad';
	$result = mysqli_query($conn, $sql);

	//fetch the resulting rows as an array
	$ads = mysqli_fetch_all($result, MYSQLI_ASSOC);
	//free result from memory
	mysqli_free_result($result);
	//close connection
	

	//print_r($requirements);



	if(isset($_POST['delete'])){
		$id_to_delete = mysqli_real_escape_string($conn, $_POST['id_to_delete']);
		
		$sql = "DELETE FROM ad WHERE id = $id_to_delete";

		if(mysqli_query($conn, $sql)){
			//success
			header('Location: ad.php');

		}else{
			echo 'query error' . mysqli_error($conn);
		}


	}

	mysqli_close($conn);

?>


<!DOCTYPE html>
<html>
	
	<?php include('templates/header.php') ?>


	<h4 class="center grey-text">Offers</h4>
	<?php if($_SESSION['user_role'] == "Admin"): ?>
	<h5 class="center">
	<a class="btn brand z-depth-0 center" href="add_ad.php">Post Offers</a></h5>
	<?php endif; ?>

		<div class="container">
			<div class="row">
				
				<?php foreach ($ads as $ad): ?>
					<?php //if($requirement['accepted'] != 'Yes'): ?>
						<div class="col s6 md3">
							<div class="card z-depth-0">
								<div class="card-content center">
									<h6><?php echo htmlspecialchars($ad['name']) ?></h6>
									<div><a href="<?php echo htmlspecialchars($ad['link']) ?>">Visit <?php echo htmlspecialchars($ad['name']) ?>!</a></div>
									<?php if($_SESSION['user_role'] == "Admin"): ?>
									<div class="card-action right-align">
										<form action="ad.php" method="POST">
											<input type="hidden" name="id_to_delete" value="<?php echo $ad['id']; ?>">
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