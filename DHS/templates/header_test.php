<?php 

	session_start();

	if(!isset($_SESSION['email'])){
		header('Location: login.php');
	}

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


	$sql = 'SELECT * FROM portfolio';
	$result = mysqli_query($conn, $sql);

	//fetch the resulting rows as an array
	$portfolios = mysqli_fetch_all($result, MYSQLI_ASSOC);
	//free result from memory
	mysqli_free_result($result);
	//close connection
	mysqli_close($conn);


?>

<head>
	<title>Designer Hiring System</title>
	
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

	<!-- Compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">

     <!-- Compiled and minified JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>

    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">


    <style type="text/css">
    	.brand{
    		background: #cbb09c !important;
    	}
    	.brand-text{
    		color: #cbb09c !important;
    	}
    	.form{
    		max-width: 480px;
    		margin: 20px auto;
    		padding: 20px;
    	}
    	.image{
			width: 300px;
			margin: 40px auto - 30px;
    </style>

<script type="text/javascript">

	  $(document).ready(function(){
	    $('.sidenav').sidenav();
	  });
       
</script>



</head>
	<body class="grey lighten-4">
		
			<div class="container">
				<a href="index.php" class="brand-logo brand-text">
				Designer Hiring System
				</a>
				<ul id="slide-out" class="sidenav">
					<li>
						
						<?php if($_SESSION['user_role'] == "Client"): ?>

							<a href="add_requirements.php" class="btn brand z-depth-0">
							Post Requirements</a>
							<?php foreach ($requirements as $requirement): ?>
								<?php if($requirement['email'] == $_SESSION['email']): ?>
								<a href="requirements_details.php?id=<?php echo $requirement['id']; ?>" class="btn brand z-depth-0">
								My Requirements</a>
								<?php endif; ?>
							<?php endforeach; ?>
							

						<?php elseif($_SESSION['user_role'] == "Designer"): ?>
							<a href="add_portfolio.php" class="btn brand z-depth-0">
							Post Portfolio</a>
							<?php foreach ($portfolios as $portfolio): ?>
								<?php if($portfolio['email'] == $_SESSION['email']): ?>
								<a href="portfolio_details.php?id=<?php echo $portfolio['id']; ?>" class="btn brand z-depth-0">
								My Portfolio</a>
								<?php endif; ?>
							<?php endforeach; ?>

						<?php endif; ?>



						<a class="btn brand z-depth-0" href="feedback.php">Feedback</a>

						<a class="btn brand z-depth-0" href="ad.php">Ad</a>

						<a class="btn brand z-depth-0" href="helpdesk.php">Helpdesk</a>

						<a href="logout.php" class="btn brand z-depth-0">Log Out</a>
					</li>
				</ul>
				<a href="#" data-target="slide-out" class="sidenav-trigger"><i class="material-icons">menu</i></a>
			</div>
		