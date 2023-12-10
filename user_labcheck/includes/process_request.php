<?php
session_start();

require "../../vendor/autoload.php";
use Minishlink\WebPush\Subscription;
use Minishlink\WebPush\WebPush;

if ($_SERVER["REQUEST_METHOD"] == "POST" || isset($_POST["submit_request"])) {

    $requestType = $_POST["request_type"];
    $description = $_POST["description"];
    $timeStart = $_POST["time-start"];
    $timeEnd = $_POST["time-end"];
    $date = $_POST["date"];
    $room = intval($_POST["room"]);

    if(empty($requestType)|| empty($timeStart) || empty($timeEnd) || empty($date) || empty($room) || empty($description)) {
        $_SESSION['notification'] = [
            'message' => 'All Fields are required',
            'type' => 'error' 
        ];
        header("Location: ../make_a_request.php");
        exit();
    }

    include_once "../../connection/database.php";

    $userid = $_SESSION['userid']; 
    $name = $_SESSION['name'];
    
    try {
        $sql = 'SELECT school_year, semester FROM user_registration WHERE id = ?';
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('s', $userid);
        $stmt->execute();
        $stmt->bind_result($schoolYear, $semester);
        $stmt->fetch();
        $stmt->close(); 
    } catch (Exception $e) {
        // Handle database errors here.
        die('Database error: ' . $e->getMessage());
    }
    
    if ($_SESSION['school_year'] !== $schoolYear || $_SESSION['semester'] !== $semester) {
        session_regenerate_id();
        $_SESSION['school_year'] = $schoolYear;
        $_SESSION['semester'] = $semester;
    }

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
  
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssssisss", $userid, $formattedNumber, $name, $description, $timeStart, $timeEnd, $date, $room, $requestType,  $schoolYear, $semester);

    if ($stmt->execute()) {
        if($requestType === 'comlab usage')
            $linkUrl = "http://localhost/labcheckv2/admin_labcheck/comlab_usage.php";
        elseif ($requestType === 'repair') 
            $linkUrl = "http://localhost/labcheckv2/admin_labcheck/terminal_repair.php";
        elseif ($requestType === 'equipment')
            $linkUrl = "http://localhost/labcheckv2/admin_labcheck/request_equipment.php";
        
        sendWebNotification("Someone is requesting.", $description ,"../images/labcheck_logo.png","../images/udm_logo.png", $linkUrl , $conn);
  
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

function sendWebNotification($title, $message, $icon, $image, $onclic_url, $conn) {
    $query1 = "SELECT * FROM webnotificationsubscription";
    $stmt = $conn->prepare($query1);

    if ($stmt) {
        $stmt->execute();
        $result1 = $stmt->get_result();

        if ($result1) {
            while ($row = $result1->fetch_assoc()) {
                $sub = Subscription::create(json_decode($row['details'], true));

                $push = new WebPush([
                    "VAPID" => [
                        "subject" => "leguizcc12@gmail.com",
                        "publicKey" => "BBt4aeJUh0cO3PoGP_T8BKsM8QtggF4zYmWDNvSOtHqwa91VO8sQVqovNBXs-U7DxjczjMw4jeeFOX1pNGktc2c",
                        "privateKey" => "1vjk0EpbiqMv2wU4F2JuYvsHamPCsc4RECWMzfxKQ5o"
                    ]
                ]);

                $result = $push->sendOneNotification($sub, json_encode([
                    "title" => $title,
                    "body" => $message,
                    "icon" => $icon,
                    "image" => $image,
                    "onclic_url" => $onclic_url
                ]));

                if ($result->isSuccess()) {
                    $_SESSION['notification'] = [
                        'message' => 'Push Notification successfully',
                        'type' => 'success'
                    ];
                } else {
                    $_SESSION['notification'] = [
                        'message' => 'Push Notification Failed',
                        'type' => 'error'
                    ];
                }
            }
            $stmt->close();
        } else {
            $_SESSION['notification'] = [
                'message' => 'Error in fetching results',
                'type' => 'error'
            ];
        }
    } else {
        $_SESSION['notification'] = [
            'message' => 'Error in preparing the statement',
            'type' => 'error'
        ];
    }
}


?>