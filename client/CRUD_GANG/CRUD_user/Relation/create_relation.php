<?php
session_start(); 
$user_id = $_SESSION['ID_user'];
if (!isset($_SESSION['ID_user'])) {
    echo "Vous devez être connecté pour accéder à cette page.";
    exit;
}

$ID_user1 = $user_id;
$ID_user2 = $_POST['ID_user2'];
$nature = $_POST['nature'];


$pdo = new PDO('mysql:host=127.0.0.1;dbname=tower_defense', 'root', 'root');
$sql = "INSERT INTO Relations (ID_user1, ID_user2, nature) VALUES (:ID_user1, :ID_user2, :nature)";
$stmt = $pdo->prepare($sql);
$stmt->execute(array(':ID_user1' => $ID_user1, ':ID_user2' => $ID_user2, ':nature' => $nature));

echo "La relation a été créée avec succès.";
?>
