<?php
// Check if the user is logged in
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit;
}

// Retrieve the user ID of the currently logged-in user
$currentUserId = $_SESSION['id'];

// Retrieve the current user from the database
$sql = "SELECT * FROM users WHERE id = ?";

// Use prepared statement to prevent SQL injection
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $currentUserId);

// Execute the statement
$stmt->execute();

// Get the result
$result = $stmt->get_result();

// Check if there are any users
if ($result->num_rows > 0) {
    // Fetch the current user as an associative array
    $currentUser = $result->fetch_assoc();

    // Output the current user information
    echo '<div class="chat-top-bar ps-2">';
    echo '<div class="chat-top-bar-right">';
    echo '<img src="' . $currentUser['image'] . '" alt="">';
    echo '<p>' . $currentUser['username'] . '</p>';
    echo '</div>';
    echo '<div class="profile">';
    echo '<img src="' . $currentUser['image'] . '" alt="">';
    echo '<a href="logout.php" class="btn btn-danger">Logout</a>';
    echo '</div>';
    echo '</div>';
} else {
    echo "User not found.";
}

?>
