<?php
session_start();
if(isset($_POST["changepassword"])){
    $userid = $_POST['userid'];
    $password = $_POST['password'];
    $comfirmpassword = $_POST['comfirm-password'];

    // Validation: Check for empty fields and password match
    if (empty($comfirmpassword) || empty($password)) {              
        $message = "Password and confirm-password are required";  
        header("Location: ../changepass.php?message=" . urlencode($message));
        exit();
    }

    if($password !== $comfirmpassword) {
        $message = "Password does not match confirm-password";
        header("Location: ../changepass.php?message=" . urlencode($message));
        exit();
    }

    require_once '../connection/database.php';

    // Use prepared statements to prevent SQL injection
    if ($stmt = $conn->prepare('UPDATE user_registration SET password = ? WHERE id = ?')) {
        // Hash the new password before storing it in the database
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        
        $stmt->bind_param('ss', $hashedPassword, $userid);
        
        if ($stmt->execute()) {
            // Update successful
            $message = "Password updated successfully.";
            header("Location: ../index.php?message=" . urlencode($message));
            exit();
        } else {
            // Error occurred during the update
            $message = "Error: " . $stmt->error;
            header("Location: ../changepass.php?message=" . urlencode($message));
            exit();
        }

        $stmt->close();
    } else {
        $message = "Error: " . $conn->error;
        header("Location: ../changepass.php?message=" . urlencode($message));
    }

    $conn->close();
}
?>

