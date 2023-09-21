<?php
session_start();
if (!$_SESSION['uid']) {
    header("location:../index.php");
}
require_once('../model/surveys_model.php');
require_once('../includes/utility_functions.php');
$obj=new db();

$survey = getSurvey('button_survey');

ob_end_flush();

?>