<?php
ob_start();
session_start();
if (!$_SESSION['uid']) {
    header("location:../index.php");
}
include('../model/fl_vi_model.php');
include('../includes/utility_functions.php');
$obj=new db();


$key_vi = array();
$key_vi = get_ven_list();
echo $key_vi[0]->v_email;
echo "<pre>";
print_r($key_vi);
echo "</pre>";

ob_end_flush();


?>