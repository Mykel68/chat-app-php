function displayUserInformation(id, username, image) {
    // Update the chat-top-bar with the selected user information
    document.getElementById('chatUserImage').src = image;
    document.getElementById('chatUsername').innerHTML = username;

    // Fetch and display the chat for the selected user
    fetch('getChatMessages.php?userId=' + id)
        .then(response => response.json())
        .then(messages => {
            // Update the chat body
            updateChatBody(messages);

            // Remove the default message
            document.getElementById('defaultMessage').style.display = 'none';
        })
        .catch(error => console.error('Error fetching chat messages:', error));
}