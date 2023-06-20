<?php
session_start();

// Vérification des autorisations (si nécessaire)
//$user_name = $_SESSION['user_name'];
//if ($user_name !== 'admin') {
//    echo "Vous n'avez pas les autorisations pour gérer les commentaires.";
//    exit;
//}


$pdo = new PDO('mysql:host=127.0.0.1;dbname=tower_defense', 'root', '');

// (Create)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['create_commentaire'])) {
    $ID_user = $_POST['ID_user'];
    $ID_post = $_POST['ID_post'];
    $commentaire = $_POST['commentaire'];
    $Timestamp = $_POST['Timestamp'];

    $sql = "INSERT INTO commentaire (ID_user, ID_post, commentaire, Timestamp) VALUES (:ID_user, :ID_post, :commentaire, :Timestamp)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(':ID_user' => $ID_user, ':ID_post' => $ID_post, ':commentaire' => $commentaire, ':Timestamp' => $Timestamp));

    echo "Le commentaire a été créé avec succès.";
}

// Opération de lecture (Read)
$sql = "SELECT * FROM commentaire";
$stmt = $pdo->query($sql);

echo "<h2>Liste des commentaires</h2>";
echo "<table>";
echo "<tr><th>ID_commentaire</th><th>ID_user</th><th>ID_post</th><th>Commentaire</th><th>Timestamp</th></tr>";

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    echo "<tr>";
    echo "<td>" . $row['ID_commentaire'] . "</td>";
    echo "<td>" . $row['ID_user'] . "</td>";
    echo "<td>" . $row['ID_post'] . "</td>";
    echo "<td>" . $row['commentaire'] . "</td>";
    echo "<td>" . $row['Timestamp'] . "</td>";
    echo "</tr>";
}

echo "</table>";

// (Update)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_commentaire'])) {
    $ID_commentaire = $_POST['ID_commentaire'];
    $ID_user = $_POST['ID_user'];
    $ID_post = $_POST['ID_post'];
    $commentaire = $_POST['commentaire'];
    $Timestamp = $_POST['Timestamp'];

    $sql = "UPDATE commentaire SET ID_user = :ID_user, ID_post = :ID_post, commentaire = :commentaire, Timestamp = :Timestamp WHERE ID_commentaire = :ID_commentaire";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(':ID_user' => $ID_user, ':ID_post' => $ID_post, ':commentaire' => $commentaire, ':Timestamp' => $Timestamp, ':ID_commentaire' => $ID_commentaire));

    echo "Le commentaire a été mis à jour avec succès.";
}

//  (Delete)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_commentaire'])) {
    $ID_commentaire = $_POST['ID_commentaire'];

    $sql = "DELETE FROM commentaire WHERE ID_commentaire = :ID_commentaire";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(':ID_commentaire' => $ID_commentaire));

    echo "Le commentaire a été supprimé avec succès.";
}
?>

<h2>Créer un commentaire</h2>
<form method="post" action="">
    <input type="hidden" name="create_commentaire" value="1">
    <label for="ID_user">ID_user :</label>
    <input type="number" name="ID_user" required><br>
    <label for="ID_post">ID_post :</label>
    <input type="number" name="ID_post" required><br>
    <label for="commentaire">Commentaire :</label>
    <input type="text" name="commentaire" required><br>
    <label for="Timestamp">Timestamp :</label>
    <input type="datetime-local" name="Timestamp" required><br>
    <input type="submit" value="Créer">
</form>

<h2>Mettre à jour un commentaire</h2>
<form method="post" action="">
    <input type="hidden" name="update_commentaire" value="1">
    <label for="ID_commentaire">ID_commentaire :</label>
    <input type="number" name="ID_commentaire" required><br>
    <label for="ID_user">ID_user :</label>
    <input type="number" name="ID_user" required><br>
    <label for="ID_post">ID_post :</label>
    <input type="number" name="ID_post" required><br>
    <label for="commentaire">Commentaire :</label>
    <input type="text" name="commentaire" required><br>
    <label for="Timestamp">Timestamp :</label>
    <input type="datetime-local" name="Timestamp" required><br>
    <input type="submit" value="Mettre à jour">
</form>

<h2>Supprimer un commentaire</h2>
<form method="post" action="">
    <input type="hidden" name="delete_commentaire" value="1">
    <label for="ID_commentaire">ID_commentaire :</label>
    <input type="number" name="ID_commentaire" required><br>
    <input type="submit" value="Supprimer">
</form>
