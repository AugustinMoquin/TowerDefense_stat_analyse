<?php
require_once("../../handler/global_chat_handler.php");
$conn = mysqli_connect("localhost", "root", 'root', "tower_defense");
?>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../pages/assets/chat.css">
    <title>global chat</title>
</head>

<body>
    <div>
        <iframe src='global_iframe.php' id="iframe" title="iframe">
        </iframe>
    </div>
    <form method="POST" action='global_chat.php'>
        <input type="text" id="global_message" name="global_message" size="10">
        <input type="submit" value="send"></button>
    </form>
    <div id="txtHint"></div>
    <div>
        <?php
        if (isset($_POST['global_message'])) {
            Add_message_global();
            unset($_POST['global_message']);
        }
        ?>
    </div>
</body>

</html>
<!-- <script>
    document.getElementById('iframe').src = document.getElementById('iframe').src
</script> -->