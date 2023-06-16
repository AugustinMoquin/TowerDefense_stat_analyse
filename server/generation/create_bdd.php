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
$sql_create_user_table = "CREATE TABLE IF NOT EXISTS user (
    ID_user INT AUTO_INCREMENT PRIMARY KEY,
    user_name VARCHAR(255),
    mdp VARCHAR(255),
    email VARCHAR(255),
    tel VARCHAR(20),
    photo_profil VARCHAR(255)
)";

if (mysqli_query($connexion, $sql_create_user_table)) {
    echo "Table 'user' créée avec succès!";
} else {
    echo "Erreur lors de la création de la table 'user': " . mysqli_error($connexion);
}

$sql_create_partie_table = "CREATE TABLE IF NOT EXISTS partie_lambda (
    ID_partie INT AUTO_INCREMENT PRIMARY KEY,
    ID_user INT,
    parties_jouees INT,
    nombre_vagues_totales INT,
    nombre_monstre_total INT,
    monstres_tues_individuel INT,
    temps_total_partie INT,
    tours_construites_total INT,
    tours_individuel_total INT,
    tune_totale INT,
    score INT,
    duree_jeu INT,
    win BOOLEAN,
    FOREIGN KEY (ID_user) REFERENCES user(ID_user)
)";

if (mysqli_query($connexion, $sql_create_partie_table)) {
    echo "Table 'partie_lambda' créée avec succès!";
} else {
    echo "Erreur lors de la création de la table 'partie_lambda': " . mysqli_error($connexion);
}

$sql_create_historique_table = "CREATE TABLE IF NOT EXISTS historique_générale (
    ID_historique INT AUTO_INCREMENT PRIMARY KEY,
    ID_partie INT,
    ID_user INT,
    FOREIGN KEY (ID_partie) REFERENCES partie_lambda(ID_partie),
    FOREIGN KEY (ID_user) REFERENCES user(ID_user)
)";

if (mysqli_query($connexion, $sql_create_historique_table)) {
    echo "Table 'historique__générale' créée avec succès!";
} else {
    echo "Erreur lors de la création de la table ' historique_générales': " . mysqli_error($connexion);
}
$sql_create_historique_table = "CREATE TABLE IF NOT EXISTS historique_parties_user (
    ID_historique INT AUTO_INCREMENT PRIMARY KEY,
    ID_partie INT,
    ID_user INT,
    FOREIGN KEY (ID_partie) REFERENCES partie_lambda(ID_partie),
    FOREIGN KEY (ID_user) REFERENCES user(ID_user),
    CONSTRAINT FK_historique_user FOREIGN KEY (ID_user) REFERENCES user(ID_user) ON DELETE CASCADE,
    CONSTRAINT FK_historique_partie_lambda FOREIGN KEY (ID_partie) REFERENCES partie_lambda(ID_partie) ON DELETE CASCADE,
    CHECK (ID_user = (SELECT ID_user FROM partie_lambda WHERE ID_partie = ID_partie))
)";

if (mysqli_query($connexion, $sql_create_historique_table)) {
    echo "Table ' historique_parties_user ' créée avec succès!";
} else {
    echo "Erreur lors de la création de la table 'historique_parties_user ': " . mysqli_error($connexion);
}

$sql_create_statistiques_table = "CREATE TABLE IF NOT EXISTS statistiques_user (
    ID_statistique INT AUTO_INCREMENT PRIMARY KEY,
    ID_user INT,
    moyenne_parties_jouees DECIMAL(10, 2),
    moyenne_nombre_vagues_totales DECIMAL(10, 2),
    moyenne_nombre_monstre_total DECIMAL(10, 2),
    moyenne_monstres_tues_individuel DECIMAL(10, 2),
    moyenne_temps_total_partie DECIMAL(10, 2),
    moyenne_tours_construites_total DECIMAL(10, 2),
    moyenne_tours_individuel_total DECIMAL(10, 2),
    moyenne_tune_totale DECIMAL(10, 2),
    moyenne_score DECIMAL(10, 2),
    moyenne_duree_jeu DECIMAL(10, 2),
    moyenne_win DECIMAL(10, 2),
    FOREIGN KEY (ID_user) REFERENCES user(ID_user)
)";




if (mysqli_query($connexion, $sql_create_statistiques_table)) {
    echo "Table 'statistiques_user' créée avec succès!";
} else {
    echo "Erreur lors de la création de la table 'statistiques_user': " . mysqli_error($connexion);
}




//_______________________Forum Partie________________
//  table "Forum"
$sql_create_forum_table = "CREATE TABLE IF NOT EXISTS forum (
   ID_forum INT AUTO_INCREMENT PRIMARY KEY,
   Forum_titre VARCHAR(255)
)";

