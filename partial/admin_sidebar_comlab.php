<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
	<link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="../css/admin-comlab-sched.css">
	<link rel="stylesheet" href="../request-notification/notification.css">
	<script defer src="main.js"></script>
	<script defer src="../request-notification/request-notification.js"></script>
	<title>Admin</title>
</head>
<body>
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
				<a><i class='fa fa-list-alt icon' ></i> Report <i class='fa fa-angle-right icon-right' ></i></a>
				<ul class="side-dropdown">
					<li><a href="comlab_usage_report.php">ComLab Usage</a></li>
					<li><a href="request_equipment_report.php">Equipment</a></li>
					<li><a href="terminal_repair_report.php">Repair</a></li>
				</ul>
			</li>
            <li><a href="settings.php"><i class='fa fa-cog icon' ></i> Settings</a></li>
			<li><a href="system_logs.php"><i class='fa fa-tags icon' ></i> System Logs</a></li>
            <li><a href="../includes/logout.php"><i class='fa fa-sign-out icon' ></i> Logout</a></li>
		</ul>		
	</section>
	</body>
