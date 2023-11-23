<?php
session_start();
$jsonData = file_get_contents('php://input');
$data = json_decode($jsonData);
if ($data !== null) {

    $category = $data->category;
    $schoolYear = $_SESSION['school_year'];
    $semester = $_SESSION['semester'];
    $notify = 0;
    
    $sql = "SELECT COUNT(*) FROM request WHERE request_type = ? AND notify = ? AND school_year = ? AND semester = ?";
    require_once "../connection/database.php";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param('siss', $category, $notify, $schoolYear, $semester);
        if ($stmt->execute()) {
            $stmt->bind_result($count);
            $stmt->fetch();

            $response = [
                'success' => true,
                'result' => $count
            ];

            header('Content-Type: application/json');
            echo json_encode($response);
            exit();
        }else {
            http_response_code(500);
            echo json_encode([
                'success' => false,
                'error' => 'Failed to execute the query' .$stmt->error
            ]);
            exit();
        }
        $stmt->close();
    }
    $conn->close();
}else {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'error' => 'Data not received'
    ]);
    exit();
}

?>