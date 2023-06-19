<?php
require("../../../src\config\database.php");
function Get_users()
{

  $conn = openCon();
  $sql = "SELECT ID_user, user_name FROM users";
  $result = $conn->query($sql);
  if ($result->num_rows > 0) {
    // output data of each row
    while ($row = $result->fetch_assoc()) {
      echo "
            <div class='user' name='user'> id: " . $row["ID_user"] . " - Name: " . $row["user_name"] . "<br> </div>
            <form method='POST' action='../../handler/inbetween_chat.php'>
                <input type='hidden' value='" . $row["ID_user"] . "' name='user'>
                <button type='input'> lets discuss </button>
            </form>
          
          ";
    }
  } else {
    echo "0 results";
  }
  $conn->close();
}




?>