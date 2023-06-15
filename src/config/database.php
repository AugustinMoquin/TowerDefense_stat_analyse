<?php

function openCon()
 {
 $dbhost = "localhost";
 $dbuser = "root";
 $dbpass = "root";
 $db = "tower_defense";
 $conn = new mysqli($dbhost, $dbuser, $dbpass, $db) or die("Connect failed: %s\n". $conn -> error);
 
 return $conn;
 }
 
function closeCon($conn)
 {
 $conn -> close();
 }

 ?>