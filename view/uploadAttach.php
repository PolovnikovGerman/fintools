<?php
include('../model/dev_model.php');
include('../includes/utility_functions.php');
$obj=new db();

if(isset($_POST['uploadAttach']) )
{
$rr = uploadAttach();

if($rr)
echo "<div style=\"background-color:#75bc10; font-family:verdana; color:white; padding:3px; font-size:11px; font-weight:bold; text-align:center;\">Successfully Uploaded</div>";
else
echo "<div style=\"background-color:#FB0000; font-family:verdana; color:white; padding:3px; font-size:11px; font-weight:bold; text-align:center;\">Upload Failed</div>";

}
?>





