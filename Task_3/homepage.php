<html>
<head>
	<title>Welcome</title>
	<link rel="stylesheet" type="text/css" href="form.css">
</head>
<?php
		session_start();
		require "connect.php";
		$connect = mysqli_connect($host,$user,$password,$db) or die ("Error connecting to database".mysqli_error());
		if(isset($_SESSION["active"])||($_SESSION["active"]!="")){
			$name = $_SESSION["active"];			
			$query = mysqli_query($connect,"SELECT * FROM details WHERE uname = '".$name."' OR email = '".$name."'");
			$row  = mysqli_fetch_array($query);
			$name = $row['uname'];
			$mail = $row['email'];
			$img = $row['image'];
		}
		else{
			header("location:form.html");
		}

		mysqli_close($connect);
?>
<body>
	<a href="logout.php" >Log Out</a>
	<div>User Name - <?php echo $name ; ?></div>
	<div>Email id - <?php echo $mail ; ?></div>
	<div><?php echo '<img src="'.$img.'"/>'; ?></div>

</body>
</html>