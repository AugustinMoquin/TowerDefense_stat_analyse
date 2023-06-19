<?php
session_start(); 
$user_id = $_SESSION['ID_user']; 
if (!isset($_SESSION['ID_user'])) {
    echo "Vous devez être connecté pour accéder à cette page.";
    exit;
}

$ID_Relations = $_GET['ID_Relations'];


$pdo = new PDO('mysql:host=127.0.0.1;dbname=tower_defense', 'root', 'root');
$sql = "DELETE FROM Relations WHERE ID_Relations = :ID_Relations AND (ID_user1 = :ID_user OR ID_user2 = :ID_user)";
$stmt = $pdo->prepare($sql);
$stmt->execute(array(':ID_Relations' => $ID_Relations, ':ID_user' => $user_id));

echo "La relation a été supprimée avec succès.";
?>
