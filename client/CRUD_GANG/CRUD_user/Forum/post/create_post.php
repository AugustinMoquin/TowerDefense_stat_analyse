<?php
session_start();
$user_id = $_SESSION['ID_user']; 
if (!isset($_SESSION['ID_user'])) {
    echo "Vous devez être connecté pour accéder à cette page.";
    exit;
}
// Récupère data formulaire
$ID_user = $user_id;
$ID_forum = $_POST['ID_forum'];
$Post = $_POST['Post'];
$titre = $_POST['titre'];

// requête bdd boom boom
$pdo = new PDO('mysql:host=127.0.0.1;dbname=tower_defense', 'root', 'root');
$sql = "INSERT INTO post (ID_user, ID_forum, Post, titre) VALUES (:ID_user, :ID_forum, :Post, :titre)";
$stmt = $pdo->prepare($sql);
$stmt->execute(array(':ID_user' => $ID_user, ':ID_forum' => $ID_forum, ':Post' => $Post, ':titre' => $titre));

echo "Le post a été créé avec succès.";
?>
