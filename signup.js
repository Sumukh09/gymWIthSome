
document.addEventListener('DOMContentLoaded', function() {
    


    document.getElementById("signup-form").addEventListener("submit", function(event) {
        event.preventDefault();
    
        var fullname = document.getElementById("fullname").value.trim();
        var email = document.getElementById("email").value.trim();
        var username = document.getElementById("username").value.trim();
        var password = document.getElementById("password").value;
    
        // Validate that fields are not empty
        if (fullname === "" || email === "" || username === "" || password === "") {
            alert("All fields must be filled");
            return;
        }
    
        // Perform AJAX request and send data to the server
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "signup.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    
        // Format the data as a URL-encoded string
        var data = "fullname=" + encodeURIComponent(fullname) + "&email=" + encodeURIComponent(email) +
                   "&username=" + encodeURIComponent(username) + "&password=" + encodeURIComponent(password);
    
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4) {
                if (xhr.status === 200) {
                    // Handle the response from the server
                    var response = JSON.parse(xhr.responseText);
                    alert(response.message);
                    if (response.status === "success") {
                        // Optionally, redirect to the login page or perform other actions
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
    


});