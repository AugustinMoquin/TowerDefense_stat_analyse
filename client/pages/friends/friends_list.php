<?php 
require '../../handler/friends_list_handler.php'; 

$rootDir = 'C:\xampp\htdocs\TowerDefense_stat_analyse\client\pages/header.php';
require_once $rootDir;

?>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/friend_list.css">
    <title>your friends</title>
</head>

<body>
<?php view_friends();?>
</body>


</html>