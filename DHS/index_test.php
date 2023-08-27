<?php 


	//connect to database
	include('config/db_connect.php');

	//write query for all requirements
	$sql = 'SELECT * FROM requirements ORDER BY created_at';
	$result = mysqli_query($conn, $sql);

	//fetch the resulting rows as an array
	$requirements = mysqli_fetch_all($result, MYSQLI_ASSOC);
	//free result from memory
	mysqli_free_result($result);
	//close connection
	//mysqli_close($conn);

	$sql = 'SELECT * FROM user';
	$result = mysqli_query($conn, $sql);

	//fetch the resulting rows as an array
	$users = mysqli_fetch_all($result, MYSQLI_ASSOC);
	//free result from memory
	mysqli_free_result($result);




	$sql = 'SELECT * FROM portfolio';
	$result = mysqli_query($conn, $sql);

	//fetch the resulting rows as an array
	$portfolios = mysqli_fetch_all($result, MYSQLI_ASSOC);
	//free result from memory
	mysqli_free_result($result);
	//close connection
	


	if(isset($_POST['delete'])){
		$id_to_delete = mysqli_real_escape_string($conn, $_POST['id_to_delete']);
		
		$sql = "DELETE FROM user WHERE id = $id_to_delete";

		if(mysqli_query($conn, $sql)){
			//success
			header('Location: index.php');

		}else{
			echo 'query error' . mysqli_error($conn);
		}


	}


	if(isset($_POST['search_portfolio'])){
		$keyword = mysqli_real_escape_string($conn,$_POST['keyword']);

		$search = "SELECT * FROM portfolio WHERE expert_at LIKE '%{$keyword}%' OR qualification LIKE '%{$keyword}%'";

		$result = mysqli_query($conn, $search);

		$searched_portfolio = mysqli_fetch_all($result, MYSQLI_ASSOC);

		/*
		foreach ($searched_animals as $animal) {
			echo $animal['name'];
		}*/
	}


	if(isset($_POST['search_requirement'])){
		$keyword = mysqli_real_escape_string($conn,$_POST['keyword']);

		$search = "SELECT * FROM requirements WHERE project_type LIKE '%{$keyword}%' OR project_description LIKE '%{$keyword}%'";

		$result = mysqli_query($conn, $search);

		$searched_requirement = mysqli_fetch_all($result, MYSQLI_ASSOC);

		/*
		foreach ($searched_animals as $animal) {
			echo $animal['name'];
		}*/
	}



	if(isset($_POST['search_user'])){
		$keyword = mysqli_real_escape_string($conn,$_POST['keyword']);

		$search = "SELECT * FROM user WHERE email LIKE '%{$keyword}%' OR user_role LIKE '%{$keyword}%'";

		$result = mysqli_query($conn, $search);

		$searched_user = mysqli_fetch_all($result, MYSQLI_ASSOC);

		/*
		foreach ($searched_animals as $animal) {
			echo $animal['name'];
		}*/
	}


	mysqli_close($conn);
	//print_r($requirements);

?>


<script type="text/javascript">

	  $(document).ready(function(){
	    $('.parallax').parallax();
	  });
       
</script>



