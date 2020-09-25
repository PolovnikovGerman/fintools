<?php
include('../model/af_model.php');
include('../includes/utility_functions.php');
$obj=new db();
if(isset($_POST['upload']) && $_POST['upload'] == 'Upload' && sizeof($_FILES['fileX']['name']) > 1)
{
echo attach_files();
}


?>