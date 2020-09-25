<?php  include_once('mysql.php');
		include_once('../controller/generic_functions.php'); ?>
 
<?php
function get_art($val)
{
$obj = new db(); $key=array();
$qry = "select * from af2_master where af_order_id >= $val and af_order_id <=".($val+500)." order by af_order_id ";
$res = $obj->query($qry);
while($data = $obj->fetch($res) )
{
$key['af_order_id'][]=$data['af_order_id'];
$key['af_rush_ck'][]=$data['af_rush_ck'];
$key['af_cust'][]=$data['af_cust'];
$key['af_desc'][]=$data['af_desc'];
$key['af_art_ck'][]=$data['af_art_ck'];
$key['af_redraw_ck'][]=$data['af_redraw_ck'];
$key['af_vector_ck'][]=$data['af_vector_ck'];
$key['af_proof_ck'][]=$data['af_proof_ck'];
$key['af_appr_ck'][]=$data['af_appr_ck'];
$key['af_notes'][]=$data['af_notes'];
$key['af_cust_ck'][]=$data['af_cust_ck'];
$key['af_datetime'][]=$data['af_datetime'];

}

return $key;
}
?>