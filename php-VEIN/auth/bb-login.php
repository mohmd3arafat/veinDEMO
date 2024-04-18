<?php
include "../DBconnect.php";

$bb_email = filterequest('bb_email');
$bb_pass = filterequest('bb_pass');

// Fetch blood bank ID based on email
$stmt = $con->prepare("SELECT id FROM `blood_bank` WHERE `email` = ?");
$stmt->execute([$bb_email]);
$bb_id = $stmt->fetch(PDO::FETCH_COLUMN);


// Fetch blood bank information
$stmt1 = $con->prepare("SELECT * FROM `blood_bank` WHERE `id` = ?");
$stmt1->execute([$bb_id]);
$bb_info = $stmt1->fetch(PDO::FETCH_ASSOC);

// Fetch notifications
$stmt2 = $con->prepare("SELECT * FROM `notification` WHERE `receiver_id` = ?");
$stmt2->execute([$bb_id]);
$bb_notf = $stmt2->fetchAll(PDO::FETCH_ASSOC);

// Fetch requests
$stmt3 = $con->prepare("SELECT * FROM `requests` WHERE `recever_id` = ?");
$stmt3->execute([$bb_id]);
$bb_req = $stmt3->fetchAll(PDO::FETCH_ASSOC);

// Verify password
$hashed_pass_stmt = $con->prepare("SELECT pass FROM `blood_bank` WHERE `email` = ?");
$hashed_pass_stmt->execute([$bb_email]);
$pass = $hashed_pass_stmt->fetch(PDO::FETCH_ASSOC);

if ($pass && password_verify($bb_pass, $pass['pass'])) {
    echo json_encode(array("status" => "success", "bloodbank_informations" => $bb_info, "bloodbank_notifications" => $bb_notf, "bloodbank_requests" => $bb_req));
} else {
    echo json_encode(array("status" => "error", "msg" => "Email or password is not correct!"));
}
