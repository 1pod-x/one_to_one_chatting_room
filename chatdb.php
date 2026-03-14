<?php
DEFINE('DB_USER','p2211032');
DEFINE('DB_PASSWORD','yourpassport');
DEFINE('DB_HOST','localhost');
DEFINE('DB_NAME','p2211032');
$dbc=mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME) or
 die('Could not connect to MySQL:'.mysqli_connect_error());
?>
