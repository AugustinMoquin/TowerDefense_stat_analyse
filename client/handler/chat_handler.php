<?php
function Add_message($friendId){
    $conn = new mysqli("localhost", "root", "root", "tower_defense") or die("Connect failed: %s\n". $conn -> error);
    $id_user = $_COOKIE['id'];
    $message = $_POST['message'];
    
    //insert into the bdd

    $sql = "SELECT ID_discussion FROM discussion_mp WHERE (ID_user1=$id_user AND ID_user2=$friendId)OR (ID_user2=$id_user AND ID_user1=$friendId)"; //
    $result = $conn->query($sql);

    if($row = mysqli_fetch_assoc($result)){
        $id_discussion = $row['ID_discussion'];
        $insertmbr = $conn->prepare("INSERT INTO message(ID_user, contenu, ID_discussion)  VALUES(?,?,?)");
        $insertmbr->execute(array($id_user, $message , $id_discussion));
    }else{
        echo "this discussion does not exist";
    }

    $conn->close();
    unset($_POST);
}
?>
<?php
function Display_chat($friendId){    
    $conn = new mysqli("localhost", "root", "root", "tower_defense") or die("Connect failed: %s\n". $conn -> error);
    $id_user = $_COOKIE['id'];


    $sql = "SELECT ID_discussion FROM discussion_mp WHERE (ID_user1=$id_user AND ID_user2=$friendId) OR (ID_user2=$id_user AND ID_user1=$friendId)"; //
    $result = $conn->query($sql);
    if($row = mysqli_fetch_assoc($result)){
        $id_discussion = $row['ID_discussion'];
        $sql2 = "SELECT * from message WHERE ID_discussion = $id_discussion";
        $result2 = $conn->query($sql2);
        if ($result2->num_rows > 0) {
            // output data of each row
            while($row2 = $result2->fetch_assoc()) {
              echo "
                <div>
                    message :" . $row2['contenu']." user : ". $row2["ID_user"]. " at : " . $row2["timestamp"]."
                </div> 
              ";
            }
          } else {
            echo "0 results";
          }

    }
    
      $conn -> close();
}
?>
