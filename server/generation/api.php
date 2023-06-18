<?php
// Include any necessary dependencies or configuration files

// Function to handle errors and return appropriate JSON response
function handleErrorResponse($message, $statusCode) {
    http_response_code($statusCode);
    $response = array('error' => $message);
    echo json_encode($response, JSON_PRETTY_PRINT);
    exit;
}

// Function to fetch and return the table structure and data
function getTableData() {
    $con = mysqli_connect("localhost","root","","tower_defense");
    if (!$con) {
        handleErrorResponse("Connection to the database failed", 500);
    }

    $sql = "SHOW TABLES";
    $result = mysqli_query($con, $sql);
    if (!$result) {
        handleErrorResponse("Failed to fetch table list", 500);
    }

    $tables = array();
    while ($row = mysqli_fetch_array($result)) {
        $tableName = $row[0];
        $tableData = array();

        // Get table columns
        $columns = array();
        $columnsResult = mysqli_query($con, "SHOW COLUMNS FROM $tableName");
        while ($column = mysqli_fetch_assoc($columnsResult)) {
            $columns[] = $column['Field'];
        }
        $tableData['columns'] = $columns;

        // Get table rows
        $rows = array();
        $rowsResult = mysqli_query($con, "SELECT * FROM $tableName");
        while ($row = mysqli_fetch_assoc($rowsResult)) {
            $rows[] = $row;
        }
        $tableData['rows'] = $rows;

        $tables[$tableName] = $tableData;
    }

    mysqli_close($con);
    return $tables;
}

// Main execution
try {
    $tableData = getTableData();

    header("Content-Type: application/json");
    echo json_encode($tableData, JSON_PRETTY_PRINT);
} catch (Exception $e) {
    handleErrorResponse($e->getMessage(), 500);
}
?>
