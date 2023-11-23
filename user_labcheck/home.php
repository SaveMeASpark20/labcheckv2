<?php   
    session_start();
    if (!isset($_SESSION['userid'])) {
        header("Location: ../index.php");
        exit();
    }
    
    $userid = $_SESSION['userid'];
    $schoolYear = $_SESSION['school_year'];
    $semester = $_SESSION['semester'];

    require_once "../connection/database.php";
    
    try {
        $sql='SELECT request_id, request_type, ticket_no, description, time, time_end, date, room_id, status, feedback FROM request WHERE user_id = ? AND school_year = ? AND semester = ? ORDER BY request_id DESC';
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('sss', $userid, $schoolYear, $semester);
        $stmt->execute();
        $resultRequest = $stmt->get_result();
    } catch (Exception $e) {
        // Handle database errors here.
        die('Database error: ' . $e->getMessage());
    }

    //this can be optimize i just dont see why i can't
    try{
        $sql='SELECT a.name, a.subject, a.description, a.created_at
        FROM announcement a
        JOIN academic_year ay
        ON a.school_year = ay.school_year AND a.semester = ay.semester
        WHERE ay.status = 1
        ORDER BY a.created_at DESC';
    
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $resultAnnouncement = $stmt->get_result();
    }catch (Exception $e) {
    // Handle database errors here.
    die('Database error: ' . $e->getMessage());
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User - Labcheck</title>
    <link rel="stylesheet" href="../css/user-style.css" >
    <link rel="stylesheet" href="../css/user-dashboard.css">

    <script src="main.js" defer></script>
    <?php require_once "../partial/user_navbar.php"; ?>
</head>
<body>
    <?php require_once "../partial/user_navbar.php" ?>
    <div class="header-info">
        <div class="name-usertype">
            <h4>Hello, <?=$_SESSION['name']?></h4>
            <small><?=$_SESSION['usertype']?></small>
        </div>
        <small><?=$schoolYear?> <?=$semester?></small>
    </div>
    <div class="home-page">
    
        <section class="request">
            <section class="header">
                <div class="requestheader-legend">
                    <div class="request-search">
                        <h3>Request: </h3>
                        <input type="text" id="searchInput" placeholder="Search..." />
                    </div>
                    <div class="legend">
                        <p>Approved/Resolved</p><span class="green"></span>
                        <p>Rejected</p><span class="red"></span>
                        <p>Pending</p><span class="gray"></span>
                    </div>
                </div>
            </section>
            <div class="ticket-row" id="ticketRowContainer">
                <?php while ($row = $resultRequest->fetch_assoc()): ?>
                <?php
                    $date = strtotime($row['date']);
                    $formattedDate = date("M d, y", $date);
                    $time = strtotime($row['time']);
                    $formattedTime = date("h:i A", $time);
                    $status = $row['status'];
                    $color='';
                    if($status === 'accept'){
                        $color = '#006d1b';
                    }
                    else if($status === 'reject'){
                        $color = '#e23100';
                    }
                    else if($status === 'pending'){
                        $color = '#8390A2';
                    }

                    $time_end = strtotime($row['time_end']);
                    $formattedEndTime = $time_end !== false ? date("g:i A", $time_end) : ' ';
                    
                ?>
                <div class="ticket" style="border-color:<?=$color?>;">
                    
                    <div class="ticket-header" style="background-color:<?=$color?>; ">
                        <p><?php echo htmlspecialchars($row['request_type']); ?></p>
                    </div>
                    <div class="ticket-details" style="border-color:<?=$color?>; ">
                        <div class="date">
                            <p>Date</p>
                            <p><?php echo $formattedDate; ?></p>
                        </div>
                        <div class="time">
                            <p>Time</p>
                            <div class="time-duration">
                                <p><?php echo $formattedTime; ?></p> -
                                <p><?php echo $formattedEndTime;?></p>
                            </div>
                        </div>
                        <div class="room">
                            <p>Room</p>
                            <p><?php echo htmlspecialchars($row['room_id']); ?></p>
                        </div>
                    </div>
                    <div class="ticket-concern" style="border-color:<?=$color?>; ">
                        <p><?php echo htmlspecialchars($row['description']); ?></p>
                    </div>
                    <div class="ticket-feedback">
                        <p>Feedback: <?php echo htmlspecialchars($row['feedback']); ?></p>
                    </div>
                    <div class="ticket-number">
                        <p>TICKET NUMBER</p>
                        <p class="ticket-combination"><?php echo htmlspecialchars($row['ticket_no']); ?></p>
                    </div>
                </div>
                <?php endwhile; ?>
            </div>
        </section>
        <section class="announcement">
            <h3 class="header-announcement">Announcement: </h3>
            <div class="announcement-row">
                <?php while ($rowAnnouncement = $resultAnnouncement->fetch_assoc()): ?>
                    <div class="list-announcement">  
                        <div class="announcement-header">
                            <p><b><?php echo htmlspecialchars($rowAnnouncement['name']);?></b></p>
                            <?php
                                $timestamp = strtotime($rowAnnouncement['created_at']);
                                $formattedTimestamp = date("F j, Y g:i A", $timestamp);
                            ?>
                            <p><?php echo htmlspecialchars($formattedTimestamp)?></p>
                        </div>
                        <p class="subject"><b><?php echo htmlspecialchars($rowAnnouncement['subject']);?></b></p>
                        <p class="description"><?php echo $rowAnnouncement['description'];?></p>
                    </div>
                <?php endwhile; ?>
            </div>
        </section>
    </div>
</body>
</html>