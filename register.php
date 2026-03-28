<?php
include("db.php");

$message = "";

if(isset($_POST['register'])){

    $name = $_POST['full_name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $ministry = $_POST['ministry'];
    $level = $_POST['level'];

    $sql = "INSERT INTO users (full_name,email,password,ministry,level,payment_status)
            VALUES ('$name','$email','$password','$ministry','$level','pending')";

    if(mysqli_query($conn,$sql)){
        $message = "<p style='color:green; text-align:center;'>Registration successful!</p>";
    }else{
        $message = "<p style='color:red; text-align:center;'>Error: ".mysqli_error($conn)."</p>";
    }
}
?>

<link rel="stylesheet" href="style.css">

<div class="auth-container">

<h2>Create SokoPrep Account</h2>

<?php echo $message; ?>

<form method="POST">

<div class="form-group">
<label>Full Name</label>
<input type="text" name="full_name" required>
</div>

<div class="form-group">
<label>Email</label>
<input type="email" name="email" required>
</div>

<div class="form-group">
<label>Password</label>
<input type="password" name="password" required>
</div>

<div class="form-group">
<label>Ministry</label>
<select name="ministry" required>
<option value="">Select Ministry</option>
<option value="EDUCATION">Education</option>
<option value="HEALTH">Health</option>
<option value="FINANCE">Finance</option>
<option value="AGRICULTURE">Agriculture</option>
<option value="CIVIL SERVICE">Civil Service</option>
</select>
</div>

<div class="form-group">
<label>Level</label>
<select name="level" required>
<option value="">Select Level</option>
<option value="6">Level 6</option>
<option value="7">Level 7</option>
<option value="8">Level 8</option>
<option value="9">Level 9</option>
<option value="10">Level 10</option>
<option value="12">Level 12</option>
<option value="13">Level 13</option>
<option value="14">Level 14</option>
<option value="15">Level 15</option>
<option value="16">Level 16</option>
<option value="17">Level 17</option>
</select>
</div>

<button class="auth-btn" type="submit" name="register">Register</button>

</form>

<a href="login.php" class="link-btn">Back to Login</a>

</div>