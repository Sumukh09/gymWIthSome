<?php
session_start();

// Check if the user is logged in
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

// Query to retrieve data from UserLog and User table
$query = "SELECT ul.user_id, u.fullname, ul.avg_sets, ul.avg_reps, ul.avg_weight
          FROM UserLog ul
          INNER JOIN users u ON ul.user_id = u.user_id
          WHERE ul.user_id = $user_id";


$result = mysqli_query($conn, $query);

// Fetch data and display it
if ($result && mysqli_num_rows($result) > 0) {
    echo "<style>
            table {
                width: 50%;
                border-collapse: collapse;
                margin-top: 20px;

                max-width: 800px;
                margin: 0 auto; 
                padding: 20px;
                text-align: center;
            }

            th, td {
                border: 1px solid #ddd;
                padding: 8px;
                text-align: left;
            }

            th {
                background-color: #3498db;
                color: #fff;
            }
            h2{
                max-width: 800px;
                margin: 0 auto; 
                padding: 20px;
                text-align: center;
            
            }
         </style>";

    echo "<h2 >UserLog </h2>";
    echo "<table>";
    echo "<tr><th>Name</th><th>Avg Sets</th><th>Avg Reps</th><th>Avg Weight</th></tr>";
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . $row['fullname'] . "</td>";
        echo "<td>" . $row['avg_sets'] . "</td>";
        echo "<td>" . $row['avg_reps'] . "</td>";
        echo "<td>" . $row['avg_weight'] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "No data available.";
}

mysqli_close($conn);
?>
