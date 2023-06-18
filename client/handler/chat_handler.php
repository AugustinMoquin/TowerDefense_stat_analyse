<?php
require ("../../../src\config\database.php");
$conn = openCon();

function Display_chat(){
    $conn = openCon();
    $sql = "SELECT ID_user, user_name FROM users";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
          echo "
            <div class='user' name='user'> id: " . $row["ID_user"]. " - Name: " . $row["user_name"]. "<br> </div>
            <form method='POST' action='../chat/chat.php'>
                <input type='hidden' value='" . $row["ID_user"]. "' name='" . $row["ID_user"]. "'>
                <button type='input'> lets discuss </button>
            </form>
          
          ";
        }
      } else {
        echo "0 results";
      }
      $conn->close();
}

if (isset($_POST['message'])){
    $message = $_POST['message'];
    $sql = "INSERT INTO message (contenu, ID_user, ID_discussion)
    VALUES ($message , '1', '1')";

    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    
    $conn->close();
}