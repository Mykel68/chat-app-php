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
    // Handle image file upload
    $targetDir = "uploads/";
    $targetFile = $targetDir . basename($_FILES["profilePicture"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    // Check if image file is a actual image or fake image
    $check = getimagesize($_FILES["profilePicture"]["tmp_name"]);
    if ($check === false) {
        echo "File is not an image.";
        $uploadOk = 0;
    }

    // Check file size
    if ($_FILES["profilePicture"]["size"] > 500000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // Allow certain file formats
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
        exit;
    } else {
        if (move_uploaded_file($_FILES["profilePicture"]["tmp_name"], $targetFile)) {
            echo "The file " . htmlspecialchars(basename($_FILES["profilePicture"]["name"])) . " has been uploaded.";
        } else {
            echo "Sorry, there was an error uploading your file.";
            exit;
        }
    }

    // Example: Insert user data into the database
    $sql = "INSERT INTO users (username, email, password, image) VALUES (?, ?, ?, ?)";
    
    // Use prepared statement to prevent SQL injection
    $stmt = $conn->prepare($sql);
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $stmt->bind_param("ssss", $username, $email, $hashedPassword, $targetFile);


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
