<?php
session_start();
//$ID_user = $_SESSION['ID_user'];
//$user_name = $_SESSION['user_name'];

//if ($user_name !== 'admin') {
   // echo "Vous n'avez pas les autorisations pour gérer les relations.";
   // exit;
//}

// Connexion bdd
$pdo = new PDO('mysql:host=127.0.0.1;dbname=tower_defense', 'root', '');

// (Create)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['create_relation'])) {
    $nature = $_POST['nature'];
    $ID_user1 = $_POST['ID_user1'];
    $ID_user2 = $_POST['ID_user2'];

    $sql = "INSERT INTO Relations (nature, ID_user1, ID_user2) VALUES (:nature, :ID_user1, :ID_user2)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(':nature' => $nature, ':ID_user1' => $ID_user1, ':ID_user2' => $ID_user2));

    echo "La relation a été créée avec succès.";
}

// (Read)
$sql = "SELECT * FROM Relations";
$stmt = $pdo->query($sql);

echo "<h2>Liste des relations</h2>";
echo "<table>";
echo "<tr><th>ID_Relations</th><th>Nature</th><th>ID_user1</th><th>ID_user2</th></tr>";

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    echo "<tr>";
    echo "<td>" . $row['ID_Relations'] . "</td>";
    echo "<td>" . $row['nature'] . "</td>";
    echo "<td>" . $row['ID_user1'] . "</td>";
    echo "<td>" . $row['ID_user2'] . "</td>";
    echo "</tr>";
}

echo "</table>";

//  (Update)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_relation'])) {
    $ID_Relations = $_POST['ID_Relations'];
    $nature = $_POST['nature'];
    $ID_user1 = $_POST['ID_user1'];
    $ID_user2 = $_POST['ID_user2'];

    $sql = "UPDATE Relations SET nature = :nature, ID_user1 = :ID_user1, ID_user2 = :ID_user2 WHERE ID_Relations = :ID_Relations";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(':nature' => $nature, ':ID_user1' => $ID_user1, ':ID_user2' => $ID_user2, ':ID_Relations' => $ID_Relations));

    echo "La relation a été mise à jour avec succès.";
}

//  (Delete)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_relation'])) {
    $ID_Relations = $_POST['ID_Relations'];

    $sql = "DELETE FROM Relations WHERE ID_Relations = :ID_Relations";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(':ID_Relations' => $ID_Relations));

    echo "La relation a été supprimée avec succès.";
}
?>

<h2>Créer une relation</h2>
<form method="post" action="">
    <input type="hidden" name="create_relation" value="1">
    <label for="nature">Nature :</label>
    <input type="text" name="nature" required><br>
    <label for="ID_user1">ID_user1 :</label>
    <input type="number" name="ID_user1" required><br>
    <label for="ID_user2">ID_user2 :</label>
    <input type="number" name="ID_user2" required><br>
    <input type="submit" value="Créer">
</form>

<h2>Mettre à jour une relation</h2>
<form method="post" action="">
    <input type="hidden" name="update_relation" value="1">
    <label for="ID_Relations">ID_Relations :</label>
    <input type="number" name="ID_Relations" required><br>
    <label for="nature">Nature :</label>
    <input type="text" name="nature" required><br>
    <label for="ID_user1">ID_user1 :</label>
    <input type="number" name="ID_user1" required><br>
    <label for="ID_user2">ID_user2 :</label>
    <input type="number" name="ID_user2" required><br>
    <input type="submit" value="Mettre à jour">
</form>

<h2>Supprimer une relation</h2>
<form method="post" action="">
    <input type="hidden" name="delete_relation" value="1">
    <label for="ID_Relations">ID_Relations :</label>
    <input type="number" name="ID_Relations" required><br>
    <input type="submit" value="Supprimer">
</form>
