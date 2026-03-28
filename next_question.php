<?php
session_start();

if(!isset($_SESSION['questions'])){
    header("Location: dashboard.php");
    exit();
}

$questions = $_SESSION['questions'];
$current = $_SESSION['current_question'];

/* Save answer safely */
if(isset($_POST['answer'])){
    $_SESSION['answers'][$current] = $_POST['answer'];
}

/* Handle actions */
if(isset($_POST['action'])){

    if($_POST['action'] == "submit"){
        header("Location: submit_exam.php");
exit();
    }

    if($_POST['action'] == "next"){
        $current++;
    }

    if($_POST['action'] == "previous"){
        $current--;
    }

}

/* Prevent going outside range */
if($current < 0){
    $current = 0;
}

if($current >= count($questions)){
    header("Location: submit_exam.php");
    exit();
}

/* Update session */
$_SESSION['current_question'] = $current;

/* Return to question page */
header("Location: question.php");
exit();
?>