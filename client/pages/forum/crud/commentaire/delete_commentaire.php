<?php
session_start(); 
$user_id = $_SESSION['ID_user']; 
if (!isset($_SESSION['ID_user'])) {
    echo "Vous devez être connecté pour accéder à cette page.";
    exit;
}

$ID_commentaire = $_GET['ID_commentaire'];


$pdo = new PDO('mysql:host=127.0.0.1;dbname=tower_defense', 'root', 'root');
$sql = "DELETE FROM commentaire WHERE ID_commentaire = :ID_commentaire AND ID_user = :ID_user";
$stmt = $pdo->prepare($sql);
$stmt->execute(array(':ID_commentaire' => $ID_commentaire, ':ID_user' => $user_id));

echo "Le commentaire a été supprimé avec succès.";
?>
