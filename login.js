document.getElementById("login-form").addEventListener("submit", function(event) {
    event.preventDefault();

    var username = document.getElementById("username").value.trim();
    var password = document.getElementById("password").value;

    // Validate that fields are not empty
    if (username === "" || password === "") {
        alert("Username and password cannot be empty");
        return;
    }

    // Perform AJAX request and send data to the server
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "login.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    // Format the data as a URL-encoded string
    var data = "username=" + encodeURIComponent(username) + "&password=" + encodeURIComponent(password);

    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4) {
            if (xhr.status === 200) {
                // Handle the response from the server
                var response = JSON.parse(xhr.responseText);
                alert(response.message);
                if (response.status === "success") {
                    // Optionally, redirect to the dashboard or perform other actions

                    window.location.href = "gym_main.php";
                }
            } else {
                // Handle error response from the server
                alert("Error: " + xhr.statusText);
            }
        }
    };

    // Send the request with the data
    xhr.send(data);
});
