<?php

    include "DBconnect.php" ;

    $stmt = $con->prepare("SELECT * FROM blood_bank");
    $stmt->execute();

    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo "<pre>";
    print_r($users);
    echo "</pre>";
    $stmt = $con->prepare("SELECT * FROM the_user");
    $stmt->execute();

    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo "<pre>";
    print_r($users);
    echo "</pre>";