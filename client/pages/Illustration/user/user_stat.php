<?php
$hostname = "localhost";
$username = "root";
$password = "";
$database = "tower_defense"; 

// Connection
$con = mysqli_connect($hostname, $username, $password, $database);

// Check connection 
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

// Get the ID_user de l' input
$user_id = $_POST['ID_user'];

$query = "SELECT win, COUNT(*) AS count FROM partie_lambda WHERE ID_user = '$user_id' GROUP BY win";
$result = mysqli_query($con, $query);

// Data_Pie Chart
$dataPoints = array();
while ($row = mysqli_fetch_assoc($result)) {
    $label = $row['win'] == 0 ? 'Win' : 'Loss';
    $dataPoints[] = array(
        "label" => $label,
        "y" => $row['count']
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
<!-- un Pie Chart Win/ Loose -->
<script>
window.onload = function() {
    var chart = new CanvasJS.Chart("chartContainer", {
        theme: "light2",
        animationEnabled: true,
        title: {
            text: "joueur <?php echo $user_id; ?> stats "
        },
        data: [{
            type: "pie",
            indexLabel: "{y}",
            yValueFormatString: "#,##0.00",
            indexLabelPlacement: "inside",
            indexLabelFontColor: "#36454F",
            indexLabelFontSize: 18,
            indexLabelFontWeight: "bolder",
            showInLegend: true,
            legendText: "{label}",
            dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
        }]
    });

    // Calcul total wins/ losses
    var totalWins = 0;
    var totalLosses = 0;
    <?php
    foreach ($dataPoints as $dataPoint) {
        if ($dataPoint['label'] == 'Win') {
            echo 'totalWins += ' . $dataPoint['y'] . ';';
        } else {
            echo 'totalLosses += ' . $dataPoint['y'] . ';';
        }
    }
    ?>

    // calcul pour pourcentage winn
    var totalGames = totalWins + totalLosses;
    var winPercentage = (totalWins / totalGames) * 100;
    var lossPercentage = (totalLosses / totalGames) * 100;

    // Pourcentage win dans titre
    chart.options.title.text += " (WinRate calculé: " + winPercentage.toFixed(2) + "%)";

    chart.render();
}
</script>

Ce code calcule le nombre total de victoires et de défaites à partir des données et ensuite calcule le pourcentage de victoires. Ensuite, il ajoute le pourcentage de victoires au titre du graphique.

</head>
<body>
<form id="userForm" method="POST" action="">
    <label for="ID_user">Enter User ID:</label>
    <input type="number" id="ID_user" name="ID_user" required>
    <button type="submit">Submit</button>
</form>
<div id="chartContainer" style="height: 370px; width: 100%;"></div>
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
</body>
</html>
