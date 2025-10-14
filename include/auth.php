<?php

include_once('db.php');

if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'auth_js') {
    $checkAuth = false;
    if (!isset($_SESSION['logined_user'])) $checkAuth = true;

    echo json_encode([
        "response" => $checkAuth
    ]);
    exit;
} else {
	if (!isset($_SESSION['logined_user'])) {
        header('Location: login.php');
        exit;
    }
    
    $current_user = $_SESSION['logined_user'];
    $sqlRole = "SELECT role, full_name FROM users WHERE user_id=$current_user";
    $resultRole = mysqli_query($conn, $sqlRole);
    $rowRole = mysqli_fetch_assoc($resultRole);
    $sCurrentRole = $rowRole['role'];
    $sFullName = $rowRole['full_name'];
}

?>