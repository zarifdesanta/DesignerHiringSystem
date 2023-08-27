<?php 

	$conn = mysqli_connect('localhost', 'zarif', '1234', 'dhs');

	//check connection
	if(!$conn){
		echo 'Connection error: ' . mysqli_connect_error();
	}


 ?>