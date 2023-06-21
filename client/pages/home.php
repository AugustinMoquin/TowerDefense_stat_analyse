<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu:wght@300&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/home.css">
    <title>home</title>
</head>

<body>
    <div class="master">
        <header>
            <div class="container1">
                <div class="halo">
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

        <div class="container">
            <div class="image"> <h1 class="title"> TOWER DEFENSE </h1></div>
            <div class="text">
            <h2>TOWER DEFENSE</h2>    
            <p style="font-family: 'Ubuntu', sans-serif; font-size: 2rem;" ></br>Bienvenue dans "Tower Defense", un jeu de tower defense épique où vous devez défendre
                 votre royaume contre des hordes d'envahisseurs maléfiques. <br>
                Plongez-vous dans des batailles stratégiques, érigez des tours de défense
                 puissantes et utilisez des compétences spéciales pour repousser 
                l'ennemi. <br> Affrontez des vagues d'adversaires toujours plus coriaces,
                 améliorez vos tours et débloquez de nouvelles compétences pour devenir
                 le gardien ultime de Defendia. Préparez-vous à une aventure palpitante
                 , où la stratégie et la tactique sont les clés de la victoire.</p></div>
        </div>
    </div>


    <footer>

    </footer>

</body>


</html>