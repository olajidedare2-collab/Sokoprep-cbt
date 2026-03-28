<?php 
session_start();
include 'db.php';

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

if(!isset($_SESSION['questions'])){
    echo "No exam data found.";
    exit();
}

/* Get user */
$user_id = $_SESSION['user_id'];
$user_sql = "SELECT payment_status FROM users WHERE id='$user_id'";
$user_result = mysqli_query($conn,$user_sql);
$user = mysqli_fetch_assoc($user_result);

/* Process result */
$questions = $_SESSION['questions'];
$answers = $_SESSION['answers'];

$total = count($questions);

/* =========================
   1. CALCULATE SCORE
========================= */
$score = 0;

foreach($questions as $index => $q){
    $correct = strtoupper($q['correct_option']);
    $user_answer = $answers[$index] ?? "";

    if($user_answer == $correct){
        $score++;
    }
}

/* =========================
   2. CALCULATE PERCENT
========================= */
$percent = round(($score / $total) * 100);

/* Pass/Fail */
$status = ($percent >= 50) ? "PASS" : "FAIL";
$status_class = ($percent >= 50) ? "pass" : "fail";

/* Save result */
$ministry = $_SESSION['ministry'];
$level = $_SESSION['level'];

$sql_result = "INSERT INTO result (user_id, ministry, level, score) 
VALUES ('$user_id', '$ministry', '$level', '$score')";

mysqli_query($conn, $sql_result);

/* Count total exams taken */
$count_sql = "SELECT COUNT(*) as total FROM result WHERE user_id='$user_id'";
$count_result = mysqli_query($conn,$count_sql);
$count_data = mysqli_fetch_assoc($count_result);
$total_exams_taken = $count_data['total'];
?>

<link rel="stylesheet" href="style.css">

<div class="result-container">

<h2>Exam Result</h2>

<div class="result-score">
    <?php echo $score; ?> / <?php echo $total; ?>
</div>

<p><strong>Percentage:</strong> <?php echo $percent; ?>%</p>

<p class="<?php echo $status_class; ?>">
    <?php echo $status; ?>
</p>
<?php
if($percent >= 50){
    echo "<p style='color:green; font-weight:bold;'>Good job! You passed.</p>";
}else{
    echo "<p style='color:red; font-weight:bold;'>You need improvement. Keep practicing.</p>";
}
?>
<!-- =========================
     3. REVIEW SECTION
========================= -->
<button onclick="showWrong()">Show Only Wrong Answers</button>
<h3 style="margin-top:30px;">Review Answers</h3>

<?php
foreach($questions as $index => $q){

    $correct = strtoupper($q['correct_option']);
    $user_answer = $answers[$index] ?? "Not answered";

    $options = [
        "A" => $q['option_a'],
        "B" => $q['option_b'],
        "C" => $q['option_c'],
        "D" => $q['option_d']
    ];

    echo "<div class='review-box'>";

    echo "<p><strong>Q".($index+1).":</strong> ".$q['question_text']."</p>";

    $user_text = isset($options[$user_answer]) ? $options[$user_answer] : "Not answered";
$correct_text = $options[$correct];

echo "<p><strong>Your Answer:</strong> ".$user_text."</p>";
echo "<p><strong>Correct Answer:</strong> ".$correct_text."</p>";

    foreach($options as $key => $value){

     $class = "";
$label = "";

if($key == $correct && $user_answer != $correct){
    $class = "correct";
    $label = " (Correct Answer)";
}

if($key == $user_answer){
    $class = ($user_answer == $correct) ? "correct" : "wrong";
    $label = " (Your Choice)";
}

        echo "<div class='review-option $class'>";

        if($key == $user_answer){
            echo "<strong>$key. $value</strong>";
        } else {
            echo "$key. $value $label";
        }

        echo "</div>";
    }

    echo "</div>";
}
?>

<!-- FREE USER WARNING -->
<?php if($user['payment_status'] != "paid"){ ?>

    <p style="color:red; margin-top:10px;">
        You are using free access (max 3 exams).
    </p>

    <?php if($total_exams_taken >= 3){ ?>
        <p style="color:red; font-weight:bold;">
            You have reached your free limit. Please upgrade to continue.
        </p>

        <a href="upgrade.php" class="btn-primary">Upgrade Now</a>
    <?php } ?>

<?php } ?>

<!-- BUTTONS -->
<div style="margin-top:20px; display:flex; gap:10px; justify-content:center; flex-wrap:wrap;">

<a href="exam.php" class="btn-primary">Take Another Exam</a>

<a href="dashboard.php" class="btn-secondary">Back to Dashboard</a>

<a href="logout.php" class="btn-danger">Logout</a>

</div>

</div>
<script>
function showWrong(){
    document.querySelectorAll('.review-box').forEach(box => {
        if(!box.querySelector('.wrong')){
            box.style.display = 'none';
        }
    });
}
</script>