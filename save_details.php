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
    // Assuming you have user_id and exid available in your session or from the form
    $user_id = $_POST["user_id"];
    $exid = $_POST["exid"];
    $sets = $_POST["sets"];
    $reps = $_POST["reps"];
    $weight = $_POST["weight"];

    // Insert user's exercise data into the userStorage table
    $sql = "INSERT INTO userStorage (user_id, exe_name, sets, reps, weight , date) VALUES ('$user_id', '$exid', '$sets', '$reps', '$weight' , CURDATE())";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(array("status" => "success", "message" => "Exercise data saved successfully"));
    } else {
        echo json_encode(array("status" => "error", "message" => "Error: " . $sql . "<br>" . $conn->error));
    }
}

$conn->close();
?>
