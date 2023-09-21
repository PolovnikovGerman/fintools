<?php
ob_start();
session_start();
if (!$_SESSION['uid']) {
    header("location:../index.php");
}
include('../model/competitor_model.php');
include('../includes/utility_functions.php');



$data = getReport();


ob_end_flush();
?>