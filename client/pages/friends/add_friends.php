<?php
    $conn = new mysqli("localhost", "root", "root", "tower_defense") or die("Connect failed: %s\n". $conn -> error);
    $id = $_COOKIE["id"];

    if (isset($_POST['added'])) {
        $friend = $_POST['added'];
        // $req = "INSERT INTO relations (ID_user1, ID_user2, nature)
        // VALUES ($id , $friend, 'Meilleur ami pour la vie')";

        $sql = "SELECT *
        FROM discussion_mp WHERE ID_user1 = $id OR ID_user2 = $friend;";
        $res = $conn->query($sql);

        if(!$row = mysqli_fetch_assoc($res)) {
            $req = "INSERT INTO discussion_mp (ID_user1, ID_user2)
            VALUES ($id , $friend)";
        
            if ($conn->query($req) === TRUE) {
                echo "Bienvenue à toi mon khoya";
            } else {
                echo "Error: " . $req . "<br>" . $conn->error;
            }
        }else{
            echo "already friends";
        }

        
        $conn -> close();
    }
?>



<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../pages/assets/chat.css">
    <title>add friend</title>
</head>

<body>
    <div>
        <form method="POST">
            <input type="text" id="add_friend" name="add_friend" placeholder="cherche un coup" class="search">
            <input type="submit" value="enter" class="search_button"></input>
        </form>
    </div>

    <div>
        <?php
        if (isset($_POST['add_friend'])) {
            $name = $_POST['add_friend'];
            $sql = "SELECT * FROM users WHERE ID_user != $id  AND user_name LIKE '%$name%'";
            $result = $conn->query($sql);
            while ($row = mysqli_fetch_assoc($result)) {
                ?>
                <p>
                    <?php echo $row['user_name'] . "#" . $row['ID_user']; ?>
                </p>
                <form action="<?php echo "#" . $row['ID_user']; ?>" method="post">
                    <input type='hidden' value='<?php echo $row['ID_user']; ?>' name='added'>
                    <input type="submit" value="add friend">
                </form>
                <?php
            }
    }
        ?>
    </div>
</body>


</html>