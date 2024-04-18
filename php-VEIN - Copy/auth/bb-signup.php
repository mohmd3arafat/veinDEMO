<?php
// Include the database connection file
include "../DBconnect.php";

// Retrieve and filter blood bank details from the request
$bb_location = filterequest('bb_location');
$bb_city = $_POST['bb_city']; // Assuming this comes from a POST request
$bb_phone = filterequest('bb_phonenumber');
$bb_email = filterequest('bb_email');
$bb_pass = password_hash(filterequest('bb_pass'), PASSWORD_DEFAULT);
$bb_name = filterequest('bb_name');

// Check if the email already exists in the database
$valid = $con->prepare('SELECT * FROM `blood_bank` WHERE `email` = ?');
$valid->execute(array($bb_email));

// If email already exists, return an error message
if ($valid->rowCount() > 0) {
    echo json_encode(array(
        "status"  => "Error",
        "message" => "This email already exists"
    ));
    exit();
} else {
    // If email doesn't exist, insert the new blood bank details into the database
    $stmt = $con->prepare("INSERT INTO `blood_bank`(`bb_name`, `location`, `city`, `phone_number`, `email`, `pass`) 
                           VALUES (?,?,?,?,?,?)");
    $stmt->execute(array($bb_name, $bb_location, $bb_city, $bb_phone, $bb_email, $bb_pass));
    
    // Check the number of affected rows
    $count = $stmt->rowCount();

    // Return success or failure based on the number of affected rows
    if ($count > 0) {
        echo json_encode(array("status" => "success"));
    } else {
        echo json_encode(array("status" => "fail"));
    }
}
