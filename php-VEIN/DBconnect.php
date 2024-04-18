<?php 

// Include the functions file
include "functions.php";

// Database connection parameters
$dsn = "mysql:host=localhost;dbname=veindb"; // Data Source Name
$user = "root"; // Database username
$pass = ""; // Database password

// PDO options for database connection
$options = array(
    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES UTF8" // Set character set to UTF-8 for Arabic support
);

try {
    // Create a new PDO instance for database connection
    $con = new PDO($dsn, $user, $pass, $options); 

    // Set PDO error mode to exception
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch(PDOException $e) {
    // Catch and display any PDO exceptions
    echo $e->getMessage();
}
