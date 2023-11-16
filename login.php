<?php
session_start();

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
    $username = isset($_POST["username"]) ? $_POST["username"] : '';
    $password = isset($_POST["password"]) ? $_POST["password"] : '';

    // Validate that the username and password are not empty
    if (empty($username) || empty($password)) {
        echo json_encode(array("status" => "error", "message" => "Username and password cannot be empty"));
        exit();
    }

    // Fetch hashed password from the database for the entered username
    $query = "SELECT user_id, password FROM users WHERE username = '$username'";
    $result = mysqli_query($conn, $query);

    if ($result) {
        $row = mysqli_fetch_assoc($result);
        $hashedPasswordFromDatabase = $row['password'];

        // Check if the entered password matches the hashed password from the database
        if (password_verify($password, $hashedPasswordFromDatabase)) {
            $_SESSION["user_id"] = $row["user_id"];
            echo json_encode(array("status" => "success", "message" => "Login successful"));
            
            exit(); // Ensure that the script stops executing after sending JSON response
        } else {
            echo json_encode(array("status" => "error", "message" => "Invalid username or password"));
            exit();
        }
    } else {
        echo json_encode(array("status" => "error", "message" => "Error: " . $query . "<br>" . mysqli_error($conn)));
        exit();
    }
}

mysqli_close($conn);
?>
