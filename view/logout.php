<?php

session_start();

# $_SESSION['username']=="";
$_SESSION=array();
session_destroy();
session_unset();

 header("location:../index.php");

?>	