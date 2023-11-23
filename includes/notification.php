<?php
    session_start();
    require_once "../connection/database.php";
    $jsonData = file_get_contents('php://input');
    $data = json_decode($jsonData);

    if(isset($data->key) && $data->key === 123) {
        
        $query = "SELECT request_type FROM request WHERE notify = ?";
        $stmt = $conn->prepare($query);

        $notifyValue = 0;
        $stmt->bind_param("i", $notifyValue);

        $stmt->execute();

        $result = $stmt->get_result();

        if ($result) {
            $results = $result->fetch_all(MYSQLI_ASSOC);

            $stmt->close();

            header('Content-Type: application/json');
            echo json_encode($results);
        }
        
    }
    
    if(isset($data->key) && $data->key === 1234){
        $notifyUpdate = "UPDATE request SET notify = ? WHERE notify = ?";
        $stmt = $conn->prepare($notifyUpdate);
        $notified = 1;
        $notify = 0;
        $stmt->bind_param("ii", $notified, $notify);
        $stmt->execute();
    }

    if(!isset($data->key) && $data->key === ''){
        echo 'API Error';
    }
    $conn->close();
?>