<?php
$hostname = "localhost";
$username = "root";
$password = "";
$database = "tower_defense";

$con = mysqli_connect($hostname, $username, $password, $database);

if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

$user_id = 40; // mettre un ID_user pour le test ou

//$user_id = isset($_COOKIE['id']) ? $_COOKIE['id'] : 0;

// ptit sql pour la data
$query = "SELECT * FROM users WHERE ID_user = $user_id";
$result = mysqli_query($con, $query);
$user = mysqli_fetch_assoc($result);

if (isset($_POST['update_user'])) {
    $user_id = $_POST['user_id'];
    $new_user_name = $_POST['user_name'];
    $new_email = $_POST['email'];
    $new_tel = $_POST['tel'];
    $new_password = $_POST['mdp'];
    $new_photo_profil = $_POST['photo_profil'];

    $query = "UPDATE users SET user_name = '$new_user_name', email = '$new_email', tel = '$new_tel', mdp = '$new_password', photo_profil = '$new_photo_profil' WHERE ID_user = $user_id";
    $result = mysqli_query($con, $query);

    if ($result) {
        echo "User data has been updated successfully.";
    } else {
        echo "Error updating user data: " . mysqli_error($con);
    }
}

if (isset($_POST['delete_user'])) {
    $user_id = $_POST['user_id'];
// jai fais pour le tableau relation
    $query = "DELETE FROM Relations WHERE ID_user1 = $user_id OR ID_user2 = $user_id";
    $result = mysqli_query($con, $query);

    if ($result) {
        // on sup de la data
        $query = "DELETE FROM users WHERE ID_user = $user_id";
        $result = mysqli_query($con, $query);

        if ($result) {
            echo "User account has been deleted successfully.";
        } else {
            echo "Error deleting user account: " . mysqli_error($con);
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>C ta page yo</title>
    <style>
        /* où est le css ? */
    </style>
</head>
<body>
    <h1>Stylé ton compte mon GARS</h1>

    <!-- pour update form -->
    <h2>Change ta donnée mek</h2>
    <form action="" method="POST">
        <input type="hidden" name="user_id" value="<?php echo $user['ID_user']; ?>">

        <label for="user_name">Blaze:</label>
        <input type="text" name="user_name" value="<?php echo $user['user_name']; ?>" required>

        <label for="email">MAIl:</label>
        <input type="email" name="email" value="<?php echo $user['email']; ?>" required>

        <label for="tel">bigo:</label>
        <input type="tel" name="tel" value="<?php echo $user['tel']; ?>" required>

        <label for="mdp">secret ton mdp:</label>
        <input type="password" name="mdp" required>

        <label for="photo_profil">PDP:</label>
        <input type="file" name="photo_profil">

        <input type="submit" name="update_user" value="Update">
    </form>

    <!-- dELeTe AcCount-->
    <h2>BYE BYE SITE DE MERDE</h2>
    <form action="" method="POST">
        <input type="hidden" name="user_id" value="<?php echo $user['ID_user']; ?>">

        <input type="submit" name="delete_user" value="Delete Account" onclick="return confirm('ON SE DIT ADIEU ma gle?');">
    </form>
</body>
</html>
