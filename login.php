<?php 
session_start();
require "db.php";
require "functions.php";

if(loggedin()){
	echo 'You are logged in as '.$_SESSION['user'];
}else{
	?>
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<style>
		form{background-color:lightblue; padding:10em;}
		.alert{margin-top:1em}
	</style>
<form action="" class="text-center" method="post" >
	Username: <input type = "text" name = "username" required/>
	Password: <input type ="password" name = "password" required/>
	<button type="submit" >Login</button>

	<?php
	if(isset($_POST['username'])&&isset($_POST['password'])){
		$username = $db->real_escape_string($_POST['username']);
		$password = $db->real_escape_string($_POST['password']);
		if(!empty($username)&&!empty($password)){
			$results = $db->query("SELECT * FROM users WHERE username = '{$username}' AND password = '{$password}'");
			if($results->num_rows){
				$row = $results->fetch_object();
				$userID =  $row->id;
				$_SESSION['user'] = $userID;
				header('Location: ../shop?p=sell');
			}else{
				echo'<div class="alert alert-danger">Invalid credentials!</div>';
			}
			
		}
	}
}
?>
</form>