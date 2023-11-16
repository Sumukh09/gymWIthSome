
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

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css"> <!-- You can link to an external CSS file if needed -->
    <title>My Gym</title>
</head>
<body>
    <div class="container">
        <h1>Welcome to My Gym</h1>

        <div class="options">
            <label for="workout-type">Select a Workout Type:</label>
            <select id="workout-type">
                <option value="cardio">Cardio</option>
                <option value="full-body">Full Body Workout</option>
            </select>
        </div>

        <div class="exercise-list">
            <h2>Exercise List</h2>
            <ul id="exercise-list">
                <!-- This is where the exercise list will be displayed dynamically -->
            </ul>
        </div>

        <div class="input-container" id="exercise-details" style="display: none;">
            <h2>Exercise Details</h2>
            <label for="sets">Sets:</label>
            <input type="number" id="sets" placeholder="Enter number of sets">

            <label for="reps">Reps:</label>
            <input type="number" id="reps" placeholder="Enter number of reps">

            <label for="weight">Weight Used (lbs/kg):</label>
            <input type="number" id="weight" placeholder="Enter weight used">


            <script>
                const user_id = <?php echo json_encode($user_id); ?>;
                let exid = null; // Initialize exid, you'll set it later in your code
            </script>

            <button onclick="saveDetails()">Save</button>
        </div>

        <button id="finish-workout" onclick="finishWorkout()" style="display: none;">Finish Workout</button>

        <table id="exercise-table" style="display: none;">
            <thead>
                <tr>
                    <th>Exercise</th>
                    <th>Sets</th>
                    <th>Reps</th>
                    <th>Weight</th>
                </tr>
            </thead>
            <tbody id="exercise-table-body"></tbody>
        </table>

        <button onclick="viewWorkoutIntensityLog()">View Workout Intensity Log</button>


        <button id="logout-button" >Logout</button>
    </div>

    <script>

       

        const workoutTypeSelect = document.getElementById("workout-type");
        const exerciseList = document.getElementById("exercise-list");
        const exerciseDetails = document.getElementById("exercise-details");
        const exerciseTable = document.getElementById("exercise-table");
        const exerciseTableBody = document.getElementById("exercise-table-body");
        const finishButton = document.getElementById('finish-workout');

        let selectedExercise = null;
        let isWorkoutFinished = false;

        workoutTypeSelect.addEventListener("change", () => {
            const selectedWorkoutType = workoutTypeSelect.value;

            const cardioExercises = ["Running", "Cycling", "Jumping Jacks", "Burpees", "Swimming"];
            const fullBodyExercises = ["Push-ups", "Squats", "Planks", "Deadlifts", "Kettlebell Swings"];

            exerciseList.innerHTML = "";

            if (selectedWorkoutType === "cardio") {
                for (const exercise of cardioExercises) {
                    const li = document.createElement("li");
                    li.textContent = exercise;
                    li.addEventListener("click", () => showExerciseDetails(exercise));
                    exerciseList.appendChild(li);
                }
            } else if (selectedWorkoutType === "full-body") {
                for (const exercise of fullBodyExercises) {
                    const li = document.createElement("li");
                    li.textContent = exercise;
                    li.addEventListener("click", () => showExerciseDetails(exercise));
                    exerciseList.appendChild(li);
                }
            }
        });

        function showExerciseDetails(exercise) {
            selectedExercise = exercise;
            exerciseDetails.style.display = 'block';
            finishButton.style.display = 'block';
        }

        function saveDetails() {
    if (!isWorkoutFinished) {
        const sets = document.getElementById('sets').value;
        const reps = document.getElementById('reps').value;
        const weight = document.getElementById('weight').value;

        const user_id = <?php echo json_encode($user_id); ?>;
        // Get user_id and exid from your session or wherever they are stored
        // Replace with the actual user_id
        const exid = selectedExercise;

        // Perform AJAX request and send data to the server
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "save_details.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        // Format the data as a URL-encoded string
        var data = "user_id=" + encodeURIComponent(user_id) + "&exid=" + encodeURIComponent(exid) + "&sets=" + encodeURIComponent(sets) + "&reps=" + encodeURIComponent(reps) + "&weight=" + encodeURIComponent(weight);

        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4) {
                if (xhr.status === 200) {
                    // Handle the response from the server
                    var response = JSON.parse(xhr.responseText);
                    alert(response.message);
                    if (response.status === "success") {
                        // Optionally, perform additional actions
                    }
                } else {
                    // Handle error response from the server
                    alert("Error: " + xhr.statusText);
                }
            }
        };

        // Send the request with the data
        xhr.send(data);
    


                const newRow = document.createElement('tr');
                newRow.innerHTML = `
                    <td>${selectedExercise}</td>
                    <td>${sets}</td>
                    <td>${reps}</td>
                    <td>${weight}</td>
                `;

                exerciseTableBody.appendChild(newRow);
                exerciseTable.style.display = 'block';

                document.getElementById('sets').value = '';
                document.getElementById('reps').value = '';
                document.getElementById('weight').value = '';

                exerciseDetails.style.display = 'none';
            }
        }

        function finishWorkout() {
            isWorkoutFinished = true;
            exerciseDetails.style.display = 'none';
            finishButton.style.display = 'none';
            document.getElementById('sets').disabled = true;
            document.getElementById('reps').disabled = true;
            document.getElementById('weight').disabled = true;
        }


        function finishWorkout() {
        isWorkoutFinished = true;
        exerciseDetails.style.display = 'none';
        finishButton.style.display = 'none';
        document.getElementById('sets').disabled = true;
        document.getElementById('reps').disabled = true;
        document.getElementById('weight').disabled = true;

        // Redirect to the summary page with necessary data
        window.location.href = 'summary.php';
    }


    function viewWorkoutIntensityLog() {
            // Redirect to the Workout Intensity Log page
            window.location.href = 'workout_intensity_log.php';
        }


    
    function handleLogout() {
                // Redirect to logout.php or your logout script
                window.location.href = "login.html";
            }

            // Attach the handleLogout function to the click event of the logout button
            document.getElementById("logout-button").addEventListener("click", handleLogout);


    </script>
</body>
</html>
