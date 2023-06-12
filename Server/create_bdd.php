<?php
// Informations de connexion à la base de données
$hostname = "localhost"; // Remplacez par l'hôte de votre serveur MySQL
$username = "votre_nom_d_utilisateur"; // Remplacez par votre nom d'utilisateur MySQL
$password = "votre_mot_de_passe"; // Remplacez par votre mot de passe MySQL

// Établir une connexion à la base de données
$connexion = mysqli_connect($hostname, $username, $password);

// Vérifier la connexion
if (!$connexion) {
    die("Échec de la connexion à la base de données : " . mysqli_connect_error());
}

// Créer la base de données
$database = "tower_defense"; // Remplacez par le nom de votre base de données
$sql_create_db = "CREATE DATABASE $database";
if (mysqli_query($connexion, $sql_create_db)) {
    echo "Base de données créée avec succès !";
} else {
    echo "Erreur lors de la création de la base de données : " . mysqli_error($connexion);
}

// Sélectionner la base de données nouvellement créée
mysqli_select_db($connexion, $database);


$sql_create_table = "CREATE TABLE joueur (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    NameTag VARCHAR(255),
    mdp VARCHAR(255),
    email VARCHAR(255),
    tel VARCHAR(20),
    photo_profil VARCHAR(255)
)";

if (mysqli_query($connexion, $sql_create_table)) {
    echo "Table 'joueur' créée avec succès !";
} else {
    echo "Erreur lors de la création de la table 'joueur' : " . mysqli_error($connexion);
}

// Fermer la connexion à la base de données
mysqli_close($connexion);
?>
