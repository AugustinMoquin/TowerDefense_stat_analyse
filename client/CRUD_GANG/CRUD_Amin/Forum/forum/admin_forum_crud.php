<?php
session_start();

// Vérification des autorisations (si nécessaire)
//$user_name = $_SESSION['user_name'];
//if ($user_name !== 'admin') {
//    echo "Vous n'avez pas les autorisations pour gérer les forums.";
//    exit;
//}


$pdo = new PDO('mysql:host=127.0.0.1;dbname=tower_defense', 'root', '');

//  (Create)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['create_forum'])) {
    $forum_titre = $_POST['forum_titre'];

    $sql = "INSERT INTO forum (Forum_titre) VALUES (:forum_titre)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(':forum_titre' => $forum_titre));

    echo "Le forum a été créé avec succès.";
}

//  (Read)
$sql = "SELECT * FROM forum";
$stmt = $pdo->query($sql);

echo "<h2>Liste des forums</h2>";
echo "<table>";
echo "<tr><th>ID_forum</th><th>Forum_titre</th></tr>";

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    echo "<tr>";
    echo "<td>" . $row['ID_forum'] . "</td>";
    echo "<td>" . $row['Forum_titre'] . "</td>";
    echo "</tr>";
}

echo "</table>";

//  (Update)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_forum'])) {
    $ID_forum = $_POST['ID_forum'];
    $forum_titre = $_POST['forum_titre'];

    $sql = "UPDATE forum SET Forum_titre = :forum_titre WHERE ID_forum = :ID_forum";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(':forum_titre' => $forum_titre, ':ID_forum' => $ID_forum));

    echo "Le forum a été mis à jour avec succès.";
}

// (Delete)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_forum'])) {
    $ID_forum = $_POST['ID_forum'];

    $sql = "DELETE FROM forum WHERE ID_forum = :ID_forum";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(':ID_forum' => $ID_forum));

    echo "Le forum a été supprimé avec succès.";
}
?>

<h2>Créer un forum</h2>
<form method="post" action="">
    <input type="hidden" name="create_forum" value="1">
    <label for="forum_titre">Titre du forum :</label>
    <input type="text" name="forum_titre" required><br>
    <input type="submit" value="Créer">
</form>

<h2>Mettre à jour un forum</h2>
<form method="post" action="">
    <input type="hidden" name="update_forum" value="1">
    <label for="ID_forum">ID_forum :</label>
    <input type="number" name="ID_forum" required><br>
    <label for="forum_titre">Titre du forum :</label>
    <input type="text" name="forum_titre" required><br>
    <input type="submit" value="Mettre à jour">
</form>

<h2>Supprimer un forum</h2>
<form method="post" action="">
    <input type="hidden" name="delete_forum" value="1">
    <label for="ID_forum">ID_forum :</label>
    <input type="number" name="ID_forum" required><br>
    <input type="submit" value="Supprimer">
</form>
