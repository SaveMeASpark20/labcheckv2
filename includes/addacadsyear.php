<?php
session_start();
if (!isset($_SESSION["admin"])) {
    header("Location: ../index.php");
    exit();
}
require_once "../connection/database.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $school_year = $_POST["school_year"];
    $semester = $_POST["semester"];
    $status = 0;
    $sql = "INSERT INTO academic_year (school_year, semester, status) VALUES (?, ?, ?)";
  
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $school_year, $semester, $status);

    if ($stmt->execute()) {
        // User added successfully

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
    header("Location: ../admin_labcheck/settings.php");
    $conn->close();
}
?>
