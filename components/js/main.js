<script>
    function selectUser(userId) {
        // You can use AJAX to fetch and display the selected user's information in the chat area
        // For simplicity, let's assume you have a function named displayUser in your JavaScript
        // that displays the selected user in the chat area.
        displayUser(userId);
    }

    function displayUser(userId) {
        // Use AJAX to fetch the user's information and display it in the chat area
        // For example, you can make an AJAX request to get user details and update the chat area
        // Here, we'll just log the userId to the console for demonstration purposes.
        console.log("Selected user: " + userId);
    }
</script>
