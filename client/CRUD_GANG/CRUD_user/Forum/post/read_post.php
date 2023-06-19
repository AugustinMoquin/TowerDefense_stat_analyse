<?php
session_start(); 
$user_id = $_SESSION['ID_user']; 
if (!isset($_SESSION['ID_user'])) {
    echo "Vous devez être connecté pour accéder à cette page.";
    exit;
}

$pdo = new PDO('mysql:host=127.0.0.1;dbname=tower_defense', 'root', 'root');
$sql = "SELECT * FROM post WHERE ID_user = :ID_user";
$stmt = $pdo->prepare($sql);
$stmt->execute(array(':ID_user' => $user_id));

// Affiche les posts
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    echo "ID du post : " . $row['ID_post'] . "<br>";
    echo "Contenu : " . $row['Post'] . "<br>";
    echo "Titre : " . $row['titre'] . "<br>";
    echo "<hr>";
}
?>
