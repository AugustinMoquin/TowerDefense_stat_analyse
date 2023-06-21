<?php
$hostname = "localhost";
$username = "root";
$password = "";
$database = "tower_defense";

$con = mysqli_connect($hostname, $username, $password, $database);

if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

// CREATE  user
if (isset($_POST['addUser'])) {
    $userName = $_POST['userName'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    $tel = $_POST['tel'];
    $photoProfil = $_POST['photoProfil'];

    $insertUserQuery = "INSERT INTO users (user_name, mdp, email, tel, photo_profil) 
                        VALUES ('$userName', '$password', '$email', '$tel', '$photoProfil')";

    $resultInsertUser = mysqli_query($con, $insertUserQuery);

    if ($resultInsertUser) {
        echo "L'utilisateur a été ajouté avec succès.";
    } else {
        echo "Une erreur s'est produite lors de l'ajout de l'utilisateur.";
    }
}

// vizu sur tout les users
$queryUsers = "SELECT * FROM users";
$resultUsers = mysqli_query($con, $queryUsers);

// MAJ USER ( devoir remplir tout les critères)
if (isset($_POST['updateUser'])) {
    $userID = $_POST['userID'];
    $newUserName = $_POST['newUserName'];
    $newPassword = $_POST['newPassword'];
    $newEmail = $_POST['newEmail'];
    $newTel = $_POST['newTel'];
    $newPhotoProfil = $_POST['newPhotoProfil'];

    $updateUserQuery = "UPDATE users SET 
                        user_name = '$newUserName',
                        mdp = '$newPassword',
                        email = '$newEmail',
                        tel = '$newTel',
                        photo_profil = '$newPhotoProfil' 
                        WHERE ID_user = $userID";

    $resultUpdateUser = mysqli_query($con, $updateUserQuery);

    if ($resultUpdateUser) {
        echo "L'utilisateur a été mis à jour avec succès.";
    } else {
        echo "Une erreur s'est produite lors de la mise à jour de l'utilisateur.";
    }
}

// sup un user
if (isset($_POST['deleteUser'])) {
    $deleteUserID = $_POST['deleteUserID'];

    //Del commentaire
    $deleteCommentaireQuery = "DELETE FROM commentaire WHERE ID_user = $deleteUserID";
    $resultDeleteCommentaire = mysqli_query($con, $deleteCommentaireQuery);

    // Del partie_lambda
    $deletePartieLambdaQuery = "DELETE FROM partie_lambda WHERE ID_user = $deleteUserID";
    $resultDeletePartieLambda = mysqli_query($con, $deletePartieLambdaQuery);

    // Del statistiques_user
    $deleteStatistiquesUserQuery = "DELETE FROM statistiques_user WHERE ID_user = $deleteUserID";
    $resultDeleteStatistiquesUser = mysqli_query($con, $deleteStatistiquesUserQuery);

    // Del post 
    $deletePostQuery = "DELETE FROM post WHERE ID_user = $deleteUserID";
    $resultDeletePost = mysqli_query($con, $deletePostQuery);

    // Del  message 
    $deleteMessageQuery = "DELETE FROM message WHERE ID_user = $deleteUserID";
    $resultDeleteMessage = mysqli_query($con, $deleteMessageQuery);

    // Del Relations 
    $deleteRelationsQuery = "DELETE FROM Relations WHERE ID_user1 = $deleteUserID OR ID_user2 = $deleteUserID";
    $resultDeleteRelations = mysqli_query($con, $deleteRelationsQuery);

    // Delete  users
    $deleteUserQuery = "DELETE FROM users WHERE ID_user = $deleteUserID";
    $resultDeleteUser = mysqli_query($con, $deleteUserQuery);

    if ($resultDeleteUser) {
        // Delete tout les users
        $deleteCascadeQuery1 = "DELETE FROM partie_lambda WHERE ID_user = $deleteUserID";
        $deleteCascadeQuery2 = "DELETE FROM historique_générale WHERE ID_user = $deleteUserID";
        $deleteCascadeQuery3 = "DELETE FROM statistiques_user WHERE ID_user = $deleteUserID";
        $deleteCascadeQuery4 = "DELETE FROM post WHERE ID_user = $deleteUserID";
        $deleteCascadeQuery5 = "DELETE FROM commentaire WHERE ID_user = $deleteUserID";
        $deleteCascadeQuery6 = "DELETE FROM message WHERE ID_user = $deleteUserID";
        $deleteCascadeQuery7 = "DELETE FROM Relations WHERE ID_user1 = $deleteUserID OR ID_user2 = $deleteUserID";

        $resultDeleteCascade1 = mysqli_query($con, $deleteCascadeQuery1);
        $resultDeleteCascade2 = mysqli_query($con, $deleteCascadeQuery2);
        $resultDeleteCascade3 = mysqli_query($con, $deleteCascadeQuery3);
        $resultDeleteCascade4 = mysqli_query($con, $deleteCascadeQuery4);
        $resultDeleteCascade5 = mysqli_query($con, $deleteCascadeQuery5);
        $resultDeleteCascade6 = mysqli_query($con, $deleteCascadeQuery6);
        $resultDeleteCascade7 = mysqli_query($con, $deleteCascadeQuery7);

            if ($resultDeleteCascade1 && $resultDeleteCascade2 && $resultDeleteCascade3 && $resultDeleteCascade4 && $resultDeleteCascade5 && $resultDeleteCascade6 && $resultDeleteCascade7) {
                echo "L'utilisateur et les enregistrements associés ont été supprimés avec succès.";
            } else {
                echo "Une erreur s'est produite lors de la suppression des enregistrements associés.";
            }
        } else {
            echo "Une erreur s'est produite lors de la suppression de l'utilisateur.";
        }
    } else {
        echo "Une erreur s'est produite lors de la suppression des commentaires associés.";
    }


mysqli_close($con);
?>

<!DOCTYPE html>
<html>
<head>
    <title>CRUD Utilisateurs</title>
</head>
<body>
    <h1>CRUD Utilisateurs</h1>

    <!-- formu joueur -->
    <h2>Ajout un frr</h2>
    <form method="POST" action="">
        <input type="text" name="userName" placeholder="Nom d'utilisateur" required><br><br>
        <input type="password" name="password" placeholder="Mot de passe" required><br><br>
        <input type="email" name="email" placeholder="Adresse e-mail" required><br><br>
        <input type="text" name="tel" placeholder="Numéro de téléphone" required><br><br>
        <input type="text" name="photoProfil" placeholder="URL de la photo de profil"><br><br>
        <input type="submit" name="addUser" value="Ajouter">
    </form>

    <!--liste des users -->
    <h2>Liste des utilisateurs</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Nom d'utilisateur</th>
            <th>E-mail</th>
            <th>Téléphone</th>
            <th>Photo de profil</th>
            <th>Actions</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($resultUsers)) { ?>
            <tr>
                <td><?php echo $row['ID_user']; ?></td>
                <td><?php echo $row['user_name']; ?></td>
                <td><?php echo $row['email']; ?></td>
                <td><?php echo $row['tel']; ?></td>
                <td><?php echo $row['photo_profil']; ?></td>
                <td>
                    <!-- Form MAJ joueur -->
                    <form method="POST" action="">
                        <input type="hidden" name="userID" value="<?php echo $row['ID_user']; ?>">
                        <input type="text" name="newUserName" placeholder="Nouveau nom d'utilisateur" required><br><br>
                        <input type="password" name="newPassword" placeholder="Nouveau mot de passe" required><br><br>
                        <input type="email" name="newEmail" placeholder="Nouvelle adresse e-mail" required><br><br>
                        <input type="text" name="newTel" placeholder="Nouveau numéro de téléphone" required><br><br>
                        <input type="text" name="newPhotoProfil" placeholder="Nouvelle URL de la photo de profil"><br><br>
                        <input type="submit" name="updateUser" value="Mettre à jour">
                    </form>

                    <!-- Formulaire suppression -->
                    <form method="POST" action="">
                        <input type="hidden" name="deleteUserID" value="<?php echo $row['ID_user']; ?>">
                        <input type="submit" name="deleteUser" value="Supprimer">
                    </form>
                </td>
            </tr>
        <?php } ?>
    </table>
</body>
</html>
