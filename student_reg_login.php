<?php
	session_start();
	$db=mysqli_connect('localhost','root','','canteen_backend');
	$errors=array();

	if (isset($_POST[''])) // front-end... 
	{
		$username=mysqli_real_escape_string($db,$_POST['username']);
		$password_1=mysqli_real_escape_string($db,$_POST['password_1']);
		$password_2=mysqli_real_escape_string($db,$_POST['password_2']);

		if ($password_1!=$password_2) {
			array_push($errors,"the passwords do not match !");
		}

		$user_check_query = "SELECT * FROM student_users WHERE username=".$username." ";
  		$result = mysqli_query($db, $user_check_query);
  		$user = mysqli_fetch_assoc($result);

  		if ($user) { 
    	if ($user['username'] === $username) {
      	array_push($errors, "Username already exists");
    											}
					}
		if (count($errors)==0) {
			$password=md5($password_1);
			$query="insert into student_users (username,password) values (".$username.",".$password.") ";
			$mysqli_query($db,$query);
			header('location: '); // redirect...........

					}			
	}

	//...........................................................................

	if (isset($_POST[''])) { // frontend........
			$username=mysqli_real_escape_string($db,$_POST['username']);
			$password=mysqli_real_escape_string($db,$_POST['password']);

			if (empty($username)) {
  				array_push($errors, "Username is required");
 	 }
 			if (empty($password)) {
  				array_push($errors, "Password is required");
  	}

  		if (count($errors)==0) {
  			$password=md5($password);
  			$results=mysqli_query($db,"select * from student_users where username=".$username." and password=".$password." ");
  			if (mysqli_num_rows($results)==1) {
  				$_SESSION['username']=$username;
  				header('location: '); //add page name to redirect...
  			}
  			else
  			{
  				array_push($errors,"Wrong username/password !");
  			}
  		}
		
		}
?>