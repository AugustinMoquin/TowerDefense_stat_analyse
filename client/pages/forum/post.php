<?php
$hostname = "localhost";
$username = "root";
$password = "";
$database = "tower_defense";

$con = mysqli_connect($hostname, $username, $password, $database);

if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

$user_id = isset($_COOKIE['id']) ? $_COOKIE['id'] : 3;
$postID = $_GET['postID'];

// Vérification de l'ID de l'utilisateur
$queryCheckUser = "SELECT * FROM users WHERE ID_user = $user_id";
$resultCheckUser = mysqli_query($con, $queryCheckUser);

if (mysqli_num_rows($resultCheckUser) == 0) {
    die("Utilisateur non valide.");
}

$queryPost = "SELECT * FROM post WHERE ID_post = $postID";
$resultPost = mysqli_query($con, $queryPost);
$rowPost = mysqli_fetch_assoc($resultPost);

$postTitre = $rowPost['titre'];
$postContenu = $rowPost['Post'];
$postTimestamp = $rowPost['Timestamp'];

$queryComments = "SELECT * FROM commentaire WHERE ID_post = " . mysqli_real_escape_string($con, $postID);
$resultComments = mysqli_query($con, $queryComments);

// Création d'un nouveau commentaire
if (isset($_POST['submit'])) {
    $commentaireContenu = $_POST['commentaire'];

    // Insertion du nouveau commentaire dans la base de données
    $queryCreateCommentaire = "INSERT INTO commentaire (ID_post, ID_user, commentaire) VALUES ($postID, $user_id, '$commentaireContenu')";
    if (mysqli_query($con, $queryCreateCommentaire)) {
        // Redirection vers la page actuelle pour afficher le nouveau commentaire
        header("Location: " . $_SERVER['REQUEST_URI']);
        exit();
    } else {
        echo "Erreur lors de la création du commentaire: " . mysqli_error($con);
    }
}

// Création ou mise à jour d'un commentaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $commentaireID = isset($_POST['commentaireID']) ? $_POST['commentaireID'] : '';
    $commentaireContenu = isset($_POST['commentaire']) ? $_POST['commentaire'] : '';

    // Vérifier si le commentaire existe déjà
    $queryCheckComment = "SELECT * FROM commentaire WHERE ID_commentaire = $commentaireID";
    $resultCheckComment = mysqli_query($con, $queryCheckComment);

    if (mysqli_num_rows($resultCheckComment) > 0) {
        // Mise à jour du commentaire existant
        $queryUpdateCommentaire = "UPDATE commentaire SET commentaire = '$commentaireContenu' WHERE ID_commentaire = $commentaireID";
        mysqli_query($con, $queryUpdateCommentaire);
    } else {
        // Création d'un nouveau commentaire
        $queryCreateCommentaire = "INSERT INTO commentaire (ID_post, ID_user, commentaire) VALUES ($postID, $user_id, '$commentaireContenu')";
        mysqli_query($con, $queryCreateCommentaire);
    }

    // Redirection pour éviter la soumission du formulaire lors du rechargement de la page
    header("Location: " . $_SERVER['REQUEST_URI']);
    exit();
}

// Suppression d'un commentaire
if (isset($_GET['deleteCommentaireID'])) {
    $deleteCommentaireID = $_GET['deleteCommentaireID'];

    // Vérifier si l'utilisateur connecté est le propriétaire du commentaire avant de le supprimer
    $queryCheckCommentOwner = "SELECT * FROM commentaire WHERE ID_commentaire = $deleteCommentaireID AND ID_user = $user_id";
    $resultCheckCommentOwner = mysqli_query($con, $queryCheckCommentOwner);

    if (mysqli_num_rows($resultCheckCommentOwner) > 0) {
        $queryDeleteCommentaire = "DELETE FROM commentaire WHERE ID_commentaire = $deleteCommentaireID";
        mysqli_query($con, $queryDeleteCommentaire);

        // Redirection vers la page actuelle
        header("Location: " . $_SERVER['REQUEST_URI']);
        exit();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <style>
        .post-container {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            border: 2px solid violet;
            background-color: white;
            padding: 20px;
        }

        .post {
            flex: 1;
            margin-right: 20px;
        }

        .commentaires {
            flex: 1;
        }

        .post-titre {
            font-weight: bold;
        }

        .post-contenu {
            margin-top: 10px;
        }

        .post-timestamp {
            font-style: italic;
            margin-top: 10px;
        }

        .commentaire {
            margin-bottom: 10px;
            border: 1px solid gray;
            padding: 5px;
        }

        .commentaire-user {
            font-weight: bold;
        }

        .commentaire-timestamp {
            font-style: italic;
            margin-top: 5px;
        }
    </style>
</head>
<body>
<div class="post-container">
    <div class="post">
        <h2 class="post-titre"><?php echo $postTitre; ?></h2>
        <p class="post-contenu"><?php echo $postContenu; ?></p>
        <span class="post-timestamp"><?php echo $postTimestamp; ?></span>
    </div>
    <div class="commentaires">
        <?php
        if ($resultComments) {
            while ($rowComment = mysqli_fetch_assoc($resultComments)) {
                $commentaireID = $rowComment['ID_commentaire'];
                $commentaireUser = $rowComment['ID_user'];
                $commentaireContenu = $rowComment['commentaire'];
                $commentaireTimestamp = $rowComment['Timestamp'];

                echo '<div class="commentaire">';
                echo '<span class="commentaire-user">User ID: ' . $commentaireUser . '</span>';

                if (isset($_GET['updateCommentaireID']) && $commentaireID == $_GET['updateCommentaireID']) {
                    // Formulaire de mise à jour du commentaire
                    echo '<form method="POST" action="' . $_SERVER['PHP_SELF'] . '?postID=' . $postID . '">';
                    echo '<input type="hidden" name="commentaireID" value="' . $commentaireID . '">';
                    echo '<textarea name="commentaire" placeholder="Modifier le commentaire" required>' . $commentaireContenu . '</textarea>';
                    echo '<button type="submit">Mettre à jour</button>';
                    echo '</form>';
                } else {
                    // Affichage normal du commentaire
                    echo '<p>' . $commentaireContenu . '</p>';
                    echo '<span class="commentaire-timestamp">' . $commentaireTimestamp . '</span>';

                    if ($commentaireUser == $user_id) {
                        echo '<a href="' . $_SERVER['PHP_SELF'] . '?postID=' . $postID . '&updateCommentaireID=' . $commentaireID . '">Modifier</a>';
                        echo '<a href="' . $_SERVER['PHP_SELF'] . '?postID=' . $postID . '&deleteCommentaireID=' . $commentaireID . '">Supprimer</a>';
                    }
                }

                echo '</div>';
            }
        }
        ?>
        <form method="POST" action="<?php echo $_SERVER['PHP_SELF'] . '?postID=' . $postID; ?>">
            <textarea name="commentaire" placeholder="Ajouter un commentaire" required></textarea>
            <button type="submit" name="submit">Ajouter</button>
        </form>
    </div>
</div>
</body>
<button onclick="redirectForum()">retourne PAPOTER</button>
    
    

<script>
    function redirectForum() {
        window.location.href = "forum.php";
    }
    f
</script>
</html>
