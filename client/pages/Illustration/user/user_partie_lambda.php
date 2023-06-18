<?php

$hostname = "localhost";
$username = "root";
$password = "";
$database = "tower_defense";

// check si formulaire rempli
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ID_user = $_POST['ID_user'];
    $ID_partie = $_POST['ID_partie'];

   
    $con = mysqli_connect($hostname, $username, $password, $database);

    
    if (!$con) {
        die("Connexion à la base de données échouée : " . mysqli_connect_error());
    }
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

    // Récupz les statistiques  partie lambda spé en fction ID_user
    $sql = "SELECT * FROM partie_lambda WHERE ID_partie = $ID_partie AND ID_user = $ID_user";
    $result = mysqli_query($con, $sql);

    if (mysqli_num_rows($result) > 0) {
       
        $partie_lambda_stats = mysqli_fetch_assoc($result);

        //  titre de victoire défaite  en fction valeur win
        $winTitle = ($partie_lambda_stats["win"] == 0) ? "Victoire" : "Défaite";
    } else {
        echo "Aucune statistique trouvée pour la partie lambda et l'ID utilisateur spécifiés.";
        mysqli_close($con);
        exit;
    }

    // Récup les statistiques moyennes parties lambda  ID_user 
    $sql = "SELECT AVG(nombre_vagues_totales) AS avg_vagues, AVG(nombre_monstre_total) AS avg_monstres, AVG(monstres_tues_individuel) AS avg_monstres_tues, AVG(temps_total_partie) AS avg_temps, AVG(tours_construites_total) AS avg_tours_construites, AVG(tours_individuel_total) AS avg_tours_individuel, AVG(tune_totale) AS avg_tune, AVG(score) AS avg_score, AVG(duree_jeu) AS avg_duree_jeu FROM partie_lambda WHERE ID_user = $ID_user";
    $result = mysqli_query($con, $sql);

    if (mysqli_num_rows($result) > 0) {
        
        $average_lambda_stats = mysqli_fetch_assoc($result);
    } else {
        echo "Aucune statistique moyenne trouvée pour l'ID utilisateur spécifié.";
        mysqli_close($con);
        exit;
    }

    
    mysqli_close($con);
}
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
</head>
<body>
<div class="container">
    <h1><?php echo $winTitle; ?></h1>
    <form action="" method="post">
        <label for="ID_user">ID Utilisateur :</label>
        <input type="number" name="ID_user" id="ID_user" required>

        <label for="ID_partie">ID Partie :</label>
        <input type="number" name="ID_partie" id="ID_partie" required>

        <input type="submit" value="Afficher les statistiques">
    </form>

    <canvas id="myChart"></canvas>

    <script>
        // Récup  PHP et stock var Js
        var partieLambdaStats = <?php echo json_encode($partie_lambda_stats); ?>;
        var averageLambdaStats = <?php echo json_encode($average_lambda_stats); ?>;

        // Créez des tableaux  étiquettes et données du graphique
        var labels = ['Vagues', 'Monstres', 'Monstres tués', 'Temps', 'Tours construites', 'Tours individuelles', 'Tune', 'Score', 'Durée du jeu'];
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

        //  contexte  dessin pour graphique
        var ctx = document.getElementById('myChart').getContext('2d');

        //  -----------------------------BARCHART COMPARATIF ----------------------------------------------------
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
                        data: dataPartieLambda
                    },
                    {
                        label: 'Moyenne des parties Lambda',
                        backgroundColor: 'rgba(150, 40, 200, 0.5)',
                        borderColor: 'rgba(150, 40, 200, 1)',
                        borderWidth: 1,
                        data: dataAverageLambda
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
</html>
