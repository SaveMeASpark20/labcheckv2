<?php
session_start();
$school_year = $_SESSION['school_year'];
$semester = $_SESSION['semester'];
$adminid = $_SESSION['adminid'];
$adminName = $_SESSION['name'];

require_once "../../connection/database.php";

if (isset($_POST["title"])) {
    $title = $_POST['title'];
    $start_event = $_POST['start'];
    $end_event = $_POST['end'];
    $room = $_POST['room'];


    $startDateTime = new DateTime($start_event);
    $endDateTime = new DateTime($end_event);

    $formattedStartDateTime = $startDateTime->format('m/d/y h:ia');
    $formattedEndDateTime = $endDateTime->format('m/d/y h:ia');

    $query = "INSERT INTO complab_schedules (title, start_event, end_event, room_id, school_year, semester) VALUES (?, ?, ?, ?, ?, ?)";
    $statement = $conn->prepare($query);

    if ($statement) {
        $statement->bind_param("sssiss", $title, $start_event, $end_event, $room, $school_year, $semester);
        $statement->execute();
        $statement->close();

        $insertedId = $conn->insert_id;
        
        $systemLog = "INSERT INTO system_logs (event_type, event_description, admin_id, school_year, semester) VALUES(?, ?, ?, ?, ?)";
        $eventType = "Add Schedules";
        $event_description = "Add Schedule for $title from $formattedStartDateTime, to $formattedEndDateTime by: $adminName";
        $logStatement = $conn->prepare($systemLog);
        if($logStatement) {
            $logStatement->bind_param("sssss", $eventType, $event_description, $adminid, $school_year, $semester);
            $logStatement->execute();
            $logStatement->close();

            echo json_encode(["id" => $insertedId]);
        }else {
            die("Error in the prepared statement for system logs: " . $conn->error);
        }

    } else {
        die("Error in the prepared statement: " . $conn->error);
    }

    $conn->close();
}

?>
