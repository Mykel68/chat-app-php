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
        $_SESSION['error_message'] = "Passwords do not match. Please try again.";
        header("Location: register.php");
        exit;
    }

    // Check if the email already exists in the database
    $checkEmailQuery = "SELECT * FROM users WHERE email = ?";
    $stmtCheckEmail = $conn->prepare($checkEmailQuery);
    $stmtCheckEmail->bind_param("s", $email);
    $stmtCheckEmail->execute();
    $resultCheckEmail = $stmtCheckEmail->get_result();

    if ($resultCheckEmail->num_rows > 0) {
        $_SESSION['error_message'] = "Email is already registered. Please use a different email address.";
        header("Location: register.php");
        exit;
    }

    // Check if the username already exists in the database
    $checkUsernameQuery = "SELECT * FROM users WHERE username = ?";
    $stmtCheckUsername = $conn->prepare($checkUsernameQuery);
    $stmtCheckUsername->bind_param("s", $username);
    $stmtCheckUsername->execute();
    $resultCheckUsername = $stmtCheckUsername->get_result();

    if ($resultCheckUsername->num_rows > 0) {
        $_SESSION['error_message'] = "Username is not available. Please choose a different username.";
        header("Location: register.php");
        exit;
    }

    // Handle image file upload
    $targetDir = "uploads/";
    $targetFile = $targetDir . basename($_FILES["profilePicture"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    // Check if image file is a actual image or fake image
    $check = getimagesize($_FILES["profilePicture"]["tmp_name"]);
    if ($check === false) {
        $_SESSION['error_message'] = "File is not an image.";
        header("Location: register.php");
        exit;
    }

    // Check file size
    if ($_FILES["profilePicture"]["size"] > 500000) {
        $_SESSION['error_message'] = "Sorry, your file is too large.";
        header("Location: register.php");
        exit;
    }

    // Allow certain file formats
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
        $_SESSION['error_message'] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        header("Location: register.php");
        exit;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        $_SESSION['error_message'] = "Sorry, your file was not uploaded.";
        header("Location: register.php");
        exit;
    } else {
        if (move_uploaded_file($_FILES["profilePicture"]["tmp_name"], $targetFile)) {
            echo "The file " . htmlspecialchars(basename($_FILES["profilePicture"]["name"])) . " has been uploaded.";
        } else {
            $_SESSION['error_message'] = "Sorry, there was an error uploading your file.";
            header("Location: register.php");
            exit;
        }
    }

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
        $_SESSION['error_message'] = "Error: " . $sql . "<br>" . $conn->error;
        header("Location: register.php");
        exit;
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();

    // Redirect to a success page or perform any other necessary actions
    header("Location: login.php");
    exit;
}
?>
