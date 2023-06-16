<?php

function view(string $filename, array $data = []): void
{
    // create variables from the associative array
    foreach ($data as $key => $value) {
        $$key = $value;
    }
    require_once __DIR__ . '/../inc/' . $filename . '.php';
}

function is_post_request(): bool
{
    return strtoupper($_SERVER['REQUEST_METHOD']) === 'POST';
}

function is_get_request(): bool
{
    return strtoupper($_SERVER['REQUEST_METHOD']) === 'GET';
}

function conn() : mysqli {
    $servername = "localhost";
    $username = "root";
    $password = "root";
    $dbname = "tower_defense";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }

    echo 'success';

}

?>
