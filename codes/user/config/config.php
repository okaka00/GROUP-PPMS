<?php
/**
 * using mysqli_connect for database connection
 */
$databaseHost = 'localhost';
$databaseUsername = 'root';
$databasePassword = '';
$databaseName = 'minicafe';
$url = "http://localhost/campsite"; 
define('BASE_URL', 'http://localhost/campsite/');
define('BASE_PATH', __DIR__);
define('ADMIN_BASE_URL', 'http://localhost/campsite/admin');


$conn = mysqli_connect($databaseHost, $databaseUsername, $databasePassword, $databaseName); 

// Check connection
if (mysqli_connect_errno())
{
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
    exit();
} 

//echo "DB Connection Successful." . "<br>";
?>

