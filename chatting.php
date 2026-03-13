<!DOCTYPE html>
<html>
<head>
<title>Chat Room</title>
<meta charset="utf-8">
<link rel="stylesheet" href="chatroom_style.css" />

</head>

	</style>
<body>
	<div id="wrapper">
            


<?php
session_start();
require('chatdb.php');

	        
      
	     $id=$_GET['id'];
	     $n=$_SESSION['uid'];//$id=$_GET['id'];
		 $query0="SELECT friend FROM relationship WHERE id='$id'";
		 $R0=mysqli_query($dbc,$query0);
		 $fr= mysqli_fetch_array($R0,MYSQLI_ASSOC);
		 $friend=$fr['friend'];
		 $queryq="SELECT avatar,username FROM users WHERE user_id='$friend'";
		 $Rq=mysqli_query($dbc,$queryq);	
		 $fq= mysqli_fetch_array($Rq,MYSQLI_ASSOC);
		 $namef=$fq['username'];
		 $favatar=$fq['avatar'];
		$imageDataq = base64_encode($favatar);
		 echo'<div id="menu">
                <p class="welcome"><img src="data:image/jpeg; base64,'.$imageDataq.'"  class="circle-image">'.$namef.'<b></b></p>
                <p class="logout"><a id="exit" href="friendlist.php">Exit Chat</a></p>
            </div>
            <div id="chatbox">';
		 $query1="SELECT message,image,sender_id,DATE_FORMAT(create_time,'%M %d %Y') FROM messages WHERE room_id='$id' ORDER BY create_time ASC";//选择需要的message
		 $R=mysqli_query($dbc,$query1);
	if ($R->num_rows > 0){
		while($q = mysqli_fetch_array($R,MYSQLI_ASSOC)){
    			 $r=$q['sender_id'];
			 $query2="SELECT username,avatar FROM users WHERE user_id='$r' ORDER BY create_time ASC";
			 $R2=mysqli_query($dbc,$query2);
			 $q2 = mysqli_fetch_array($R2,MYSQLI_ASSOC);
			 $me=$q['message'];
			 $name=$q2['username'];
			$im=$q['image'];
			 $avatar=$q2['avatar'];
			  $imageData3 = base64_encode($avatar);
			  $imageData2 = base64_encode($im);
             if(is_null($me)){
				if($r==$n){
			 $e='<div class="image-container" style="float:left;">';}
				else{$e='<div class="image-container" style="float:right;">';
				}
                      
		echo $e;
		echo '<img src="data:image/jpeg; base64,'.$imageData3.'"  class="circle-image">';
		echo'<img src="data:image/jpeg;base64,'.$imageData2.'" class="image2">';
		echo'</div>';
				  }
					
			 else{
				if($r==$n){
			 $i='<div class="message-container" style="float:left">';
				 $l="<div class='message' style='background-color:#FFFFFF;'>";}
				 
				else{$i='<div class="message-container" style="float:right;>';
					 $l="<div class='message' style='background-color:#B3C4D9;'>";}
			echo $i;
			 echo'<img src="data:image/jpeg; base64,'.$imageData3.'"  class="circle-image">'.$name.':';
			 echo $l.$me." </div></div>";}
				
						 
	}}

	
		
	

		if(!empty($_POST['m'])){
		$message=$_POST['m'];
		$n=$_SESSION['uid'];
		$query2="INSERT INTO messages (room_id,sender_id,message,create_time) VALUES('$id', '$n','$message',NOW());";//插入消息库里面
		$Q=mysqli_query($dbc,$query2);
			if($Q){
		 $query6="SELECT message FROM messages WHERE room_id='$id' ORDER BY create_time DESC LIMIT 1" ;
								     $result6 = mysqli_query($dbc,$query6);
								     $output6 = mysqli_fetch_array($result6,MYSQLI_ASSOC);
								     $z = $output6['message'];
			                         $query3="SELECT username,avatar FROM users WHERE user_id='$n' ORDER BY create_time ASC";
			 						 $R3=mysqli_query($dbc,$query3);
			 						 $q3 = mysqli_fetch_array($R3,MYSQLI_ASSOC);
				                     $sender1=$q3['username'];
				                     $avatar1=$q3['avatar'];
				 					 $imageData5 = base64_encode($avatar1);
								     echo '<div class="message-container" style="float:left;">';//新消息插入
				 echo'<img src="data:image/jpeg; base64,'. $imageData5.'"  class="circle-image">'.$sender1.':';
			 echo "<div class='message'>".$z." </div></div>";
			
		}
		}
      if(!empty($_FILES['image1'])){
        $image=$_FILES['image1'];
		$con= file_get_contents($image['tmp_name']);
		$blob=addslashes(file_get_contents($image['tmp_name']));
		$R="INSERT INTO messages (sender_id,room_id,create_time,image) VALUES('$n','$id',NOW(),'$blob');";
	   $U=mysqli_query($dbc,$R);
	if ($U){
		$query7="SELECT image FROM messages WHERE room_id='$id' ORDER BY create_time DESC LIMIT 1" ;
								     $result7 = mysqli_query($dbc,$query7);
								     $output7 = mysqli_fetch_array($result7,MYSQLI_ASSOC);
								     $z = $output7['image'];
			                         //$r=$output7['sender_id'];
			$imageData = base64_encode($z);
		 $imageData3 = base64_encode($avatar);
		echo'<div class="image-container" style="float:left;">';
		echo '<img src="data:image/jpeg; base64,'.$imageData3.'"  class="circle-image">';
		echo'<img src="data:image/jpeg;base64,'.$imageData.'" class="image2">';
		echo'</div>';
	}
 }
				echo'</div>';
 echo'<form id="myForm"  enctype="multipart/form-data" method="post" ">
	 <input name="m" type="text" id="m">
<input type="submit" value="send"></form>
 <form id="myForm2" method="post"  enctype="multipart/form-data" ">
 <input name="image1" id=image1 type="file" size="10" value="Choose a File" ><input type="submit" value="send">  
</form>';
?>
</body>
</html>