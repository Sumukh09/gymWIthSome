document.addEventListener('DOMContentLoaded', function () {
    const forgotPasswordForm = document.getElementById('forgotpassword-form');

    forgotPasswordForm.addEventListener('submit', function (event) {
        event.preventDefault();

        // Perform form validation and submission logic here
        // You can use AJAX to send the form data to the server

        // For now, let's just log a message
        console.log('Forgot Password form submitted!');
    });
});
