<?php
session_start(); 
$user_id = $_SESSION['ID_user'];
if (!isset($_SESSION['ID_user'])) {
    echo "Vous devez être connecté pour accéder à cette page.";
    exit;
}

$ID_user = $user_id;
$ID_post = $_POST['ID_post'];
$commentaire = $_POST['commentaire'];


$pdo = new PDO('mysql:host=127.0.0.1;dbname=tower_defense', 'root', 'root');
$sql = "INSERT INTO commentaire (ID_user, ID_post, commentaire) VALUES (:ID_user, :ID_post, :commentaire)";
$stmt = $pdo->prepare($sql);
$stmt->execute(array(':ID_user' => $ID_user, ':ID_post' => $ID_post, ':commentaire' => $commentaire));

echo "Le commentaire a été créé avec succès.";
?>
