<?php
include('../model/af_model.php');
include('../includes/utility_functions.php');
$obj=new db();
if(isset($_POST['upload']) && $_POST['upload'] == 'Upload' && sizeof($_FILES['fileX']['name']) > 1)
{
$rr = attach_files();
if($rr>0)
echo "<div style=\"background-color:#75bc10; font-family:verdana; color:white; padding:3px; font-size:11px; font-weight:bold; text-align:center;\">Upload Succesfull</div>";
else
echo "<div style=\"background-color:#FB0000; font-family:verdana; color:white; padding:3px; font-size:11px; font-weight:bold; text-align:center;\">Upload Failed</div>";

}

?>
