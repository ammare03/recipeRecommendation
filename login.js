// login.js
$(document).ready(function() {
    $('#loginForm').submit(function(event) {
        let email = $('#email').val();
        let password = $('#password').val();
        let valid = true;

        if (email === '') {
            alert('Please enter your email.');
            valid = false;
        } else if (password === '') {
            alert('Please enter your password.');
            valid = false;
        }

        if (!valid) {
            event.preventDefault(); // Prevent form submission
        }
    });
});
