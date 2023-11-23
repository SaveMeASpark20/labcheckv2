<?php

session_start();
if (!isset($_SESSION["admin"])) {
    header("Location: ../index.php");
    exit();
}
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $roomNumber = $_POST["room_number"];
        $dayOfWeek = $_POST["day_of_week"];
        $startTime = $_POST["start_time"];
        $endTime = $_POST["end_time"];
        $professor = $_POST["professor"];
        $section = $_POST["section"];
        $subject = $_POST["subject"];

        $adminid = $_SESSION['adminid'];

        require_once "../connection/database.php";

        $stmt = $conn->prepare('SELECT start_time, end_time FROM schedule WHERE day_of_week = ? AND room_id = ?');
        $stmt->bind_param('si', $dayOfWeek, $roomNumber);
        $stmt->execute();
        $stmt->store_result();

        $overlapping = false;

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($dbStartTime, $dbEndTime);

            while ($stmt->fetch()) {
                if (($startTime >= $dbStartTime && $startTime < $dbEndTime) ||
                    ($endTime > $dbStartTime && $endTime <= $dbEndTime)) {
                    $overlapping = true;
                    break; // No need to check further, as there is an overlap
                }
            }
        }

        

        if ($overlapping) {
            echo "There is an overlap with an existing schedule.";
        } else {

            $selectAcademicYearQuery = "SELECT school_year, semester FROM academic_year WHERE status = 1";
            if ($stmt = $conn->prepare($selectAcademicYearQuery)) {
                $stmt->execute();
                $result = $stmt->bind_result($schoolYear, $semester);
            
                if ($stmt->fetch()) {
                    $stmt->close();
                    $sql = "INSERT INTO schedule (room_id, user_id, day_of_week, start_time, end_time, date, professor, section, subject, school_year, semester) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                    
                    $stmt = $conn->prepare($sql);
                    
                    date_default_timezone_set('Asia/Manila');
                    
                    $currentDate = date('Y-m-d');
                    $stmt->bind_param("issssssssss", $roomNumber, $adminid, $dayOfWeek, $startTime, $endTime, $currentDate, $professor, $section, $subject, $schoolYear, $semester);
                    
                    if ($stmt->execute()) {
                        // User added successfully
                        header("Location: ../admin_labcheck/complab_schedule.php");
                        exit();
                    } else {
                        // Handle database error
                        die('Database error: ' . $stmt->error);
                    }
                } else {
                    $message = "No academic year are enable";
                    header("Location: ../admin_labcheck/complab_schedule.php?message=" .urlencode($message));
                    exit();
                }
            
                $stmt->close();
            }
            // Close your database connection
            $conn->close();
        }
    }
?>