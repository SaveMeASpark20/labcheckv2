<?php
    session_start();
    if(!isset($_SESSION["userid"])){
        header("Location: index.php");
        exit();
    }

    $userid = $_SESSION['userid'];

    require "notification/NotificationManager.php";
    $NotificationManager = new NotificationManager();
    $notifications = $NotificationManager->getNotifications();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LabCheck - Change Password</title>
    <link rel="stylesheet" href="css/index-style.css">
</head>
<body>

    <nav>
        <div>
            <img src="images/labcheck_logo.png" alt="labcheck_logo" class="labcheck_logo">
        </div>
        <div class="logo-container">
            <span class="logo-title">LabCheck</span>
            <span class="logo-description"> A Computer Laboratory Monitoring System</span>
        </div>
        <div>
            <img src="images/udm_logo.png" alt="udm_logo" class="logo">
        </div>
    </nav>
    
    <main>

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

        <form class="form" action="includes/change_password.php" method="POST">
            <p class="form-title">Change your password</p>
            <div class="input-container">
            <input type="hidden" name="userid" value="<?php echo $userid; ?>">
                <p>User ID: <?php echo $userid; ?></p>
                <span class="password-has">Password: 8 characters or more, including at least one capital letter and special characters.</span>
            </div>
            <div class="input-container">
                <input type="password" name="password" placeholder="Enter password" required>
            </div>
            <div class="input-container">
                <input type="password" name="comfirm-password" placeholder="Re-Enter password" required>
            </div>
                <button type="submit" name="changepassword" class="submit">
                Change Password
                </button>
        </form>
    </main>
</body>
</html>