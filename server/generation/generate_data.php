<?php
// Informations de connexion à la base de données
$hostname = "localhost"; // Remplacez par l'hôte de votre serveur MySQL
$username = "root"; // Remplacez par votre nom d'utilisateur MySQL
$password = "root"; // Remplacez par votre mot de passe MySQL
$database = "tower_defense"; 
$limit = ini_get('memory_limit');
ini_set('memory_limit', -1);
set_time_limit(300); 

//connexion à la base de données
$connexion = mysqli_connect($hostname, $username, $password, $database);

// Vérifier la connexion
if (!$connexion) {
    die("Échec de la connexion à la base de données : " . mysqli_connect_error());
}
//_____________générer_______________
// Fonction générer un ID unique
function generateUniqueID($table, $column)
{
    global $connexion;
    $id = uniqid();
    $query = "SELECT $column FROM $table WHERE $column = '$id'";
    $result = mysqli_query($connexion, $query);
    if (mysqli_num_rows($result) > 0) {
        return generateUniqueID($table, $column);
    }
    return $id;
}

//  données aléatoires pour  table "joueur"
function generateRandomJoueurData()
{
    $nametag = "Player" . rand(1, 1000);
    $mdp = "password" . rand(1, 1000);
    $email = $nametag . "@example.com";
    $tel = "123456789";
    $photo_profil = "profile.jpg"; // Chemin vers une image de profil par défaut
    return [
        "nametag" => $nametag,
        "mdp" => $mdp,
        "email" => $email,
        "tel" => $tel,
        "photo_profil" => $photo_profil
    ];
}

// données aléatoires pour table "statistiques_joueur"
function generateRandomStatistiquesJoueurData($joueurID)
{
    $parties_jouees_total = rand(2, 100);
    $nombre_vagues_totales = rand(2, 50);
    $nombre_vague_maximale = rand(2, 10);
    $nombre_monstre_total = rand(2, 1000);
    $monstres_tues_individuel = rand(2, 500);
    $temps_total_jeu = rand(2, 1000);
    $tours_construites_total = rand(2, 200);
    $tours_individuel_total = rand(2, 100);
    $tune_totale = rand(2, 100000);
    $score = rand(2, 10000);
    return [
        "ID_joueur" => $joueurID,
        "parties_jouees_total" => $parties_jouees_total,
        "nombre_vagues_totales" => $nombre_vagues_totales,
        "nombre_vague_maximale" => $nombre_vague_maximale,
        "nombre_monstre_total" => $nombre_monstre_total,
        "monstres_tues_individuel" => $monstres_tues_individuel,
        "temps_total_jeu" => $temps_total_jeu,
        "tours_construites_total" => $tours_construites_total,
        "tours_individuel_total" => $tours_individuel_total,
        "tune_totale" => $tune_totale,
        "score" => $score
    ];
}

//   données aléatoires pourtable "partie_lambda"
function generateRandomPartieLambdaData($joueurID)
{
    $parties_jouees = rand(1, 100);
    $nombre_vagues_totales = rand(1, 50);
    $nombre_monstre_total = rand(1, 1000);
    $monstres_tues_individuel = rand(1, 500);
    $temps_total_partie = rand(1, 1000);
    $tours_construites_total = rand(1, 200);
    $tours_individuel_total = rand(1, 100);
    $tune_totale = rand(1, 100000);
    $score = rand(1, 10000);
    return [
        "ID_joueur" => $joueurID,
        "parties_jouees" => $parties_jouees,
        "nombre_vagues_totales" => $nombre_vagues_totales,
        "nombre_monstre_total" => $nombre_monstre_total,
        "monstres_tues_individuel" => $monstres_tues_individuel,
        "temps_total_partie" => $temps_total_partie,
        "tours_construites_total" => $tours_construites_total,
        "tours_individuel_total" => $tours_individuel_total,
        "tune_totale" => $tune_totale,
        "score" => $score
    ];
}

