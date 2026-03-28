<?php
session_start();
include 'db.php';

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$ministry = $_SESSION['ministry'];
$level = $_SESSION['level'];

/* Get user payment status */
$user_sql = "SELECT payment_status FROM users WHERE id='$user_id'";
$user_result = mysqli_query($conn, $user_sql);
$user = mysqli_fetch_assoc($user_result);

/* 🚫 BLOCK FREE USERS AFTER 3 EXAMS */
if($user['payment_status'] != "paid"){

    $count_sql = "SELECT COUNT(*) as total FROM result WHERE user_id='$user_id'";
    $count_result = mysqli_query($conn, $count_sql);
    $count_data = mysqli_fetch_assoc($count_result);

    if($count_data['total'] >= 3){

        echo "<div style='text-align:center; margin-top:100px;'>";
        echo "<h2 style='color:red;'>Free Limit Reached 🚫</h2>";
        echo "<p>You have used your 3 free exams.</p>";
        echo "<p>Please upgrade to continue.</p>";
        echo "<a href='upgrade.php' class='btn-primary'>Upgrade Now</a>";
        echo "</div>";

        exit();
    }
}

/* ✅ SELECT QUESTIONS */

// Paid → 60 questions | Free → 5 questions
if($user['payment_status'] == 'paid'){
    $limit = 60;
} else {
    $limit = 5;
}

$sql = "SELECT * FROM questions ORDER BY RAND() LIMIT $limit";
$result = mysqli_query($conn, $sql);

if(!$result){
    die("Error selecting questions: " . mysqli_error($conn));
}

$questions = [];

while($row = mysqli_fetch_assoc($result)){
    $questions[] = $row;
}

/* Ensure questions exist */
if(count($questions) == 0){
    die("No questions found. Please contact admin.");
}

/* ✅ SET TIMER (ONLY ONCE) */
$_SESSION['start_time'] = time();

/* Save questions in session */
$_SESSION['questions'] = $questions;
$_SESSION['current_question'] = 0;
$_SESSION['answers'] = [];

/* Redirect to exam page */
header("Location: question.php");
exit();
?>