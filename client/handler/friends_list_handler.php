<?php

function view_friends(){
    $conn = new mysqli("localhost", "root", "root", "tower_defense") or die("Connect failed: %s\n". $conn -> error);
    $id = $_COOKIE["id"];
    $sql = "SELECT *
    FROM users
    INNER JOIN discussion_mp ON users.ID_user = discussion_mp.ID_user1;";
    $result = $conn->query($sql);

    while ($row = mysqli_fetch_assoc($result)) {
        ?>
        <html lang="en">

        <head>
            <meta charset="UTF-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Chat</title>
        </head>

        <body>

            <p>
                <?php echo "#" . $row['ID_user2']; ?>
            </p>
            <form action="<?php echo "../chat/chat.php?id=".$row['ID_user2']; ?>" method="POST"> 
                <input type='hidden' value='<?php echo $row['ID_user2']; ?>' name='chat_with'>
                <input type='hidden' value='<?php echo $row['ID_Relations']; ?>' name='id_relations'>
                <input type="submit" value="chat with">
            </form>

        </body>

        </html>
        <?php
        // if (isset($_POST['chat_with'])) {
        //     Chat_with();
        // }
    }
}
?>

