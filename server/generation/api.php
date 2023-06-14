<?php
$con = mysqli_connect("localhost","root","tower_defense");
$response = array();
if ($con){
    $sql = "SHOW TABLES";
    $result = mysqli_query($con, $sql);
    if ($result){
        header("Content-Type: application/json");
        $i = 0;
        while ($row = mysqli_fetch_array($result)){
            $response[$i] = $row[0];
            $i++;
        }
        echo json_encode($response, JSON_PRETTY_PRINT);
    }
}
else{
    echo " Connection a la databse ratée";
}
?>