<?php
header('Access-Control-Allow-Origin: *');

//database
$dbname = "registration_sruthi";
$conn = mysqli_connect("localhost", "root", "");

// Check connection
if (mysqli_connect_errno() || !$conn) {
	// If there is an error with the connection, stop the script and display the error.
	exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}

$create_db_sql = "CREATE DATABASE IF NOT EXISTS $dbname";
if(mysqli_query($conn, $create_db_sql)) {
    // Select database
    mysqli_select_db($conn, $dbname);

    // Query to create table
    $sql = "CREATE TABLE IF NOT EXISTS `registrationform` (
    `id` INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `firstName` VARCHAR(255),
    `lastName` VARCHAR(255),
    `email` VARCHAR(255),
    `PASSWORD` VARCHAR(255),
    `phone` INT(20),
    `state` varchar(255),
    `city` varchar(255))";

    //create table
    if (!mysqli_query($conn, $sql)) {
        echo "Error creating table: " . mysqli_error($conn);
    }
} else {
    echo "Error creating database: " . mysqli_error($conn);
}

//post data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $rePassword = $_POST['rePassword'];
    $phone = $_POST['phone'];
    $state = $_POST['state'];
    $city = $_POST['city'];

    $errors = array();

// First Name Validation
if(empty($firstName)){
    $errors['firstName'] = 'First name is required';
} else {
    if(!preg_match("/^[a-zA-Z']{3,8}$/", $firstName)){
        $errors['firstName'] = 'Invalid first name';
    }
}

// Last Name Validation
if(empty($lastName)){
    $errors['lastName'] = 'Last name is required';
} else {
    if(!preg_match("/^[a-zA-Z']{3,8}$/", $lastName)){
        $errors['lastName'] = 'Invalid last name';
    }
}

// Email Validation
if(empty($email)){
    $errors['email'] = 'Email is required';
} else {
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $errors['email'] = 'Invalid email format';
    }
}

// Password Validation
if(empty($password)){
    $errors['password'] = 'Password is required';
} else {
    if(!preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{6,}$/", $password)){
        $errors['password'] = 'Invalid password';
    }
}

// Re-Enter Password Validation
if(empty($rePassword)){
    $errors['rePassword'] = 'Please re-enter your password';
} else {
    if($rePassword != $password){
        $errors['rePassword'] = 'Passwords do not match';
    }
}

// Phone Validation
if(empty($phone)){
    $errors['phone'] = 'Phone number is required';
} else {
    if(!preg_match("/^\d{3}-\d{3}-\d{4}$/", $phone)){
        $errors['phone'] = 'Invalid phone number format';
    }
}

// State Validation
if(empty($state)){
    $errors['state'] = 'State is required';
} else {
    $stateList = array('AL', 'AK', 'AZ', 'AR', 'CA', 'CO', 'CT', 'DE', 'FL', 'GA', 'HI', 'ID', 'IL', 'IN', 'IA', 'KS', 'KY', 'LA', 'ME', 'MD', 'MA', 'MI', 'MN', 'MS', 'MO', 'MT', 'NE', 'NV', 'NH', 'NJ', 'NM', 'NY', 'NC', 'ND', 'OH', 'OK', 'OR', 'PA', 'RI', 'SC', 'SD', 'TN', 'TX', 'UT', 'VT', 'VA', 'WA', 'WV', 'WI', 'WY');
    if(!preg_match("/^[A-Za-z]{2}$/", $state) || !in_array(strtoupper($state), $stateList)){
        $errors['state'] = 'Invalid state';
    }
}

// Output errors if any
if(!empty($errors)){
    foreach($errors as $error){
        return $error . '<br>';
    }
}
    //hash and salt for the password 
    $salt = uniqid();
    $hashedPassword = sha1($password . $salt);

    //remove hyphen from phone
    $phone = str_replace('-', '', $_POST['phone']);

    //insert data
    $sql = "INSERT INTO `registrationform` (`id`, `firstName`, `lastName`, `email`, `PASSWORD`, `phone`, `state`, `city`) VALUES (NULL, '$firstName','$lastName','$email','$hashedPassword',$phone,'$state','$city')";

    $insertData = mysqli_query($conn, $sql);

    echo $insertData ? "success" : "failure";

    mysqli_close($conn);
}