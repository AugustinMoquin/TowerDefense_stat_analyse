<?php
require_once("../../handler/chat_handler.php");
$conn = new mysqli("localhost", "root", "root", "tower_defense") or die("Connect failed: %s\n" . $conn->error);
$friendId = $_GET['id'];
?>
<?php

$rootDir = 'C:\xampp\htdocs\TowerDefense_stat_analyse\client\pages/header.php';
require_once $rootDir;

?>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/chat.css">
    <title>chat</title>
</head>

<body>
    <iframe src='<?php echo "iframe.php?id=" . $friendId; ?>
            ' id="iframe" title="iframe" class="iframe">
    </iframe>
    <div class="message_container">
        <form method="POST" action='<?php echo "chat.php?id=" . $friendId; ?>'>
            <input type="text" id="message" name="message" class="message" required maxlength="50" size="10" placeholder="Your message">
            <input type="submit" value="send" class="button_submit"></button>
        </form>
    </div>
        <?php
        if (isset($_POST['message'])) {
            Add_message($friendId);
            unset($_POST['message']);
        }
        ?>
</body>

</html>
<!-- <script>
    document.getElementById('iframe').src = document.getElementById('iframe').src
</script> -->