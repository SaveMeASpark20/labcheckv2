<?php
include 'connection/database.php';

if (isset ($_POST['sub'])){
    
        $stmt = $conn->prepare("SELECT * FROM `webnotificationsubscription` WHERE details = ?");
        $stmt->bind_param("s", $_POST['sub']);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $response = ['message' => 'Web notification subscription already exists. Nothing to create.'];
        } else {

            $stmt = $conn->prepare("INSERT INTO `webnotificationsubscription`(`details`, `status`) VALUES (?, 'subscribed')");
            $stmt->bind_param("s", $_POST['sub']);
            $stmt->execute();

            $response = ['message' => 'Web notification subscription created successfully'];
        }

        header('Content-Type: application/json');
        echo json_encode($response);
} else {
    $response = ['message' => 'Invalid data received.'];
    header('Content-Type: application/json');
    echo json_encode($response);
}
?>
