<?php
// Start a session
session_start();

// Check if the user is an admin
if (!isset($_SESSION["admin"])) {
    header("Location: ../index.php");
    exit();
}
require_once "../connection/database.php"; 

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $school_year = $_POST["school_year"];
    $semester = $_POST["semester"];
    $status = 1;

    // Check if the academic year and semester already exist
    $isExistQuery = "SELECT school_year, semester FROM academic_year WHERE school_year = ? AND semester = ?";
    $stmtExist = $conn->prepare($isExistQuery);

    if ($stmtExist) {
        $stmtExist->bind_param("ss", $school_year, $semester);
        $stmtExist->execute();
        $resultExist = $stmtExist->get_result();
        
        if ($resultExist->num_rows > 0) {
            // Academic year and semester already exist, update users
            updateUsers($conn, $school_year, $semester, 'Updated');

        } else {
            // Academic year and semester do not exist, insert
            $insertAcadYearQuery = "INSERT INTO academic_year (school_year, semester, status) VALUES (?, ?, ?)";
            $stmtInsert = $conn->prepare($insertAcadYearQuery);
            $stmtInsert->bind_param("ssi", $school_year, $semester, $status);

            if ($stmtInsert->execute()) {
                
                $_SESSION['notification'] = [
                    'message' => "Successfully Added the school year and semester of all users.",
                    'type' => 'success'
                ];

                updateUsers($conn, $school_year, $semester,  'Update');
            } else {
                $_SESSION['notification'] = [
                    'message' => "Failed to add the school year and semester: " . $stmtInsert->error,
                    'type' => 'error'
                ];
            }

            $stmtInsert->close();
        }
        
        $stmtExist->close();
    } else {
        $_SESSION['notification'] = [
            'message' => "Failed to check if the academic year and semester exist: " . $stmtExist->error,
            'type' => 'error'
        ];
    }

    // Redirect
    header("Location: ../admin_labcheck/settings.php");
    $conn->close();
}

function updateUsers($conn, $school_year, $semester,  $action) {
    $updateAcadYearOfUser = "UPDATE user_registration SET school_year = ?, semester = ?";
    $stmtUpdate = $conn->prepare($updateAcadYearOfUser);
    $stmtUpdate->bind_param("ss", $school_year, $semester);

    if ($stmtUpdate->execute()) {

        session_regenerate_id();
        $_SESSION['school_year'] = $school_year;
        $_SESSION['semester'] = $semester;

        $_SESSION['notification'] = [
            'message' => "Successfully $action the school year and semester of all users.",
            'type' => 'success'
        ];
    } else {
        $_SESSION['notification'] = [
            'message' => "Failed to update the school year and semester: " . $stmtUpdate->error,
            'type' => 'error'
        ];
    }

    $stmtUpdate->close();
}
