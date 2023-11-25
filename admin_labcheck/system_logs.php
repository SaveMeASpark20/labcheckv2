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

require_once "../connection/database.php";

try {
    $sortOrder = isset($_GET['sortOrder']) ? $_GET['sortOrder'] : 'newest';
    $validSortOrders = ['newest', 'oldest'];

    if (!in_array($sortOrder, $validSortOrders)) {
        $sortOrder = 'newest'; // Default to 'newest' if the value is invalid
    }

    $sql = "SELECT s.admin_id, s.event_type, s.event_description, DATE_FORMAT(s.created_at, '%M %e, %Y %h:%i %p') AS formatted_created_at, s.school_year, s.semester
    FROM system_logs s
    JOIN academic_year ay ON s.school_year = ay.school_year AND s.semester = ay.semester
    WHERE ay.status = 1
    ORDER BY s.school_year DESC, s.semester DESC, s.created_at " . ($sortOrder == 'newest' ? 'DESC' : 'ASC');

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

    <form method="get" action="">
        <label for="sortOrder">Sort by:</label>
        <select name="sortOrder" id="sortOrder">
            <option value="newest" <?php echo ($sortOrder == 'newest') ? 'selected' : ''; ?>>Newest</option>
            <option value="oldest" <?php echo ($sortOrder == 'oldest') ? 'selected' : ''; ?>>Oldest</option>
        </select>
        <button type="submit">Apply</button>
    </form>

    <div class="table-container">
        <table>
            <thead>
                <tr class="table-row-header">
                    <td>Admin Id</td>
                    <td>Event Type</td>
                    <td>Event Description</td>
                    <td>Action Taken At</td>
                </tr>
            </thead>
            <tbody id="reportTable" class="table-body">
                <?php
                $currentSchoolYear = '';
                $currentSemester = '';
                while ($row = $result->fetch_assoc()) :
                    $schoolYear = $row['school_year'];
                    $semester = $row['semester'];

                    if ($currentSchoolYear != $schoolYear || $currentSemester != $semester) :
                        if ($currentSchoolYear != '') {
                            echo '</tbody>'; // Close the previous tbody
                        }
                        $currentSchoolYear = $schoolYear;
                        $currentSemester = $semester;
                ?>
                        <tbody class="group">
                            <tr>
                                <td colspan="4" class="group-header">
                                    <?php echo $schoolYear . ' ' . $semester; ?>
                                </td>
                            </tr>
                <?php
                    endif;
                ?>
                        <tr>
                            <td data-cell="Admin Id"><?php echo htmlspecialchars($row['admin_id']); ?></td>
                            <td data-cell="Event Type"><?php echo htmlspecialchars($row['event_type']); ?></td>
                            <td data-cell="Event Description"><?php echo htmlspecialchars($row['event_description']); ?></td>
                            <td data-cell="Action Taken At"><?php echo htmlspecialchars($row['formatted_created_at']); ?></td>
                        </tr>
                <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </main>
</body>

</html>
