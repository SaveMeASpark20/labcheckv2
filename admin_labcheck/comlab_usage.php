<?php
    session_start();
    if (!isset($_SESSION["admin"])) {
        header("Location: ../index.php");
        exit();
    }

    $page = "Comlab Usage";
    include '../partial/admin_sidebar.php';
    include '../partial/header.php';

    $requestType = "comlab usage";
    $status = "pending"; //pending

    try {
        require_once "../connection/database.php";

        $sql='SELECT r.request_id, r.ticket_no, r.user_id, r.name, r.description, r.time, r.time_end, r.date, r.room_id, r.feedback, r.school_year, r.semester
            FROM request r
            JOIN academic_year ay
            ON r.school_year = ay.school_year AND r.semester = ay.semester
            WHERE ay.status = 1
            AND r.request_type = ?
            AND r.status = ?
            ORDER BY  r.school_year, r.semester, r.request_id DESC';

        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ss', $requestType, $status);
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
<body>
    <main class="comlab-usage">    
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
                <table class="table-header">
                    <thead>
                        <tr>
                            <th>User ID</th>
                            <th>Name</th>
                            <th>Ticket No.</th>
                            <th>Room No.</th>
                            <th>Description</th>
                            <th>Time Needed</th>
                            <th>Time End</th>
                            <th>Date Needed</th>
                            <th>Action</th>

                        </tr>
                    </thead>
                    <tbody id="reportTable" class="table-body">
                        <!-- Table rows here -->
                        <?php 
                            $currentSchoolYear = '';
                            $currentSemester = '';
                            while ($row = $result->fetch_assoc()): ?>
                            <?php 
                                $time = strtotime($row['time']);
                                $formattedTime = date("g:i A", $time);
                                $time_end = strtotime($row['time_end']);
                                $formattedEndTime = $time_end !== false ? date("g:i A", $time_end) : ' ';
                                $date = strtotime($row['date']);
                                $formattedDate = date("F j, Y ", $date); 
                                $schoolYear = $row['school_year'];
                                $semester = $row['semester'];
                            ?>
                            <?php if ($currentSchoolYear != $schoolYear || $currentSemester != $semester): ?>
                                <tr>
                                    <td data-cell="School Year and Semester" colspan="9" class="group-header">
                                         <?php echo $schoolYear. ' ' .$semester; ?>
                                    </td>
                                </tr>
                            <?php
                            // Update the current group
                            $currentSchoolYear = $schoolYear;
                            $currentSemester = $semester;
                            endif; ?>
                                
                                <td data-cell="User Id"><?php echo htmlspecialchars($row['user_id']); ?></td>
                                <td data-cell="Name"><?php echo htmlspecialchars(ucwords($row['name'])); ?></td>
                                <td data-cell="Ticket No"><?php echo htmlspecialchars($row['ticket_no']); ?></td>
                                <td data-cell="Room"><?php echo htmlspecialchars($row['room_id']); ?></td>
                                <td data-cell="Description"><?php echo htmlspecialchars(ucwords($row['description'])); ?></td>
                                <td data-cell="Time Needed"><?php echo $formattedTime; ?></td>
                                <td data-cell="Time End"><?php echo $formattedEndTime; ?></td>
                                <td data-cell="Date Needed"><?php echo $formattedDate; ?></td>
                                <td data-cell="Action">
                                    <div class="action-flex">
                                    <form action="../includes/process_comlab_usage.php" method="post" class="approval-form">
                                        <input type="hidden" name="request_id" value="<?php echo $row['request_id']; ?>">
                                        <button type="submit" onclick="return confirmApproval()" name="approve">Approve</button>
                                    </form>

                                    <form action="../includes/process_comlab_usage.php" method="post" class="rejection-form">
                                        <input type="hidden" name="request_id" value="<?php echo $row['request_id']; ?>">
                                        <button type="button" onclick="showRejectionReason(this)">Reject</button>
                                    </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
    <div id="rejectionModal" class="modal">
        <div class="modal-content">
            <span class="close" id="closeModal">&times;</span>
            <h2>Rejection Reason</h2>
            <form action="../includes/process_comlab_usage.php" method="POST" class="modal-rejection-form">
                <input type="hidden" name="request_id" value="">
                <textarea id="rejection_reason" name="rejection_reason" placeholder="Enter rejection reason" required></textarea>
                <input type="submit" name="reject"/>
            </form>
        </div>
    </div>
</body>
</html>