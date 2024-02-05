<?php
require 'config.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate and sanitize form data
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    $password = $_POST['password'];

    if (empty($email) || empty($password)) {
        echo "Both email and password are required.";
        exit;
    }

    // Example: Retrieve user data from the database
    $sql = "SELECT * FROM users WHERE email = ?";
    
    // Use prepared statement to prevent SQL injection
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);

    // Execute the statement
    $stmt->execute();
    
    // Get the result
    $result = $stmt->get_result();

    // Check if the user exists and the password is correct
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Verify the password
        if (password_verify($password, $user['password'])) {
            // Save user information in session
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['email'] = $user['email'];

            // Redirect to the index page
            header("Location: index.php");
            exit;
        } else {
            echo "Invalid email or password. Please try again.";
            header("Location: login.php");
        }
    } else {
        echo "Invalid email or password. Please try again.";
        header("Location: login.php");
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}
?>
