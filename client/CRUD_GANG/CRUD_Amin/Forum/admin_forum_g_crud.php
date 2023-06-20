<?php
session_start();

// Vérification des autorisations (si nécessaire)
//$user_name = $_SESSION['user_name'];
//if ($user_name !== 'admin') {
//    echo "Vous n'avez pas les autorisations pour gérer les forums.";
//    exit;
//}


$pdo = new PDO('mysql:host=127.0.0.1;dbname=tower_defense', 'root', '');


//___________________________________________________________ FORUM_________________________________________________________
//  (Create)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['create_forum'])) {
    $forum_titre = $_POST['forum_titre'];

    $sql = "INSERT INTO forum (Forum_titre) VALUES (:forum_titre)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(':forum_titre' => $forum_titre));

    echo "Le forum a été créé avec succès.";
}

//  (Read)
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

//  (Read with filter)
$forumFilter = isset($_GET['forum_filter']) ? $_GET['forum_filter'] : null;
$sql = "SELECT * FROM forum";
if ($forumFilter) {
    $sql .= " WHERE ID_forum = :forum_filter OR Forum_titre = :forum_filter";
}
$stmt = $pdo->prepare($sql);
if ($forumFilter) {
    $stmt->bindParam(':forum_filter', $forumFilter);
}
$stmt->execute();

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

// (Update)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_forum'])) {
    $ID_forum = $_POST['ID_forum'];
    $forum_titre = $_POST['forum_titre'];

    $sql = "UPDATE forum SET Forum_titre = :forum_titre WHERE ID_forum = :ID_forum";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(':forum_titre' => $forum_titre, ':ID_forum' => $ID_forum));

    echo "Le forum a été mis à jour avec succès.";
}

//  (Delete)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_forum'])) {
    $ID_forum = $_POST['ID_forum'];

    $sql = "DELETE FROM forum WHERE ID_forum = :ID_forum";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(':ID_forum' => $ID_forum));

    echo "Le forum a été supprimé avec succès.";
}

//___________________________________ POST ___________________________________________________________


//(Create)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['create_post'])) {
    $ID_user = $_POST['ID_user'];
    $ID_forum = $_POST['ID_forum'];
    $Post = $_POST['Post'];
    $titre = $_POST['titre'];
    $Timestamp = $_POST['Timestamp'];

    $sql = "INSERT INTO post (ID_user, ID_forum, Post, titre, Timestamp) VALUES (:ID_user, :ID_forum, :Post, :titre, :Timestamp)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(':ID_user' => $ID_user, ':ID_forum' => $ID_forum, ':Post' => $Post, ':titre' => $titre, ':Timestamp' => $Timestamp));

    echo "Le post a été créé avec succès.";
}

//  (Read)
$sql = "SELECT * FROM post";
$stmt = $pdo->query($sql);

echo "<h2>Liste des posts</h2>";
echo "<table>";
echo "<tr><th>ID_post</th><th>ID_user</th><th>ID_forum</th><th>Post</th><th>titre</th><th>Timestamp</th></tr>";

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    echo "<tr>";
    echo "<td>" . $row['ID_post'] . "</td>";
    echo "<td>" . $row['ID_user'] . "</td>";
    echo "<td>" . $row['ID_forum'] . "</td>";
    echo "<td>" . $row['Post'] . "</td>";
    echo "<td>" . $row['titre'] . "</td>";
    echo "<td>" . $row['Timestamp'] . "</td>";
    echo "</tr>";
}

echo "</table>";

//  (Read avec filtre spé)
$postFilter = isset($_GET['post_filter']) ? $_GET['post_filter'] : null;
$userFilter = isset($_GET['user_filter']) ? $_GET['user_filter'] : null;
$titleFilter = isset($_GET['title_filter']) ? $_GET['title_filter'] : null;

