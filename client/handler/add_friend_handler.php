<?php
$conn = new mysqli("localhost", "root", "root", "tower_defense") or die("Connect failed: %s\n". $conn -> error);


$id = $_COOKIE["id"];

if (isset($_POST['add_friend'])) {
    $name = $_POST['add_friend'];
    $sql = "SELECT * FROM users WHERE ID_user != $id  AND user_name LIKE '%$name%'";
    $result = $conn->query($sql);
}

if (isset($_POST['added'])) {
    $friend = $_POST['added'];
    // $req = "INSERT INTO relations (ID_user1, ID_user2, nature)
    // VALUES ($id , $friend, 'Meilleur ami pour la vie')";

    $req = "INSERT INTO discussion_mp (ID_user1, ID_user2)
    VALUES ($id , $friend)";

    if ($conn->query($req) === TRUE) {
        echo "Bienvenue à toi mon khoya";
    } else {
        echo "Error: " . $req . "<br>" . $conn->error;
    }
    
    $conn -> close();
}
?>