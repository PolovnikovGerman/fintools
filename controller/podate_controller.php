<?php
ob_start();
session_start();
if(!session_is_registered(myusername)) {
    header("location:../index.php");
} else {
    include('../model/podate_model.php');
    include('../includes/utility_functions.php');
    $obj=new db();

    ////////////////////////////***************************************** SAVE AND CLOSE ****************************************///////////////////////////////////
    ////////////////////////////***************************************** SAVE AND CLOSE ****************************************///////////////////////////////////
    $ven_list = $obj->get_ven_list();
    $num_recs = get_podate_count();

    $key=array(); $att=array();
    $num_recs=  get_podate_count();
    $curpage=0;
}

?>