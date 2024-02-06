<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1>Register</h1>
        <form action="register_process.php" method="post" enctype="multipart/form-data">
        <?php
        session_start();
        if (isset($_SESSION['error_message'])) {
            echo '<div class="alert alert-danger mt-2" role="alert">' . $_SESSION['error_message'] . '</div>';
            unset($_SESSION['error_message']);
        }
        ?>
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input
                    type="text"
                    class="form-control"
                    name="username"
                    id="username"
                    placeholder="Enter your username"
                    required
                />
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input
                    type="email"
                    class="form-control"
                    name="email"
                    id="email"
                    placeholder="Enter your email"
                    required
                />
            </div>
            <div class="mb-3">
                <label for="profilePicture" class="form-label">Profile Picture</label>
                <input
                    type="file"
                    class="form-control"
                    name="profilePicture"
                    id="profilePicture"
                    accept="image/*"
                    required
                />
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input
                    type="password"
                    class="form-control"
                    name="password"
                    id="password"
                    placeholder="Enter your password"
                    required
                />
            </div>
            <div class="mb-3">
                <label for="confirmPassword" class="form-label">Confirm Password</label>
                <input
                    type="password"
                    class="form-control"
                    name="confirmPassword"
                    id="confirmPassword"
                    placeholder="Confirm your password"
                    required
                />
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</body>
</html>
