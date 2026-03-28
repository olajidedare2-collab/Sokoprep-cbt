<?php
session_start();

if(!isset($_SESSION['user_id'])){
    die("Access denied");
}

include "db.php";

if(isset($_POST['import'])){

$file = $_FILES['file']['tmp_name'];

$handle = fopen($file,"r");

fgetcsv($handle); // skip header row

while(($data = fgetcsv($handle,1000,",")) !== FALSE){
$ministry = $data[0];
$level = $data[1];
$question = mysqli_real_escape_string($conn,$data[2]);
$a = mysqli_real_escape_string($conn,$data[3]);
$b = mysqli_real_escape_string($conn,$data[4]);
$c = mysqli_real_escape_string($conn,$data[5]);
$d = mysqli_real_escape_string($conn,$data[6]);
$correct = $data[7];
$access = $data[8];

$sql = "INSERT INTO questions
(ministry,level,question_text,option_a,option_b,option_c,option_d,correct_option,access_type)

VALUES

('$ministry','$level','$question','$a','$b','$c','$d','$correct','$access')";

mysqli_query($conn,$sql);

}

echo "Questions imported successfully.";

}
?>

<h2>Import Questions (CSV)</h2>

<form method="POST" enctype="multipart/form-data">

<input type="file" name="file" required>

<br><br>

<button name="import">Upload CSV</button>

</form>