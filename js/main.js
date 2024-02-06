function displayUserInformation(userId, username, userImage) {
    // Update chat-top-bar with selected user's information
    document.getElementById('chatUserImage').src = userImage;
    document.getElementById('chatUsername').innerText = username;

    // Fetch and display chat messages for the selected user
    startChatWithUser(userId, username);
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

    // Make sure to replace 'path/to/emoji-picker.js' with the correct path
    const emojiPicker = new EmojiPicker({
        emojiable_selector: '[data-emojiable=true]',
        assetsPath: 'js/emoji-picker.js',
        popupButtonClasses: 'fa',
        events: {
            keyup: function (editor, event) {
                // Handle keyup events if needed
            }
        }
    });
    emojiPicker.discover();