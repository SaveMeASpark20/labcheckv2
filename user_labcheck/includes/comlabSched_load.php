<?php

require_once "../../connection/database.php";

$data = array();
$room = $_GET['room'];
$query = "SELECT * FROM complab_schedules WHERE ROOM_ID = ? ORDER BY schedule_id";

if ($stmt = $conn->prepare($query)) {
    $stmt->bind_param('i', $room); //pinalitan dahil integer type yan sa database
    $stmt->execute();

    // Get the result set
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

    // Close the prepared statement
    $stmt->close();
}

echo json_encode($data);

$conn->close(); // Close the database connection
?>