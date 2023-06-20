<?php
$hostname = "localhost";
$username = "root";
$password = "";
$database = "tower_defense";

$con = mysqli_connect($hostname, $username, $password, $database);

if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

$user_id = isset($_COOKIE['id']) ? $_COOKIE['id'] : '';

if (!empty($user_id)) {
    $queryParties = "SELECT ID_partie, win, score FROM partie_lambda WHERE ID_user = $user_id ORDER BY ID_partie ASC";
    $resultParties = mysqli_query($con, $queryParties);
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
    <div class="parties-container">
        <?php
        while ($rowPartie = mysqli_fetch_assoc($resultParties)) {
            $partieID = $rowPartie['ID_partie'];
            $partieWin = $rowPartie['win'] == 0 ? 'Win' : 'Loss';
            $partieScore = $rowPartie['score'];

            echo '<div class="partie">';
            echo '<div class="info-partie">';
            echo '<span class="partie-id">Partie ID: <a href="user_partie_lambda.php?partie=' . $partieID . '">' . $partieID . '</a></span>';
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
            //nombre de page par pagination
            $partiesParPage = 5;
            $nombreTotalParties = mysqli_num_rows($resultParties);
            $nombreDePages = ceil($nombreTotalParties / $partiesParPage);

            // check le nombre de page
            $pageActuelle = isset($_GET['page']) ? $_GET['page'] : 1;
            if ($pageActuelle < 1 || $pageActuelle > $nombreDePages) {
                $pageActuelle = 1;
            }

            //index fin debut
            $indexDebut = ($pageActuelle - 1) * $partiesParPage;
            $indexFin = min($indexDebut + $partiesParPage - 1, $nombreTotalParties - 1);

            // lien de pagination
            for ($page = 1; $page <= $nombreDePages; $page++) {
                $lienPage = $_SERVER['PHP_SELF'] . '?page=' . $page;
                $classeActive = ($page == $pageActuelle) ? 'active' : '';
                echo '<a href="' . $lienPage . '" class="' . $classeActive . '">' . $page . '</a>';
            }
        }
        ?>
    </div>
    <button onclick="redirectStats()">Affiche Tes stats mek</button>
    <button onclick="redirectHist()">Ton historique de game</button>
    

<script>
    function redirectStats() {
        window.location.href = "user_stat.php";
    }
    function redirectHist() {
        window.location.href = "user_hist.php";
    }
</script>
</body>
</html>
