<?php
// Include the database connection file
include "../DBconnect.php";

// Retrieve and filter user SSN and password from the request
$ssn = filterequest('ssn');
$user_pass = filterequest('user_pass');

// Prepare and execute SQL statements to fetch user information, notifications, and requests
$stmt1 = $con->prepare("SELECT * FROM `the_user` WHERE `ssn` = ?");
$stmt1->execute(array($ssn));
$user_info = $stmt1->fetchAll(PDO::FETCH_ASSOC);

$stmt2 = $con->prepare("SELECT * FROM `notification` WHERE `receiver_id` = ?");
$stmt2->execute(array($ssn));
$user_notf = $stmt2->fetchAll(PDO::FETCH_ASSOC);

$stmt3 = $con->prepare("SELECT * FROM `requests` WHERE `receiver_id` = ?");
$stmt3->execute(array($ssn));
$user_req = $stmt3->fetchAll(PDO::FETCH_ASSOC);

// Prepare and execute SQL statement to fetch hashed password from the database
$hashed_pass_stmt = $con->prepare("SELECT pass FROM `the_user` WHERE `ssn` = ?");

// If the SQL statement is prepared successfully
if ($hashed_pass_stmt) {
    $hashed_pass_stmt->execute([$ssn]);
    $pass = $hashed_pass_stmt->fetch(PDO::FETCH_ASSOC);

    // If the password is found
    if ($pass) {
        $hashed_password_from_database = $pass['pass'];

        // Verify the provided password against the hashed password
        if (password_verify($user_pass, $hashed_password_from_database)) {
            echo json_encode(array("status" => "success", "users_informations" => $user_info, "users_notifications" => $user_notf, "users_requests" => $user_req));
        } else {
            echo json_encode(array("status" => "error", "msg" => "Email or password is not correct!"));
        }
    } else {
        echo json_encode(array("status" => "error", "msg" => "Email or password is not correct!"));
    }
} else {
    echo json_encode(array("status" => "error", "msg" => "Error in preparing SQL statement"));
}
