<?php
session_start();
include("db.php");

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

/* Get user info */
$user_sql = "SELECT full_name, payment_status FROM users WHERE id='$user_id'";
$user_result = mysqli_query($conn,$user_sql);
$user = mysqli_fetch_assoc($user_result);

/* Get stats */
$exam_sql = "SELECT COUNT(*) as total_exams, MAX(score) as best_score FROM result WHERE user_id='$user_id'";
$exam_result = mysqli_query($conn,$exam_sql);
$stats = mysqli_fetch_assoc($exam_result);

$total_exams = $stats['total_exams'];
$best_score = $stats['best_score'] ?? 0;
?>

<!DOCTYPE html>
<html>

<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="style.css">
</head>

<body>
<!-- ✅ NAVBAR -->
<div style="background:#0d6efd; color:white; padding:12px 20px; display:flex; justify-content:space-between;">
    <strong>SokoPrep CBT</strong>
    <span>
    <?php echo $user['full_name']; ?> 👋 |
    <a href="logout.php" style="color:white; text-decoration:none;">Logout</a>
</span>
</div>

<link rel="stylesheet" href="style.css">

<!-- ✅ NOW HTML CONTENT -->
<div class="container dashboard-container">

<h1>Welcome to SokoPrep CBT</h1>

<h3>Hello, <?php echo $user['full_name']; ?></h3>

<p>You are successfully logged in.</p>

<hr>

<h3>Account Status</h3>

<?php if($user['payment_status'] == 'paid'){ ?>

    <p class="pass">Premium Account ✅</p>

<?php } else { ?>

   <p class="fail">
    Free Account 🔓 <br>
    <a href="upgrade.php" class="upgrade-btn">Upgrade Now</a>
</p>

<?php } ?>

<hr>

<h3>Your Statistics</h3>

<div class="stats-box">

    <div class="stat-card">
        <h4>Exams Taken</h4>
        <h2><?php echo $total_exams; ?></h2>
    </div>

    <div class="stat-card">
        <h4>Best Score</h4>
        <h2><?php echo $best_score; ?></h2>
    </div>

</div>

<hr>

<div class="dashboard-links">
    <a class="btn-primary" href="exam.php">Start CBT Exam</a>
    <a class="btn-secondary" href="result_history.php">My Exam History</a>
    <a class="btn-danger" href="logout.php">Logout</a>
</div>

</div>
</body>
</html>