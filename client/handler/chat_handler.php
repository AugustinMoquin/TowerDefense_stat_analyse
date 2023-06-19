<?php
require ("../../src\config\database.php");
$conn = openCon();
$id_user = $_COOKIE['id'];

//insert into the bdd
if (isset($_POST['message'])){
    $message = $_POST['message'];
    $relation = $_POST['id_relations'];
    $sql = "INSERT INTO message (contenu, ID_user, ID_discussion)
    VALUES ($message , $id_user, $relation)";

    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    
    $conn->close();
}

function Display_chat($id_discussion){
    $conn = openCon();
    $sql = "SELECT * FROM message WHERE ID_discussion = $id_discussion INNER JOIN realtions ON message.ID_discussion = relations.ID_Relations ";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
          echo "
            <div>
                message :" . $row['contenu']." user : ". $row["ID_user"]. " at : " . $row["Timestamp"]."
            </div> 
          ";
        }
      } else {
        echo "0 results";
      }
      $conn->close();

      
}