if (mysqli_query($connexion, $sql_create_forum_table)) {
    echo "Table 'forum' créée avec succès!";
} else {
    echo "Erreur lors de la création de la table 'forum': " . mysqli_error($connexion);
// table "post" 
$sql_create_post_table = "CREATE TABLE IF NOT EXISTS post (
    ID_post INT AUTO_INCREMENT PRIMARY KEY,
    ID_user INT,
    ID_forum INT,
    Post VARCHAR(255),
    titre VARCHAR(255),
    Timestamp TIMESTAMP,
    FOREIGN KEY (ID_user) REFERENCES user(ID_user),
    FOREIGN KEY (ID_forum) REFERENCES forum(ID_forum)
)";

if (mysqli_query($connexion, $sql_create_post_table)) {
    echo "Table 'post' créée avec succès!";
} else {
    echo "Erreur lors de la création de la table 'post': " . mysqli_error($connexion);
}


// table "commentaire" 
$sql_create_commentaire_table = "CREATE TABLE IF NOT EXISTS commentaire (
    ID_commentaire INT AUTO_INCREMENT PRIMARY KEY,
    ID_user INT,
    ID_post INT,
    commentaire VARCHAR(255),
    Timestamp TIMESTAMP,
    FOREIGN KEY (ID_user) REFERENCES user(ID_user),
    FOREIGN KEY (ID_post) REFERENCES post(ID_post)
)";

if (mysqli_query($connexion, $sql_create_commentaire_table)) {
    echo "Table 'commentaire' créée avec succès!";
} else {
    echo "Erreur lors de la création de la table 'commentaire': " . mysqli_error($connexion);
}


}


//____________________ CHAT PART____________________
//  table "Discussion MP"
$sql_create_discussion_table = "CREATE TABLE IF NOT EXISTS discussion_mp (
    ID_discussion INT AUTO_INCREMENT PRIMARY KEY,
    ID_user1 INT,
    FOREIGN KEY (ID_user1) REFERENCES user(ID_user),
    ID_user2 INT,
    FOREIGN KEY (ID_user2) REFERENCES user(ID_user)
)";

if (mysqli_query($connexion, $sql_create_discussion_table)) {
    echo "Table 'discussion_mp' créée avec succès!";
} else {
    echo "Erreur lors de la création de la table 'discussion_mp': " . mysqli_error($connexion);
}
//  table "Message"
$sql_create_message_table = "CREATE TABLE IF NOT EXISTS _message (
    ID_message INT AUTO_INCREMENT PRIMARY KEY,
    timestamp TIMESTAMP,
    ID_user INT,
    FOREIGN KEY (ID_user) REFERENCES user(ID_user),
    contenu VARCHAR(255),
    ID_discussion INT,
    FOREIGN KEY (ID_discussion) REFERENCES discussion_mp(ID_discussion)
)";

if (mysqli_query($connexion, $sql_create_message_table)) {
    echo "Table 'message' créée avec succès!";
} else {
    echo "Erreur lors de la création de la table 'message': " . mysqli_error($connexion);
}


// Table "Historique Discussion Général"
$sql_create_historique_table = "CREATE TABLE IF NOT EXISTS discussion_historique (
    ID_historique INT AUTO_INCREMENT PRIMARY KEY,
    ID_discussion INT,
    FOREIGN KEY (ID_discussion) REFERENCES discussion_mp(ID_discussion)
)";

if (mysqli_query($connexion, $sql_create_historique_table)) {
    echo "Table 'discussion_historique' créée avec succès!";
} else {
    echo "Erreur lors de la création de la table 'discussion_historique': " . mysqli_error($connexion);
}

// Table "Historique Discussion User"
$sql_create_user_historique_table = "CREATE TABLE IF NOT EXISTS user_discussion_historique (
    ID_user INT,
    FOREIGN KEY (ID_user) REFERENCES user(ID_user),
    ID_discussion INT,
    FOREIGN KEY (ID_discussion) REFERENCES discussion_mp(ID_discussion),
    PRIMARY KEY (ID_user, ID_discussion)
)";

if (mysqli_query($connexion, $sql_create_user_historique_table)) {
    echo "Table 'user_historique' créée avec succès!";
} else {
    echo "Erreur lors de la création de la table 'user_historique': " . mysqli_error($connexion);
}
//___________Relation ________
$sql_create_relations_table = "CREATE TABLE IF NOT EXISTS Relations (
    ID_Relations INT AUTO_INCREMENT PRIMARY KEY,
    nature Varchar(15), 
    ID_user1 INT,
    FOREIGN KEY (ID_user1) REFERENCES user(ID_user),
    ID_user2 INT,
    FOREIGN KEY (ID_user2) REFERENCES user(ID_user),
    timestamp TIMESTAMP
)";

if (mysqli_query($connexion, $sql_create_relations_table)) {
    echo "Table 'Relations' créée avec succès!";
} else {
    echo "Erreur lors de la création de la table 'Relations': " . mysqli_error($connexion);
}


// Fermer la connexion à la base de données
mysqli_close($connexion);
?>
