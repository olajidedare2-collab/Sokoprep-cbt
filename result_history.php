<?php
session_start();
include("db.php");

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

/* Fetch results */
$sql = "SELECT * FROM result WHERE user_id='$user_id' ORDER BY id DESC";
$result = mysqli_query($conn,$sql);
?>

<link rel="stylesheet" href="style.css">

<div class="container">

<h2>My Exam History</h2>

<table class="history-table">

<tr>
<th>Date</th>
<th>Ministry</th>
<th>Level</th>
<th>Score</th>
<th>Percentage</th>
<th>Status</th>
</tr>

<?php while($row = mysqli_fetch_assoc($result)){ 

    $score = $row['score'];
    $total = 60; // your exam total
    $percent = round(($score / $total) * 100);

    if($percent >= 50){
        $status = "<span class='badge-pass'>PASS</span>";
    }else{
        $status = "<span class='badge-fail'>FAIL</span>";
    }
?>

<tr>
<td><?php echo $row['created_at'] ?? '---'; ?></td>
<td><?php echo $row['ministry']; ?></td>
<td><?php echo $row['level']; ?></td>
<td><?php echo $score; ?> / <?php echo $total; ?></td>
<td><?php echo $percent; ?>%</td>
<td><?php echo $status; ?></td>
</tr>

<?php } ?>

</table>

<br>

<a href="dashboard.php" class="btn-primary">Back to Dashboard</a>

</div>