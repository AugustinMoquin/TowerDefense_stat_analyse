<html lang="en">
<?php
require ("../../../server/src/config/database.php");
$conn = openCon();
?>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../pages/assets/chat.css">
    <title>chat</title>
</head>

<body>
    <form action="#" method="POST">
        <input type="text" id="message" name="message" required
       maxlength="50" size="10">
       <button type="submit">envoie</button>
    </form>
</body>


</html>

<?php

?>