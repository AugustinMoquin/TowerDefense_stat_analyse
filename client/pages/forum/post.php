<?php
$hostname = "localhost";
$username = "root";
$password = "root";
$database = "tower_defense";

$con = mysqli_connect($hostname, $username, $password, $database);

if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

// Récupérer le post et les commentaires
$postID = $_GET['postID'];

$queryPost = "SELECT * FROM post WHERE ID_post = $postID";
$resultPost = mysqli_query($con, $queryPost);
$rowPost = mysqli_fetch_assoc($resultPost);

$postTitre = $rowPost['titre'];
$postContenu = $rowPost['Post'];
$postTimestamp = $rowPost['Timestamp'];

$queryComments = "SELECT * FROM commentaire WHERE ID_post = $postID";
$resultComments = mysqli_query($con, $queryComments);

// Création d'un commentaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = isset($_COOKIE['id']) ? $_COOKIE['id'] : 5;
    $commentaireContenu = isset($_POST['commentaire']) ? $_POST['commentaire'] : '';

    $queryCreateCommentaire = "INSERT INTO commentaire (ID_post, ID_user, commentaire) VALUES ($postID, $user_id, '$commentaireContenu')";
    mysqli_query($con, $queryCreateCommentaire);

    // Redirection pour éviter la soumission du formulaire lors du rechargement de la page
    header("Location: " . $_SERVER['REQUEST_URI']);
    exit();
}

// Mise à jour d'un commentaire
if (isset($_GET['updateCommentaireID'])) {
    $updateCommentaireID = $_GET['updateCommentaireID'];

    // Vérifier si l'utilisateur connecté est le propriétaire
    $user_id = isset($_COOKIE['id']) ? $_COOKIE['id'] : 5;
    $queryCheckOwner = "SELECT * FROM commentaire WHERE ID_commentaire = $updateCommentaireID AND ID_user = $user_id";
    $resultCheckOwner = mysqli_query($con, $queryCheckOwner);

    if (mysqli_num_rows($resultCheckOwner) > 0) {
        $rowComment = mysqli_fetch_assoc($resultCheckOwner);
        $commentaireContenu = $rowComment['commentaire'];

        // Afficher le formulaire de mise à jour du commentaire
        echo '<form method="POST" action="' . $_SERVER['PHP_SELF'] . '?postID=' . $postID . '">';
        echo '<input type="hidden" name="user" value="' . $user_id . '">';
        echo '<input type="hidden" name="updateCommentaireID" value="' . $updateCommentaireID . '">';
        echo '<textarea name="commentaire" placeholder="Modifier le commentaire" required>' . $commentaireContenu . '</textarea>';
        echo '<button type="submit">Mettre à jour</button>';
        echo '</form>';
    }
}

// Gestion de la suppression d'un commentaire
if (isset($_GET['deleteCommentaireID'])) {
    $deleteCommentaireID = $_GET['deleteCommentaireID'];

    // Vérifier si l'utilisateur connecté est le propriétaire du post avant de supprimer le commentaire
    $user_id = isset($_COOKIE['id']) ? $_COOKIE['id'] : 5;
    $queryCheckOwner = "SELECT * FROM post WHERE ID_post = $postID AND ID_user = $user_id";
    $resultCheckOwner = mysqli_query($con, $queryCheckOwner);

    if (mysqli_num_rows($resultCheckOwner) > 0) {
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
            <h2 class="post-titre">
                <?php echo $postTitre; ?>
            </h2>
            <p class="post-contenu">
                <?php echo $postContenu; ?>
            </p>
            <span class="post-timestamp">
                <?php echo $postTimestamp; ?>
            </span>
        </div>
        <div class="commentaires">
            <?php
            while ($rowComment = mysqli_fetch_assoc($resultComments)) {
                $commentaireID = $rowComment['ID_commentaire'];
                $commentaireUser = $rowComment['ID_user'];
                $commentaireContenu = $rowComment['commentaire'];
                $commentaireTimestamp = $rowComment['Timestamp'];

                echo '<div class="commentaire">';
                echo '<span class="commentaire-user">User ID: ' . $commentaireUser . '</span>';
                echo '<p>' . $commentaireContenu . '</p>';
                echo '<span class="commentaire-timestamp">' . $commentaireTimestamp . '</span>';

                if (isset($user_id) && $commentaireUser == $user_id) {
                    echo '<a href="' . $_SERVER['PHP_SELF'] . '?postID=' . $postID . '&updateCommentaireID=' . $commentaireID . '">Modifier</a>';
                }
                
                // Lien de suppression du commentaire si l'utilisateur est le propriétaire du post
                $queryCheckPostOwner = "SELECT * FROM post WHERE ID_post = $postID AND ID_user = $user_id";
                $resultCheckPostOwner = mysqli_query($con, $queryCheckPostOwner);

                if (mysqli_num_rows($resultCheckPostOwner) > 0) {
                    echo '<a href="' . $_SERVER['PHP_SELF'] . '?postID=' . $postID . '&deleteCommentaireID=' . $commentaireID . '">Supprimer</a>';
                }

                echo '</div>';
            }

            mysqli_close($con);
            ?>
        </div>
    </div>

    <form method="POST" action="<?php echo $_SERVER['PHP_SELF'] . '?postID=' . $postID; ?>">
        <input type="hidden" name="user" value="<?php echo $user_id; ?>">
        <textarea name="commentaire" placeholder="Ajouter un commentaire" required></textarea>
        <button type="submit">Ajouter</button>
    </form>

</body>
<button onclick="redirectForum()">RETOUR AU FORUM</button>

<script>
    function redirectForum() {
        window.location.href = "forum.php";
    }
</script>

</html>