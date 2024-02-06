<?php

// Check if the user is logged in
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit;
}

// Retrieve the user ID of the currently logged-in user
$currentUserId = $_SESSION['id'];

// Retrieve all users from the database excluding the current user
$sql = "SELECT * FROM users WHERE id <> ?";

// Use prepared statement to prevent SQL injection
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $currentUserId);

// Execute the statement
$stmt->execute();

// Get the result
$result = $stmt->get_result();

// Check if there are any users
if ($result->num_rows > 0) {
    // Fetch all users as an associative array
    $users = $result->fetch_all(MYSQLI_ASSOC);

    // Output or process the users as needed
    echo '<div class="container-fluid border-end">';
    echo '<ul>';
    echo '<h2>Contacts</h2>';

    foreach ($users as $user) {
        echo '<li>';
        echo '<img src="' . $user['image'] . '" alt="">';
        echo '<div class="online">';
        echo '<div class="online-presence"></div>';
        echo '<p> ' . $user['username'] . '</p>';
        echo '</div>';
        echo '</li>';
    }

    echo '</ul>';
    echo '</div>';
} else {
    echo "No other users found.";
}

?>
