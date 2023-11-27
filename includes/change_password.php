<?php
session_start();
if(isset($_POST["changepassword"])){
    $userid = $_POST['userid'];
    $password = $_POST['password'];
    $comfirmpassword = $_POST['comfirm-password'];

    function handleNotification($type, $message) {
        $_SESSION['notification'] = ['type' => $type, 'message' => $message];
    }

    if (empty($comfirmpassword) || empty($password)) {
        handleNotification('error', 'All fields are required');              
        header("Location: ../changepass.php");
        exit();
    }

    if($password !== $comfirmpassword) {
        $message = "Password does not match confirm-password";
        handleNotification('error', 'Password does not match to comfirm password');
        header("Location: ../changepass.php");
        exit();
    }

    function checkPassword($password) {
        return strlen($password) >= 8 && preg_match('/[@_!#$%^&*()<>?\/\|}{~:]/', $password) && preg_match('/[A-Z]/', $password);
    }

    if(!checkPassword($password)){
        handleNotification('error', 'Password needs to be 8 characters above,  has atleast 1 capital letter, and has special character');
        header("Location: ../changepass.php");
        exit();
    }

    require_once '../connection/database.php';


    if ($stmt = $conn->prepare('UPDATE user_registration SET password = ? WHERE id = ?')) {

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        
        $stmt->bind_param('ss', $hashedPassword, $userid);
        
        if ($stmt->execute()) {
            // Update successful
            handleNotification('success', 'Change Password Successfully');
            header("Location: ../index.php");
            exit();
        } else {
            // Error occurred during the update
            handleNotification('error', 'Something wrong happened');
            header("Location: ../changepass.php");
            exit();
        }

        $stmt->close();
    } else {
        handleNotification('error', $conn->error);
        header("Location: ../changepass.php");
    }

    $conn->close();
}
?>

