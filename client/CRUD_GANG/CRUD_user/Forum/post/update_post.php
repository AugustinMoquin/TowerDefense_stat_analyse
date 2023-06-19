<?php
session_start(); 
$user_id = $_SESSION['ID_user']; 
if (!isset($_SESSION['ID_user'])) {
    echo "Vous devez être connecté pour accéder à cette page.";
    exit;
}
// Récupère données  formulaire
$ID_post = $_POST['ID_post'];
$Post = $_POST['Post'];
$titre = $_POST['titre'];

// UPDATE YOUP YOUP
$pdo = new PDO('mysql:host=127.0.0.1;dbname=tower_defense', 'root', 'root');
$sql = "UPDATE post SET Post = :Post, titre = :titre WHERE ID_post = :ID_post AND ID_user = :ID_user";
$stmt = $pdo->prepare($sql);
$stmt->execute(array(':Post' => $Post, ':titre' => $titre, ':ID_post' => $ID_post, ':ID_user' => $user_id));

echo "Le post a été mis à jour avec succès.";
?>
