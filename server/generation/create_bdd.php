<?php
// Informations de connexion à la base de données
$hostname = "localhost"; // Remplacez par l'hôte de votre serveur MySQL
$username = "root"; // Remplacez par votre nom d'utilisateur MySQL
$password = "root"; // Remplacez par votre mot de passe MySQL

// Établir une connexion à la base de données
$connexion = mysqli_connect($hostname, $username, $password);

// Vérifier la connexion
if (!$connexion) {
    die("Échec de la connexion à la base de données : " . mysqli_connect_error());
}

// Créer la base de données
$database = "tower_defense"; // Remplacez par le nom de votre base de données
// $sql_create_db = "CREATE DATABASE $database";
// if (mysqli_query($connexion, $sql_create_db)) {
//     echo "Base de données créée avec succès !";
// } else {
//     echo "Erreur lors de la création de la base de données : " . mysqli_error($connexion);
// }

// Sélectionner la base de données nouvellement créée
mysqli_select_db($connexion, $database);

// ____________________GAMING PARTIE_________________________________________
$sql_create_table = "CREATE TABLE joueur (
    ID_joueur INT AUTO_INCREMENT PRIMARY KEY,
    NameTag VARCHAR(255),
    mdp VARCHAR(255),
    email VARCHAR(255),
    tel VARCHAR(20),
    photo_profil VARCHAR(255)
)";

if (mysqli_query($connexion, $sql_create_table)) {
    echo "Table 'joueur' créée avec succès!";
} else {
    echo "Erreur lors de la création de la table 'joueur': " . mysqli_error($connexion);
}


//  table "Partie Lambda"
$sql_create_partie_table = "CREATE TABLE partie_lambda (
    ID_partie INT AUTO_INCREMENT PRIMARY KEY,
    ID_joueur INT,
    FOREIGN KEY (ID_joueur) REFERENCES joueur(ID_joueur),
    parties_jouees INT,
    nombre_vagues_totales INT,
    nombre_monstre_total INT,
    monstres_tues_individuel INT,
    temps_total_partie INT,
    tours_construites_total INT,
    tours_individuel_total INT,
    tune_totale INT,
    score INT
)";

if (mysqli_query($connexion, $sql_create_partie_table)) {
    echo "Table 'partie_lambda' créée avec succès!";
} else {
    echo "Erreur lors de la création de la table 'partie_lambda': " . mysqli_error($connexion);
}

//  table "Historique des Parties"
$sql_create_historique_table = "CREATE TABLE historique_parties (
    ID_historique INT PRIMARY KEY,
    ID_partie INT,
    FOREIGN KEY (ID_partie) REFERENCES partie_lambda(ID_partie),
    ID_joueur INT,
    FOREIGN KEY (ID_joueur) REFERENCES joueur(ID_joueur),
    nombre_vagues_totales INT,
    nombre_monstre_total INT,
    monstres_tues_individuel INT,
    temps_total_partie INT,
    tours_construites_total INT,
    tours_individuel_total INT,
    tune_totale INT,
    score INT
)";

if (mysqli_query($connexion, $sql_create_historique_table)) {
    echo "Table 'historique_parties' créée avec succès!";
} else {
    echo "Erreur lors de la création de la table 'historique_parties': " . mysqli_error($connexion);
}

// table "Statistiques du joueur"
$sql_create_statistiques_table = "CREATE TABLE statistiques_joueur (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    ID_joueur INT,
    FOREIGN KEY (ID_joueur) REFERENCES joueur(ID_joueur),
    ID_historique INT,
    FOREIGN KEY (ID_historique) REFERENCES historique_parties(ID_historique),
    parties_jouees_total INT,
    nombre_vagues_totales INT,
    nombre_vague_maximale INT,
    nombre_monstre_total INT,
    monstres_tues_individuel INT,
    temps_total_jeu INT,
    tours_construites_total INT,
    tours_individuel_total INT,
    tune_totale INT,
    score INT
)";

if (mysqli_query($connexion, $sql_create_statistiques_table)) {
    echo "Table 'statistiques_joueur' créée avec succès!";
} else {
    echo "Erreur lors de la création de la table 'statistiques_joueur': " . mysqli_error($connexion);
}

