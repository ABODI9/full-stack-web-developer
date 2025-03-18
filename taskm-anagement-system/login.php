<?php
include 'action.php';
session_start();


if($_SERVER["REQUEST_METHOD"] == "POST")
{
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email']; // Email field

    // ✅ Ensure we also retrieve `id` (user_id) for session storage
    $sql = "SELECT id, username, email, password FROM users WHERE username=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $db_username, $db_email, $hashed_password);
        $stmt->fetch();

        // ✅ Ensure email matches the stored email
        if ($db_email == $email) {
            if (password_verify($password, $hashed_password)) {
                $_SESSION['user_id'] = $id;  // ✅ Store `user_id` in the session
                $_SESSION['username'] = $db_username; // Store username as well

                // ✅ Redirect to view_tasks.php instead of view.php
                header("Location: view_tasks.php");
                exit();
            } else {
                echo "<script>alert('Invalid Password');</script>";
            }
        } else {
            echo "<script>alert('Email does not match');</script>";
        }
    } else {
        echo "<script>alert('User not found. Redirecting to register...');</script>";
        header("Location: register.php");
        exit();
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</head>
<body>
<form action="Login.php" method="post">
    <label for="username">UserName:</label>
    <input type="text" name="username" id="username" placeholder="Enter username" class="form-control" required>
    <br>

    <label for="email">Email:</label> <!-- إضافة حقل البريد الإلكتروني -->
    <input type="email" name="email" id="email" placeholder="Enter email" class="form-control" required>
    <br>
  
    <label for="password" >Password :</label>
    <input type="password" name="password" id="password" placeholder="Enter password" class="form-control" required>
    <br>
    <button type="submit" class="btn btn-dark">Login</button>
    <a href="register.php" class="btn btn-primary">Register</a>
</form>
</body>
</html>
