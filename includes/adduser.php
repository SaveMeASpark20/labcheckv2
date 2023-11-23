<?php
session_start();
if (!isset($_SESSION["admin"])) {
    header("Location: ../index.php");
    exit();
}

require_once "../connection/database.php";

function handleNotification($type, $message) {
    $_SESSION['notification'] = ['type' => $type, 'message' => $message];
    header("Location: ../admin_labcheck/user_register.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $firstname = $_POST["firstname"];
    $lastname = $_POST["lastname"];
    $middlename = $_POST["middlename"];
    $uid = $_POST["id"];
    $section = $_POST["section"];
    $usertype = $_POST["usertype"];

    if (empty($firstname) || empty($lastname) || empty($uid) || empty($usertype)) {
        handleNotification('error', 'All data is required except section and middlename.');
    }

    if ($section === '') {
        $section = NULL;
    }
    if ($middlename === '') {
        $middlename = NULL;
    }

    $defaultPassword = password_hash('!defaultPassword', PASSWORD_DEFAULT);

    try {
        
        // Insert user data into user_registration table
        $selectAcademicYearQuery = "SELECT school_year, semester FROM academic_year WHERE status = 1";

        if ($stmt = $conn->prepare($selectAcademicYearQuery)) {
            $stmt->execute();
            $result = $stmt->bind_result($schoolYear, $semester);

            if ($stmt->fetch()) {
                $stmt->close();

                // Insert user data into user_registration table
                $insertQuery = "INSERT INTO user_registration (firstname, lastname, middlename, id, section, password, user_type, school_year, semester) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
                $stmt = $conn->prepare($insertQuery);
                $stmt->bind_param("sssssssss", $firstname, $lastname, $middlename, $uid, $section, $defaultPassword, $usertype, $schoolYear, $semester);

                if ($stmt->execute()) {
                    $id = $_SESSION["adminid"];
                    $adminId = $id;
                    // Log successful user registration
                    $logEventType = "User Registration";
                    $logEventDescription = "User registration for $firstname $lastname (ID: $uid) created by $adminId";

                    // Debugging output
                    var_dump($logEventType);
                    var_dump($logEventDescription);
                    var_dump($adminId);

                    $sql = 'INSERT INTO system_logs (event_type, event_description, admin_id) VALUES (?, ?, ?)';
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param('sss', $logEventType, $logEventDescription, $adminId);
                    $stmt->execute();

                    handleNotification('success', 'User Successfully Added');
                } else {
                    handleNotification('error', 'User Failed to Add.');
                }
                $stmt->close();
            } else {
                handleNotification('error', 'There is something wrong happened.');
            }
        } else {
            $conn->close();
            handleNotification('error', 'There is something wrong happen in the prepared statement.');
        }
    } catch (Exception $e) {
        // Log database error
        $logEventType = "Error";
        $logEventDescription = 'Database error: ' . $e->getMessage();

        $sql = 'INSERT INTO system_logs (event_type, event_description, admin_id) VALUES (?, ?, ?)';
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ssi', $logEventType, $logEventDescription, $adminId);
        $stmt->execute();

        handleNotification('error', 'Database error: ' . $e->getMessage());
    }
}
?>
