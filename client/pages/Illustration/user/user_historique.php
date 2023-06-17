<?php
$hostname = "localhost";
$username = "root";
$password = "";
$database = "tower_defense";

$con = mysqli_connect($hostname, $username, $password, $database);

if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

$user_id = isset($_POST['ID_user']) ? $_POST['ID_user'] : '';

if (!empty($user_id)) {
    // on pete les parties dans lordre des id
    $queryParties = "SELECT ID_partie, win, score FROM partie_lambda WHERE ID_user = $user_id ORDER BY ID_partie ASC";
    $resultParties = mysqli_query($con, $queryParties);

    // affiche partie
    
}

mysqli_close($con);
?>

<!DOCTYPE html>
<html>
<head>
<style>
    .parties-container {
    border: 2px solid violet;
    background-color: white;
    padding: 20px;
}

.partie {
    border-bottom: 1px solid violet;
    padding: 10px;
}

.info-partie {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.victoire {
    font-weight: bold;
}

.score {
    font-style: italic;
}

.pagination {
    margin-top: 20px;
}

.pagination a {
    display: inline-block;
    margin-right: 5px;
    padding: 5px 10px;
    background-color: lightgray;
    text-decoration: none;
    color: black;
    border: 1px solid gray;
}

.pagination a:hover {
    background-color: gray;
    color: white;
}
</style> 
</head>
<body>
    <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <label for="ID_user">Enter User ID:</label>
        <input type="text" name="ID_user" id="ID_user" required>
        <button type="submit">Submit</button>
    </form>

    <div class="parties-container">
        <?php
        while ($rowPartie = mysqli_fetch_assoc($resultParties)) {
            $partieID = $rowPartie['ID_partie'];
            $partieWin = $rowPartie['win'] == 0 ? 'Win' : 'Loss';
            $partieScore = $rowPartie['score'];
    
            echo '<div class="partie">';
            echo '<div class="info-partie">';
            echo '<span class="partie-id">Partie ID: ' . $partieID . '</span>';
            echo '<span class="partie-resultat ' . ($partieWin == "Win" ? "victoire" : "defaite") . '">' . $partieWin . '</span>';
            echo '</div>';
            echo '<div class="info-partie">';
            echo '<span class="partie-score">Score: ' . $partieScore . '</span>';
            echo '</div>';
            echo '</div>';
        }
        ?>
    </div>

    <div class="pagination">
        <?php
        if (!empty($user_id)) {
            //  nombre total de pages dependant du nombre de parties par page : pagination
            $partiesParPage = 5;
            $nombreTotalParties = mysqli_num_rows($resultParties);
            $nombreDePages = ceil($nombreTotalParties / $partiesParPage);

            // Vérification validité  page actuelle
            $pageActuelle = isset($_GET['page']) ? $_GET['page'] : 1;
            if ($pageActuelle < 1 || $pageActuelle > $nombreDePages) {
                $pageActuelle = 1;
            }

            // Calcul de l'index de début / fin des parties  afficher
            $indexDebut = ($pageActuelle - 1) * $partiesParPage;
            $indexFin = min($indexDebut + $partiesParPage - 1, $nombreTotalParties - 1);

            //  liens de pagination
            for ($page = 1; $page <= $nombreDePages; $page++) {
                $lienPage = $_SERVER['PHP_SELF'] . '?page=' . $page;
                $classeActive = ($page == $pageActuelle) ? 'active' : '';
                echo '<a href="' . $lienPage . '" class="' . $classeActive . '">' . $page . '</a>';
            }
        }
        ?>
    </div>
</body>
</html>
