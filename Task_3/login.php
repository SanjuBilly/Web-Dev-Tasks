<?php
	require 'connect.php';
	$connect = mysqli_connect($host,$user,$password,$db) or die("Error connecting to database".mysql_error());

	if($_SERVER["REQUEST_METHOD"]=="POST"){
		$name = mysqli_real_escape_string($connect,$_POST["cred_uname"]);
		$name = htmlspecialchars($name);
		$pwd = mysqli_real_escape_string($connect,$_POST["pass"]);
		$pwd = htmlspecialchars($pwd);
		
	}
		$pwd = sha1($pwd);
		$query = mysqli_query($connect,"SELECT * FROM details WHERE uname = '".$name."' OR email = '".$name."'");
		$row = mysqli_fetch_array($query);

		if($name==""||$pwd==""){
			echo "Enter the login credentials first";
			?>
			<a href="form.html">Click here to Login</a>
			<?php

		}

		else if(!$row){
			echo "Username or Email doesn't exist";
		}

		else {
			if($row['password']!=$pwd){
				echo "Incorrect password ";
			}
			else{
				session_start();
				$_SESSION["active"]=$name;
				header("location:homepage.php");
			}
		}

?>