<?php
session_start(); 
$user_id = $_SESSION['ID_user']; 
if (!isset($_SESSION['ID_user'])) {
    echo "Vous devez être connecté pour accéder à cette page.";
    exit;
}

$pdo = new PDO('mysql:host=127.0.0.1;dbname=tower_defense', 'root', 'root');
$sql = "SELECT * FROM commentaire WHERE ID_user = :ID_user";
$stmt = $pdo->prepare($sql);
$stmt->execute(array(':ID_user' => $user_id));


while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    echo "ID du commentaire : " . $row['ID_commentaire'] . "<br>";
    echo "Contenu : " . $row['commentaire'] . "<br>";
    echo "<hr>";
}
?>
