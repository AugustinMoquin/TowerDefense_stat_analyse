<?php
$rootDir = 'C:\xampp\htdocs\TowerDefense_stat_analyse\client\pages/header.php';
require_once $rootDir;
?>
<?php
$hostname = "localhost";
$username = "root";
$password = "root";
$database = "tower_defense";

$con = mysqli_connect($hostname, $username, $password, $database);

if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

$queryUsers = "SELECT DISTINCT ID_user FROM partie_lambda";
$resultUsers = mysqli_query($con, $queryUsers);
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

    .error-message {
        color: red;
        margin-top: 10px;
    }
</style> 
</head>
<body>
    <div class="parties-container">
        <form method="get" action="">
            <label for="filterUserID">Filter by User ID:</label>
            <select id="filterUserID" name="ID_user">
                <option value="">All Users</option>
                <?php
                while ($rowUser = mysqli_fetch_assoc($resultUsers)) {
                    $user_id = $rowUser['ID_user'];
                    echo '<option value="' . $user_id . '">' . $user_id . '</option>';
                }
                ?>
            </select>

            <label for="filterPartieID">Filter by Partie ID:</label>
            <input type="number" id="filterPartieID" name="ID_partie">

            <label for="filterMinScore">Filter by Minimum Score:</label>
            <select id="filterMinScore" name="min_score">
                <option value="">All Scores</option>
                <option value="0">0+</option>
                <option value="400">400+</option>
                <option value="600">600+</option>
                
                
            </select>

            <button type="submit">Filter</button>
        </form>

        <?php
        // recup filtre via get
        $filterUserID = isset($_GET['ID_user']) ? $_GET['ID_user'] : "";
        $filterPartieID = isset($_GET['ID_partie']) ? $_GET['ID_partie'] : "";
        $filterMinScore = isset($_GET['min_score']) ? $_GET['min_score'] : "";

        // QUERY en fonction des filtre
        if (!empty($filterUserID)) {
            $query = "SELECT partie_lambda.ID_partie, partie_lambda.win, partie_lambda.score, partie_lambda.ID_user 
                      FROM partie_lambda 
                      WHERE partie_lambda.ID_user = '$filterUserID'
                      ORDER BY partie_lambda.ID_partie ASC";
        } elseif (!empty($filterPartieID)) {
            $query = "SELECT partie_lambda.ID_partie, partie_lambda.win, partie_lambda.score, partie_lambda.ID_user 
                      FROM partie_lambda 
                      WHERE partie_lambda.ID_partie = '$filterPartieID'
                      ORDER BY partie_lambda.ID_partie ASC";
        } elseif (!empty($filterMinScore)) {
            $query = "SELECT partie_lambda.ID_partie, partie_lambda.win, partie_lambda.score, partie_lambda.ID_user 
                      FROM partie_lambda 
                      WHERE partie_lambda.score >= '$filterMinScore'
                      ORDER BY partie_lambda.ID_partie ASC";
        } else {
            $query = "SELECT partie_lambda.ID_partie, partie_lambda.win, partie_lambda.score, partie_lambda.ID_user 
                      FROM partie_lambda
                      ORDER BY partie_lambda.ID_partie ASC";
        }

        $result = mysqli_query($con, $query);

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $partieID = $row['ID_partie'];
                $partieWin = $row['win'] == 0 ? 'Win' : 'Loss';
                $partieScore = $row['score'];
                $user_id = $row['ID_user'];

                echo '<div class="partie">';
                echo '<div class="info-partie">';
                echo '<span class="partie-id">Partie ID: ' . $partieID . '</span>';
                echo '<span class="partie-user">User ID: ' . $user_id . '</span>';
                echo '<form action="partie_lambda.php" method="get">';
                echo '<input type="hidden" name="ID_user" value="' . $user_id . '">';
                echo '<input type="hidden" name="ID_partie" value="' . $partieID . '">';
                echo '<input type="submit" value="View Details">';
                echo '</form>';
                echo '</div>';
                echo '<div class="info-partie">';
                echo '<span class="partie-resultat ' . ($partieWin == "Win" ? "victoire" : "defaite") . '">' . $partieWin . '</span>';
                echo '</div>';
                echo '<div class="info-partie">';
                echo '<span class="partie-score">Score: ' . $partieScore . '</span>';
                echo '</div>';
                echo '</div>';
            }
        } else {
            echo '<p class="error-message">PAS LES BON CRITERES , CHERCHE AUTRE CHOSE STP</p>';
        }
        ?>
    </div>
</body>
</html>
