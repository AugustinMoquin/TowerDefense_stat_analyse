<?php
session_start(); 
$user_id = $_SESSION['ID_user']; 
if (!isset($_SESSION['ID_user'])) {
    echo "Vous devez être connecté pour accéder à cette page.";
    exit;
}

$ID_Relations = $_POST['ID_Relations'];
$nature = $_POST['nature'];


$pdo = new PDO('mysql:host=127.0.0.1;dbname=tower_defense', 'root', 'root');
$sql = "UPDATE Relations SET nature = :nature WHERE ID_Relations = :ID_Relations AND (ID_user1 = :ID_user OR ID_user2 = :user_id)";
$stmt = $pdo->prepare($sql);
$stmt->execute(array(':nature' => $nature, ':ID_Relations' => $ID_Relations, ':ID_user' => $user_id));

echo "La relation a été mise à jour avec succès.";
?>
