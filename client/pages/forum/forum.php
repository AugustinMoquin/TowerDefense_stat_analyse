<?php
$hostname = "localhost";
$username = "root";
$password = "";
$database = "tower_defense";

$con = mysqli_connect($hostname, $username, $password, $database);

if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

$user_id = isset($_COOKIE['id']) ? $_COOKIE['id'] : 5;

// Récupérer tous les forums
$queryForums = "SELECT * FROM forum";
$resultForums = mysqli_query($con, $queryForums);

// Traitement du formulaire de création de forum
if (isset($_POST['createForum'])) {
    $forumTitre = $_POST['forumTitre'];

    $insertForumQuery = "INSERT INTO forum (Forum_titre, ID_user) VALUES ('$forumTitre', $user_id)";
    $resultInsertForum = mysqli_query($con, $insertForumQuery);

    if ($resultInsertForum) {
        echo "Le forum a été créé avec succès.";
    } else {
        echo "Une erreur s'est produite lors de la création du forum.";
    }
}

// Traitement du formulaire de création de post
if (isset($_POST['createPost'])) {
    $forumID = $_POST['forumID'];
    $postTitre = $_POST['postTitre'];
    $postContenu = $_POST['postContenu'];
    
    $insertPostQuery = "INSERT INTO post (ID_forum, ID_user, titre, Post) VALUES ($forumID, $user_id, '$postTitre', '$postContenu')";

    $resultInsertPost = mysqli_query($con, $insertPostQuery);

    if ($resultInsertPost) {
        echo "Le post a été créé avec succès.";
    } else {
        echo "Une erreur s'est produite lors de la création du post.";
    }
}

?>

<!DOCTYPE html>
<html>
<head>
<style>
    .forum-container {
        border: 2px solid violet;
        background-color: white;
        padding: 20px;
    }

    .forum {
        border-bottom: 1px solid violet;
        padding: 10px;
    }

    .forum-titre {
        font-weight: bold;
    }

    .post {
        margin-left: 20px;
        padding: 5px;
        border-left: 1px solid gray;
        cursor: pointer;
    }

    .timestamp {
        font-style: italic;
    }
</style> 
</head>
<body>
    <div class="forum-container">
        <?php
        // Formulaire de création de forum si l'utilisateur est connecté
        if ($user_id > 0) {
            echo '<div class="create-forum">';
            echo '<form method="POST" action="' . $_SERVER['REQUEST_URI'] . '">';
            echo 'Titre du forum: <input type="text" name="forumTitre">';
            echo '<input type="submit" name="createForum" value="Créer un forum">';
            echo '</form>';
            echo '</div>';
        }

        while ($rowForum = mysqli_fetch_assoc($resultForums)) {
            $forumID = $rowForum['ID_forum'];
            $forumTitre = $rowForum['Forum_titre'];

            // Vérifier si la clé 'ID_user' existe dans le tableau $rowForum
            $forumOwnerID = isset($rowForum['ID_user']) ? $rowForum['ID_user'] : null;

            echo '<div class="forum">';
            echo '<span class="forum-titre">' . $forumTitre . '</span>';

            // Options de mise à jour et de suppression du forum
            if ($forumOwnerID !== null && $user_id == $forumOwnerID) {
                echo '<div class="forum-actions">';
                echo '<form method="POST" action="' . $_SERVER['REQUEST_URI'] . '">';
                echo '<input type="hidden" name="forumID" value="' . $forumID . '">';
                echo 'Nouveau titre: <input type="text" name="forumTitre" value="' . $forumTitre . '">';
                echo '<input type="submit" name="updateForum" value="Mettre à jour">';
                echo '</form>';

                echo '<form method="GET" action="' . $_SERVER['REQUEST_URI'] . '">';
                echo '<input type="hidden" name="deleteForumID" value="' . $forumID . '">';
                echo '<input type="submit" name="deleteForum" value="Supprimer">';
                echo '</form>';
                echo '</div>';
            }

            // Récupérer tous les posts d'un forum
            $queryPosts = "SELECT * FROM post WHERE ID_forum = $forumID";
            $resultPosts = mysqli_query($con, $queryPosts);

            while ($rowPost = mysqli_fetch_assoc($resultPosts)) {
                $postID = $rowPost['ID_post'];
                $postContenu = $rowPost['Post'];
                $postTitre = $rowPost['titre'];
                $postTimestamp = $rowPost['Timestamp'];

                echo '<div class="post" onclick="window.location.href=\'post.php?postID=' . $postID . '\'">';
                echo '<span class="post-titre">Titre du post: ' . $postTitre . '</span>';
                echo '<p class="post-contenu">' . $postContenu . '</p>';
                echo '<span class="timestamp">' . $postTimestamp . '</span>';

                // Options de mise à jour et de suppression du post
                if ($forumOwnerID !== null && $user_id == $forumOwnerID) {
                    echo '<div class="post-actions">';
                    echo '<form method="POST" action="' . $_SERVER['REQUEST_URI'] . '">';
                    echo '<input type="hidden" name="postID" value="' . $postID . '">';
                    echo 'Nouveau titre: <input type="text" name="postTitre" value="' . $postTitre . '">';
                    echo 'Nouveau contenu: <input type="text" name="postContenu" value="' . $postContenu . '">';
                    echo '<input type="submit" name="updatePost" value="Mettre à jour">';
                    echo '</form>';

                    echo '<form method="GET" action="' . $_SERVER['REQUEST_URI'] . '">';
                    echo '<input type="hidden" name="deletePostID" value="' . $postID . '">';
                    echo '<input type="submit" name="deletePost" value="Supprimer">';
                    echo '</form>';
                    echo '</div>';
                }

                echo '</div>';
            }

            // Formulaire de création de post si l'utilisateur est connecté
            if ($user_id > 0) {
                echo '<div class="create-post">';
                echo '<form method="POST" action="' . $_SERVER['REQUEST_URI'] . '">';
                echo '<input type="hidden" name="forumID" value="' . $forumID . '">';
                echo 'Titre: <input type="text" name="postTitre">';
                echo 'Contenu: <input type="text" name="postContenu">';
                echo '<input type="submit" name="createPost" value="Créer un post">';
                echo '</form>';
                echo '</div>';
            }

            echo '</div>';
        }

        mysqli_close($con);
        ?>
    </div>
</body>
</html>