<!DOCTYPE html>
<html>

	<?php include('templates/header.php') ?>

	<script>

	  $(document).ready(function(){
	    $('.parallax').parallax();
	  });
       
	</script>


	<div class="parallax-container">
		<div class="parallax">
			<img src="images/parallax2.jpg" class="responsive-img">
		</div>
	</div>


	<div class="container">
		<p>hsbdkhabskjdjasbdjabdjansjdbakjbakjdjakndjandjkanskjdnkjsndjknasjndjksndnj</p>
		<p>hsbdkhabskjdjasbdjabdjansjdbakjbakjdjakndjandjkanskjdnkjsndjknasjndjksndnj</p>
		<p>hsbdkhabskjdjasbdjabdjansjdbakjbakjdjakndjandjkanskjdnkjsndjknasjndjksndnj</p>
		<p>hsbdkhabskjdjasbdjabdjansjdbakjbakjdjakndjandjkanskjdnkjsndjknasjndjksndnj</p>
		<p>hsbdkhabskjdjasbdjabdjansjdbakjbakjdjakndjandjkanskjdnkjsndjknasjndjksndnj</p>
		<p>hsbdkhabskjdjasbdjabdjansjdbakjbakjdjakndjandjkanskjdnkjsndjknasjndjksndnj</p>
		<p>hsbdkhabskjdjasbdjabdjansjdbakjbakjdjakndjandjkanskjdnkjsndjknasjndjksndnj</p>
		<p>hsbdkhabskjdjasbdjabdjansjdbakjbakjdjakndjandjkanskjdnkjsndjknasjndjksndnj</p>
		<p>hsbdkhabskjdjasbdjabdjansjdbakjbakjdjakndjandjkanskjdnkjsndjknasjndjksndnj</p>
		<p>hsbdkhabskjdjasbdjabdjansjdbakjbakjdjakndjandjkanskjdnkjsndjknasjndjksndnj</p>
		<p>hsbdkhabskjdjasbdjabdjansjdbakjbakjdjakndjandjkanskjdnkjsndjknasjndjksndnj</p>
		<p>hsbdkhabskjdjasbdjabdjansjdbakjbakjdjakndjandjkanskjdnkjsndjknasjndjksndnj</p>
		<p>hsbdkhabskjdjasbdjabdjansjdbakjbakjdjakndjandjkanskjdnkjsndjknasjndjksndnj</p>
		<p>hsbdkhabskjdjasbdjabdjansjdbakjbakjdjakndjandjkanskjdnkjsndjknasjndjksndnj</p>
	</div>


		
	<?php if($_SESSION['user_role'] == "Designer"): ?>

		<h4 class="center grey-text">Posted Requirements</h4>

		


		<div class="container">

			<nav>
		    <div class="nav-wrapper">
		      <form action="index_test.php" method="POST">
		        <div class="input-field brand">

		          <input type="search" name="keyword" required>
		          <label class="label-icon" for="search"><i class="material-icons">search</i></label>
		          <input type="hidden" name="search_requirement" value="Search">
		          
		          <i class="material-icons">close</i>
		        </div>
		      </form>
		    </div>
		  </nav>

		


			<?php if(isset($searched_requirement)): ?>
				Results Found: <?php echo count($searched_requirement); ?>

			<div class="row">
				
				<?php foreach ($searched_requirement as $requirement): ?>
					<?php //if($requirement['accepted'] != 'Yes'): ?>
						<div class="col s6 md3">
							<div class="card z-depth-0">
								<div class="card-content center">

									<h6><?php echo htmlspecialchars($requirement['project_type']) ?></h6>
									<div><?php echo 'Deadline: ' . htmlspecialchars($requirement['deadline']) ?></div>
									<div><?php echo 'Accepted: ' . htmlspecialchars($requirement['accepted']) ?></div>
									<div class="card-action right-align">
										<a class="brand-text" href="requirements_details.php?id=<?php echo $requirement['id'] ?>">more info</a>
									</div>
								</div>
							</div>
						</div>

					<?php //endif; ?>

				<?php endforeach; ?>


			<?php else: ?>
			<div class="row">
				
				<?php foreach ($requirements as $requirement): ?>
					<?php //if($requirement['accepted'] != 'Yes'): ?>
						<div class="col s6 md3">
							<div class="card z-depth-0">
								<div class="card-content center">

									<h6><?php echo htmlspecialchars($requirement['project_type']) ?></h6>
									<div><?php echo 'Deadline: ' . htmlspecialchars($requirement['deadline']) ?></div>
									<div><?php echo 'Accepted: ' . htmlspecialchars($requirement['accepted']) ?></div>
									<div class="card-action right-align">
										<a class="brand-text" href="requirements_details.php?id=<?php echo $requirement['id'] ?>">more info</a>
									</div>
								</div>
							</div>
						</div>

					<?php //endif; ?>

				<?php endforeach; ?>

			<?php endif; ?>

			</form>

			</div>
		</div>



	<!--Client-->
	<?php elseif($_SESSION['user_role'] == "Client"): ?>

		<!--HOMEPAGE FOR CLIENT-->

		<h4 class="center grey-text">Designers</h4>

		<div class="container">
			<form action="index.php" method="POST">
			<input type="text" name="keyword">
			<input type="submit" name="search_portfolio" value="Search" class="btn brand z-depth-0">

			<?php if(isset($searched_portfolio)): ?>
				Results Found: <?php echo count($searched_portfolio); ?>
				<div class="row">
				
				<?php foreach ($searched_portfolio as $portfolio): ?>
					
						<div class="col s6 md3">
							<div class="card z-depth-0">
								<div class="card-content center">

									<h6><?php echo htmlspecialchars($portfolio['expert_at']) ?></h6>
									<div><?php echo htmlspecialchars($portfolio['username']) ?></div>
									
									<div class="card-action right-align">
										<a class="brand-text" href="portfolio_details.php?id=<?php echo $portfolio['id'] ?>">more info</a>
									</div>
								</div>
							</div>
						</div>


				<?php endforeach; ?>

				</div>


			<?php else: ?>


			<div class="row">
				
				<?php foreach ($portfolios as $portfolio): ?>
					
						<div class="col s6 md3">
							<div class="card z-depth-0">
								<div class="card-content center">

									<h6><?php echo htmlspecialchars($portfolio['expert_at']) ?></h6>
									<div><?php echo htmlspecialchars($portfolio['username']) ?></div>
									
									<div class="card-action right-align">
										<a class="brand-text" href="portfolio_details.php?id=<?php echo $portfolio['id'] ?>">more info</a>
									</div>
								</div>
							</div>
						</div>


				<?php endforeach; ?>
		
			<?php endif; ?>
			</form>

			</div>
		</div>






	<!--Admin-->
	<?php else: ?>
		<h4 class="center grey-text">Accounts</h4>

		<div class="container">

			<form action="index.php" method="POST">
			<input type="text" name="keyword">
			<input type="submit" name="search_user" value="Search" class="btn brand z-depth-0">

			<?php if(isset($searched_user)): ?>
				Results Found: <?php echo count($searched_user); ?>

				<div class="row">
				
				<?php foreach ($searched_user as $user): ?>
					
						<div class="col s6 md3">
							<div class="card z-depth-0">
								<div class="card-content center">

									<h6><?php echo htmlspecialchars($user['user_role']) ?></h6>
									<div><?php echo htmlspecialchars($user['email']) ?></div>
									
									<div class="card-action right-align">
										<form action="index.php" method="POST">
											<input type="hidden" name="id_to_delete" value="<?php echo $user['id']; ?>">
											<input type="submit" name="delete" value="Delete" class="btn brand z-depth-0">
										</form>
									</div>
								</div>
							</div>
						</div>


				<?php endforeach; ?>

			</div>


			<?php else: ?>

			<div class="row">
				
				<?php foreach ($users as $user): ?>
					
						<div class="col s6 md3">
							<div class="card z-depth-0">
								<div class="card-content center">

									<h6><?php echo htmlspecialchars($user['user_role']) ?></h6>
									<div><?php echo htmlspecialchars($user['email']) ?></div>
									
									<div class="card-action right-align">
										<form action="index.php" method="POST">
											<input type="hidden" name="id_to_delete" value="<?php echo $user['id']; ?>">
											<input type="submit" name="delete" value="Delete" class="btn brand z-depth-0">
										</form>
									</div>
								</div>
							</div>
						</div>


				<?php endforeach; ?>

			<?php endif; ?>
			</form>
			</div>
		</div>

	<?php endif; ?>


	


	<?php include('templates/footer.php') ?>





</html>







