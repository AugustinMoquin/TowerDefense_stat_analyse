<?php
session_start(); 
$user_id = $_SESSION['ID_user']; 
if (!isset($_SESSION['ID_user'])) {
    echo "Vous devez être connecté pour accéder à cette page.";
    exit;
}
//  l'ID du post à supprimer
$ID_post = $_GET['ID_post'];

// hop plus rien
$pdo = new PDO('mysql:host=127.0.0.1;dbname=tower_defense', 'root', 'root');
$sql = "DELETE FROM post WHERE ID_post = :ID_post AND ID_user = :ID_user";
$stmt = $pdo->prepare($sql);
$stmt->execute(array(':ID_post' => $ID_post, ':ID_user' => $user_id));

echo "Le post a été supprimé avec succès.";
?>
