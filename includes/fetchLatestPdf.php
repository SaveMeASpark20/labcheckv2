<?php
session_start();
$schoolYear = $_SESSION['school_year'];
$semester = $_SESSION['semester'];

require_once "../connection/database.php";

$jsonData = file_get_contents('php://input');
$data = json_decode($jsonData);

if(isset($data->selectedRoom)){
    $roomid = $data->selectedRoom;

    $sql = 'SELECT pdf_name FROM ftfroomschedule WHERE school_year = ? AND semester = ? AND room_id = ? ORDER BY rs_id DESC LIMIT 1';
    $result = $conn->prepare($sql);
    $result->bind_param('ssi', $schoolYear, $semester, $roomid); 

    $result->execute();
    $result->store_result();

    if ($result && $result->num_rows > 0) {
        $result->bind_result($pdfName);
        $result->fetch();
        echo json_encode(['pdfName' => $pdfName]);
    } else {
        echo json_encode(['pdfName' => null]);
    }

    $result->close();
    $conn->close();

}
?>

