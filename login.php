<?php
session_start();
include('db.php');

if(isset($_POST['sign_in'])){
    $name = $_POST['name'];
    $email = $_POST['email'];
    $age = $_POST['age'];
    $phone = $_POST['phone'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password

    if($age < 10) {
        echo "<script>alert('Age under 10 is not allowed');</script>";
    }
    else{
        $sql = "INSERT INTO user(name, email, age, phone, password) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssiis", $name, $email, $age, $phone, $password);
        $stmt->execute();
        echo "<script>alert('Registered Successfully'); window.location.href = 'index.php';</script>";
        exit();
    }
}

if(isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $sql = "SELECT * FROM user WHERE name=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            // Password is correct, set session variables and redirect to home page
            $_SESSION['username'] = $username;
            header("Location: index.php"); // Redirect to home page
            exit();
        } else {
            echo "<script>alert('Invalid username or password')</script>";
        }
    } else {
        echo "<script>alert('User not found')</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="signup.css">
    <script src="login.js"></script>
</head>
<body>
<div class="container">
    <!--Data or Content-->
    <div class="box-1">
        <div class="content-holder">
            <h2>Hello!</h2>
            <button class="button-1" onclick="signup()">Sign up</button>
            <button class="button-2" onclick="login()">Login</button>
        </div>
    </div>

    <!--Forms-->
    <div class="box-2">
        <!-- Login Form -->
        <form method="post" id="loginForm">
            <div class="login-form-container">
                <h1>Login Form</h1>
                <input type="text" placeholder="Username" class="input-field" name="username">
                <br><br>
                <input type="password" placeholder="Password" class="input-field" name="password">
                <br><br>
                <button class="login-button" type="submit" name="login">Login</button>
            </div>
        </form>

        <!-- Signup Form -->
        <form method="post" id="signupForm"> <!-- Hidden by default -->
            <div class="signup-form-container">
                <h1>Sign Up Form</h1>
                <input type="text" name="name" placeholder="Name" class="input-field">
                <br><br>
                <input type="email" name="email" placeholder="Email" class="input-field">
                <br><br>
                <input type="number" name="phone" placeholder="Phone" class="input-field">
                <br><br>
                <input type="number" name="age" placeholder="Age" class="input-field">
                <br><br>
                <input type="password" name="password" placeholder="Password" class="input-field">
                <br><br>
                <button class="signup-button" type="submit" name="sign_in">Sign Up</button>
            </div>
        </form>
    </div>
</div>
</body>
</html>
