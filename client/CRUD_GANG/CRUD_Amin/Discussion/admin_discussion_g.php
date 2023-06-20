<?php
session_start();
//$ID_user = $_SESSION['ID_user'];
//$user_name = $_SESSION['user_name'];

//if ($user_name !== 'admin') {
   // echo "Vous n'avez pas les autorisations pour gérer les messages.";
   // exit;
//}


$pdo = new PDO('mysql:host=127.0.0.1;dbname=tower_defense', 'root', '');


//______________________________________ DISCUSSION____________________________________
// (Create)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['create_discussion'])) {
    $ID_user1 = $_POST['ID_user1'];
    $ID_user2 = $_POST['ID_user2'];

    $sql = "INSERT INTO discussion_mp (ID_user1, ID_user2) VALUES (:ID_user1, :ID_user2)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(':ID_user1' => $ID_user1, ':ID_user2' => $ID_user2));

    echo "La discussion a été créée avec succès.";
}

//  (Read)
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

//  (Update)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_discussion'])) {
    $ID_discussion = $_POST['ID_discussion'];
    $ID_user1 = $_POST['ID_user1'];
    $ID_user2 = $_POST['ID_user2'];

    $sql = "UPDATE discussion_mp SET ID_user1 = :ID_user1, ID_user2 = :ID_user2 WHERE ID_discussion = :ID_discussion";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(':ID_user1' => $ID_user1, ':ID_user2' => $ID_user2, ':ID_discussion' => $ID_discussion));

    echo "La discussion a été mise à jour avec succès.";
}

// (Delete)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_discussion'])) {
    $ID_discussion = $_POST['ID_discussion'];

    $sql = "DELETE FROM discussion_mp WHERE ID_discussion = :ID_discussion";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(':ID_discussion' => $ID_discussion));

    echo "La discussion a été supprimée avec succès.";
}


//_________________________________________________ Message _____________________________________



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

// Opération de lecture (Read)
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

// (Delete)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_message'])) {
    $ID_message = $_POST['ID_message'];

    $sql = "DELETE FROM message WHERE ID_message = :ID_message";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(':ID_message' => $ID_message));

    echo "Le message a été supprimé avec succès.";
}

//____________________________________________________________ FILTRE_________________________________________

// ID_user filtre
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['filter_by_user'])) {
    $filter_user = $_POST['filter_user'];

    $sql = "SELECT * FROM discussion_mp WHERE ID_user1 = :filter_user OR ID_user2 = :filter_user";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(':filter_user' => $filter_user));

    echo "<h2>Résultats de filtrage par ID_user ($filter_user) :</h2>";
    echo "<table>";
    echo "<tr><th>ID_discussion</th><th>ID_user1</th><th>ID_user2</th></tr>";
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr><td>".$row['ID_discussion']."</td><td>".$row['ID_user1']."</td><td>".$row['ID_user2']."</td></tr>";
    }
    echo "</table>";
}

// ID_DISCUSSION FILTRRE
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['filter_by_discussion'])) {
    $filter_discussion = $_POST['filter_discussion'];

    $sql = "SELECT * FROM discussion_mp WHERE ID_discussion = :filter_discussion";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(':filter_discussion' => $filter_discussion));

    echo "<h2>Résultats de filtrage par ID_discussion ($filter_discussion) :</h2>";
    echo "<table>";
    echo "<tr><th>ID_discussion</th><th>ID_user1</th><th>ID_user2</th></tr>";
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr><td>".$row['ID_discussion']."</td><td>".$row['ID_user1']."</td><td>".$row['ID_user2']."</td></tr>";
    }
    echo "</table>";
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


<h2>Filtrer les discussions par ID_user :</h2>
<form method="post" action="">
    <input type="hidden" name="filter_by_user" value="1">
    <label for="filter_user">ID_user :</label>
    <input type="number" name="filter_user" required><br>
    <input type="submit" value="Filtrer">
</form>

<h2>Filtrer les discussions par ID_discussion :</h2>
<form method="post" action="">
    <input type="hidden" name="filter_by_discussion" value="1">
    <label for="filter_discussion">ID_discussion :</label>
    <input type="number" name="filter_discussion" required><br>
    <input type="submit" value="Filtrer">
</form>