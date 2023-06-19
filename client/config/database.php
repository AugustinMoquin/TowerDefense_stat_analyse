<?php

function openCon()
 {
 $dbhost = "localhost";
 $dbuser = "root";
 $dbpass = "root";
 $db = "tower_defense";
 $conn = new mysqli("localhost", "root", "root", "tower_defense") or die("Connect failed: %s\n". $conn -> error);
 
 return $conn;
 }
 
function closeCon($conn)
 {
 $conn -> close();
 }

 ?>