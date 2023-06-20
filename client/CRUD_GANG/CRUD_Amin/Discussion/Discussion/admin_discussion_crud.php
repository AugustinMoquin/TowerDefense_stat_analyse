<?php
session_start();
//$ID_user = $_SESSION['ID_user'];
//$user_name = $_SESSION['user_name'];

//if ($user_name !== 'admin') {
   // echo "Vous n'avez pas les autorisations pour gérer les messages.";
   // exit;
//}

// Connexion à la base de données
$pdo = new PDO('mysql:host=127.0.0.1;dbname=tower_defense', 'root', '');

// Opération de création (Create)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['create_discussion'])) {
    $ID_user1 = $_POST['ID_user1'];
    $ID_user2 = $_POST['ID_user2'];

    $sql = "INSERT INTO discussion_mp (ID_user1, ID_user2) VALUES (:ID_user1, :ID_user2)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(':ID_user1' => $ID_user1, ':ID_user2' => $ID_user2));

    echo "La discussion a été créée avec succès.";
}

// Opération de lecture (Read)
$sql = "SELECT * FROM discussion_mp";
$stmt = $pdo->query($sql);

echo "<h2>Liste des discussions</h2>";
echo "<table>";
echo "<tr><th>ID_discussion</th><th>ID_user1</th><th>ID_user2</th></tr>";

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    echo "<tr>";
    echo "<td>" . $row['ID_discussion'] . "</td>";
    echo "<td>" . $row['ID_user1'] . "</td>";
    echo "<td>" . $row['ID_user2'] . "</td>";
    echo "</tr>";
}

echo "</table>";

// Opération de mise à jour (Update)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_discussion'])) {
    $ID_discussion = $_POST['ID_discussion'];
    $ID_user1 = $_POST['ID_user1'];
    $ID_user2 = $_POST['ID_user2'];

    $sql = "UPDATE discussion_mp SET ID_user1 = :ID_user1, ID_user2 = :ID_user2 WHERE ID_discussion = :ID_discussion";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(':ID_user1' => $ID_user1, ':ID_user2' => $ID_user2, ':ID_discussion' => $ID_discussion));

    echo "La discussion a été mise à jour avec succès.";
}

// Opération de suppression (Delete)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_discussion'])) {
    $ID_discussion = $_POST['ID_discussion'];

    $sql = "DELETE FROM discussion_mp WHERE ID_discussion = :ID_discussion";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(':ID_discussion' => $ID_discussion));

    echo "La discussion a été supprimée avec succès.";
}
?>

<h2>Créer une discussion</h2>
<form method="post" action="">
    <input type="hidden" name="create_discussion" value="1">
    <label for="ID_user1">ID_user1 :</label>
    <input type="number" name="ID_user1" required><br>
    <label for="ID_user2">ID_user2 :</label>
    <input type="number" name="ID_user2" required><br>
    <input type="submit" value="Créer">
</form>

<h2>Mettre à jour une discussion</h2>
<form method="post" action="">
    <input type="hidden" name="update_discussion" value="1">
    <label for="ID_discussion">ID_discussion :</label>
    <input type="number" name="ID_discussion" required><br>
    <label for="ID_user1">ID_user1 :</label>
    <input type="number" name="ID_user1" required><br>
    <label for="ID_user2">ID_user2 :</label>
    <input type="number" name="ID_user2" required><br>
    <input type="submit" value="Mettre à jour">
</form>

<h2>Supprimer une discussion</h2>
<form method="post" action="">
    <input type="hidden" name="delete_discussion" value="1">
    <label for="ID_discussion">ID_discussion :</label>
    <input type="number" name="ID_discussion" required><br>
    <input type="submit" value="Supprimer">
</form>
