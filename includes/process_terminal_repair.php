<?php
session_start();

// Assuming $conn is defined before this point
require_once '../connection/database.php';

if (isset($_POST['reject']) || isset($_POST['resolve'])) {
    $requestId = $_POST['request_id'];
    $requestType = "repair";
    $eventType = isset($_POST['reject']) ? "Repair Rejected" : "Repair Resolved"; // Define the event type here

    $feedbackDone = "DONE";

    // Fetch the ticket_no from the database
    $ticketNo = null;
    $stmtFetchTicket = $conn->prepare('SELECT ticket_no FROM request WHERE request_id = ?');
    $stmtFetchTicket->bind_param('i', $requestId);
    $stmtFetchTicket->execute();
    $stmtFetchTicket->bind_result($ticketNo);
    $stmtFetchTicket->fetch();
    $stmtFetchTicket->close();

    // Update request status
    if (isset($_POST['reject'])) {
        $newStatus = 'reject';
        $rejectReason = $_POST['rejection_reason'];

        $sql = 'UPDATE request SET status = ?, feedback = ?, time_end = CURRENT_TIMESTAMP WHERE request_id = ? AND request_type = ?';
        $stmt = $conn->prepare($sql);

        if ($stmt) {
            $stmt->bind_param('ssis', $newStatus, $rejectReason, $requestId, $requestType);
        } else {
            $_SESSION['notification'] = [
                'message' => 'Database connection error',
                'type' => 'error'
            ];
        }
    } elseif (isset($_POST['resolve'])) {
        $newStatus = 'resolved';

        $sql = 'UPDATE request SET status = ?, feedback = ? time_end = CURRENT_TIMESTAMP WHERE request_id = ? AND request_type = ?';
        $stmt = $conn->prepare($sql);

        if ($stmt) {
            $stmt->bind_param('ssis', $newStatus, $feedbackDone, $requestId, $requestType);
        } else {
            $_SESSION['notification'] = [
                'message' => 'Database connection error',
                'type' => 'error'
            ];
        }
    }

    if ($stmt && $stmt->execute()) {
        // Log the event in the system logs
        logSystemEvent($conn, $eventType, $ticketNo);
        $_SESSION['notification'] = [
            'message' => "Successfully " . strtolower($eventType) . " the request",
            'type' => 'success'
        ];
    } else {
        $_SESSION['notification'] = [
            'message' => "Error updating request status: " . ($stmt ? $stmt->error : 'Unknown error'),
            'type' => 'error'
        ];
    }

    if ($stmt) {
        $stmt->close();
    }

    header("Location: ../admin_labcheck/terminal_repair.php");
    $conn->close();
}

function logSystemEvent($conn, $eventType, $ticketNo) {
    $adminId = $_SESSION['adminid'];
    $description = "$eventType for Ticket No: $ticketNo by Admin ID: $adminId";

    $sql = 'INSERT INTO system_logs (event_type, event_description, admin_id) VALUES (?, ?, ?)';
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param('sss', $eventType, $description, $adminId);

        if (!$stmt->execute()) {
            $_SESSION['notification'] = [
                'message' => "Error logging $eventType: " . $stmt->error,
                'type' => 'error'
            ];
        }

        $stmt->close();
    } else {
        $_SESSION['notification'] = [
            'message' => 'Database connection error',
            'type' => 'error'
        ];
    }
}
?>
