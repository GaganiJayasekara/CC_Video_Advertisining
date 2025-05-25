<?php
$host = 'localhost';     
$dbname = 'ycd'; 
$username = 'root'; 
$password = 'gagani@1234'; 

// Create connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully";
?>