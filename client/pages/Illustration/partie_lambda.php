
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
    die("Connexion à la base de données échouée : " . mysqli_connect_error());
}
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $ID_user = $_GET['ID_user'];
    $ID_partie = $_GET['ID_partie'];

    // recup id spe user partie
    $sql = "SELECT * FROM partie_lambda WHERE ID_partie = $ID_partie AND ID_user = $ID_user";
    $result = mysqli_query($con, $sql);

    if (mysqli_num_rows($result) > 0) {
        $partie_lambda_stats = mysqli_fetch_assoc($result);

        // determine win ou loose
        $partieWin = ($partie_lambda_stats["win"] == 0) ? "Victoire" : "Défaite";

        //recup la moyenne
        $sql = "SELECT AVG(nombre_vagues_totales) AS avg_vagues, AVG(nombre_monstre_total) AS avg_monstres, AVG(monstres_tues_individuel) AS avg_monstres_tues, AVG(temps_total_partie) AS avg_temps, AVG(tours_construites_total) AS avg_tours_construites, AVG(tours_individuel_total) AS avg_tours_individuel, AVG(tune_totale) AS avg_tune, AVG(score) AS avg_score, AVG(duree_jeu) AS avg_duree_jeu FROM partie_lambda WHERE ID_user = $ID_user";
        $result = mysqli_query($con, $sql);

        if (mysqli_num_rows($result) > 0) {
            $average_lambda_stats = mysqli_fetch_assoc($result);

            // affich stat et chart
            echo '<!DOCTYPE HTML>
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
            
                    form {
                        display: flex;
                        flex-direction: column;
                        margin-bottom: 20px;
                    }
            
                    form label {
                        font-weight: bold;
                    }
            
                    form input {
                        margin-bottom: 10px;
                    }
                </style>
                <script>
                // Function to general_historique.php
                function goBack() {
                    window.location.href = "general_historique.php";
                }
                // Functione to stat_player.php
                function goToStatPlayer() {
            var userID = ' . $ID_user . ';
            window.location.href = "stat_player.php?ID_user=" + userID;
        }
            </script>
            </head>
            <body>
            <div class="container">
            <h2>ID Utilisateur: <a href="javascript:void(0)" onclick="goToStatPlayer()">' . $ID_user . '</a></h2>
                <h1>' . $partieWin . '</h1>
                <canvas id="myChart"></canvas>
                
            <button class="back-button" onclick="goBack()">Retour</button>

   
                <script>
                    // Recup PHP variables hop dans JavaScript variables
                    var partieLambdaStats = ' . json_encode($partie_lambda_stats) . ';
                    var averageLambdaStats = ' . json_encode($average_lambda_stats) . ';
            
                    //BARCHART
                    var labels = ["Vagues", "Monstres", "Monstres tués", "Temps", "Tours construites", "Tours individuelles", "Tune", "Score", "Durée du jeu"];
                    var dataPartieLambda = [
                        partieLambdaStats.nombre_vagues_totales,
                        partieLambdaStats.nombre_monstre_total,
                        partieLambdaStats.monstres_tues_individuel,
                        partieLambdaStats.temps_total_partie,
                        partieLambdaStats.tours_construites_total,
                        partieLambdaStats.tours_individuel_total,
                        partieLambdaStats.tune_totale,
                        partieLambdaStats.score,
                        partieLambdaStats.duree_jeu
                    ];
                    var dataAverageLambda = [
                        averageLambdaStats.avg_vagues,
                        averageLambdaStats.avg_monstres,
                        averageLambdaStats.avg_monstres_tues,
                        averageLambdaStats.avg_temps,
                        averageLambdaStats.avg_tours_construites,
                        averageLambdaStats.avg_tours_individuel,
                        averageLambdaStats.avg_tune,
                        averageLambdaStats.avg_score,
                        averageLambdaStats.avg_duree_jeu
                    ];
            
                    // chart
                    var ctx = document.getElementById("myChart").getContext("2d");
                    var chart = new Chart(ctx, {
                        type: "bar",
                        data: {
                            labels: labels,
                            datasets: [{
                                label: "Partie Lambda",
                                data: dataPartieLambda,
                                backgroundColor: "rgba(54, 162, 235, 0.5)",
                                borderColor: "rgba(54, 162, 235, 1)",
                                borderWidth: 1
                            },
                            {
                                label: "Moyenne Lambda",
                                data: dataAverageLambda,
                                backgroundColor: "rgba(255, 99, 132, 0.5)",
                                borderColor: "rgba(255, 99, 132, 1)",
                                borderWidth: 1
                            }]
                        },
                        options: {
                            scales: {
                                y: {
                                    beginAtZero: true
                                }
                            }
                        }
                    });
                </script>
            </div>
            </body>
            </html>';
        } else {
            echo "Aucune donnée trouvée pour les statistiques moyennes.";
        }
    } else {
        echo "Aucune donnée trouvée pour cette partie.";
    }
} else {
    echo "Mauvaise méthode de requête.";
}
mysqli_close($con);
?>
