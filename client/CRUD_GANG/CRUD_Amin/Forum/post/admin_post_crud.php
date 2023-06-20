<?php
session_start();
//$ID_user = $_SESSION['ID_user'];
//$user_name = $_SESSION['user_name'];

//if ($user_name !== 'admin') {
   // echo "Vous n'avez pas les autorisations pour gérer les posts.";
   // exit;
//}

// Connexion à la base de données
$pdo = new PDO('mysql:host=127.0.0.1;dbname=tower_defense', 'root', '');

// Opération de création (Create)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['create_post'])) {
    $ID_user = $_POST['ID_user'];
    $ID_forum = $_POST['ID_forum'];
    $Post = $_POST['Post'];
    $titre = $_POST['titre'];
    $Timestamp = $_POST['Timestamp'];

    $sql = "INSERT INTO post (ID_user, ID_forum, Post, titre, Timestamp) VALUES (:ID_user, :ID_forum, :Post, :titre, :Timestamp)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(':ID_user' => $ID_user, ':ID_forum' => $ID_forum, ':Post' => $Post, ':titre' => $titre, ':Timestamp' => $Timestamp));

    echo "Le post a été créé avec succès.";
}

// Opération de lecture (Read)
$sql = "SELECT * FROM post";
$stmt = $pdo->query($sql);

echo "<h2>Liste des posts</h2>";
echo "<table>";
echo "<tr><th>ID_post</th><th>ID_user</th><th>ID_forum</th><th>Post</th><th>titre</th><th>Timestamp</th></tr>";

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    echo "<tr>";
    echo "<td>" . $row['ID_post'] . "</td>";
    echo "<td>" . $row['ID_user'] . "</td>";
    echo "<td>" . $row['ID_forum'] . "</td>";
    echo "<td>" . $row['Post'] . "</td>";
    echo "<td>" . $row['titre'] . "</td>";
    echo "<td>" . $row['Timestamp'] . "</td>";
    echo "</tr>";
}

echo "</table>";

// Opération de mise à jour (Update)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_post'])) {
    $ID_post = $_POST['ID_post'];
    $ID_user = $_POST['ID_user'];
    $ID_forum = $_POST['ID_forum'];
    $Post = $_POST['Post'];
    $titre = $_POST['titre'];
    $Timestamp = $_POST['Timestamp'];

    $sql = "UPDATE post SET ID_user = :ID_user, ID_forum = :ID_forum, Post = :Post, titre = :titre, Timestamp = :Timestamp WHERE ID_post = :ID_post";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(':ID_user' => $ID_user, ':ID_forum' => $ID_forum, ':Post' => $Post, ':titre' => $titre, ':Timestamp' => $Timestamp, ':ID_post' => $ID_post));

    echo "Le post a été mis à jour avec succès.";
}

// Opération de suppression (Delete)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_post'])) {
    $ID_post = $_POST['ID_post'];

    $sql = "DELETE FROM post WHERE ID_post = :ID_post";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(':ID_post' => $ID_post));

    echo "Le post a été supprimé avec succès.";
}
?>

<h2>Créer un post</h2>
<form method="post" action="">
    <input type="hidden" name="create_post" value="1">
    <label for="ID_user">ID_user :</label>
    <input type="number" name="ID_user" required><br>
    <label for="ID_forum">ID_forum :</label>
    <input type="number" name="ID_forum" required><br>
    <label for="Post">Post :</label>
    <input type="text" name="Post" required><br>
    <label for="titre">Titre :</label>
    <input type="text" name="titre" required><br>
    <label for="Timestamp">Timestamp :</label>
    <input type="datetime-local" name="Timestamp" required><br>
    <input type="submit" value="Créer">
</form>

<h2>Mettre à jour un post</h2>
<form method="post" action="">
    <input type="hidden" name="update_post" value="1">
    <label for="ID_post">ID_post :</label>
    <input type="number" name="ID_post" required><br>
    <label for="ID_user">ID_user :</label>
    <input type="number" name="ID_user" required><br>
    <label for="ID_forum">ID_forum :</label>
    <input type="number" name="ID_forum" required><br>
    <label for="Post">Post :</label>
    <input type="text" name="Post" required><br>
    <label for="titre">Titre :</label>
    <input type="text" name="titre" required><br>
    <label for="Timestamp">Timestamp :</label>
    <input type="datetime-local" name="Timestamp" required><br>
    <input type="submit" value="Mettre à jour">
</form>

<h2>Supprimer un post</h2>
<form method="post" action="">
    <input type="hidden" name="delete_post" value="1">
    <label for="ID_post">ID_post :</label>
    <input type="number" name="ID_post" required><br>
    <input type="submit" value="Supprimer">
</form>
