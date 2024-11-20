<?php

$host = 'localhost';
$user = 'root';
$password = '';
$dbname = 'greentea';

// create connnection
$conn = new mysqli($host, $user, $password, $dbname);

// check connection
if ($conn->connect_error) {
    die("Connection Failed: " . $conn->connect_error);
}

?>