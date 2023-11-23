<?php
    session_start();
    if (!isset($_SESSION["admin"])) {
        header("Location: ../index.php");
        exit();
    }

    $page = "Settings";

    include '../partial/admin_sidebar.php';
    include '../partial/header.php';

    try {
        require_once "../connection/database.php";

        $stmt = $conn->prepare('SELECT * FROM academic_year ');
        $stmt->execute();
        $result = $stmt->get_result();
    } catch (Exception $e) {
        // Handle database errors here.
        die('Database error: ' . $e->getMessage());
    }
    require "NotificationManager.php";
    $NotificationManager = new NotificationManager();
    $notifications = $NotificationManager->getNotifications();
?>
<main class="settings">
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
    <div class="add-update-acadyear">
        <button id="showSchoolYearForm"> Add Academic Year </button>
        <?php
            
            include '../includes/addacadsyear_form.php';
        ?>

        <button id="showUpdateSchoolYearForm"> Update Academic Year of User </button>
        <?php
            include '../includes/update_acadyearuser_form.php';
        ?>

    </div>
    <div class="table-container">

        <table class="table-header">
            <thead>
                <tr>
                    <th>School Year</th>
                    <th>Semester</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody id="reportTable"class="table-body">

                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td data-cell="School Year"><?php echo htmlspecialchars($row['school_year']); ?></td>
                        <td data-cell="Semester"><?php echo htmlspecialchars($row['semester']); ?></td>
                        <td data-cell="Status" id="status-<?php echo $row['school_year']; ?>" >
                            <?php echo ($row['status'] == 0) ? 'Disable' : 'Enable'; ?>
                        </td>
                        <td data-cell="Action">
                        <button class="myButton" value="<?php echo $row['school_year']; ?>"
                            data-status="<?php echo $row['status']; ?>"
                            data-semester="<?php echo $row['semester']; ?>"
                            style="background-color: <?php echo $row['status'] == 0 ? '#006d1b' : '#e23100'; ?>">
                            <?php echo $row['status'] == 0 ? 'Enable ?' : 'Disable ?'; ?>
                        </button>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

</div>
</main>

</section>
</body>
</html>