<!DOCTYPE html>
<html>
<head>
	<title>Friend List</title>
		<style>
			.form{
				    display: flex;
  					justify-content: center;
					}
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
        }
        
        #header {
            background-color: #333;
            color: #fff;
            padding: 20px;
            text-align: center;
        }
        
        #content {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-top: 20px;
        }
        
        h1 {
            margin: 0;
            padding: 0;
        }
        
        p {
            margin-top: 10px;
        }
        
        input[type="text"],
        input[type="password"],
        input[type="email"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        
        input[type="submit"] {
            background-color: #333;
            color: #fff;
            border: none;
            padding: 10px 20px;
            text-align: center;
            cursor: pointer;
            border-radius: 5px;
        }
        
        .error {
            color: red;
        }
			.form{
				    display: flex;
  					justify-content: center;
				
					}
			.family {
  position: relative;
}

.button {
  position: absolute;
  top: 0;
  left: 0;
  z-index: 1;
}

.div1 {
  position: absolute;
  top: 0;
  left: 0;
  z-index: 2;
}
.content{
				overflow: auto;
	width: 600px;
        height: 200px; 
			}
.button {
display: table-cell;
vertical-align: middle;
}
  			.a{
margin: 0px;
        padding: 0px;
	 width: 100%;
        text-align: center;
        bottom: 0px;
        position: fixed;

}
</style>			
</head>

<body>	
    <div id="header">
        <h1>Chatroom TiMi</h1>
	</div>

	<div id="content">	
	
<?php
session_start();
if(isset($_SESSION['uid']) && isset($_SESSION['un'])) {
	     $n=$_SESSION['uid'];
	      
	      echo '<body>
					<div>
					<h1>Welcome</h1>
					<h2>hello '.$_SESSION['un'].'</h2>
					<div class="a"><form id="form3" name="form3" method="get"><input type="text" name="friend" id="friend"><input type="submit"></form></div>';
//header
	echo'<div class="content">';
	      require('chatdb.php');
	      $T="SELECT id,friend,users, DATE_FORMAT(create_time,'%M %d %Y') FROM relationship WHERE users='$n' OR friend='$n'";
					$R=mysqli_query($dbc,$T);
	                while ($q = mysqli_fetch_array($R,MYSQLI_ASSOC)){
						$friend=$q ['friend'];
						$user1=$q ['users'];
						$_SESSION ['id'] = $q ['id'];		  
						$id=$_SESSION ['id'];
						$query5="SELECT username,avatar FROM users WHERE user_id<>'$n' and (user_id='$friend' or user_id='$user1')" ;//寻找新好友对信息并列印出来
								     $result5=mysqli_query($dbc,$query5);
								     $output5=mysqli_fetch_array($result5,MYSQLI_ASSOC);
								     $z3=$output5['username'];
								     $s3=$output5['avatar'];
								echo"<div class='family'><div class=button> <a href='chatting.php?id=$id'>
 <button style='width:600px;height: 50px;'>".$z3."</button>
</a></div1>";
						
							}
	//friendlist
		  
if (isset($_GET['friend'])) {
	$f =$_GET['friend'];
	$query1="SELECT user_id,username,avatar 
			 FROM users  
			 WHERE 
			 email='$f'"; //判断是否存在该用户
	$result1 = mysqli_query($dbc,$query1);
	if ($result1->num_rows > 0){
		                    $rowf = mysqli_fetch_array($result1,MYSQLI_ASSOC);
		                    $friendid=$rowf['user_id'];
							$queryr="SELECT friend FROM relationship WHERE (friend='$friendid' OR friend='$n') AND (users='$n' OR users='$friendid');";
							$resultr=mysqli_query($dbc,$queryr);
		                    $rowt = mysqli_fetch_array($resultr,MYSQLI_ASSOC);//判断是否已经是朋友
		                    if(!$rowt){
								$query2 = "INSERT INTO relationship (users,friend,create_time) VALUES('$n','$friendid',NOW());";
								$result2 = mysqli_query($dbc,$query2);//添加好友
									 $query3="SELECT id FROM relationship WHERE users='$n' AND friend=' $friendid'"; //把新好友列印出来
									 $result3= mysqli_query($dbc,$query3);
									 $sessionr=mysqli_fetch_array($result3,MYSQLI_ASSOC);
									 $_SESSION['id'] = $sessionr['id'];//把ID放在一个session里面
									 $id=$_SESSION['id'];
								     $query6="SELECT username,avatar FROM users WHERE user_id='$friendid'" ;//寻找新好友对信息并列印出来
								     $result6=mysqli_query($dbc,$query6);
								     $output6=mysqli_fetch_array($result6,MYSQLI_ASSOC);
								     $z=$output6['username'];
								     $s=$output6['avatar'];
								     echo"<div class='family'><div class=button> <a href='chatting.php?id=$id'>
 <button style='width:600px;height: 50px;'>".$z."</button>
</a></div1>";
								
							}

		           else{
			             echo'You are already friends！';
				   }
		}
	else{
				 echo'This account does not exist';
			 }
}
	 

}
		echo'</div>';
?>	
</div>
	</body>	

