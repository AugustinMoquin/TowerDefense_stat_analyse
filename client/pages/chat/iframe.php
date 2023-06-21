<meta http-equiv="refresh" content="2">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/iframe.css">
    <title>chat</title>
</head>

<script>
        window.onload = function() {
            window.scrollTo(0, document.body.scrollHeight);
        };
</script>

<?php
$conn = new mysqli("localhost", "root", "root", "tower_defense") or die("Connect failed: %s\n". $conn -> error);
$id_user = $_COOKIE['id'];
$friendId = $_GET['id'];

$sql = "SELECT ID_discussion FROM discussion_mp WHERE (ID_user1=$id_user AND ID_user2=$friendId) OR (ID_user2=$id_user AND ID_user1=$friendId)"; //
$result = $conn->query($sql);
if($row = mysqli_fetch_assoc($result)){
    $id_discussion = $row['ID_discussion'];
    $sql2 = "SELECT * from message WHERE ID_discussion = $id_discussion";
    $result2 = $conn->query($sql2);
    if ($result2->num_rows > 0) {
        // output data of each row
        while($row2 = $result2->fetch_assoc()) {
            echo "
            <div class='user'>
                from user : ". $row2["ID_user"]. " | at : " . $row2["timestamp"]." <br>
                message : " . $row2['contenu']."  
                <br>
                <br>
                <div class='bar'></div>
                <br>
            </div> 
            ";
        }
        } else {
        echo "0 results";
        }

}

$conn -> close();
?>