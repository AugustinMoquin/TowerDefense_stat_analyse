
<?php
$rootDir = 'C:\xampp\htdocs\TowerDefense_stat_analyse\client\pages/header.php';
require_once $rootDir;
?><?php
$hostname = "localhost";
$username = "root";
$password = "root";
$database = "tower_defense";



$user_id = isset($_COOKIE['id']) ? $_COOKIE['id'] : '';

$con = mysqli_connect($hostname, $username, $password, $database);

if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

if (!empty($user_id)) {
    $ID_partie = isset($_GET['partie']) ? $_GET['partie'] : '';

    if (!empty($ID_partie)) {
        
        $queryPartie = "SELECT * FROM partie_lambda WHERE ID_partie = $ID_partie AND ID_user = $user_id";
        $resultPartie = mysqli_query($con, $queryPartie);

        if (mysqli_num_rows($resultPartie) > 0) {
            $partieStats = mysqli_fetch_assoc($resultPartie);
            $winTitle = ($partieStats["win"] == 0) ? "Victoire" : "Défaite";
        } else {
            echo "Aucune statistique trouvée pour la partie lambda et l'ID utilisateur spécifiés.";
            mysqli_close($con);
            exit;
        }
    } else {
        echo "Aucune partie spécifiée.";
        mysqli_close($con);
        exit;
    }
} else {
    echo "ID utilisateur non trouvé.";
    mysqli_close($con);
    exit;
}

mysqli_close($con);
?>

<!DOCTYPE HTML>
<html>
<head>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }

        h1 {
            text-align: center;
        }
    </style>
</head>
<body>
<div class="container">
    <h1><?php echo $winTitle; ?></h1>

    <canvas id="myChart"></canvas>

    <script>
        // Récupère les statistiques  partie e les stocke dans  var JS
        var partieStats = <?php echo json_encode($partieStats); ?>;

        // etiquettes données graphiques
        var labels = ['Vagues', 'Monstres', 'Monstres tués', 'Temps', 'Tours construites', 'Tours individuelles', 'Tune', 'Score', 'Durée du jeu'];
        var dataPartie = [
            partieStats.nombre_vagues_totales,
            partieStats.nombre_monstre_total,
            partieStats.monstres_tues_individuel,
            partieStats.temps_total_partie,
            partieStats.tours_construites_total,
            partieStats.tours_individuel_total,
            partieStats.tune_totale,
            partieStats.score,
            partieStats.duree_jeu
        ];

        // Obtient le contexte de dessin= graphique
        var ctx = document.getElementById('myChart').getContext('2d');

        //=BARCHART
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [
                    {
                        label: 'Partie Lambda',
                        backgroundColor: 'rgba(255, 255, 255, 1)',
                        borderColor: 'rgba(0, 0, 0, 1)',
                        borderWidth: 1,
                        data: dataPartie
                    }
                ]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
        ctx.canvas.style.backgroundColor = 'black';
    </script>
</div>
</body>
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
</html>
