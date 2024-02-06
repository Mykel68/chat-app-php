<?php

    require 'config.php';
    session_start();

    // Check if the user is logged in
    if (!isset($_SESSION['id'])) {
        header("Location: login.php");
        exit;
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container p-3">
        <div class="box-container d-flex bg-secondary p-3 ">
            <div class="sidebar">
                <?php
                include ('components/sidebar.php')
                ?>
            </div>
            <div class="chat-container">
                <?php
                include ('components/chat-container.php')
                ?>
            </div>
        </div>
    </div>
    
</body>
<script src="js/main.js"></script>
<script>
    function updateChatTopBar(userId, imageUrl, username) {
        // Update the content of the chat-top-bar
        document.getElementById('chat-top-bar-image').src = imageUrl;
        document.getElementById('chat-top-bar-username').innerText = username;
    }
    function startChatWithUser(username) {
    // Replace the default message with the selected user's chat
    document.getElementById('chatBody').innerHTML = `
        <div class="recieve">
            <div class="recieve-msg">
                <p class="recieve-msg-text">Hi, how are you?</p>
                <div class="recieve-time">
                    <p class="msg-time"> 10:01</p>
                </div>
            </div>
        </div>

        <div class="sent">
            <div class="sent-msg">
                <p class="sent-msg-text">I am fine</p>
                <div class="sent-time">
                    <p class="msg-time"> 10:01</p>
                </div>
            </div>
        </div>
    `;
}
function startChatWithUser(userId, username) {
    // Make an asynchronous request to fetch chat messages for the selected user
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
            // Update the chat-body with the fetched messages
            document.getElementById('chatBody').innerHTML = xhr.responseText;
        }
    };
    xhr.open('GET', 'get_chat_messages.php?user_id=' + userId, true);
    xhr.send();
}
function startChatWithUser(userId, username) {
    // Replace the default message with the selected user's chat
    document.getElementById('defaultMessage').style.display = 'none';

    // Fetch chat messages for the selected user
    fetch('getChatMessages.php?userId=' + userId)
        .then(response => response.json())
        .then(data => {
            const chatMessagesContainer = document.getElementById('chatMessagesContainer');
            chatMessagesContainer.innerHTML = ''; // Clear existing messages

            // Append fetched messages to the container
            data.forEach(message => {
                const messageDiv = document.createElement('div');
                messageDiv.className = message.sender === userId ? 'sent' : 'recieve';

                messageDiv.innerHTML = `
                    <div class="${message.sender === userId ? 'sent' : 'recieve'}-msg">
                        <p class="${message.sender === userId ? 'sent' : 'recieve'}-msg-text">${message.content}</p>
                        <div class="${message.sender === userId ? 'sent' : 'recieve'}-time">
                            <p class="msg-time">${message.timestamp}</p>
                        </div>
                    </div>
                `;

                chatMessagesContainer.appendChild(messageDiv);
            });
        })
        .catch(error => {
            console.error('Error fetching chat messages:', error);
        });
}
</script>
</html>

<?php
?>