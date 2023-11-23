<?php

require_once "../../connection/database.php";

if (isset($_POST["id"])) {

    $title = $_POST['title'];
    $start_event = $_POST['start'];
    $end_event = $_POST['end'];
    $schedule_id = $_POST['id'];

    $query = "UPDATE complab_schedules SET title=?, start_event=?, end_event=? WHERE schedule_id=?";
    $statement = $conn->prepare($query);

    if ($statement) {
        $statement->bind_param("sssi", $title, $start_event, $end_event, $schedule_id);
        $statement->execute();
        $statement->close();
        
    } else {
        die("Error in the prepared statement: " . $conn->error);
    }

    $conn->close();
}

?>
