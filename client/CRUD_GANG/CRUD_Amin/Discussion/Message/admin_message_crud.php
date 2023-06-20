<?php
session_start();
//$ID_user = $_SESSION['ID_user'];
//$user_name = $_SESSION['user_name'];

//if ($user_name !== 'admin') {
   // echo "Vous n'avez pas les autorisations pour gérer les messages.";
   // exit;
//}


$pdo = new PDO('mysql:host=127.0.0.1;dbname=tower_defense', 'root', '');

//  (Create)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['create_message'])) {
    $timestamp = $_POST['timestamp'];
    $ID_user = $_POST['ID_user'];
    $contenu = $_POST['contenu'];
    $ID_discussion = $_POST['ID_discussion'];

    $sql = "INSERT INTO message (timestamp, ID_user, contenu, ID_discussion) VALUES (:timestamp, :ID_user, :contenu, :ID_discussion)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(':timestamp' => $timestamp, ':ID_user' => $ID_user, ':contenu' => $contenu, ':ID_discussion' => $ID_discussion));

    echo "Le message a été créé avec succès.";
}

//  (Read)
$sql = "SELECT * FROM message";
$stmt = $pdo->query($sql);

echo "<h2>Liste des messages</h2>";
echo "<table>";
echo "<tr><th>ID_message</th><th>timestamp</th><th>ID_user</th><th>contenu</th><th>ID_discussion</th></tr>";

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    echo "<tr>";
    echo "<td>" . $row['ID_message'] . "</td>";
    echo "<td>" . $row['timestamp'] . "</td>";
    echo "<td>" . $row['ID_user'] . "</td>";
    echo "<td>" . $row['contenu'] . "</td>";
    echo "<td>" . $row['ID_discussion'] . "</td>";
    echo "</tr>";
}

echo "</table>";

//  (Update)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_message'])) {
    $ID_message = $_POST['ID_message'];
    $timestamp = $_POST['timestamp'];
    $ID_user = $_POST['ID_user'];
    $contenu = $_POST['contenu'];
    $ID_discussion = $_POST['ID_discussion'];

    $sql = "UPDATE message SET timestamp = :timestamp, ID_user = :ID_user, contenu = :contenu, ID_discussion = :ID_discussion WHERE ID_message = :ID_message";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(':timestamp' => $timestamp, ':ID_user' => $ID_user, ':contenu' => $contenu, ':ID_discussion' => $ID_discussion, ':ID_message' => $ID_message));

    echo "Le message a été mis à jour avec succès.";
}

//  (Delete)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_message'])) {
    $ID_message = $_POST['ID_message'];

    $sql = "DELETE FROM message WHERE ID_message = :ID_message";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(':ID_message' => $ID_message));

    echo "Le message a été supprimé avec succès.";
}
?>

<h2>Créer un message</h2>
<form method="post" action="">
    <input type="hidden" name="create_message" value="1">
    <label for="timestamp">Timestamp :</label>
    <input type="datetime-local" name="timestamp" required><br>
    <label for="ID_user">ID_user :</label>
    <input type="number" name="ID_user" required><br>
    <label for="contenu">Contenu :</label>
    <input type="text" name="contenu" required><br>
    <label for="ID_discussion">ID_discussion :</label>
    <input type="number" name="ID_discussion" required><br>
    <input type="submit" value="Créer">
</form>

<h2>Mettre à jour un message</h2>
<form method="post" action="">
    <input type="hidden" name="update_message" value="1">
    <label for="ID_message">ID_message :</label>
    <input type="number" name="ID_message" required><br>
    <label for="timestamp">Timestamp :</label>
    <input type="datetime-local" name="timestamp" required><br>
    <label for="ID_user">ID_user :</label>
    <input type="number" name="ID_user" required><br>
    <label for="contenu">Contenu :</label>
    <input type="text" name="contenu" required><br>
    <label for="ID_discussion">ID_discussion :</label>
    <input type="number" name="ID_discussion" required><br>
    <input type="submit" value="Mettre à jour">
</form>

<h2>Supprimer un message</h2>
<form method="post" action="">
    <input type="hidden" name="delete_message" value="1">
    <label for="ID_message">ID_message :</label>
    <input type="number" name="ID_message" required><br>
    <input type="submit" value="Supprimer">
</form>
