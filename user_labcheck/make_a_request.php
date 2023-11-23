<?php
    
    session_start();
    if (!isset($_SESSION['userid'])) {
        header("Location: ../index.php");
        exit();
    }
    
    require "NotificationManager.php";
    $NotificationManager = new NotificationManager();
    $notifications = $NotificationManager->getNotifications();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User - Labcheck</title>
    <link rel="stylesheet" href="../css/user-style.css" >
    <link rel="stylesheet" href="../css/make-a-request.css">

    <script src="main.js" defer></script>
</head>
<body>
    <?php require_once "../partial/user_navbar.php" ?>

    <main style="background-color:transparent;">
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
        <div class="make-a-request">
            <form action="includes/process_request.php" method="POST">
                <div class="request-row">
                    <h3>Make a Request: </h3>
                    <select name="request_type" placeholder="Make a request" required onchange="toggleTimeEnd()" id="option-request">
                        <option value="comlab usage">Computer Usage</option>
                        <option value="repair">Repair</option>
                        <option value="equipment">Equipment</option>
                    </select>
                </div>
                <textarea name="description" placeholder="Description of your request" required></textarea> 
                <div class="time-date">
                    <div class="time">
                        <label>Time : </label>
                        <input type="time" name="time-start" ></input>
                        <input type="time" name="time-end" id="timeEndInput"></input>
                    </div>
                    <input type="date" name="date" required></input>
                </div>
                <div class="room-submit">
                    <select name="room" required>
                        <option value=205>Room 205</option>
                        <option value=206>Room 206</option>
                    </select>
                    <button type="submit" name="submit_request">Send</button>
                </div>
            </form>
        </div>
    </main>
</body>
</html>

