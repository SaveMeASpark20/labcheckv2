<?php

require_once "../../connection/database.php";

if (isset($_POST["id"])) {
    $id = $_POST['id'];

    $query = "DELETE FROM complab_schedules WHERE schedule_id = ?";
    $statement = $conn->prepare($query);

    if ($statement) {
        $statement->bind_param("i", $id); 
        $statement->execute();
        $statement->close();
    } else {
        die("Error in the prepared statement: " . $conn->error);
    }

    $conn->close();
}

?>
