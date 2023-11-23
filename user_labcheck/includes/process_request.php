<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST" || isset($_POST["submit_request"])) {

    $requestType = $_POST["request_type"];
    $description = $_POST["description"];
    $timeStart = $_POST["time-start"];
    $timeEnd = $_POST["time-end"];
    $date = $_POST["date"];
    $room = intval($_POST["room"]);

    if($requestType !== 'repair' && empty($timeEnd))
    echo $requestType;


    if($requestType != 'repair' && empty($timeEnd)) {
        $_SESSION['notification'] = [
            'message' => 'All Fields are required',
            'type' => 'error' 
        ];
        header("Location: ../make_a_request.php");
        exit();
    }

    if($timeEnd === '') {
        $timeEnd = NULL;
    }

    if(empty($requestType)|| empty($timeStart) || empty($date) || empty($room) || empty($description)) {
        $_SESSION['notification'] = [
            'message' => 'All Fields are required',
            'type' => 'error' 
        ];
        header("Location: ../make_a_request.php");
        exit();
    }

    
    include_once "../../connection/database.php";

    $userid = $_SESSION['userid']; 
    $schoolYear = $_SESSION['school_year'];
    $semester = $_SESSION['semester'];
    $name = $_SESSION['name'];
    
    $unique = false;
    while (!$unique) {
        $randomNumber = mt_rand(0, 999999); 
        $formattedNumber = str_pad($randomNumber, 6, '0', STR_PAD_LEFT);

        $checkIfUnique = "SELECT COUNT(*) as count FROM request WHERE ticket_no = '$formattedNumber'";
        $result = $conn->query($checkIfUnique);
        $row = $result->fetch_assoc();
        if ($row['count'] == 0) {
            $unique = true;
        }
    }

    $sql = "INSERT INTO request (user_id, ticket_no, name, description, time, time_end, date, room_id, request_type, school_year, semester) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?,?,?)";
    // Use prepared statement to prevent SQL injection
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssssisss", $userid, $formattedNumber, $name, $description, $timeStart, $timeEnd, $date, $room, $requestType,  $schoolYear, $semester);

    if ($stmt->execute()) {
        // User added successfully
        $_SESSION['notification'] = [
            'message' => 'Add request successfully',
            'type' => 'success' 
        ];
    } else {
        $_SESSION['notification'] = [
            'message' => 'request failed. Try again later',
            'type' => 'error' 
        ];
    }

    header("Location: ../make_a_request.php");
}
?>