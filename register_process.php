<?php

require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate and sanitize form data
    $username = htmlspecialchars($_POST['username']);
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    $password = $_POST['password']; 
    $confirmPassword = $_POST['confirmPassword'];

    // Example: Check if password and confirm password match
    if ($password !== $confirmPassword) {
        echo "Passwords do not match. Please try again.";
        exit;
    }

    // Check if the email already exists in the database
    $checkEmailQuery = "SELECT * FROM users WHERE email = ?";
    $stmtCheckEmail = $conn->prepare($checkEmailQuery);
    $stmtCheckEmail->bind_param("s", $email);
    $stmtCheckEmail->execute();
    $resultCheckEmail = $stmtCheckEmail->get_result();

    if ($resultCheckEmail->num_rows > 0) {
        echo "Email is already registered. Please use a different email address.";
        exit;
    }

    // Check if the username already exists in the database
    $checkUsernameQuery = "SELECT * FROM users WHERE username = ?";
    $stmtCheckUsername = $conn->prepare($checkUsernameQuery);
    $stmtCheckUsername->bind_param("s", $username);
    $stmtCheckUsername->execute();
    $resultCheckUsername = $stmtCheckUsername->get_result();

    if ($resultCheckUsername->num_rows > 0) {
        echo "Username is not available. Please choose a different username.";
        exit;
    }

    // Handle image file upload
    // (Your existing image upload code)

    // Example: Insert user data into the database without hashing the password
    $sql = "INSERT INTO users (username, email, password, image) VALUES (?, ?, ?, ?)";

    // Use prepared statement to prevent SQL injection
    $stmt = $conn->prepare($sql);

    // Bind parameters
    $stmt->bind_param("ssss", $username, $email, $password, $targetFile);

    // Execute the statement
    if ($stmt->execute()) {
        echo "Registration successful! User data inserted into the database.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();

    // Redirect to a success page or perform any other necessary actions
    header("Location: login.php");
    exit;
}
?>
