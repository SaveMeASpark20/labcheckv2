<?php
session_start();
require_once "../../connection/database.php";

if (isset($_POST["id"])) {

    $title = $_POST['title'];
    $start_event = $_POST['start'];
    $end_event = $_POST['end'];
    $schedule_id = $_POST['id'];

    $adminid = $_SESSION['adminid'];
    $school_year = $_SESSION['school_year'];
    $semester = $_SESSION['semester'];
    $adminName = $_SESSION['name'];

    $startDateTime = new DateTime($start_event);
    $endDateTime = new DateTime($end_event);

    $formattedStartDateTime = $startDateTime->format('m/d/y h:ia');
    $formattedEndDateTime = $endDateTime->format('m/d/y h:ia');

    $query = "UPDATE complab_schedules SET title=?, start_event=?, end_event=? WHERE schedule_id=?";
    $statement = $conn->prepare($query);

    if ($statement) {
        $statement->bind_param("sssi", $title, $start_event, $end_event, $schedule_id);
        $statement->execute();
        $statement->close();
        $systemLog = "INSERT INTO system_logs (event_type, event_description, admin_id, school_year, semester) VALUES(?, ?, ?, ?, ?)";
            $eventType = "Update Schedule";
            $event_description = "Update the schedule of $title to $formattedStartDateTime - $formattedEndDateTime by $adminName";
            $logStatement = $conn->prepare($systemLog);

            if ($logStatement) {
                $logStatement->bind_param("sssss", $eventType, $event_description, $adminid, $school_year, $semester);
                $logStatement->execute();
                $logStatement->close();
            } else {
                throw new Exception("Error in the prepared statement for system logs: " . $conn->error);
            }
    } else {
        die("Error in the prepared statement: " . $conn->error);
    }

    $conn->close();
}

?>
