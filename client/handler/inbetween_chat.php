<?php
require ("../../src\config\database.php");

$id_user2 = $_POST['user'];
$conn = openCon();
$sql = "INSERT INTO discussion_mp (ID_user1, ID_user2)
VALUES ('1', '$id_user2')";

if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();

header('../chat/chat.php');

