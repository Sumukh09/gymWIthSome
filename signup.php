<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');

$servername = "localhost";
$username = "root";
$password = "root"; // Replace with your actual MySQL root password
$dbname = "gymApp";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullname = isset($_POST["fullname"]) ? $_POST["fullname"] : '';
    $email = isset($_POST["email"]) ? $_POST["email"] : '';
    $username = isset($_POST["username"]) ? $_POST["username"] : '';
    $password = isset($_POST["password"]) ? password_hash($_POST["password"], PASSWORD_DEFAULT) : '';

    // Validate that the username and password are not empty
    if (empty($username) || empty($password)) {
        echo json_encode(array("status" => "error", "message" => "Username and password cannot be empty"));
        return;
    }

    // Insert user data into the database
    $sql = "INSERT INTO users (fullname, email, username, password) VALUES ('$fullname', '$email', '$username', '$password')";

    if (mysqli_query($conn, $sql)) {
        echo json_encode(array("status" => "success", "message" => "User registered successfully"));
    } else {
        echo json_encode(array("status" => "error", "message" => "Error: " . mysqli_error($conn)));
    }
}

mysqli_close($conn);
?>
