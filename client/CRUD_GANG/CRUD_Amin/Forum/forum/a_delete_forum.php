<?php
session_start();
$ID_user = $_SESSION['ID_user'];
$user_name = $_SESSION['user_name'];

if ($user_name !== 'admin') {
    echo "Vous n'avez pas les autorisations pour supprimer un forum.";
    exit;
}

$ID_forum = $_GET['ID_forum'];

$pdo = new PDO('mysql:host=127.0.0.1;dbname=tower_defense', 'root', 'root');
$sql = "DELETE FROM forum WHERE ID_forum = :ID_forum";
$stmt = $pdo->prepare($sql);
$stmt->execute(array(':ID_forum' => $ID_forum));

echo "Le forum a été supprimé avec succès.";
?>
