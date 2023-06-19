<?php
session_start();
$ID_user = $_SESSION['ID_user'];
$user_name = $_SESSION['user_name'];

if ($user_name !== 'admin') {
    echo "Vous n'avez pas les autorisations pour mettre à jour un forum.";
    exit;
}

$ID_forum = $_POST['ID_forum'];
$forum_titre = $_POST['forum_titre'];

$pdo = new PDO('mysql:host=127.0.0.1;dbname=tower_defense', 'root', 'root');
$sql = "UPDATE forum SET Forum_titre = :forum_titre WHERE ID_forum = :ID_forum";
$stmt = $pdo->prepare($sql);
$stmt->execute(array(':forum_titre' => $forum_titre, ':ID_forum' => $ID_forum));

echo "Le forum a été mis à jour avec succès.";
?>
