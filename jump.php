<?php
session_start();

if(!isset($_SESSION['questions'])){
    header("Location: dashboard.php");
    exit();
}

$q = isset($_GET['q']) ? intval($_GET['q']) : 0;

$_SESSION['current_question'] = $q;

header("Location: question.php");
exit();
?>