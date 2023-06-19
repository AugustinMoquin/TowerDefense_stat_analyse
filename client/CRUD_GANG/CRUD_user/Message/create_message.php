<?php
session_start(); 
$user_id = $_SESSION['ID_user']; 
if (!isset($_SESSION['ID_user'])) {
    echo "Vous devez être connecté pour accéder à cette page.";
    exit;
}

$ID_user = $user_id;
$contenu = $_POST['contenu'];
$ID_discussion = $_POST['ID_discussion'];


$pdo = new PDO('mysql:host=127.0.0.1;dbname=tower_defense', 'root', 'root');
$sql = "INSERT INTO message (ID_user, contenu, ID_discussion) VALUES (:ID_user, :contenu, :ID_discussion)";
$stmt = $pdo->prepare($sql);
$stmt->execute(array(':ID_user' => $ID_user, ':contenu' => $contenu, ':ID_discussion' => $ID_discussion));

echo "Le message a été créé avec succès.";
?>
