<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/home.css">
    <title>home</title>
</head>

<body>

    <header>
        <div class="container1">
            <div>
                <a href="home.php" style="background: repeat; border:none;">
                    <img src="assets/images/tower-svgrepo-com.png">
                </a>
            </div>
            <?php if ($_COOKIE['id'] == 1) { ?>
                <a href="../crud_gang/crud_amin/forum/admin_forum_g_crud.php" class="panel_admin">
                    <div class="panel_admin">pannel admin</div>
                </a>
                <?php
            } ?>
        </div>
        <div class="container2">
            <div class="register_account">
                <?php if (!$_COOKIE['id']) { ?>
                    <div class="register">register - login</div>
                    <?php
                } else { ?>
                    <div class="account">my account</div>
                <?php } ?>
            </div>
            <div class="menu">
                <a href="illustration/user/user_stat.php">
                    <div>My Stat</div>
                </a>
                <a href="illustration/user/user_hist.php">History</a>
                <a href="friends/friends_list.php">Friend List</a>
                <a href="friends/add_friends.php">Add Friend</a>
                <a href="friends/add_friends.php">Forum</a>
                <a href="chat/global_chat.php">Global Chat</a>
            </div>
        </div>
    </header>

    <div class="container">aled</div>

    <footer>

    </footer>

</body>


</html>