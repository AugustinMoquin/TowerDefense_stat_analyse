<?php
session_start(); 
$user_id = $_SESSION['ID_user']; 

if (!isset($_SESSION['ID_user'])) {
    echo "Vous devez être connecté pour accéder à cette page.";
    exit;
}
$ID_message = $_GET['ID_message'];


$pdo = new PDO('mysql:host=127.0.0.1;dbname=tower_defense', 'root', 'root');
$sql = "DELETE FROM message WHERE ID_message = :ID_message AND ID_user = :ID_user";
$stmt = $pdo->prepare($sql);
$stmt->execute(array(':ID_message' => $ID_message, ':ID_user' => $user_id));

echo "Le message a été supprimé avec succès.";
?>
