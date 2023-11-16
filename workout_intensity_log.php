<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to login page if not logged in
    header("Location: login.php");
    exit();
}

// Retrieve user_id from session
$user_id = $_SESSION['user_id'];

// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "gymApp";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Fetch user's name
$userNameQuery = "SELECT fullname FROM users WHERE user_id = $user_id";
$userNameResult = mysqli_query($conn, $userNameQuery);

if ($userNameResult && mysqli_num_rows($userNameResult) > 0) {
    $row = mysqli_fetch_assoc($userNameResult);
    $userName = $row['fullname'];
} else {
    $userName = "Unknown"; // Set a default name if not found
}

// Call the stored procedure
$procedureCall = "CALL CalculateWorkoutIntensityForDay($user_id, CURRENT_DATE())";
$result = mysqli_query($conn, $procedureCall);

// Check if the stored procedure executed successfully
if (!$result) {
    echo "Error executing stored procedure: " . mysqli_error($conn);
} else {
    // Fetch and display the result
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <style>
            body {
                font-family: Arial, sans-serif;
                background-color: #f4f4f4;
                margin: 0;
                padding: 0;
                display: flex;
                align-items: center;
                justify-content: center;
                height: 100vh;
            }

            .container {
                text-align: center;
                background-color: #fff;
                padding: 20px;
                border-radius: 8px;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            }

            h1 {
                color: #3498db;
            }

            .result {
                margin-top: 20px;
                padding: 10px;
                border: 1px solid #ddd;
                border-radius: 4px;
                background-color: #f9f9f9;
            }
        </style>
        <title>Workout Intensity</title>
    </head>
    <body>
        <div class="container">
            <h1>Workout Intensity</h1>
            <div class="result">
                <?php
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<p>Name: " . $userName . "</p>";
                    echo "<p>Total Sets: " . $row['total_sets'] . "</p>";
                    echo "<p>Total Reps: " . $row['total_reps'] . "</p>";
                    echo "<p>Total Weight: " . $row['total_weight'] . "</p>";
                    echo "<p>Workout Intensity: " . $row['intensity'] . "</p>";
                }
                ?>
            </div>
        </div>
    </body>
    </html>
    <?php
}

// Close connection
mysqli_close($conn);
?>
