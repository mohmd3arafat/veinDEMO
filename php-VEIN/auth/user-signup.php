<?php
// Include the database connection file
include "../DBconnect.php";

// Retrieve and filter user details from the request
$ssn = filterequest('ssn');
$username = filterequest('username');
$user_phone = filterequest('user_phonenumber');
$user_email = filterequest('user_email');
$user_pass = password_hash(filterequest('user_pass'), PASSWORD_DEFAULT); // Hash the user password
$blood_group = filterequest('blood_type');
$user_city = filterequest('user_city');
$bdate = date('Y-m-d', strtotime($_POST['bdate'])); // Convert bdate to Y-m-d format

// Check if the SSN already exists in the database
$valid = $con->prepare('SELECT * FROM `the_user` WHERE `ssn` = ?');
$valid->execute(array($ssn));

// If the SSN already exists, return an error message
if ($valid->rowCount() > 0) {
    echo json_encode(array(
        "status"  => "Error",
        "message" => "User SSN already exists"
    ));
    exit();
} else {
    // If the SSN doesn't exist, insert the new user details into the database
    $stmt = $con->prepare("INSERT INTO `the_user`(`ssn`, `name`, `phone_number`, `email`, `pass`, `blood_group`, `city`, `bdate`) 
                           VALUES (?,?,?,?,?,?,?,?)");
    $stmt->execute(array($ssn, $username, $user_phone, $user_email, $user_pass, $blood_group, $user_city, $bdate));
    
    // Check the number of affected rows
    $count = $stmt->rowCount();

    // Return success or failure based on the number of affected rows
    if ($count > 0) {
        echo json_encode(array("status" => "success"));
    } else {
        echo json_encode(array("status" => "fail"));
    }
}
