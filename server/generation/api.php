<?php
// Include any necessary dependencies or configuration files

// Function to handle errors and return appropriate JSON response
function handleErrorResponse($message, $statusCode) {
    http_response_code($statusCode);
    $response = array('error' => $message);
    echo json_encode($response, JSON_PRETTY_PRINT);
    exit;
}

// Function to fetch and return the list of tables
function getTableList() {
    $con = mysqli_connect("localhost","root","root","tower_defense");
    if (!$con) {
        handleErrorResponse("Connection to the database failed", 500);
    }

    $sql = "SHOW TABLES";
    $result = mysqli_query($con, $sql);
    if (!$result) {
        handleErrorResponse("Failed to fetch table list", 500);
    }

    $response = array();
    while ($row = mysqli_fetch_array($result)) {
        $response[] = $row[0];
    }

    mysqli_close($con);
    return $response;
}

// Main execution
try {
    $tableList = getTableList();

    header("Content-Type: application/json");
    echo json_encode($tableList, JSON_PRETTY_PRINT);
} catch (Exception $e) {
    handleErrorResponse($e->getMessage(), 500);
}
?>
