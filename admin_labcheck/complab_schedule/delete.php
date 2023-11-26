<?php
session_start();
$school_year = $_SESSION['school_year'];
$semester = $_SESSION['semester'];
$adminid = $_SESSION['adminid'];
$adminName = $_SESSION['name'];

require_once "../../connection/database.php";

try {
    if (isset($_POST["id"])) {
        $id = $_POST["id"];
        $title = $_POST["title"];

        $query = "DELETE FROM complab_schedules WHERE schedule_id = ?";
        $deleteStatement = $conn->prepare($query);

        if ($deleteStatement) {
            $deleteStatement->bind_param("i", $id); 
            $deleteStatement->execute();
            $deleteStatement->close();

            $systemLog = "INSERT INTO system_logs (event_type, event_description, admin_id, school_year, semester) VALUES(?, ?, ?, ?, ?)";
            $eventType = "Delete Schedule";
            $event_description = "Delete the schedule of $title by $adminName";
            $logStatement = $conn->prepare($systemLog);

            if ($logStatement) {
                $logStatement->bind_param("sssss", $eventType, $event_description, $adminid, $school_year, $semester);
                $logStatement->execute();
                $logStatement->close();
            } else {
                throw new Exception("Error in the prepared statement for system logs: " . $conn->error);
            }
        } else {
            throw new Exception("Error in the prepared statement: " . $conn->error);
        }
    }

} catch (Exception $e) {
    die("Error: " . $e->getMessage());
} finally {
    $conn->close();
}
?>
