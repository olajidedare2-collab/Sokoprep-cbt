<?php
session_start();
include 'db.php';

if($_SERVER["REQUEST_METHOD"] == "POST"){

$ministry = $_POST['ministry'];
$level = $_POST['level'];
$question = $_POST['question'];
$a = $_POST['option_a'];
$b = $_POST['option_b'];
$c = $_POST['option_c'];
$d = $_POST['option_d'];
$correct = $_POST['correct'];

$sql = "INSERT INTO questions 
(ministry, level, question_text, option_a, option_b, option_c, option_d, correct_option)
VALUES ('$ministry','$level','$question','$a','$b','$c','$d','$correct')";

mysqli_query($conn,$sql);

echo "Question added successfully!";
}
?>

<h2>Add CBT Question</h2>

<form method="POST">

Ministry:<br>
<input type="text" name="ministry" required><br><br>

Level:<br>
<input type="text" name="level" required><br><br>

Question:<br>
<textarea name="question" required></textarea><br><br>

Option A:<br>
<input type="text" name="option_a" required><br><br>

Option B:<br>
<input type="text" name="option_b" required><br><br>

Option C:<br>
<input type="text" name="option_c" required><br><br>

Option D:<br>
<input type="text" name="option_d" required><br><br>

Correct Option:<br>
<select name="correct">
<option value="A">A</option>
<option value="B">B</option>
<option value="C">C</option>
<option value="D">D</option>
</select><br><br>

<button type="submit">Add Question</button>

</form>