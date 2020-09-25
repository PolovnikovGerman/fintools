<?php
ob_start();
session_start();
if(!session_is_registered(myusername))
header("location:../index.php");
include('../model/competitor_model.php');
include('../includes/utility_functions.php');



$data = getReport();


ob_end_flush();
?>