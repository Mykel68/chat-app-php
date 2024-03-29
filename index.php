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
<script src="js/emoji-picker.js"></script>




</html>

<?php
?>