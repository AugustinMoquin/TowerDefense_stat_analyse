<header>
    <div class="container1">
        <div class="halo">
            <a href="../home/home.php" style="background: repeat; border:none;">
                <img src="../assets/images/tower-svgrepo-com.png">
            </a>
        </div>
        <?php if ($_COOKIE['id'] == 1) { ?>
            <a href="../../crud_gang/crud_amin/forum/forum/admin_forum_crud.php" class="panel_admin">
                <div class="panel_admin">pannel admin</div>
            </a>
            <?php
        } ?>
    </div>
    <div class="container3"> <h1>TOWER DEFENSE</h1></div>

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
            <a href="../illustration/user_stat.php">
                <div>My Stat</div>
            </a>
            <a href="../illustration/user_hist.php">History</a>
            <a href="../illustration/general_historique.php">History Global</a>
            <a href="../friends/friends_list.php">Friend List</a>
            <a href="../friends/add_friends.php">Add Friend</a>
            <a href="../friends/add_friends.php">Forum</a>
            <a href="../chat/global_chat.php">Global Chat</a>
            <a href="../illustration/rank.php">Rank</a>
        </div>
    </div>
</header>

<style>

@font-face {
    font-family: title;
    src: url(assets/fonts/KungFuMaster-K7vrX.otf);
}

*{
    margin:0px;
}

    header {
    height: 8rem;
    width: auto;
    box-shadow: inset 0 -3em 3em rgba(0, 0, 0, 0.1), 0 0 0 0px rgb(255, 255, 255), 0em 0.3em 1em rgba(0, 0, 0, 0.3);
    padding: 1rem;
    display: flex;
    flex-direction: row;
    color: black;
    /* background-color: #fbf1ff; */
    background-color: #694EB4;
}

.panel_admin {
    max-width: 7rem;
    background: repeat;
    border: none;
}

.halo {
    max-width: 5.5rem;
    border-radius: 100%;
    background-color: #fbf1ff;
}

img {
    max-width: 5rem;
}

a {
    border: solid white 1px;
    padding: 5px;
    border-radius: 3px;
    background-color: white;
}

a:link {
    color: black;
}


/* visited link */

a:visited {
    color: black;
}


/* mouse over link */

a:hover {
    color: hotpink;
}


/* selected link */

a:active {
    color: blue;
}

.container1 {
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    position: relative;
    width: 10%;
}

.container2 {
    display: flex;
    flex-direction: column;
    justify-content: right;
    position: relative;
    width: 40%;
    justify-content: space-between;
}

.container3{
    width: 40%;
    font-size: 3rem;
    font-family: title, Arial;
    margin-right: 10%;
}

.menu {
    display: flex;
    flex-direction: row;
    gap: 1rem;
}

.register_account {
    justify-content: right;
    position: relative;
    display: flex;
    flex-direction: row;
}

.register {
    float: right;
    margin-right: 0px;
    transform: translateX(-50%);
    position: relative;
}

.account {
    float: right;
    margin-right: 0px;
    transform: translateX(-50%);
    position: relative;
}
</style>