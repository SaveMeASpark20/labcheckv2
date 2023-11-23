<?php
session_start();
if (!isset($_SESSION["admin"])) {
    header("Location: ../index.php");
    exit();
}

$page = "Report";
include '../partial/admin_sidebar.php';
include '../partial/header.php';

require_once "../connection/database.php";

// Fetch reports from the database
try {
    $stmt = $conn->prepare('SELECT room_no, pc_no, description, status FROM report');
    $stmt->execute();
    $result = $stmt->get_result();
} catch (Exception $e) {
    // Handle database errors here.
    die('Database error: ' . $e->getMessage());
}
?>
<body>
<div class="main-content">
    <main>
    <div class="table-container">
        <div class="table-header">
            <table>
                <thead>
                    <tr>
                        <th>Room No.</th>
                        <th>PC No.</th>
                        <th>Description</th>
                        <th>Status</th>
                    </tr>
                </thead>
            </table>
        </div>

        <div class="table-body">
            <table id="reportTable">
                <!-- Table rows here -->
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td data-cell="room_no"><?php echo htmlspecialchars($row['room_no']); ?></td>
                        <td data-cell="pc_no"><?php echo htmlspecialchars($row['pc_no']); ?></td>
                        <td data-cell="description"><?php echo htmlspecialchars($row['description']); ?></td>
                        <td data-cell="status">
                        <?php
                            // Check the value of the "status" column and display accordingly
                            if ($row['status'] == 0) {
                                echo "On Process";
                            } elseif ($row['status'] == 1) {
                                echo "Done";
                            } else {
                                // Handle other cases as needed
                                echo "Unknown Status";
                            }
                            ?>
                    </tr>
                <?php endwhile; ?>
            </table>
        </div>
    </div>
    </main>
</div>
</body>
</html>
