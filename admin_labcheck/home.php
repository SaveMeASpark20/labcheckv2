<?php
    session_start();
    if (!isset($_SESSION["admin"])) {
    header("Location: ../index.php");
    exit();
    }

$page = "Dashboard";

 $schoolYear = $_SESSION['school_year'] ;
 $semester = $_SESSION['semester'];

require_once '../connection/database.php';

try {

    function getTotalCount($conn, $table, $requestType, $schoolYear, $semester) {
        $sql = "SELECT COUNT(*)
                FROM $table
                WHERE school_year = ? 
                AND semester = ?
                AND request_type = ?";
        
        if($stmt = $conn->prepare($sql)){
            $stmt->bind_param('sss', $schoolYear, $semester, $requestType);
            if($stmt->execute()) {
                $stmt->bind_result($count);
                $stmt->fetch();
                $stmt->close();
                return $count;
            } else {
                return "Error executing query"; 
            }
        } else {
            return "Error preparing statement";
        }
    }
    

    
    $comlabUsageTotalCount = getTotalCount($conn, 'request', 'comlab usage', $schoolYear,  $semester);
    $requestEquipmentTotalCount = getTotalCount($conn, 'request', 'equipment', $schoolYear,  $semester);
    $terminalRepairTotalCount = getTotalCount($conn, 'request', 'repair', $schoolYear,  $semester);

} catch (Exception $e) {
    error_log($e->getMessage());

    echo "Oops! Something went wrong.";
}

try {

    function getUserCount($conn, $table, $schoolYear,  $semester) {
        $sql = "SELECT COUNT(*)
            FROM $table 
            WHERE school_year = ?
            AND semester = ?";

        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param('ss', $schoolYear, $semester);
            if ($stmt->execute()) {
                $stmt->bind_result($count);
                $stmt->fetch();
                $stmt->close();
                return $count;
            } else {
                return "Error executing query"; 
            }
        } else {
            return "Error preparing statement";
        }
    }

    $userCount = getUserCount($conn, 'user_registration', $schoolYear, $semester);

} catch (Exception $e) {
    error_log($e->getMessage());

    echo "Oops! Something went wrong.";
}

