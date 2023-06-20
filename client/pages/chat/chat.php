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
    <div>
        <iframe src='<?php echo "http://localhost/towerdefense_stat_analyse/client/pages/chat/iframe.php?id=". $friendId;?>
             ' id="iframe" title="iframe">
        </iframe>
    </div>
    <form method="POST" action='<?php echo "chat.php?id=". $friendId; ?>'>
        <input type="text" id="message" name="message" required maxlength="50" size="10">
        <input type="submit" value="send"></button>
    </form>
    <div id="txtHint"></div>
    <div>
        <?php 
        if (isset($_POST['message'])){
            Add_message($friendId);
            unset($_POST['message']);
        }
        ?>
    </div>
</body>
</html>
<!-- <script>
    document.getElementById('iframe').src = document.getElementById('iframe').src
</script> -->