<?php

function view_friends(){
    $conn = new mysqli("localhost", "root", "root", "tower_defense") or die("Connect failed: %s\n". $conn -> error);
    $id = $_COOKIE["id"];
    $sql = "SELECT *
    FROM discussion_mp WHERE ID_user1 = $id OR ID_user2 = $id;";
    $result = $conn->query($sql);

    while ($row = mysqli_fetch_assoc($result)) {
        
        $ID_user2 = $row["ID_user2"];
        $ID_user1 = $row["ID_user1"];
        $id_relation = $row["ID_discussion"];
        echo "
        <html lang='en'>

        <head>
            <meta charset='UTF-8'>
            <meta http-equiv='X-UA-Compatible' content='IE=edge'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <title>Chat</title>
        </head>

        <body>";
                if($row['ID_user1'] = $id){
                    $usersql = "SELECT *
                    FROM users WHERE ID_user = $ID_user2";
                    $userRes = $conn->query($usersql);
                    $userRow = mysqli_fetch_assoc($userRes);
                    echo "
                    <p>
                        "echo '#' . $row['ID_user2']." ;
                        <?php echo ' - '" . $userRow['user_name']." ; ?>
                    </p>

                    <form action='<?php echo '../chat/chat.php?id='". $row['ID_user2'] ."; ?>' method='POST'> 
                        <input type='hidden' value='<?php echo ". $row['ID_user2'] ."; ?>' name='chat_with'>
                        <input type='hidden' value='<?php echo " . $id_relation."; ?>' name='id_relations'>
                        <input type='submit' value='chat with'>
                    </form>";
                }
                if($row['ID_user2'] = $id){
                    $usersql = "SELECT *
                    FROM users WHERE ID_user = $ID_user1";
                    $userRes = $conn->query($usersql);
                    $userRow = mysqli_fetch_assoc($userRes);
                    echo "
                <p>
                    <?php echo '#'" . $row['ID_user1']." ; ?>
                    <?php echo ' - '" . $userRow['user_name']." ; ?>
                </p>

                <form action='<?php echo '../chat/chat.php?id='".$row['ID_user1'] ."; ?>' method='POST'> 
                    <input type='hidden' value='<?php echo ". $row['ID_user1'] ."; ?>' name='chat_with'>
                    <input type='hidden' value='<?php echo " . $id_relation."; ?>' name='id_relations'>
                    <input type='submit' value='chat with'>
                </form>";
                }
            ?>
        </body>

        </html>
        <?php
    }
}
?>