if ($postFilter !== null || $userFilter !== null || $titleFilter !== null) {
  $sql = "SELECT * FROM post WHERE 1=0"; // Initialisation de la requête à une condition fausse

  if ($postFilter !== null) {
    $sql .= " OR ID_post = :post_filter";
  }

  if ($userFilter !== null) {
    $sql .= " OR ID_user = :user_filter";
  }

  if ($titleFilter !== null) {
    $sql .= " OR titre = :title_filter";
  }

  $stmt = $pdo->prepare($sql);

  if ($postFilter !== null) {
    $stmt->bindParam(':post_filter', $postFilter);
  }

  if ($userFilter !== null) {
    $stmt->bindParam(':user_filter', $userFilter);
  }

  if ($titleFilter !== null) {
    $stmt->bindParam(':title_filter', $titleFilter);
  }

  $stmt->execute();

  if ($stmt->rowCount() > 0) {
    echo "<h2>ON A TROUVE CA BG</h2>";
    echo "<table>";
    echo "<tr><th>ID_post</th><th>ID_user</th><th>ID_forum</th><th>Post</th><th>titre</th><th>Timestamp</th></tr>";

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      echo "<tr>";
      echo "<td>" . $row['ID_post'] . "</td>";
      echo "<td>" . $row['ID_user'] . "</td>";
      echo "<td>" . $row['ID_forum'] . "</td>";
      echo "<td>" . $row['Post'] . "</td>";
      echo "<td>" . $row['titre'] . "</td>";
      echo "<td>" . $row['Timestamp'] . "</td>";
      echo "</tr>";
    }

    echo "</table>";
  } else {
    echo "<p> RIEN DE TROUVE COMME NOTRE AVENIR LOL</p>";
  }
} else {
  echo "<p>met un  paramètre bg stp</p>";
}

// (Update)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_post'])) {
    $ID_post = $_POST['ID_post'];
    $ID_user = $_POST['ID_user'];
    $ID_forum = $_POST['ID_forum'];
    $Post = $_POST['Post'];
    $titre = $_POST['titre'];
    $Timestamp = $_POST['Timestamp'];

    $sql = "UPDATE post SET ID_user = :ID_user, ID_forum = :ID_forum, Post = :Post, titre = :titre, Timestamp = :Timestamp WHERE ID_post = :ID_post";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(':ID_user' => $ID_user, ':ID_forum' => $ID_forum, ':Post' => $Post, ':titre' => $titre, ':Timestamp' => $Timestamp, ':ID_post' => $ID_post));

    echo "Le post a été mis à jour avec succès.";
}

// (Delete)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_post'])) {
    $ID_post = $_POST['ID_post'];

    $sql = "DELETE FROM post WHERE ID_post = :ID_post";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(':ID_post' => $ID_post));

    echo "Le post a été supprimé avec succès.";
}




//______________________________________________ COMMENTAIRE ______________________________________________________

// (Create)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['create_commentaire'])) {
    $ID_user = $_POST['ID_user'];
    $ID_post = $_POST['ID_post'];
    $commentaire = $_POST['commentaire'];
    $Timestamp = $_POST['Timestamp'];

    $sql = "INSERT INTO commentaire (ID_user, ID_post, commentaire, Timestamp) VALUES (:ID_user, :ID_post, :commentaire, :Timestamp)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(':ID_user' => $ID_user, ':ID_post' => $ID_post, ':commentaire' => $commentaire, ':Timestamp' => $Timestamp));

    echo "Le commentaire a été créé avec succès.";
}

//  (Read) tout
$sql = "SELECT * FROM commentaire";
$stmt = $pdo->query($sql);

echo "<h2>Liste des commentaires</h2>";
echo "<table>";
echo "<tr><th>ID_commentaire</th><th>ID_user</th><th>ID_post</th><th>Commentaire</th><th>Timestamp</th></tr>";

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    echo "<tr>";
    echo "<td>" . $row['ID_commentaire'] . "</td>";
    echo "<td>" . $row['ID_user'] . "</td>";
    echo "<td>" . $row['ID_post'] . "</td>";
    echo "<td>" . $row['commentaire'] . "</td>";
    echo "<td>" . $row['Timestamp'] . "</td>";
    echo "</tr>";
}

echo "</table>";


