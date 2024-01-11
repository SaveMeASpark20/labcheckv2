<?php
session_start();
if (!isset($_SESSION["admin"])) {
    header("Location: ../index.php");
    exit();
}


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['selectedRoom'])) {
    $selectedRoom = $_POST['selectedRoom'];

    $schoolYear = $_SESSION['school_year'] ;
    $semester = $_SESSION['semester'];

    $targetDirectory = "../room_schedule/";
    $fileName = basename($_FILES["pdfFile"]["name"]);
    $targetFilePath = $targetDirectory . $fileName;
    $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);
    
    $allowedExtensions = array("pdf");

    require_once "../connection/database.php";

    if(in_array($fileType, $allowedExtensions)){
        if(move_uploaded_file($_FILES["pdfFile"]["tmp_name"], $targetFilePath)){
            
            $sql = 'INSERT INTO ftfroomschedule (pdf_name, room_id, school_year, semester) VALUES (?, ?, ?, ?)';
            $roomSchedStmt = $conn->prepare($sql);
            $roomSchedStmt->bind_param("siss", $fileName, $selectedRoom, $schoolYear, $semester);

            if ($roomSchedStmt->execute()) {
            
                echo json_encode(['success' => true, 'message' => 'File uploaded successfully']);
                
            } else {

                echo json_encode(['success' => false, 'message' => 'Failed to add the room schedule']);
            }
            
        } else{
            echo json_encode(['success' => false, 'message' => 'Error uploading the file']);
        }
    } else{

        echo json_encode(['success' => false, 'message' => 'Only PDF files are allowed.']);
    }
    $conn->close();
}

?>