// données aléatoires pour table "historique_parties"
function generateRandomHistoriquePartiesData($partieID, $joueurID)
{
    $nombre_vagues_totales = rand(2, 50);
    $nombre_monstre_total = rand(2, 1000);
    $monstres_tues_individuel = rand(2, 500);
    $temps_total_partie = rand(2, 1000);
    $tours_construites_total = rand(2, 200);
    $tours_individuel_total = rand(2, 100);
    $tune_totale = rand(2, 100000);
    $score = rand(2, 10000);
    return [
        "ID_historique" => generateUniqueID('historique_parties', 'ID_historique'),
        "ID_partie" => $partieID,
        "ID_joueur" => $joueurID,
        "nombre_vagues_totales" => $nombre_vagues_totales,
        "nombre_monstre_total" => $nombre_monstre_total,
        "monstres_tues_individuel" => $monstres_tues_individuel,
        "temps_total_partie" => $temps_total_partie,
        "tours_construites_total" => $tours_construites_total,
        "tours_individuel_total" => $tours_individuel_total,
        "tune_totale" => $tune_totale,
        "score" => $score
    ];
}

//  données aléatoires pourtable "post"
function generateRandomPostData($joueurID)
{
    $post = "Lorem ipsum dolor sit amet, consectetur adipiscing elit.";
    $commentaire = rand(10, 10);
    $titre = "Titre du post " . rand(10, 100);
    $timestamp = date("Y-m-d H:i:s");
    return [
        "ID_joueur" => $joueurID,
        "Post" => $post,
        "Commentaire" => $commentaire,
        "Titre" => $titre,
        "Timestamp" => $timestamp
    ];
}

// données aléatoires pour  table "commentaire"
function generateRandomCommentaireData($joueurID, $postID)
{
    $commentaire = "Lorem ipsum dolor sit amet, consectetur adipiscing elit.";
    $timestamp = date("Y-m-d H:i:s");
    return [
        "ID_joueur" => $joueurID,
        "ID_post" => $postID,
        "Commentaire" => $commentaire,
        "Timestamp" => $timestamp
    ];
}

//   données aléatoires  table "discussion_mp"
function generateRandomDiscussionMPData($joueur1ID, $joueur2ID)
{
    $discussionID = generateUniqueID('discussion_mp', 'ID_discussion');
    $messageID = rand(1, 100);
    return [
        "ID_joueur1" => $joueur1ID,
        "ID_joueur2" => $joueur2ID,
        "ID_discussion" => $discussionID,
        "ID_message" => $messageID
    ];
}

// données aléatoires pour  "message"
function generateRandomMessageData($joueurID)
{
    $messageID = rand(1, 100);
    $timestamp = date("Y-m-d H:i:s");
    $contenu = "Lorem ipsum dolor sit amet, consectetur adipiscing elit.";
    return [
        "ID_message" => $messageID,
        "timestamp" => $timestamp,
        "ID_joueur" => $joueurID,
        "contenu" => $contenu
    ];
}

//  données aléatoires pour "discussion_historique"
function generateRandomDiscussionHistoriqueData($discussionID)
{
    $historiqueID = generateUniqueID('discussion_historique', 'ID_historique');
    return [
        "ID_discussion" => $discussionID,
        "ID_historique" => $historiqueID
    ];
}