//____________________________FILTRE USER_________________( COMMENTAIRE ET POST)_________________
if (isset($_GET['user_posts_filter'])) {
    $user_posts_filter = $_GET['user_posts_filter'];
  
    // Récup les posts 
    $post_sql = "SELECT * FROM post WHERE ID_user = :user_posts_filter";
    $post_stmt = $pdo->prepare($post_sql);
    $post_stmt->bindParam(':user_posts_filter', $user_posts_filter);
    $post_stmt->execute();
  
    // Récup les commentaires
    $comment_sql = "SELECT * FROM commentaire WHERE ID_user = :user_posts_filter";
    $comment_stmt = $pdo->prepare($comment_sql);
    $comment_stmt->bindParam(':user_posts_filter', $user_posts_filter);
    $comment_stmt->execute();
  
    echo "<h2>Posts et commentaires de l'utilisateur ID_user = $user_posts_filter</h2>";
  
    //  posts de l'utilisateur
    echo "<h3>Posts de l'utilisateur :</h3>";
    echo "<table>";
    echo "<tr><th>ID_post</th><th>ID_user</th><th>ID_forum</th><th>Post</th><th>titre</th><th>Timestamp</th></tr>";
  
    while ($post_row = $post_stmt->fetch(PDO::FETCH_ASSOC)) {
      echo "<tr>";
      echo "<td>" . $post_row['ID_post'] . "</td>";
      echo "<td>" . $post_row['ID_user'] . "</td>";
      echo "<td>" . $post_row['ID_forum'] . "</td>";
      echo "<td>" . $post_row['Post'] . "</td>";
      echo "<td>" . $post_row['titre'] . "</td>";
      echo "<td>" . $post_row['Timestamp'] . "</td>";
      echo "</tr>";
    }
  
    echo "</table>";
  
    //  commentaires de l'utilisateur
    echo "<h3>Commentaires de l'utilisateur :</h3>";
    echo "<table>";
    echo "<tr><th>ID_commentaire</th><th>ID_user</th><th>ID_post</th><th>Commentaire</th><th>Timestamp</th></tr>";
  
    while ($comment_row = $comment_stmt->fetch(PDO::FETCH_ASSOC)) {
      echo "<tr>";
      echo "<td>" . $comment_row['ID_commentaire'] . "</td>";
      echo "<td>" . $comment_row['ID_user'] . "</td>";
      echo "<td>" . $comment_row['ID_post'] . "</td>";
      echo "<td>" . $comment_row['commentaire'] . "</td>";
      echo "<td>" . $comment_row['Timestamp'] . "</td>";
      echo "</tr>";
    }
  
    echo "</table>";
}

// (Update)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_commentaire'])) {
    $ID_commentaire = $_POST['ID_commentaire'];
    $ID_user = $_POST['ID_user'];
    $ID_post = $_POST['ID_post'];
    $commentaire = $_POST['commentaire'];
    $Timestamp = $_POST['Timestamp'];

    $sql = "UPDATE commentaire SET ID_user = :ID_user, ID_post = :ID_post, commentaire = :commentaire, Timestamp = :Timestamp WHERE ID_commentaire = :ID_commentaire";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(':ID_user' => $ID_user, ':ID_post' => $ID_post, ':commentaire' => $commentaire, ':Timestamp' => $Timestamp, ':ID_commentaire' => $ID_commentaire));

    echo "Le commentaire a été mis à jour avec succès.";
}

//  (Delete)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_commentaire'])) {
    $ID_commentaire = $_POST['ID_commentaire'];

    $sql = "DELETE FROM commentaire WHERE ID_commentaire = :ID_commentaire";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(':ID_commentaire' => $ID_commentaire));

    echo "Le commentaire a été supprimé avec succès.";
}
?>









<h2>Créer un forum</h2>
<form method="post" action="">
    <input type="hidden" name="create_forum" value="1">
    <label for="forum_titre">Titre du forum :</label>
    <input type="text" name="forum_titre" required><br>
    <input type="submit" value="Créer">
</form>

<h2>Mettre à jour un forum</h2>
<form method="post" action="">
    <input type="hidden" name="update_forum" value="1">
    <label for="ID_forum">ID_forum :</label>
    <input type="number" name="ID_forum" required><br>
    <label for="forum_titre">Titre du forum :</label>
    <input type="text" name="forum_titre" required><br>
    <input type="submit" value="Mettre à jour">
</form>

<h2>Supprimer un forum</h2>
<form method="post" action="">
    <input type="hidden" name="delete_forum" value="1">
    <label for="ID_forum">ID_forum :</label>
    <input type="number" name="ID_forum" required><br>
    <input type="submit" value="Supprimer">
</form>


