<?php
require_once "../../connection/database.php";

session_start();
$school_year = $_SESSION['school_year'];
$semester = $_SESSION['semester'];

$data = array();
$roomNumber = $_GET['room']; // Get the room number from the URL query parameter

// Modify your SQL query to filter by room number
$query = "SELECT * FROM complab_schedules WHERE room_id = ? AND school_year = ? AND semester = ? ORDER BY schedule_id";

if ($stmt = $conn->prepare($query)) {
    $stmt->bind_param('iss', $roomNumber, $school_year, $semester); // Bind the room number as a parameter
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $data[] = array(
                'id'    => $row["schedule_id"],
                'title' => $row["title"],
                'start' => $row["start_event"],
                'end'   => $row["end_event"],
            );
        }
    }

    $stmt->close();
}

echo json_encode($data);

$conn->close(); // Close the database connection
?>
