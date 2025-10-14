<?php

include_once('include/db.php');

if (isset($_POST['email']) && isset($_POST['password'])) {

    $email = mysqli_real_escape_string($conn, trim($_POST['email']));
    $password = $_POST['password'];

    $query = "SELECT user_id, password, status FROM users WHERE email = '$email' LIMIT 1";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);

        if ($row['status'] == 1 && password_verify($password, $row['password'])) {
            $_SESSION['logined_user'] = $row['user_id'];
            echo json_encode([
                "status" => "success",
                "message" => "Login successful",
                "redirect" => "index.php"
            ]);
            exit;
        } else {
            echo json_encode([
                "status" => "error",
                "message" => "Invalid password or inactive account."
            ]);
            exit;
        }
    } else {
        echo json_encode([
            "status" => "error",
            "message" => "Email not found."
        ]);
        exit;
    }

    mysqli_close($conn);
} else {
    echo json_encode([
        "status" => "error",
        "message" => "Please provide email and password."
    ]);
    exit;
}
