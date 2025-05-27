<?php
$host = 'localhost';     
$dbname = 'ccvideo'; 
$username = 'root'; 
$password = '12345'; 

// Create connection
$conn = new mysqli($host, $username, $password, $dbname,3307);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully";
?>