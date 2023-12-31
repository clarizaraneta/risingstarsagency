<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "capstone";

$conn = new mysqli($servername, $username, $password, $dbname);
 
if ($conn->connect_errno) {
    echo "Error: " . $conn->connect_error;
}