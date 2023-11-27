<?php
session_start();
if (isset($_POST['feedback'])) {
    $requestId = $_POST['request_id'];

    $feedback = $_POST['feedback_message'] . ". ";
    $requestType = 'repair';

    $adminId = $_SESSION["adminid"];
    $name = ucwords($_SESSION ["name"]);
    $schoolYear = $_SESSION['school_year'];
    $semester = $_SESSION['semester'];

    require_once '../connection/database.php';

    $ticketNo = null;
    $stmtFetchTicket = $conn->prepare('SELECT ticket_no FROM request WHERE request_id = ?');
    $stmtFetchTicket->bind_param('i', $requestId);
    $stmtFetchTicket->execute();
    $stmtFetchTicket->bind_result($ticketNo);
    $stmtFetchTicket->fetch();
    $stmtFetchTicket->close();

    if ($stmt = $conn->prepare('UPDATE request SET feedback = ? WHERE request_id = ? AND request_type = ?')) {
        $stmt->bind_param('sis', $feedback, $requestId, $requestType);

        if ($stmt->execute()) {
            // Log successful update
            $logEventType = "Repair Request Feedback";
            $logEventDescription = "Ticket No $ticketNo feedback send: $feedback by Admin: $name";
            
            $logSql = 'INSERT INTO system_logs (event_type, event_description, admin_id, school_year, semester) VALUES (?, ?, ?, ?, ?)';
            $logStmt = $conn->prepare($logSql);
            $logStmt->bind_param('sssss', $logEventType, $logEventDescription, $adminId, $schoolYear, $semester);
            $logStmt->execute();

            $_SESSION['notification'] = [
                'message' => 'Successfully feedback the request',
                'type' => 'success',
            ];
        } else {
            $_SESSION['notification'] = [
                'message' => "There's an issue sending feedback to the request",
                'type' => 'error',
            ];
        }

        $stmt->close();

    } else {
        $_SESSION['notification'] = [
            'message' => 'Database connection error',
            'type' => 'error',
        ];
    }

    header("Location: ../admin_labcheck/terminal_repair.php");
    $conn->close();
}

?>