<?php
include('../../model/mysql.php');
$obj=new db();

$qry="select i_itemid, i_desc from af_items order by i_itemid ASC";
$res=$obj->query($qry);
while($newarray=$obj->fetch($res))
{
$itemid[]=$newarray['i_itemid'];
$desc[]=$newarray['i_desc'];

}
 
   
  $doc = new DOMDocument(); 
  $doc->formatOutput = true; 
   
  $r = $doc->createElement( "items" ); 
  $doc->appendChild( $r ); 
   
  for($i=0;$i<sizeof($itemid);$i++)
  { 
  $b = $doc->createElement( "item" ); 
   
  $num = $doc->createElement( "itemid" ); 
  $num->appendChild( $doc->createTextNode( $itemid[$i] ) ); 
  $b->appendChild( $num ); 
  
  $num = $doc->createElement( "description" ); 
  $num->appendChild( $doc->createTextNode( $desc[$i] ) ); 
  $b->appendChild( $num ); 
  
   
  $r->appendChild( $b ); 
  } 
   
  echo $doc->saveXML(); 
  $doc->save("items.xml") 
?>