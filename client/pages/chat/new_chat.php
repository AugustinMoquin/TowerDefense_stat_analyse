<?php
require("../../handler/new_chat_handler.php");
?>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat</title>
</head>

<body>
    <form method='POST' action='#'>
        <input type='text' name='search_name' id='search'>
        <button> search </button>
    </form>
    <?php
    if (isset($_POST['search_name'])) {
        Get_users();
    }

    ?>


</body>

</html>