<h2>Créer un post</h2>
<form method="post" action="">
    <input type="hidden" name="create_post" value="1">
    <label for="ID_user">ID_user :</label>
    <input type="number" name="ID_user" required><br>
    <label for="ID_forum">ID_forum :</label>
    <input type="number" name="ID_forum" required><br>
    <label for="Post">Post :</label>
    <input type="text" name="Post" required><br>
    <label for="titre">Titre :</label>
    <input type="text" name="titre" required><br>
    <label for="Timestamp">Timestamp :</label>
    <input type="datetime-local" name="Timestamp" required><br>
    <input type="submit" value="Créer">
</form>

<h2>Mettre à jour un post</h2>
<form method="post" action="">
    <input type="hidden" name="update_post" value="1">
    <label for="ID_post">ID_post :</label>
    <input type="number" name="ID_post" required><br>
    <label for="ID_user">ID_user :</label>
    <input type="number" name="ID_user" required><br>
    <label for="ID_forum">ID_forum :</label>
    <input type="number" name="ID_forum" required><br>
    <label for="Post">Post :</label>
    <input type="text" name="Post" required><br>
    <label for="titre">Titre :</label>
    <input type="text" name="titre" required><br>
    <label for="Timestamp">Timestamp :</label>
    <input type="datetime-local" name="Timestamp" required><br>
    <input type="submit" value="Mettre à jour">
</form>

<h2>Supprimer un post</h2>
<form method="post" action="">
    <input type="hidden" name="delete_post" value="1">
    <label for="ID_post">ID_post :</label>
    <input type="number" name="ID_post" required><br>
    <input type="submit" value="Supprimer">
</form>


<h2>Créer un commentaire</h2>
<form method="post" action="">
    <input type="hidden" name="create_commentaire" value="1">
    <label for="ID_user">ID_user :</label>
    <input type="number" name="ID_user" required><br>
    <label for="ID_post">ID_post :</label>
    <input type="number" name="ID_post" required><br>
    <label for="commentaire">Commentaire :</label>
    <input type="text" name="commentaire" required><br>
    <label for="Timestamp">Timestamp :</label>
    <input type="datetime-local" name="Timestamp" required><br>
    <input type="submit" value="Créer">
</form>

<h2>Mettre à jour un commentaire</h2>
<form method="post" action="">
    <input type="hidden" name="update_commentaire" value="1">
    <label for="ID_commentaire">ID_commentaire :</label>
    <input type="number" name="ID_commentaire" required><br>
    <label for="ID_user">ID_user :</label>
    <input type="number" name="ID_user" required><br>
    <label for="ID_post">ID_post :</label>
    <input type="number" name="ID_post" required><br>
    <label for="commentaire">Commentaire :</label>
    <input type="text" name="commentaire" required><br>
    <label for="Timestamp">Timestamp :</label>
    <input type="datetime-local" name="Timestamp" required><br>
    <input type="submit" value="Mettre à jour">
</form>

<h2>Supprimer un commentaire</h2>
<form method="post" action="">
    <input type="hidden" name="delete_commentaire" value="1">
    <label for="ID_commentaire">ID_commentaire :</label>
    <input type="number" name="ID_commentaire" required><br>
    <input type="submit" value="Supprimer">
</form>


<!-- Filtre  forums  ID_forum/Forum_titre -->
<form method="GET" action="">
  <h3>Filtre forums</h3>
  <label for="forum_filter">entrer ID_forum ou titre du forum :</label>
  <input type="text" name="forum_filter" id="forum_filter" placeholder="Entrez l'ID_forum ou le Forum_titre">
  <input type="submit" value="Filtrer">
</form>

<!-- Filtre posts  ID_user/ ID_post / titre -->
<form method="GET" action="">
  <h3>Filtre posts</h3>
  <label for="post_filter">Filtre par ID_user :</label>
  <input type="text" name="user_filter" id="user_filter" placeholder="Entrez l'ID_user">
  <label for="post_filter">Filtre par ID_post :</label>
  <input type="text" name="post_filter" id="post_filter" placeholder="Entrez l'ID_post">
  <label for="title_filter">Filtre par titre :</label>
  <input type="text" name="title_filter" id="title_filter" placeholder="Entrez le titre">
  <input type="submit" value="Filtrer">
</form>

<!-- Filtre posts d'un utilisateur -->
<form method="GET" action="">
  <h3>Filtre  Participations d'un utilisateur</h3>
  <label for="user_posts_filter">Filtrer par ID_user :</label>
  <input type="text" name="user_posts_filter" id="user_posts_filter" placeholder="Entrez l'ID_user">
  <input type="submit" value="Filtrer">
</form>
