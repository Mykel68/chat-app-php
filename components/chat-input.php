<form action="sendMessage.php" method="post" class="border-top p-2 chat-input" enctype="multipart/form-data">
    <input type="text" name="message" placeholder="Type your message here...">
    
    <!-- Update your chat-input.php -->
    <input type="text" name="emoji" id="emoji" placeholder="Pick an emoji" data-emojiable="true">


    <!-- File Attachment -->
    <input type="file" name="attachment" id="attachment">
    
    <button type="submit">Send</button>
</form>

<!-- Add this script to include an emoji picker library (e.g., EmojiPicker.js) -->
<script src="path/to/emoji-picker.js"></script>
<script>
    // Initialize emoji picker
    const emojiPicker = new EmojiPicker({
        emojiable_selector: '[data-emojiable=true]',
        assetsPath: 'path/to/emoji-picker-assets',
        popupButtonClasses: 'fa',
        events: {
            keyup: function (editor, event) {
                // Handle keyup events if needed
            }
        }
    });
    emojiPicker.discover();

    // Optionally, you can customize the appearance of the emoji picker button
    const emojiButton = document.querySelector('#emoji-picker-button');
    emojiPicker.listenOn(emojiButton);
</script>