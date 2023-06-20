<?php
$hostname = "localhost";
$username = "root";
$password = "";
$database = "tower_defense";

$con = mysqli_connect($hostname, $username, $password, $database);

if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

$user_id = isset($_COOKIE['id']) ? $_COOKIE['id'] : 0;


$query = "SELECT 
    AVG(parties_jouees) AS avg_parties_jouees,
    AVG(nombre_vagues_totales) AS avg_nombre_vagues_totales,
    AVG(nombre_monstre_total) AS avg_nombre_monstre_total,
    AVG(monstres_tues_individuel) AS avg_monstres_tues_individuel,
    AVG(temps_total_partie) AS avg_temps_total_partie,
    AVG(tours_construites_total) AS avg_tours_construites_total,
    AVG(tours_individuel_total) AS avg_tours_individuel_total,
    AVG(tune_totale) AS avg_tune_totale,
    AVG(score) AS avg_score,
    AVG(duree_jeu) AS avg_duree_jeu
FROM partie_lambda
WHERE ID_user = '" . mysqli_real_escape_string($con, $user_id) . "'";

$result = mysqli_query($con, $query);


$dataRow = mysqli_fetch_assoc($result);

// DATA BARCHATRT
$dataBar = array(
    array("label" => "Parties Jouées", "y" => $dataRow['avg_parties_jouees']),
    array("label" => "Nombre de Vagues Totales", "y" => $dataRow['avg_nombre_vagues_totales']),
    array("label" => "Nombre de Monstres Total", "y" => $dataRow['avg_nombre_monstre_total']),
    array("label" => "Monstres Tués Individuel", "y" => $dataRow['avg_monstres_tues_individuel']),
    array("label" => "Temps Total de Partie", "y" => $dataRow['avg_temps_total_partie']),
    array("label" => "Tours Construites Total", "y" => $dataRow['avg_tours_construites_total']),
    array("label" => "Tours Individuel Total", "y" => $dataRow['avg_tours_individuel_total']),
    array("label" => "Tune Totale", "y" => $dataRow['avg_tune_totale']),
    array("label" => "Score", "y" => $dataRow['avg_score']),
    array("label" => "Durée de Jeu", "y" => $dataRow['avg_duree_jeu'])
);

$queryPie = "SELECT win, COUNT(*) AS count FROM partie_lambda WHERE ID_user = '$user_id' GROUP BY win";
$resultPie = mysqli_query($con, $queryPie);

// DATA PIECHART
$dataPointsPie = array();
while ($rowPie = mysqli_fetch_assoc($resultPie)) {
    $labelPie = $rowPie['win'] == 0 ? 'Win' : 'Loss';
    $dataPointsPie[] = array(
        "label" => $labelPie,
        "y" => $rowPie['count']
    );
}

mysqli_close($con);
?>

<!DOCTYPE HTML>
<html>
<head>
<style>
    #userForm {
        margin-bottom: 10px;
    }
</style>
</head>
<body>
<div id="chartContainerPie" style="height: 370px; width: 100%;"></div>
<div id="chartContainerBar" style="height: 370px; width: 100%;"></div>

<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
<script>
window.onload = function() {
    var chartPie = new CanvasJS.Chart("chartContainerPie", {
        theme: "light2",
        animationEnabled: true,
        title: {
            text: "User <?php echo $user_id; ?> Win/Loss Stats"
        },
        data: [{
            type: "pie",
            indexLabel: "{y}",
            yValueFormatString: "#,##0",
            indexLabelPlacement: "inside",
            indexLabelFontColor: "#36454F",
            indexLabelFontSize: 18,
            indexLabelFontWeight: "bolder",
            showInLegend: true,
            legendText: "{label}",
            dataPoints: <?php echo json_encode($dataPointsPie, JSON_NUMERIC_CHECK); ?>
        }]
    });

    var chartBar = new CanvasJS.Chart("chartContainerBar", {
        theme: "light2",
        animationEnabled: true,
        title: {
            text: "User <?php echo $user_id; ?> Average Stats"
        },
        axisY: {
            title: "Average Value"
        },
        data: [{
            type: "column",
            indexLabel: "{y}",
            yValueFormatString: "#,##0.00",
            dataPoints: <?php echo json_encode($dataBar, JSON_NUMERIC_CHECK); ?>
        }]
    });

    // Calcul du total des victoires/défaites
    var totalWins = 0;
    var totalLosses = 0;
    <?php
    foreach ($dataPointsPie as $dataPointPie) {
        if ($dataPointPie['label'] == 'Win') {
            echo 'totalWins += ' . $dataPointPie['y'] . ';';
        } else {
            echo 'totalLosses += ' . $dataPointPie['y'] . ';';
        }
    }
    ?>

    // Calcul + pourcentag
    var totalGames = totalWins + totalLosses;
    var winPercentage = (totalWins / totalGames) * 100;
    var lossPercentage = (totalLosses / totalGames) * 100;

    // Ajout du pourcentage de victoire + titre
    chartPie.options.title.text += " (WinRate: " + winPercentage.toFixed(2) + "%)";

    chartPie.render();
    chartBar.render();
}
</script>
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
