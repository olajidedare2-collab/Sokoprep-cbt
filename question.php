<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

if(!isset($_SESSION['start_time'])){
    header("Location: exam.php");
    exit();
}
if(!isset($_SESSION['questions']) || !isset($_SESSION['current_question'])){
    echo "Exam session not found. Please start the exam again.";
    exit();
}

$questions = $_SESSION['questions'];
if(empty($questions)){
    echo "No questions loaded!";
    exit();
}
$current = $_SESSION['current_question'] ?? 0;

if(!isset($questions[$current])){
    $current = 0;
    $_SESSION['current_question'] = 0;
}

$question = $questions[$current] ?? null;

if(!$question){
    echo "Error loading question. Please restart exam.";
    exit();
}

$total = count($questions);
$selected = $_SESSION['answers'][$current] ?? '';
$answered = count($_SESSION['answers']);
?>

<!DOCTYPE html>
<html>

<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="style.css">
</head>

<body>
    
<div class="container cbt-container">

<?php if(isset($_SESSION['payment_status']) && $_SESSION['payment_status'] != 'paid'){ ?>
    <div style="background:#fff3cd; padding:10px; text-align:center; margin-bottom:10px;">
        🔒 Free Mode (Limited Access) |
        <a href="upgrade.php" style="font-weight:bold; color:blue; margin-left:10px;">
            Upgrade Now
        </a>
    </div>
<?php } ?>
<div class="header">
    <div class="header-row">

<div class="title">SokoPrep CBT</div>

<div class="timer">
⏱ <span id="timer">30:00</span>
</div>

<div class="answered">
Answered: <?php echo $answered; ?> / <?php echo $total; ?>
</div>

</div>

</div>
<div class="exam-layout">

    <!-- LEFT SIDE -->
    <div class="exam-left">

        <h3>Question <?php echo $current + 1; ?> of <?php echo $total; ?></h3>

       <form id="examForm" action="next_question.php" method="POST">

            <div class="question">
                <?php echo $question['question_text']; ?>
            </div>

            <div class="options">

                <label>
                    <input type="radio" name="answer" value="A" <?php if($selected=='A') echo 'checked'; ?>>
                    <?php echo $question['option_a']; ?>
                </label>

                <label>
                    <input type="radio" name="answer" value="B" <?php if($selected=='B') echo 'checked'; ?>>
                    <?php echo $question['option_b']; ?>
                </label>

                <label>
                    <input type="radio" name="answer" value="C" <?php if($selected=='C') echo 'checked'; ?>>
                    <?php echo $question['option_c']; ?>
                </label>

                <label>
                    <input type="radio" name="answer" value="D" <?php if($selected=='D') echo 'checked'; ?>>
                    <?php echo $question['option_d']; ?>
                </label>

            </div>

            <div class="exam-buttons">

                <?php if($current > 0){ ?>
                <button type="submit" name="action" value="previous">Previous</button>
                <?php } ?>

                <?php if($current < $total - 1){ ?>
                <button type="submit" name="action" value="next">Next</button>
                <?php } ?>

                <?php if($current == $total - 1){ ?>
                <button type="button" onclick="confirmSubmit()">Submit Exam</button>
                <?php } ?>

            </div>

        </form>

    </div>

    <!-- RIGHT SIDE -->
    <div class="exam-right">

        <h4>Questions</h4>

<div class="legend">
    <span class="box current"></span> Current
    <span class="box answered"></span> Answered
    <span class="box"></span> Not Answered
</div>
<div class="question-grid">
<?php
for($n = 0; $n < $total; $n++){

    $qnum = $n + 1;
    $class = "";

    if(isset($_SESSION['answers'][$n])){
        $class = "answered";
    }

    if($n == $current){
        $class = "current";
    }

    echo "<a href='jump.php?q=$n' class='$class'>$qnum</a>";
}
?>
</div>
    </div>

</div>

<script>

var examDuration = 1800; // 30 mins

// ✅ use remaining time instead
var startTime = new Date().getTime();

var endTime = startTime + (examDuration * 1000);

var submitted = false;

function forceSubmit(){

    if(submitted) return;
    submitted = true;

    let form = document.getElementById("examForm");

    let input = document.createElement("input");
    input.type = "hidden";
    input.name = "action";
    input.value = "submit";

    form.appendChild(input);
    form.submit();
}

function updateTimer(){

    var now = new Date().getTime();
    var timeLeft = Math.floor((endTime - now) / 1000);
    console.log(timeLeft);
    if(timeLeft <= 0){

        document.getElementById("timer").innerHTML = "00:00";

        alert("Time is up! Exam will be submitted.");

        forceSubmit();
        return;
    }

    var minutes = Math.floor(timeLeft / 60);
    var seconds = timeLeft % 60;

    if(seconds < 10){
        seconds = "0" + seconds;
    }

    document.getElementById("timer").innerHTML = minutes + ":" + seconds;
}

updateTimer();
setInterval(updateTimer,1000);

function confirmSubmit(){
    if(confirm("Are you sure you want to submit?")){
        forceSubmit();
    }
}

</script>
</body>
</html>