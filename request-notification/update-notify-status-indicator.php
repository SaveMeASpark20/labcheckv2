<?php
session_start();
$jsonData = file_get_contents('php://input');
$data = json_decode($jsonData);

if ($data !== null) {
    $category = $data->category;
    $schoolYear = $_SESSION['school_year'];
    $semester = $_SESSION['semester'];
    $notify = 1; 
    $sql = "UPDATE request SET notify = ? WHERE school_year = ? AND semester = ? AND request_type = ?";
    require_once "../connection/database.php";

    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param('isss', $notify, $schoolYear, $semester, $category);

        if ($stmt->execute()) {
            $response = [
                'success' => true,
                'message' => 'Notify status updated successfully'
            ];

            header('Content-Type: application/json');
            echo json_encode($response);
            exit();
        } else {
            http_response_code(500);
            echo json_encode([
                'success' => false,
                'error' => 'Failed to execute the update query'
            ]);
            exit();
        }

        $stmt->close();
    }

    $conn->close();
} else {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'error' => 'Data not received'
    ]);
    exit();
}
?>
