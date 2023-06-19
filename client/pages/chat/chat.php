<?php
require_once("../../handler/chat_handler.php");
$conn = new mysqli("localhost", "root", "root", "tower_defense") or die("Connect failed: %s\n". $conn -> error);
$friendId = $_GET['id'];
?>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../pages/assets/chat.css">
    <title>chat</title>
</head>
<body>
    <form method="POST" action='<?php echo "chat.php?id=". $friendId; ?>'>
        <input type="text" id="message" name="message" required maxlength="50" size="10">
        <button type="submit">envoie</button>
    </form>

    <div>
        <?php 
        if (isset($_POST['message'])){
            Add_message($friendId);
        }
        Display_chat($friendId);
        ?>
    </div>
</body>


</html>