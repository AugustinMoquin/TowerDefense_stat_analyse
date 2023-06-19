<?php
session_start();
if (!isset($_SESSION['ID_user'])) {
    echo "Vous devez être connecté pour accéder à cette page.";
    exit;
}

$pdo = new PDO('mysql:host=127.0.0.1;dbname=tower_defense', 'root', 'root');
$sql = "SELECT * FROM forum";
$stmt = $pdo->query($sql);

echo "<h2>Liste des forums</h2>";
echo "<table>";
echo "<tr><th>ID_forum</th><th>Forum_titre</th></tr>";

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    echo "<tr>";
    echo "<td>" . $row['ID_forum'] . "</td>";
    echo "<td>" . $row['Forum_titre'] . "</td>";
    echo "</tr>";
}

echo "</table>";
?>