try {
    require_once "../connection/database.php";
    $sql = "SELECT name, subject, description, created_at
            FROM announcement
            ORDER BY created_at DESC";


    // $sql='SELECT a.name, a.subject, a.description, a.created_at
    //     FROM announcement a
    //     JOIN academic_year ay
    //     ON a.school_year = ay.school_year AND a.semester = ay.semester
    //     WHERE ay.status = 1
    //     ORDER BY a.created_at DESC';
    
    $stmt = $conn->prepare($sql);
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
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
	<link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="../css/admin-style.css">
	<link rel="stylesheet" href="../request-notification/notification.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.js" integrity="sha512-TW5s0IT/IppJtu76UbysrBH9Hy/5X41OTAbQuffZFU6lQ1rdcLHzpU5BzVvr/YFykoiMYZVWlr/PX1mDcfM9Qg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
	<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script defer src="main.js"></script>
	<script defer src="../request-notification/request-notification.js"></script>
    
	<title>Admin</title>
</head>
<body>
	<!-- SIDEBAR -->
	<section id="sidebar">
		<a href="#" class="brand"><img src="../images/labcheck_logo.png" class="logo-sidebar"> LabCheck <img src="../images/udm_logo.png" class="logo-sidebar-udm"> </a>
		<ul class="side-menu">
			<li><a href="home.php"><i class='fa fa-home icon' ></i> Dashboard</a></li>
			<li><a href="user_register.php"><i class='fa fa-user-circle icon' ></i> User Registration</a></li>
			<li><a href="complab_schedule.php"><i class='fa fa-calendar icon' ></i> ComLab Schedule</a></li>
			<li>
            <a><i class='fa fa-file icon' ></i> Request <span id="requestIndication" class="notification-indicator"></span><i class='fa fa-angle-right icon-right' ></i></a>
				<ul class="side-dropdown">
					<li><a id="comlabUsageLink" href="comlab_usage.php">ComLab Usage<span id="comlabUsageIndicator" class="notification-indicator"></span></a></li>
					<li><a id="requestEquipmentLink" href="request_equipment.php">Equipment<span id="equipmentIndicator" class="notification-indicator"></span></a></li>
					<li><a id="terminalRepairLink" href="terminal_repair.php">Repair<span id="repairIndicator" class="notification-indicator"></span></a></li>
				</ul>
			</li>
            <li>
				<a ><i class='fa fa-list-alt icon' ></i> Report <i class='fa fa-angle-right icon-right' ></i></a>
				<ul class="side-dropdown">
					<li><a href="comlab_usage_report.php">ComLab Usage</a></li>
					<li><a href="request_equipment_report.php">Equipment</a></li>
					<li><a href="terminal_repair_report.php">Repair</a></li>
				</ul>
			</li>
            <li><a href="settings.php"><i class='fa fa-cog icon' ></i> Settings</a></li>
            <li><a href="system_logs.php"><i class='fa fa-cog icon' ></i> System Logs</a></li>
            <li><a href="../includes/logout.php"><i class='fa fa-sign-out icon' ></i> Logout</a></li>
		</ul>
	</section>
    <?php include '../partial/header.php'; ?>
    <main>
        <div class="cardBox">
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

                    <div class="card" >
                        <div class="card-description">
                            <h1><?=$comlabUsageTotalCount?></h1>
                            <span>Total Request Comlab Usage</span>
                        </div>
                        <div>
                            <span class="fa fa-desktop"></span>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-description">
                            <h1><?=$requestEquipmentTotalCount?></h1>
                            <span>Total Request Equipment</span>
                        </div>
                        <div>
                            <span class="fa fa-exclamation-circle"></span>
                            
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-description">
                            <h1><?=$terminalRepairTotalCount?></h1>
                            <span>Total Request Repair</span>
                        </div>
                        <div>
                            <span class="fa fa-cogs"></span>
                        </div>
                    </div>

                    <a class="card link" href="user_register.php">
                        <div class="card-description">
                            <h1><?=$userCount?></h1>
                            <span>Total Users</span>
                        </div>
                        <div>
                            <span class="fa fa-users"></span>
                        </div>
                    </a>
                    </div>
                </div>
                <section class="analytics-anouncement">
                    <div class="analytics">
                        <canvas id="myChart" class="myChart" height="350"></canvas>
                    </div>
                    <!-- analytics.js -->
                    <script src="analytics.js"></script>
    
                    <div class="announcement-box">  
                        <div class="announcement-create">
                            <h2>Announcements</h2>
                            <button id="createAnnouncement">Create
                                <span class="fa fa-arrow-right">
                                </span>
                            </button>
                        </div>
                        <div class="input-announcement" id="showInputAnnouncement" >
                            <form action="../includes/addannouncement.php" method="POST">
                                <div>
                                    <input type="text" name="subject" placeholder="Subject" required />
                                </div>
                                <div>
                                    <textarea type="text" name="description" placeholder="Description" required ></textarea>
                                </div>
                                <div>
                                    <button type="submit" name="submit-announcement">Post Announcement</button>
                                </div>
                            </form>
                        </div>
        
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <div class="list-announcement">
                                <div class="announcement-header">
                                    <p><b><?php echo htmlspecialchars($row['name']);?></b></p>
                                    <?php
                                        $timestamp = strtotime($row['created_at']);
                                        $formattedTimestamp = date("F j, Y g:i A", $timestamp);
                                    ?>
                                    <p><?php echo htmlspecialchars($formattedTimestamp)?></p>
                                </div>
                                <p class="subject"><b><?php echo htmlspecialchars(ucwords($row['subject']));?></b></p>
                                <p class="description"><?php echo $row['description'];?></p>
                            </div>
                        <?php endwhile; ?>
                    </div>
                </section>                    
            <!-- ================ Announcements ================= -->
        </main>
    </body>
</html>

