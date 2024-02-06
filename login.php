<?php
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>
<body>
    <div class="d-flex flex-column bg-primary p-2">
        <form action="login_process.php" method="post">

        <?php
        session_start();
        if (isset($_SESSION['error_message'])) {
            echo '<div class="alert alert-danger mt-2" role="alert">' . $_SESSION['error_message'] . '</div>';
            unset($_SESSION['error_message']);
        }
        ?>
        
            <div class="mb-3">
                <label for="" class="form-label">Email</label>
                <input
                    type="email"
                    class="form-control"
                    name="email"
                    aria-describedby="helpId"
                    placeholder=""
                />
            </div>
            <div class="mb-3">
                <label for="" class="form-label">Password</label>
                <input
                    type="password"
                    class="form-control"
                    name="password"
                    aria-describedby="helpId"
                    placeholder=""
                />
            </div>
            <input type="submit" value="Login">
        </form>

        <a href="register.php" class="btn btn-secondary mt-2 w-25">Register</a>

   

    </div>
</body>
</html>
