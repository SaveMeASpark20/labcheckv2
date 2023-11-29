<?php
session_start();
if (!isset($_SESSION["admin"])) {
    header("Location: ../index.php");
    exit();
}
require_once "../connection/database.php";

if (isset($_POST['submit-announcement'])) {
    $subject = $_POST["subject"];
    $description = nl2br($_POST["description"]);

    $adminid = $_SESSION['adminid'];
    $name = $_SESSION['name'];
    $schoolYear = $_SESSION['school_year'];
    $semester = $_SESSION['semester'];

    date_default_timezone_set('Asia/Manila'); 

    // Get the current date and time
    $currentDateTime = date('Y-m-d H:i:s');

        $sql = "INSERT INTO announcement(user_id, name, subject, description, created_at, school_year, semester) VALUES (?, ?, ?, ?, ?, ?, ?)";
        if($stmt = $conn->prepare($sql)){
            $stmt->bind_param("sssssss", $adminid, $name, $subject, $description, $currentDateTime, $schoolYear, $semester);

            if ($stmt->execute()) {
                $_SESSION['notification'] = [
                    'message' => 'Successfully Post an Announcement.',
                    'type' => 'success' 
                ];
            } else {
                $_SESSION['notification'] = [
                    'message' => "Failed to Post an Announcement.",
                    'type' => 'error' 
                ];
            }
        } 
        header("Location: ../admin_labcheck/home.php");
}
?>