//________________générer data + insert dans tableau_________
// nombre de row à insérer
$numRows = 3;
for ($i = 0; $i < $numRows; $i++) {
    // la table "joueur"
    $joueurData = generateRandomJoueurData();
    $sql_insert_joueur = "INSERT INTO joueur (NameTag, mdp, email, tel, photo_profil) VALUES (?, ?, ?, ?, ?)";
    $stmt_joueur = mysqli_prepare($connexion, $sql_insert_joueur);
    mysqli_stmt_bind_param($stmt_joueur, "sssss", $joueurData['nametag'], $joueurData['mdp'], $joueurData['email'], $joueurData['tel'], $joueurData['photo_profil']);
    if (mysqli_stmt_execute($stmt_joueur)) {
        echo "Données insérées avec succès dans la table 'joueur' !\n";
    } else {
        echo "Erreur lors de l'insertion des données dans la table 'joueur' : " . mysqli_error($connexion);
    }

    $joueurID = mysqli_insert_id($connexion);

    // la table "statistiques_joueur"
    $statistiquesJoueurData = generateRandomStatistiquesJoueurData($joueurID);
    $sql_insert_statistiques_joueur = "INSERT INTO statistiques_joueur (ID_joueur, parties_jouees_total, nombre_vagues_totales, nombre_vague_maximale, nombre_monstre_total, monstres_tues_individuel, temps_total_jeu, tours_construites_total, tours_individuel_total, tune_totale, score) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt_statistiques_joueur = mysqli_prepare($connexion, $sql_insert_statistiques_joueur);
    mysqli_stmt_bind_param($stmt_statistiques_joueur, "iiiiiiiiiii", $statistiquesJoueurData['ID_joueur'], $statistiquesJoueurData['parties_jouees_total'], $statistiquesJoueurData['nombre_vagues_totales'], $statistiquesJoueurData['nombre_vague_maximale'], $statistiquesJoueurData['nombre_monstre_total'], $statistiquesJoueurData['monstres_tues_individuel'], $statistiquesJoueurData['temps_total_jeu'], $statistiquesJoueurData['tours_construites_total'], $statistiquesJoueurData['tours_individuel_total'], $statistiquesJoueurData['tune_totale'], $statistiquesJoueurData['score']);
    if (mysqli_stmt_execute($stmt_statistiques_joueur)) {
        echo "Données insérées avec succès dans la table 'statistiques_joueur' !\n";
    } else {
        echo "Erreur lors de l'insertion des données dans la table 'statistiques_joueur' : " . mysqli_error($connexion);
    }

    // la table "partie_lambda"
    $partieLambdaData = generateRandomPartieLambdaData($joueurID);
    $sql_insert_partie_lambda = "INSERT INTO partie_lambda (ID_joueur, parties_jouees, nombre_vagues_totales, nombre_monstre_total, monstres_tues_individuel, temps_total_partie, tours_construites_total, tours_individuel_total, tune_totale, score) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt_partie_lambda = mysqli_prepare($connexion, $sql_insert_partie_lambda);
    mysqli_stmt_bind_param($stmt_partie_lambda, "iiiiiiiiii", $partieLambdaData['ID_joueur'], $partieLambdaData['parties_jouees'], $partieLambdaData['nombre_vagues_totales'], $partieLambdaData['nombre_monstre_total'], $partieLambdaData['monstres_tues_individuel'], $partieLambdaData['temps_total_partie'], $partieLambdaData['tours_construites_total'], $partieLambdaData['tours_individuel_total'], $partieLambdaData['tune_totale'], $partieLambdaData['score']);
    if (mysqli_stmt_execute($stmt_partie_lambda)) {
        echo "Données insérées avec succès dans la table 'partie_lambda' !\n";
    } else {
        echo "Erreur lors de l'insertion des données dans la table 'partie_lambda' : " . mysqli_error($connexion);
    }

    $partieID = mysqli_insert_id($connexion);

    // la table "historique_parties"
    $historiquePartiesData = generateRandomHistoriquePartiesData($partieID, $joueurID);
    $sql_insert_historique_parties = "INSERT INTO historique_parties (ID_historique, ID_partie, ID_joueur, nombre_vagues_totales, nombre_monstre_total, monstres_tues_individuel, temps_total_partie, tours_construites_total, tours_individuel_total, tune_totale, score) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt_historique_parties = mysqli_prepare($connexion, $sql_insert_historique_parties);
    mysqli_stmt_bind_param($stmt_historique_parties, "iiiiiiiiiii", $historiquePartiesData['ID_historique'], $historiquePartiesData['ID_partie'], $historiquePartiesData['ID_joueur'], $historiquePartiesData['nombre_vagues_totales'], $historiquePartiesData['nombre_monstre_total'], $historiquePartiesData['monstres_tues_individuel'], $historiquePartiesData['temps_total_partie'], $historiquePartiesData['tours_construites_total'], $historiquePartiesData['tours_individuel_total'], $historiquePartiesData['tune_totale'], $historiquePartiesData['score']);
    if (mysqli_stmt_execute($stmt_historique_parties)) {
        echo "Données insérées avec succès dans la table 'historique_parties' !\n";
    } else {
        echo "Erreur lors de l'insertion des données dans la table 'historique_parties' : " . mysqli_error($connexion);
    }

    // table "post"
    $postData = generateRandomPostData($joueurID);
    $sql_insert_post = "INSERT INTO post (ID_joueur, Post, Commentaire, Titre, Timestamp) VALUES (?, ?, ?, ?, ?)";
    $stmt_post = mysqli_prepare($connexion, $sql_insert_post);
    mysqli_stmt_bind_param($stmt_post, "issss", $postData['ID_joueur'], $postData['Post'], $postData['Commentaire'], $postData['Titre'], $postData['Timestamp']);
    if (mysqli_stmt_execute($stmt_post)) {
        echo "Données insérées avec succès dans la table 'post' !\n";
    } else {
        echo "Erreur lors de l'insertion des données dans la table 'post' : " . mysqli_error($connexion);
    }

    $postID = mysqli_insert_id($connexion);

    //  table "commentaire"
    $commentaireData = generateRandomCommentaireData($joueurID, $postID);
    $sql_insert_commentaire = "INSERT INTO commentaire (ID_joueur, ID_post, Commentaire, Timestamp) VALUES (?, ?, ?, ?)";
    $stmt_commentaire = mysqli_prepare($connexion, $sql_insert_commentaire);
    mysqli_stmt_bind_param($stmt_commentaire, "iiss", $commentaireData['ID_joueur'], $commentaireData['ID_post'], $commentaireData['Commentaire'], $commentaireData['Timestamp']);
    if (mysqli_stmt_execute($stmt_commentaire)) {
        echo "Données insérées avec succès dans la table 'commentaire' !\n";
    } else {
        echo "Erreur lors de l'insertion des données dans la table 'commentaire' : " . mysqli_error($connexion);
    }
    //  table "message"
    $messageData = generateRandomMessageData($joueurID);
    $sql_insert_message = "INSERT INTO _message (ID_message, timestamp, ID_joueur, contenu) SELECT ?, ?, ?, ? FROM joueur WHERE ID_joueur = ?";                  
    $stmt_message = mysqli_prepare($connexion, $sql_insert_message);
    mysqli_stmt_bind_param($stmt_message, "issis", $messageData['ID_message'], $messageData['timestamp'], $messageData['ID_joueur'], $messageData['contenu'], $messageData['ID_joueur']);
    if (mysqli_stmt_execute($stmt_message)) {
        echo "Données insérées avec succès dans la table 'message' !\n";
    } else {
        echo "Erreur lors de l'insertion des données dans la table 'message' : " . mysqli_error($connexion);
    }

    // la table "discussion_mp"
    $discussionMPData = generateRandomDiscussionMPData($joueurID, $joueurID + 1);
    $sql_insert_discussion_mp = "INSERT INTO discussion_mp (ID_joueur1, ID_joueur2, ID_discussion, ID_message) SELECT ?, ?, ?, ? FROM joueur WHERE ID_joueur = ? AND EXISTS (SELECT ID_joueur FROM joueur WHERE ID_joueur = ?)";
    $stmt_discussion_mp = mysqli_prepare($connexion, $sql_insert_discussion_mp);
    mysqli_stmt_bind_param($stmt_discussion_mp, "iiiiii", $discussionMPData['ID_joueur1'], $discussionMPData['ID_joueur2'], $discussionMPData['ID_discussion'], $discussionMPData['ID_message'], $discussionMPData['ID_joueur1'], $discussionMPData['ID_joueur2']);
    if (mysqli_stmt_execute($stmt_discussion_mp)) {
        echo "Données insérées avec succès dans la table 'discussion_mp' !\n";
    } else {
        echo "Erreur lors de l'insertion des données dans la table 'discussion_mp' : " . mysqli_error($connexion);
    }

    //  table "discussion_historique"
    $discussionHistoriqueData = generateRandomDiscussionHistoriqueData($discussionMPData['ID_discussion']);
$sql_insert_discussion_historique = "INSERT INTO discussion_historique (ID_discussion, ID_historique) SELECT ?, ? FROM discussion_mp WHERE ID_discussion = ?";
$stmt_discussion_historique = mysqli_prepare($connexion, $sql_insert_discussion_historique);
mysqli_stmt_bind_param($stmt_discussion_historique, "ssi", $discussionHistoriqueData['ID_discussion'], $discussionHistoriqueData['ID_historique'], $discussionHistoriqueData['ID_discussion']);
if (mysqli_stmt_execute($stmt_discussion_historique)) {
    echo "Données insérées avec succès dans la table 'discussion_historique' !\n";
} else {
    echo "Erreur lors de l'insertion des données dans la table 'discussion_historique' : " . mysqli_error($connexion);
}
}
mysqli_close($connexion);
ini_set('memory_limit', $limit);
?>

