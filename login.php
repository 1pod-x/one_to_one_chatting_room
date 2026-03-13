


<?php
$page_title = "Home Page";
include('homepage.php');
?>

<div id="content">

<?
session_start();
$page_title = "Login";
       
if ($_SERVER['REQUEST_METHOD']=="GET") {
    echo '<form id="form1" name="form1" method="post" action="">
  <h1><strong>Login
  </strong></h1>
  <p>
    <label for="email">Email Address:</label>
    <input type="email" name="email" id="email">
  </p >
  <p>
    <label for="password">Password:</label>
    <input type="password" name="password" id="password">
  </p >
  <p>
    <input type="submit" name="submit" id="submit" value="Login">
  </p >
  <p>
    <p1><u><a href=" ">sign in</a ></u></p1>
   
  </p >
  <p>&nbsp;</p >
 </form>';
     
} else {
    if (empty($_POST['email'])) {
        echo '<p class="error">You forgot to input your email!</p >';
    } else {
        $email = $_POST['email'];
    }  
    if (empty($_POST['password'])) {
        echo '<p class="error">You forgot to input your password!</p >';
    } else {
        $password = $_POST['password'];
    }
   
    if (isset($email, $password)) {
        require('chatdb.php');
        $sql = "SELECT user_id,username
                FROM users
                WHERE email='$email' AND password=SHA1('$password')";
        $result = mysqli_query($dbc, $sql);
       
        //if (mysqli_num_rows($result) > 0) {  
			$row=mysqli_fetch_array($result, MYSQLI_ASSOC);
            $_SESSION['uid'] = $row['user_id'];
			$_SESSION["un"] = $row['username'];
		    $id=$row['user_id'];
			$_SESSION["avatar"] = $row['avatar'];
			header("Location: friendlist.php?id=".$id);
            exit();            
           
        
    }
	else{
		echo"The password and image do not match";
	}
}  
?> 
</div>

</html>



