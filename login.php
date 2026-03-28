<?php
ob_start();
session_start();
include("db.php");

$message = "";

if(isset($_POST['login'])){

    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    $email = mysqli_real_escape_string($conn, $email);
    $password = mysqli_real_escape_string($conn, $password);

    $sql = "SELECT * FROM users WHERE email='$email' AND password='$password'";
    $result = mysqli_query($conn, $sql);

    if(!$result){
        die("SQL ERROR: " . mysqli_error($conn));
    }

    // ✅ THIS IS THE MISSING CHECK
    if(mysqli_num_rows($result) > 0){

        $user = mysqli_fetch_assoc($result);

        $_SESSION['user_id'] = $user['id'];
        $_SESSION['ministry'] = $user['Ministry'];
        $_SESSION['level'] = $user['Level'];

        header("Location: dashboard.php");
        exit();

    }else{
        $message = "<p style='color:red; text-align:center;'>Invalid email or password</p>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
</head>

<body>

<div class="auth-container">
    <h2>SokoPrep CBT Login</h2>

    <?php echo $message ?? ''; ?>

    <form method="POST">

        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" required>
        </div>

        <div class="form-group">
            <label>Password</label>
            <input type="password" name="password" required>
        </div>

        <button class="auth-btn" name="login">Login</button>

    </form>

    <a href="register.php" class="link-btn">Create Account</a>
</div>

</body>
</html>