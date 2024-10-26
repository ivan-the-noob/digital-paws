<?php
$servername = "localhost"; 
$username = "ejivan2323";         
$password = "ejivan2323";             
$dbname = "paws";  

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
