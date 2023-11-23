<?php
    session_start();
    if(!isset($_SESSION["userid"])){
        header("Location: index.php");
        exit();
    }

    $userid = $_SESSION['userid'];
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
        <img src="images/labcheck_logo.png" alt="labcheck_logo" class="logo">
        <div class="logo-container">
            <span class="logo-title">LabCheck</span>
            <span class="logo-description"> A Computer Laboratory Monitoring System</span>
        </div>
        <img src="images/udm_logo.png" alt="udm_logo" class="logo">
    </nav>
    <main>      
        <form class="form" action="includes/change_password.php" method="POST">
            <p class="form-title">Change your password</p>
            <div class="input-container">
            <input type="hidden" name="userid" value="<?php echo $userid; ?>">
                <p>User ID: <?php echo $userid; ?></p>
                <span>
                </span>
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