<?php
session_start();

if (isset($_POST['approve']) || isset($_POST['reject'])) {
    $requestId = $_POST['request_id'];

    if (isset($_POST['approve'])) {
        $newStatus = 'approve';
    } elseif (isset($_POST['reject'])) {
        $newStatus = 'reject';
        $rejectReason = $_POST['rejection_reason'];
    }

    $requestType = "comlab usage";
    require_once '../connection/database.php';

    // Assuming adminid is the admin's identifier in the sessions
    $adminId = $_SESSION["adminid"];
    $name = ucwords($_SESSION ["name"]);
    $schoolYear = $_SESSION['school_year'];
    $semester = $_SESSION['semester'];

    $feedbackDone = 'DONE';

    date_default_timezone_set('Asia/Manila'); 

    $currentDateTime = date('Y-m-d H:i:s');

    // Fetch the ticket_no from the database
    $ticketNo = null;
    $stmtFetchTicket = $conn->prepare('SELECT ticket_no FROM request WHERE request_id = ?');
    $stmtFetchTicket->bind_param('i', $requestId);
    $stmtFetchTicket->execute();
    $stmtFetchTicket->bind_result($ticketNo);
    $stmtFetchTicket->fetch();
    $stmtFetchTicket->close();

    if ($newStatus === 'reject') {
        if ($stmt = $conn->prepare('UPDATE request SET status = ?, feedback = ? WHERE request_id = ? AND request_type = ?')) {
            $stmt->bind_param('ssis', $newStatus, $rejectReason, $requestId, $requestType);

            if ($stmt->execute()) {
                // Log successful update
                $logEventType = "Comlab Usage";
                $logEventDescription = "Ticket No $ticketNo status updated to $newStatus with reason: $rejectReason by Admin: $name ";

                $logSql = 'INSERT INTO system_logs (event_type, event_description, admin_id, created_at, school_year, semester) VALUES (?, ?, ?, ?,?, ?)';
                $logStmt = $conn->prepare($logSql);
                $logStmt->bind_param('ssssss', $logEventType, $logEventDescription, $adminId, $currentDateTime,  $schoolYear, $semester);
                $logStmt->execute();

                $_SESSION['notification'] = [
                    'message' => 'Successfully rejected the request',
                    'type' => 'success',
                ];
            } else {
                $_SESSION['notification'] = [
                    'message' => "There's an issue updating the request status",
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
    } elseif ($newStatus === 'approve') {
        if ($stmt = $conn->prepare('UPDATE request SET status = ?, feedback = ? WHERE request_id = ? AND request_type = ?')) {
            $stmt->bind_param('ssis', $newStatus, $feedbackDone, $requestId, $requestType);

            if ($stmt->execute()) {
                // Log successful update
                $logEventType = "Comlab Usage";
                $logEventDescription = "Ticket No $ticketNo status updated to $newStatus by Admin: $name";

                $logSql = 'INSERT INTO system_logs (event_type, event_description, admin_id, created_at, school_year, semester) VALUES (?, ?, ?, ?, ?, ?)';
                $logStmt = $conn->prepare($logSql);
                $logStmt->bind_param('ssssss', $logEventType, $logEventDescription, $adminId, $currentDateTime, $schoolYear, $semester);
                $logStmt->execute();

                $_SESSION['notification'] = [
                    'message' => 'Successfully approved the request',
                    'type' => 'success',
                ];
            } else {
                $_SESSION['notification'] = [
                    'message' => "There's an issue updating the request status",
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
    }

    header("Location: ../admin_labcheck/comlab_usage.php");
    $conn->close();
}
?>
