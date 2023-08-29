<!DOCTYPE html>
<html>

<head>
    <title>Registration Form</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js"></script>
    <style>
        header {
            color: #cc0000;
            text-align: center;
            font-size: 20px;
            font-weight: bold;
            text-decoration: underline;
        }

        form {
            width: 50%;
            margin: 0 auto;
            padding-bottom: 20px;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"],
        input[type="tel"] {
            width: 100%;
            box-sizing: border-box;
            padding: 10px;
            border: 2px solid black;
            border-radius: 4px;
            margin-bottom: 20px;
            font-size: 16px;
        }

        .disableSubmit {
            background-color: #a15858;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 15px;
            font-size: 16px;
            margin-top: 20px;
            /* cursor: pointer; */

        }

        .enableSubmit {
            background-color: #700404;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 15px;
            cursor: pointer;
            font-size: 18px;
            margin-top: 20px;
            font-weight: bold;
        }

        .container {
            text-align: center;
        }

        .error {
            color: red;
        }

        .success {
            color: green;
        }
    </style>

<body>
    <header>Registration Form</header><br>
    <form method="post" action="getData.php">
        <label for="firstName">First Name:</label>
        <input type="text" id="firstName" name="firstName" placeholder="Enter First Name (3-8 characters)" required>
        <span id="firstNameError"></span><br>

        <br><label for="lastName">Last Name:</label>
        <input type="text" id="lastName" name="lastName" placeholder="Enter Last Name (3-8 characters)" required>
        <span id="lastNameError"></span><br>

        <br><label for="email">Email:</label>
        <input type="text" id="email" name="email" placeholder="Enter Email" required>
        <span id="emailError"></span><br>

        <br><label for="password">Password:</label>
        <input type="password" id="password" name="password" placeholder="Enter Password" required>
        <span id="passwordError"></span><br>

        <br><label for="rePassword">Re-type Password:</label>
        <input type="password" id="rePassword" name="rePassword" placeholder="Re-type Password" required>
        <span id="rePasswordError"></span><br>

        <br><label for="phone">Mobile:</label>
        <input type="tel" id="phone" name="phone" placeholder="xxx-xxx-xxxx" required>
        <span id="phoneError"></span><br>

        <br><label for="state">State:</label>
        <input type="text" id="state" name="state" placeholder="Enter State (2 characters)" required>
        <span id="stateError"></span><br>

        <br><label for="city">City:</label>
        <input type="text" id="city" name="city" placeholder="Enter City" required>
        <span id="cityError"></span><br>

        <div class="container">
            <input type="submit" name="submit-button" value="Register Now" id="submit-button">
        </div>
    </form>

    <script>
        $(document).ready(function() {
            $('.error').html('');

            $('#submit-button').prop('disabled', true).addClass('disableSubmit');

            $('#firstName').on('input', function() {
                checkFirstName();
                validateForm();
            });
            $('#lastName').on('input', function() {
                checkLastName();
                validateForm();
            });
            $('#email').on('input', function() {
                checkEmail();
                validateForm();
            });
            $('#password').on('input', function() {
                checkPassword();
                validateForm();
            });
            $('#rePassword').on('input', function() {
                checkRePassword();
                validateForm();
            });
            $('#phone').on('input', function() {
                checkPhone();
                validateForm();
            });
            $('#state').on('input', function() {
                checkState();
                validateForm();
            });


            function validateForm() {

                // Enable submit button if all fields are validated
                if ($('#firstNameError').html() === 'Correct' &&
                    $('#lastNameError').html() === 'Correct' &&
                    $('#emailError').html() === 'Correct' &&
                    $('#passwordError').html() === 'Correct' &&
                    $('#rePasswordError').html() === 'Correct' &&
                    $('#phoneError').html() === 'Correct' &&
                    $('#stateError').html() === 'Correct') {
                    $('#submit-button').prop('disabled', false).addClass('enableSubmit');
                } else {
                    $('#submit-button').prop('disabled', true).addClass('disableSubmit');
                }
            }

            // If no errors, submit form
            $('#submit-button').click(function(e) {
                e.preventDefault(); // Prevent default form submission

                // Send data to PHP using AJAX
                $.post('getData.php', $('form').serialize(), function(response) {
                    if(response === "success") {
                            $('form').html('<h2 style="text-align:center;">Registration completed, thank you.</h2>');
                        } else {
                            alert('Something went wrong. Please try again later');
                        }
                });
            });
        });

        function checkFirstName() {
            var nameRegex = /^[a-zA-Z']{3,8}$/;
            var firstName = $('#firstName').val();
            if (firstName.length != 0) {
                if (firstName.length < 3 || firstName.length > 8 || !nameRegex.test(firstName)) {
                    $('#firstNameError').html('Error').removeClass('success').addClass("error");
                } else {
                    $('#firstNameError').html('Correct').addClass("success");
                }
            }
        }

        function checkLastName() {
            var nameRegex = /^[a-zA-Z']{3,8}$/;
            var lastName = $('#lastName').val();
            if (lastName.length != 0) {
                if (lastName.length < 3 || lastName.length > 8 || !nameRegex.test(lastName)) {
                    $('#lastNameError').html('Error').addClass("error");
                } else {
                    $('#lastNameError').html('Correct').addClass("success");
                }
            }
        }

        function checkEmail() {
            var email = $('#email').val();
            var emailRegex = /^[a-zA-Z][a-zA-Z0-9._'-]*@[a-zA-Z]+(\.[a-zA-Z]+){1,2}$/;
            if (email.length != 0) {
                if (!emailRegex.test(email)) {
                    $('#emailError').html('Error').addClass("error");
                } else {
                    $('#emailError').html('Correct').addClass("success");
                }
            }
        }

        function checkPassword() {
            var password = $('#password').val();
            var passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{6,}$/;
            if (password.length != 0) {
                if (!passwordRegex.test(password)) {
                    $('#passwordError').html('Error').addClass("error");
                } else {
                    $('#passwordError').html('Correct').addClass("success");
                }
            }
        }

        function checkRePassword() {
            var rePassword = $('#rePassword').val();
            var password = $('#password').val();
            if (rePassword.length != 0) {
                if (rePassword != password) {
                    $('#rePasswordError').html('Error').addClass("error");
                } else {
                    $('#rePasswordError').html('Correct').addClass("success");
                }
            }
        }

        function checkPhone() {
            var phone = $('#phone').val();
            var phoneRegex = /^\d{3}-\d{3}-\d{4}$/;
            if (phone.length != 0) {
                if (phone.length != 12 || !phoneRegex.test(phone)) {
                    $('#phoneError').html('Error').addClass("error");
                } else {
                    $('#phoneError').html('Correct').addClass("success");
                }
            }
        }

        function checkState() {
            var state = $('#state').val();
            var stateRegex = /^[A-Za-z]{2}$/;
            var stateList = ['AL', 'AK', 'AZ', 'AR', 'CA', 'CO', 'CT', 'DE', 'FL', 'GA', 'HI', 'ID', 'IL', 'IN', 'IA', 'KS', 'KY', 'LA', 'ME', 'MD', 'MA', 'MI', 'MN', 'MS', 'MO', 'MT', 'NE', 'NV', 'NH', 'NJ', 'NM', 'NY', 'NC', 'ND', 'OH', 'OK', 'OR', 'PA', 'RI', 'SC', 'SD', 'TN', 'TX', 'UT', 'VT', 'VA', 'WA', 'WV', 'WI', 'WY'];
            if (state.length != 0) {
                if (state.length != 2 || $.inArray(state, stateList) === -1) {
                    $('#stateError').html('Error').addClass("error");
                } else {
                    $('#stateError').html('Correct').addClass("success");
                }
            }
        }
    </script>
</body>