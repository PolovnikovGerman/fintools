<?php

echo "<pre>";
print_r($_POST);
echo "</pre>";

$arr = str_replace("\n",'GOT HERE',$_POST['r2_ven_msg']);
echo "<pre>";
print_r($arr);
echo "</pre>";


?>