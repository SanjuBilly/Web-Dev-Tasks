
	<?php
		require 'connect.php' ;
		$dir = "/var/www/html/images/";

		$connect = mysqli_connect($host,$user,$password,$db) or die ("Problem in connecting :".mysql_error());

			if($_SERVER["REQUEST_METHOD"] == "POST"){
				$u_name= mysqli_real_escape_string($connect,$_POST["username"]);
				$u_name= htmlspecialchars($u_name);
				$passwd= mysqli_real_escape_string($connect,$_POST["pass"]);
				$passwd= htmlspecialchars($passwd);
				$mail  = mysqli_real_escape_string($connect,$_POST["usermail"]);
				$mail  = htmlspecialchars($mail);
				$file = $dir.basename($_FILES["prof_pic"]["name"]);
				$ext = pathinfo($file,PATHINFO_EXTENSION);
			}
			$passwd = sha1($passwd);
			
			$query = mysqli_query($connect,"SELECT * FROM details WHERE uname = '".$u_name."' OR email = '".$mail."'");
			$row = mysqli_fetch_array($query);

			$check = getimagesize($_FILES["prof_pic"]["tmp_name"]);
			$flag = 1;

			if(!$check){
				echo "File is not an image ";
				$flag=0;
			}

			else if(file_exists($file)){
				echo "Filename is already present";
				$flag=0;
			}

			else if ($_FILES["prof_pic"]["size"]>300000){
				echo "Size limit is 3 mb";
				$flag = 0;
			}

			else if($ext!="jpg"&&$ext!="png"&&$ext!="jpeg"&&$ext!="x-png"){
				echo "Not desired image extension  ";
				echo $ext ;
				$flag=0;
			}


			if($flag){
				if($u_name==""||$passwd==""||$mail==""){
					echo "Cannot be empty!!";
					?>
					<a href="form.html">Go Back</a>
					<?php
				}
				else if($row){
					echo "User already registered. Try login ";
					?>
					<a href="form.html">Go Back</a>
					<?php
				}
				else {
					$img_file = $_FILES["prof_pic"]["tmp_name"];
					$query = mysqli_query($connect,"INSERT INTO details (uname,password,email,image,img) VALUES ('$u_name','$passwd','$mail','$file','$img_file')");
					move_uploaded_file($_FILES["prof_pic"]["tmp_name"],$file);
					echo "Registration complete!!" ;
					?>
					<a href="form.html">Go Back</a>
					<?php
				}
			}

			else {
				?>
				<a href="form.html">Go Back</a>
				<?php
			}
				

			mysqli_close($connect);		
	?>