<?php
session_start(); 
$user_id = $_SESSION['ID_user']; 

if (!isset($_SESSION['ID_user'])) {
    echo "Vous devez être connecté pour accéder à cette page.";
    exit;
}
$ID_message = $_POST['ID_message'];
$contenu = $_POST['contenu'];


$pdo = new PDO('mysql:host=127.0.0.1;dbname=tower_defense', 'root', 'root');
$sql = "UPDATE message SET contenu = :contenu WHERE ID_message = :ID_message AND ID_user = :ID_user";
$stmt = $pdo->prepare($sql);
$stmt->execute(array(':contenu' => $contenu, ':ID_message' => $ID_message, ':ID_user' => $user_id));

echo "Le message a été mis à jour avec succès.";
?>
