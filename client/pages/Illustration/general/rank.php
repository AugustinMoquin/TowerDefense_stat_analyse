<?php
$hostname = "localhost";
$username = "root";
$password = "";
$database = "tower_defense";

$con = mysqli_connect($hostname, $username, $password, $database);

if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

// ______________________________________ PLUS GRAND NOMBRE DE WAVES(jparles pas de cheuveux____________________________)
$queryMaxWaves = "SELECT ID_user FROM partie_lambda ORDER BY nombre_vagues_totales DESC LIMIT 1";
$resultMaxWaves = mysqli_query($con, $queryMaxWaves);
$rowMaxWaves = mysqli_fetch_assoc($resultMaxWaves);
$userMaxWaves = $rowMaxWaves['ID_user'];


$queryWavesCount = "SELECT nombre_vagues_totales AS waves_count FROM partie_lambda WHERE ID_user = {$userMaxWaves}";
$resultWavesCount = mysqli_query($con, $queryWavesCount);
$rowWavesCount = mysqli_fetch_assoc($resultWavesCount);
$wavesCount = $rowWavesCount['waves_count'];

//__________________________________________ PLUS DE MONSTRE DIFF TUE____________________________________
$queryMaxMonstersKilled = "SELECT ID_user FROM partie_lambda ORDER BY monstres_tues_individuel DESC LIMIT 1";
$resultMaxMonstersKilled = mysqli_query($con, $queryMaxMonstersKilled);
$rowMaxMonstersKilled = mysqli_fetch_assoc($resultMaxMonstersKilled);
$userMaxMonstersKilled = $rowMaxMonstersKilled['ID_user'];


$queryMonstersKilledCount = "SELECT monstres_tues_individuel AS monsters_killed_count FROM partie_lambda WHERE ID_user = {$userMaxMonstersKilled}";
$resultMonstersKilledCount = mysqli_query($con, $queryMonstersKilledCount);
$rowMonstersKilledCount = mysqli_fetch_assoc($resultMonstersKilledCount);
$monstersKilledCount = $rowMonstersKilledCount['monsters_killed_count'];

// __________________________________PLUS  DE TEMPS DE JEU___________________________________________
$queryMaxGameDuration = "SELECT ID_user FROM partie_lambda ORDER BY duree_jeu DESC LIMIT 1";
$resultMaxGameDuration = mysqli_query($con, $queryMaxGameDuration);
$rowMaxGameDuration = mysqli_fetch_assoc($resultMaxGameDuration);
$userMaxGameDuration = $rowMaxGameDuration['ID_user'];

$queryGameDuration = "SELECT duree_jeu AS game_duration FROM partie_lambda WHERE ID_user = {$userMaxGameDuration}";
$resultGameDuration = mysqli_query($con, $queryGameDuration);
$rowGameDuration = mysqli_fetch_assoc($resultGameDuration);
$gameDuration = $rowGameDuration['game_duration'];

//____________________________________ BEST TOWER CONSTRUCTION____________________________________________
$queryMaxTowersBuilt = "SELECT ID_user FROM partie_lambda ORDER BY tours_construites_total DESC LIMIT 1";
$resultMaxTowersBuilt = mysqli_query($con, $queryMaxTowersBuilt);
$rowMaxTowersBuilt = mysqli_fetch_assoc($resultMaxTowersBuilt);
$userMaxTowersBuilt = $rowMaxTowersBuilt['ID_user'];


$queryTowersBuiltCount = "SELECT tours_construites_total AS towers_built_count FROM partie_lambda WHERE ID_user = {$userMaxTowersBuilt}";
$resultTowersBuiltCount = mysqli_query($con, $queryTowersBuiltCount);
$rowTowersBuiltCount = mysqli_fetch_assoc($resultTowersBuiltCount);
$towersBuiltCount = $rowTowersBuiltCount['towers_built_count'];

//_________________________________________PLUS MONEY____________________________________
$queryMaxMoney = "SELECT ID_user FROM partie_lambda ORDER BY tune_totale DESC LIMIT 1";
$resultMaxMoney = mysqli_query($con, $queryMaxMoney);
$rowMaxMoney = mysqli_fetch_assoc($resultMaxMoney);
$userMaxMoney = $rowMaxMoney['ID_user'];


