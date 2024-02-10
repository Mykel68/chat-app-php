<?php
session_start();
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Assuming you have a session with the current user ID
    $senderId = $_SESSION['id'];

    // Extract message from the form
    $message = $_POST['message'];

    // Assuming you have a variable $receiverId representing the ID of the receiver (selected user)
    $receiverId = $_POST['receiver_id']; // Make sure to sanitize and validate this value

    // Insert the message into the database
    $sql = "INSERT INTO chat_messages (sender_id, receiver_id, message) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iis", $senderId, $receiverId, $message);

    if ($stmt->execute()) {
        // Message sent successfully
        echo "Message sent successfully!";
    } else {
        // Error handling
        echo "Error: " . $stmt->error;
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
} else {
    // Handle invalid requests
    http_response_code(400);
    echo "Invalid request.";
}
?>
