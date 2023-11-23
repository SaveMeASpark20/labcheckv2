<?php
    session_start();
    // if (isset($_SESSION['usertype'])) {
    // header("Location: admin_labcheck/home.php");
    // exit();
    // }

    require "notification/NotificationManager.php";
    $NotificationManager = new NotificationManager();
    $notifications = $NotificationManager->getNotifications();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LabCheck</title>
    <link rel="stylesheet" href="css/index-style.css">
    <script defer src="index.js"></script>
</head>
<body>
    <nav>
        <div>
            <img src="images/labcheck_logo.png" alt="labcheck_logo" class="labcheck-logo">
        </div>
        <div class="logo-container">
            <span class="logo-title"> LabCheck</span>
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
        <form class="form" action="includes/login.php" method="POST">
            <p class="form-title">Sign in to your account</p>
            <div class="input-container">
            <input type="text" name="id" placeholder="Enter ID" required >
            <span>
            </span>
        </div>
        <div class="input-container">
            <input type="password" name="password" placeholder="Enter password" required>
            </div>
            <button type="submit" name="signin" class="submit">
            Sign in
            </button>
        </form>

    </main>
</body>
</html>