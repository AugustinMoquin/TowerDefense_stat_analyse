<?php

$rootDir = 'C:\xampp\htdocs\TowerDefense_stat_analyse\client\pages/header.php';
require_once $rootDir;

?>

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

        if($row = mysqli_fetch_assoc($res)) {
            $req = "INSERT INTO discussion_mp (ID_user1, ID_user2)
            VALUES ($id , $friend)";
        
            if ($conn->query($req) === TRUE) {
                $message = "ajouté";
                echo "<script type='text/javascript'>alert('$message');</script>";
            } else {
                echo "Error: " . $req . "<br>" . $conn->error;
            }
        }else{
            $message = "déjà ton poto";
            echo "<script type='text/javascript'>alert('$message');</script>";
        }

        
        $conn -> close();
    }
?>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/add_friend.css">
    <title>add friend</title>
</head>

<body>

    <div class="master">
            <form method="POST" class="container">
                <input type="text" id="add_friend" name="add_friend" placeholder="cherche un coup" class="search">
                <button type="submit" class="search-button ">&#9773;</button>
            </form>
        <div class="container_list_master">
            <div class="container_list">
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
                        <div>
                            <form action="<?php echo "#" . $row['ID_user']; ?>" method="post" class="container_list_item">
                                <input type='hidden' value='<?php echo $row['ID_user']; ?>' name='added' class="item">
                                <input type="submit" value="add" class="add-button" >
                            </form>
                        </div>
                        <div class="bar" ></div>
                        <?php
                    }
            }
                ?>
            </div>
        </div>
    </div>
</body>


</html>