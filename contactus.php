<?php
// Database connection parameters
$servername = "localhost"; // Change this if your database is hosted on a different server
$username = "root"; // Change this to your database username
$password = ""; // Change this to your database password
$database = "greentea"; // Change this to your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


// If the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $message = $_POST['message'];
    
    // Insert data into database
    $sql = "INSERT INTO contacts(name, email, phone, message) VALUES ('$name', '$email', '$phone', '$message')";
    
    if ($conn->query($sql) === TRUE) {
        header('location: index.php?contact');
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Close connection
$conn->close();
?>


