<?php
session_start();
$ID_user = $_SESSION['ID_user'];
$user_name = $_SESSION['user_name'];

if ($user_name !== 'admin') {
    echo "Vous n'avez pas les autorisations pour créer un forum.";
    exit;
}

$forum_titre = $_POST['forum_titre'];

$pdo = new PDO('mysql:host=127.0.0.1;dbname=tower_defense', 'root', 'root');
$sql = "INSERT INTO forum (Forum_titre) VALUES (:forum_titre)";
$stmt = $pdo->prepare($sql);
$stmt->execute(array(':forum_titre' => $forum_titre));

echo "Le forum a été créé avec succès.";
?>
