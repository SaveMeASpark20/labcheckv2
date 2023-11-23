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

        $sql = "INSERT INTO announcement(user_id, name, subject, description, created_at, school_year, semester) VALUES (?, ?, ?, ?, NOW(), ?, ?)";
        if($stmt = $conn->prepare($sql)){
            $stmt->bind_param("ssssss", $adminid, $name, $subject, $description,  $schoolYear, $semester);

            if ($stmt->execute()) {
                $_SESSION['notification'] = [
                    'message' => 'Successfully added the school year and semester.',
                    'type' => 'success' 
                ];
            } else {
                $_SESSION['notification'] = [
                    'message' => "Failed to add the school year and semester.",
                    'type' => 'error' 
                ];
            }
        } 
        header("Location: ../admin_labcheck/home.php");
}
?>
