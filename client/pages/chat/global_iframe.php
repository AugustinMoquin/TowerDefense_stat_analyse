<meta http-equiv="refresh" content="2">
<script>
        window.onload = function() {
            window.scrollTo(0, document.body.scrollHeight);
        };
</script>

<?php
$conn = new mysqli("localhost", "root", "root", "tower_defense") or die("Connect failed: %s\n". $conn -> error);
$id_user = $_COOKIE['id'];

    $id_discussion = 1;
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

    
      $conn -> close();
?>