$queryMaxMoneyValue = "SELECT tune_totale AS max_money FROM partie_lambda WHERE ID_user = {$userMaxMoney}";
$resultMaxMoneyValue = mysqli_query($con, $queryMaxMoneyValue);
$rowMaxMoneyValue = mysqli_fetch_assoc($resultMaxMoneyValue);
$maxMoney = $rowMaxMoneyValue['max_money'];

//____________________________________ Best SCORE____________________________________________
$queryMaxScore = "SELECT ID_user FROM partie_lambda ORDER BY score DESC LIMIT 1";
$resultMaxScore = mysqli_query($con, $queryMaxScore);
$rowMaxScore = mysqli_fetch_assoc($resultMaxScore);
$userMaxScore = $rowMaxScore['ID_user'];


$queryMaxScoreValue = "SELECT score AS max_score FROM partie_lambda WHERE ID_user = {$userMaxScore}";
$resultMaxScoreValue = mysqli_query($con, $queryMaxScoreValue);
$rowMaxScoreValue = mysqli_fetch_assoc($resultMaxScoreValue);
$maxScore = $rowMaxScoreValue['max_score'];

//____________________________________  Best WINNER___________________________________________
$queryMaxWins = "SELECT ID_user FROM partie_lambda WHERE win = 0 GROUP BY ID_user ORDER BY COUNT(*) DESC LIMIT 1";
$resultMaxWins = mysqli_query($con, $queryMaxWins);
$rowMaxWins = mysqli_fetch_assoc($resultMaxWins);
$userMaxWins = $rowMaxWins['ID_user'];


$queryWinsCount = "SELECT COUNT(*) AS wins_count FROM partie_lambda WHERE win = 0 AND ID_user = {$userMaxWins}";
$resultWinsCount = mysqli_query($con, $queryWinsCount);
$rowWinsCount = mysqli_fetch_assoc($resultWinsCount);
$winsCount = $rowWinsCount['wins_count'];
//____________________________________ Best LOOSE____________________________________________
$queryMaxLosses = "SELECT ID_user FROM partie_lambda WHERE win = 1 GROUP BY ID_user ORDER BY COUNT(*) DESC LIMIT 1";
$resultMaxLosses = mysqli_query($con, $queryMaxLosses);
$rowMaxLosses = mysqli_fetch_assoc($resultMaxLosses);
$userMaxLosses = $rowMaxLosses['ID_user'];

$queryLossesCount = "SELECT COUNT(*) AS loss_count FROM partie_lambda WHERE win = 1 AND ID_user = {$userMaxLosses}";
$resultLossesCount = mysqli_query($con, $queryLossesCount);
$rowLossesCount = mysqli_fetch_assoc($resultLossesCount);
$lossesCount = $rowLossesCount['loss_count'];

mysqli_close($con);

// affiche User et Stats records
echo "Le plus grand survivants est  " . $userMaxWaves . "  avec ({$wavesCount}  de vagues subit)<br>";
echo "Le plus gros Sadique est " . $userMaxMonstersKilled . " avec  ({$monstersKilledCount} différents tués)<br>";
echo "va prendre une douche  " . $userMaxGameDuration . "  t'as joué ({$gameDuration} minutes d'affilés)<br>";
echo " En mode btp " . $userMaxTowersBuilt . "  , il a construit ({$towersBuiltCount} tours)<br>";
echo " Le maxi juif est  " . $userMaxMoney . " avec  ({$maxMoney} de moula récolté)<br>";
echo "Le plus gros tryhader  " . $userMaxScore . " avec  ({$maxScore} score ! RESPIRE STP)<br>";
echo "Le plus skillé " . $userMaxWins . "  est ({$winsCount} , prend le soleil stp)<br>";
echo "Quitte le jeu " . $userMaxLosses . "  , avec ({$lossesCount} losses t'es le plus gros looseur)<br>";

?>





