<?php

session_start();

$response = ['isAdmin' => false];

// Check if the user is logged in and is an admin
if (isset($_SESSION['usertype']) && $_SESSION['usertype'] === 'admin' && $_SESSION['admin'] === true) {
    $response['isAdmin'] = true;
}

header('Content-Type: application/json');
echo json_encode($response);
?>
