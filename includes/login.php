<?php
    session_start();
    if(isset($_POST["signin"])){
        
        $id = $_POST['id'];
        $password = $_POST['password'];

        if (empty($id) OR empty($password)) {  
            
            $message = "ID and Password are required";    
            header("Location: ../index.php?message=" . urlencode($message));
        }
        else{               
        require_once "../connection/database.php";
        
        if ($stmt = $conn->prepare('SELECT firstname, lastname, middlename, section, password, user_type, school_year, semester FROM user_registration WHERE id = ?')) {
            $stmt->bind_param('s', $id);
            $stmt->execute();
            // Store the result so we can check if the account exists in the database.
            $stmt->store_result();
            if ($stmt->num_rows > 0) {
                $stmt->bind_result($firstname, $lastname, $middlename, $section,  $dbpassword, $usertype, $schoolYear, $semester);
                $stmt->fetch();
                if (password_verify($password, $dbpassword)) {
                   
                    if (password_verify('!defaultPassword', $dbpassword)) {
                        session_regenerate_id();
                        $_SESSION['userid'] = $id;
                        header('Location: ../changepass.php');
                    }

                    else if($usertype === 'student'){
                        session_regenerate_id();
                        $_SESSION['student'] = TRUE; 
                        $_SESSION['name'] = $firstname . " " . $middlename . " " . $lastname;
                        $_SESSION['section'] = $section;
                        $_SESSION['userid'] = $id;
                        $_SESSION['usertype'] = $usertype;
                        $_SESSION['school_year'] = $schoolYear;
                        $_SESSION['semester'] = $semester;

                        header('Location: ../user_labcheck/home.php');
                    }

                    else if($usertype === 'admin'){
                        session_regenerate_id();
                        $_SESSION['admin'] = TRUE;
                        $_SESSION['name'] = $firstname . " " . $middlename . " " . $lastname;
                        $_SESSION['adminid'] = $id;
                        $_SESSION['usertype'] = $usertype;
                        $_SESSION['school_year'] = $schoolYear;
                        $_SESSION['semester'] = $semester;

                        header('Location: ../admin_labcheck/home.php');
                    }
                    
                    else if($usertype === 'faculty'){
                        session_regenerate_id();
                        $_SESSION['faculty'] = TRUE;
                        $_SESSION['name'] = $firstname . " " . $middlename . " " . $lastname;
                        $_SESSION['userid'] = $id;
                        $_SESSION['usertype'] = $usertype;
                        $_SESSION['school_year'] = $schoolYear;
                        $_SESSION['semester'] = $semester;
                        
                        header('Location: ../user_labcheck/home.php');

                    }
                } else {
                    // Incorrect password
                    $_SESSION['notification'] = [
                        'message' => 'Incorrect User Id or Password',
                        'type' => 'error'
                    ];
                    header("Location: ../index.php");
                }
            }else {
                $_SESSION['notification'] = [
                        'message' => 'Incorrect User Id or Password',
                        'type' => 'error'
                ];
                header("Location: ../index.php");
            }
            $stmt->close();
        }
    }
    }
?>