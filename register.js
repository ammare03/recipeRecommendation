$(document).ready(function() {
    $('#registerForm').submit(function(event) {
        event.preventDefault(); // Prevent form submission for validation

        let email = $('#email').val();
        let password = $('#password').val();
        let valid = true;
        let errorMessage = '';

        const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        const passwordPattern = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*])[A-Za-z\d!@#$%^&*]{8,}$/;

        // Email validation
        if (!email) {
            errorMessage = 'Please enter your email.';
            valid = false;
        } else if (!emailPattern.test(email)) {
            errorMessage = 'Invalid email format.';
            valid = false;
        }

        // Password validation
        if (valid && !password) {
            errorMessage = 'Please enter your password.';
            valid = false;
        } else if (valid && !passwordPattern.test(password)) {
            errorMessage = 'Password must be at least 8 characters long and contain at least one uppercase letter, one lowercase letter, one number, and one special character.';
            valid = false;
        }

        if (!valid) {
            $('.message').text(errorMessage).show();
        } else {
            this.submit(); // Submit form if valid
        }
    });
});
