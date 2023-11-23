<?php
session_start();
$jsonData = file_get_contents('php://input');
$data = json_decode($jsonData);
if ($data !== null) {

    $schoolYear = $data->schoolYear;
    $semester = $data->semester;
    $status = $data->status;
    $newStatus = ($status == 0) ? 1 : 0;
    $sql = "UPDATE academic_year SET status = ? WHERE school_year = ? AND semester = ?;";
    require_once "../connection/database.php";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param('sss', $newStatus, $schoolYear, $semester);
        if ($stmt->execute()) {
            $_SESSION['notification'] = [
                'message' => 'Successfully update the status of academic year and semester.',
                'type' => 'success' 
            ];

            $response = ['message' => 'Data received and processed successfully'];
            header('Content-Type: application/json');
            echo json_encode($response);
        }
        $stmt->close();
    }
    $conn->close();
}else {
    $_SESSION['notification'] = [
        'message' => 'Failed to update the status of academic year and semester.',
        'type' => 'error' 
    ];

    http_response_code(400); // Bad Request
    echo json_encode(['error' => 'Data not received']);
}
?>