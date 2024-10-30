// login.js
$(document).ready(function() {
    $('#loginForm').submit(function(event) {
        event.preventDefault(); // Prevent form submission for validation

        let email = $('#email').val();
        let password = $('#password').val();
        let valid = true;
        let errorMessage = '';

        const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

        if (!email) {
            errorMessage = 'Please enter your email.';
            valid = false;
        } else if (!emailPattern.test(email)) {
            errorMessage = 'Invalid email format.';
            valid = false;
        }

        if (valid && !password) {
            errorMessage = 'Please enter your password.';
            valid = false;
        }

        if (!valid) {
            $('.message').text(errorMessage).show();
        } else {
            this.submit(); // Submit form if valid
        }
    });
});
