<?php
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['userId'])) {
    $userId = $_GET['userId'];

    // Fetch chat messages from the database based on $userId
    // Replace this with your actual database query to get chat messages for the selected user

    // Example:
    $sql = "SELECT * FROM chat_messages WHERE receiver_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    $messages = $result->fetch_all(MYSQLI_ASSOC);

    // Return JSON response with chat messages
    header('Content-Type: application/json');
    echo json_encode($messages);
    exit;
} else {
    // Handle invalid requests
    http_response_code(400);
    echo "Invalid request.";
    exit;
}

?>
