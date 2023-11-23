<?php
//subject to delete because we have complab schedule with table
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $room = $_POST["room"];
    $date = $_POST["date"];
    $start_time = $_POST["start_time"];
    $end_time = $_POST["end_time"];
    $recurring = isset($_POST["recurring"]) ? 1 : 0;
    $recurring_frequency = $_POST["recurring_frequency"];
    $recurring_day = $_POST["recurring_day"];
    $recurring_until = $_POST["recurring_until"];

    $user_id= $_SESSION["adminid"];

    require_once "../connection/database.php";
    // Construct the SQL query to insert the schedule
    $sql = "INSERT INTO Schedule (room_id, user_id, start_time, end_time, date, recurring, recurring_frequency, recurring_day, recurring_until)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);

    $stmt->bind_param("issssisss", $room, $user_id, $start_time, $end_time, $date, $recurring, $recurring_frequency, $recurring_day, $recurring_until);


    if ($stmt->execute()) {
        // Successful insertion
        echo "Schedule successfully added!";
    } else {
        // Error handling
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Close the statement
    $stmt->close();
}

// Close the database connection
$conn->close();
?>
