<?php
session_start();
$school_year = $_SESSION['school_year'];
$semester = $_SESSION['semester'];
require_once "../../connection/database.php";

if (isset($_POST["title"])) {
    $title = $_POST['title'];
    $start_event = $_POST['start'];
    $end_event = $_POST['end'];
    $room = $_POST['room'];

    $query = "INSERT INTO complab_schedules (title, start_event, end_event, room_id, school_year, semester) VALUES (?, ?, ?, ?, ?, ?)";
    $statement = $conn->prepare($query);

    if ($statement) {
        $statement->bind_param("sssiss", $title, $start_event, $end_event, $room, $school_year, $semester);
        $statement->execute();
        $statement->close();
    } else {
        die("Error in the prepared statement: " . $conn->error);
    }

    $conn->close();
}

?>
