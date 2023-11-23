<?php
    session_start();
    if (!isset($_SESSION["admin"])) {
    header("Location: ../index.php");
    exit();
    }

$id = $_SESSION["adminid"];
$page = "System Logs";
include '../partial/admin_sidebar.php';
include '../partial/header.php';

 $schoolYear = $_SESSION['school_year'] ;
 $semester = $_SESSION['semester'];
require_once "../connection/database.php";

try {


    $sql = 'SELECT admin_id, event_type, event_description, created_at
    FROM system_logs';

    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result();

} catch (Exception $e) {
    die('Database error: ' . $e->getMessage());
}

require "NotificationManager.php";
$NotificationManager = new NotificationManager();
$notifications = $NotificationManager->getNotifications();
?>
<main class="user-reg-box">
    <?php foreach ($notifications as $notification) : ?>
        <?php if ($notification['type'] === 'success' && !empty($notification['message'])): ?>
            <div class="notification success">
                <p><?php echo htmlspecialchars($notification['message']); ?></p>
            </div>
            <?php endif; ?>

            <?php if ($notification['type'] === 'error' && !empty($notification['message'])): ?>
            <div class="notification error">
                <?php echo htmlspecialchars($notification['message']); ?>
            </div>
        <?php endif; ?>
    <?php endforeach; ?>
        <div class="table-container">
            <table>
                <thead>
                    <tr class="table-row-header">
                        <td>Admin Id</td>
                        <td>Event Type</td>
                        <td>Event Description</td>
                        <td>Created At</td>
                    </tr>
                </thead>
                <tbody id="reportTable" class="table-body">
                    <!-- Table rows here -->    
                    <?php while ($row = $result->fetch_assoc()): ?>
                            <td data-cell="Admin Id"><?php echo htmlspecialchars($row['admin_id']); ?></td>
                            <td data-cell="Event Type"><?php echo htmlspecialchars($row['event_type']); ?></td>
                            <td data-cell="Event Description"><?php echo htmlspecialchars($row['event_description']); ?></td>
                            <td data-cell="Created At"><?php echo htmlspecialchars($row['created_at']); ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </main>   
</body>
</html>