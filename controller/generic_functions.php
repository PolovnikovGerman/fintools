<?php
//function to find extention of a passed file name.
function findexts($filename)
{
	$filename = strtolower($filename) ; 
	$exts = preg_split("[/\\.]", $filename) ;
	$n = count($exts)-1; 
	$exts = $exts[$n]; 
	return $exts; 
} 