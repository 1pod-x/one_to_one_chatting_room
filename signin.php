<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Untitled Document</title>
</head>
<?php
$page_title="sigin";
include('homepage.php');
?>
<div id="content">
<?php
//需要修改：如果图片太长 显示图片过长
if ($_SERVER['REQUEST_METHOD']=="GET"){
	echo'<body><h1>Register</h1>
  <form id="form1" name="form1" method="post" enctype="multipart/form-data">
  <p>
    <label for="email">Email Address:</label>
    <input name="email" type="email" id="email" size="20" maxlength="60">
  </p>
  <p>
    <label for="pass1">Password:</label>
    <input name="pass1" type="password" id="pass1" size="10" maxlength="20">
  </p>
  <p>
    <label for="pass2">Retype Password:</label>
    <input name="pass2" type="password" id="pass2" size="10" maxlength="10">
  </p>
  <p>
    <label for="username">Username:</label>
    <input name="username" type="text" id="username" size="20" maxlength="60">
  </p>
  <p>
   <label for="image">Choose an avater:</label>
   <input name="image" type="file" size="10" value="Choose a File" > 
	</p>
  <p>
    <input type="submit" name="submit" id="submit" value="Register">
  </p>
 </form>';
 $msg = "";
}else{
	if (empty($_POST['email'])){
		echo'<p class="error">You forgot to input your email address!</p>';
	}else
		$email=$_POST['email'];
	
	if (empty($_POST['pass1'])){
		echo'<p class="error">You forgot to input your password!</p>';
	}else
		$pass1=$_POST['pass1'];
	
	if (empty($_POST['pass2'])){
		echo'<p class="error">You forgot to retype your password!</p>';
	}else
		$pass2=$_POST['pass2'];
	if (empty($_POST['username'])){
		echo'<p class="error">You forgot to input your username!</p>';
	}else
		$username=$_POST['username'];
	
	if (empty($_FILES['image'])){
		echo'<p class="error">You forgot to upload an avatar!</p>';
		
	}
	else{
        $avatar=$_FILES['image'];
		$filesize = filesize($avatar['tmp_name']);
		$con= file_get_contents($avatar['tmp_name']);
		$blob=addslashes(file_get_contents($avatar['tmp_name']));
		if($filesize>64000){
			echo"The avatar uploaded is too large ！";
		}
	}
		
    if (isset($pass1,$pass2)&&($pass1 != $pass2)){
		echo'<p class="error">The password do not match!</p>';
		unset($pass1);
		
	}
	if (isset ($email,$pass1,$pass2,$avatar) and $filesize<=64000){
		require('chatdb.php');
		$w="SELECT email FROM users WHERE email = '$email' ";
		$resultr= mysqli_query($dbc,$w);
		$e = mysqli_fetch_array($resultr);
		if($resultr->num_rows > 0){
			echo'You have already registered!'; }
	    else{
			$sql="INSERT INTO users (email , password ,username,create_time,avatar)
		VALUES('$email',SHA1('$pass1'),'$username',Now(),'$blob')";
		$result= mysqli_query($dbc,$sql);
		if($result){
			echo"<h2>You are registered!</h2>";
			$query = "SELECT avatar,username FROM users WHERE email = '$email' ;";
			$r = mysqli_query ($dbc,$query);
			$row = mysqli_fetch_array($r);
			echo $row['username'];
			echo '<img src="data:image/jpeg;base64,'.base64_encode($row['avatar']).'" style="border-radius: 50%;
	  width: 50px; 
      height: 50px; ">';
			echo'<p><a id="exit" href="login.php">Log in</a></p>';

		}else{
			echo"<h2>Failed to register!</h2>";
			echo '<p>'.mysqli_error($dbc)."</p><p>Qery: $sql</p>";
			echo'';
		}
		}
	}
}

?>
</div>
</html>

</html>