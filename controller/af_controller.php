<?php
ob_start();
session_start();
//if(!session_is_registered(myusername))
//header("location:../index.php");
include('../model/af_model.php');
include('../includes/utility_functions.php');
$obj=new db();

////////////////////////////***************************************** SAVE AND CLOSE ****************************************///////////////////////////////////
////////////////////////////***************************************** SAVE AND CLOSE ****************************************///////////////////////////////////
if(isset($_POST['upload']) && $_POST['upload'] == 'Upload' && sizeof($_FILES['fileX']['name']) > 1)
{
$key = attach_files();
}

$key=array();
if(isset($_GET['or']) && is_numeric($_GET['or']) )
{
$_SESSION['or']=$_GET['or'];
$key = get_art();

}
else
$key = get_art();

// Write code if "open" button is clicked call get files list from DB

$att = chk_attach_files();


ob_end_flush();


?>