//_______________________Forum Partie________________
// table "post" 
$sql_create_post_table = "CREATE TABLE post (
    ID_post INT AUTO_INCREMENT PRIMARY KEY,
    ID_joueur INT,
    Post VARCHAR(255),
    Commentaire VARCHAR(255),
    Titre VARCHAR(255),
    Timestamp TIMESTAMP,
    FOREIGN KEY (ID_joueur) REFERENCES joueur(ID_joueur)
)";

if (mysqli_query($connexion, $sql_create_post_table)) {
    echo "Table 'post' créée avec succès!";
} else {
    echo "Erreur lors de la création de la table 'post': " . mysqli_error($connexion);
}


// table "commentaire" 
$sql_create_commentaire_table = "CREATE TABLE commentaire (
    ID_commentaire INT AUTO_INCREMENT PRIMARY KEY,
    ID_joueur INT,
    ID_post INT,
    Commentaire VARCHAR(255),
    Timestamp TIMESTAMP,
    FOREIGN KEY (ID_joueur) REFERENCES joueur(ID_joueur),
    FOREIGN KEY (ID_post) REFERENCES post(ID_post)
)";

if (mysqli_query($connexion, $sql_create_commentaire_table)) {
    echo "Table 'commentaire' créée avec succès!";
} else {
    echo "Erreur lors de la création de la table 'commentaire': " . mysqli_error($connexion);
}


//  table "Forum"
$sql_create_forum_table = "CREATE TABLE forum (
    ID_post INT,
    FOREIGN KEY (ID_post) REFERENCES post(ID_post),
    ID_forum INT PRIMARY KEY
)";

if (mysqli_query($connexion, $sql_create_forum_table)) {
    echo "Table 'forum' créée avec succès!";
} else {
    echo "Erreur lors de la création de la table 'forum': " . mysqli_error($connexion);
}


//____________________ CHAT PART____________________
//  table "Message"
$sql_create_message_table = "CREATE TABLE _message (
    ID_message INT AUTO_INCREMENT PRIMARY KEY,
    timestamp TIMESTAMP,
    ID_joueur INT,
    FOREIGN KEY (ID_joueur) REFERENCES joueur(ID_joueur),
    contenu VARCHAR(255)
)";

if (mysqli_query($connexion, $sql_create_message_table)) {
    echo "Table 'message' créée avec succès!";
} else {
    echo "Erreur lors de la création de la table 'message': " . mysqli_error($connexion);
}
//  table "Discussion MP"
$sql_create_discussion_table = "CREATE TABLE discussion_mp (
    ID_joueur1 INT,
    FOREIGN KEY (ID_joueur1) REFERENCES joueur(ID_joueur),
    ID_joueur2 INT,
    FOREIGN KEY (ID_joueur2) REFERENCES joueur(ID_joueur),
    ID_discussion INT AUTO_INCREMENT PRIMARY KEY,
    ID_message INT,
    FOREIGN KEY (ID_message) REFERENCES _message(ID_message)
)";

if (mysqli_query($connexion, $sql_create_discussion_table)) {
    echo "Table 'discussion_mp' créée avec succès!";
} else {
    echo "Erreur lors de la création de la table 'discussion_mp': " . mysqli_error($connexion);
}



//  table "Discussion Historique"
$sql_create_historique_table = "CREATE TABLE discussion_historique (
    ID_discussion INT,
    FOREIGN KEY (ID_discussion) REFERENCES discussion_mp(ID_discussion),
    ID_historique INT  AUTO_INCREMENT PRIMARY KEY
)";

if (mysqli_query($connexion, $sql_create_historique_table)) {
    echo "Table 'discussion_historique' créée avec succès!";
} else {
    echo "Erreur lors de la création de la table 'discussion_historique': " . mysqli_error($connexion);
}
//___________Relation ________
$sql_create_message_table = "CREATE TABLE Relations(
    ID_Relations INT AUTO_INCREMENT PRIMARY KEY,
    ID_joueur INT,
    FOREIGN KEY (ID_joueur) REFERENCES joueur(ID_joueur)
)";

if (mysqli_query($connexion, $sql_create_message_table)) {
    echo "Table 'Relations' créée avec succès!";
} else {
    echo "Erreur lors de la création de la table 'Relations': " . mysqli_error($connexion);
}

// Fermer la connexion à la base de données
mysqli_close($connexion);
?>
