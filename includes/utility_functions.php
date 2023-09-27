<?php
function col_bg($color,$pos)
{
if($pos%2 == 0)
return "bgcolor=\"".$color."\"";
else
return "bgcolor=\"white\"";

}

function parr($arr)
{
	echo "<pre>";
	print_r($arr);
	echo "</pre>";
}
function col_bg_leads($type, $pos, $scheme = false)
{
if($scheme){
if($pos%2 != 0)
switch($type)
	{
		case 1: return "bgcolor=#faf7a1";
				break;
		case 2: return "bgcolor=#f0f0f0";
				break;
		case 3: return "bgcolor=#cfa0bf";
				break;
		case 4: return "bgcolor=#d6ebfe";
				break;
		default: return "bgcolor=white";
}
else
switch($type)
	{
		case 1: return "bgcolor=#fbde1f";
				break;
		case 2: return "bgcolor=white";
				break;
		case 3: return "bgcolor=#b35895";
				break;
		case 4: return "bgcolor=#91c9fc";
				break;		
		default: return "bgcolor=white";
	}
}//close of if scheme
else
if($type == 2)
	if($pos%2 != 0)
		return "bgcolor=white";
	else
		return "bgcolor=#f0f0f0";
else
	switch($type)
	{
		case 1: return "bgcolor=#fbde1f";
				break;
		case 2: return "bgcolor=white";
				break;
		case 3: return "bgcolor=#b35895";
				break;
		case 4: return "bgcolor=#91c9fc";
				break;		
		default: return "bgcolor=white";
	}
}


function format_date($d)
{
if(is_numeric($d) && strlen($d) == 6)
return "20".substr($d,4,2)."-".substr($d,0,2)."-".substr($d,2,2);

if (preg_match('/^\d{1,2}\/\d{1,2}\/\d{2}$/', $d)) 
return "20".substr($d,6,2)."-".substr($d,0,2)."-".substr($d,3,2);
else
return "2090-12-30";
}

function print_date($d)
{
if($d == '2090-12-30' || $d == '0000-00-00') return '';
if(!empty($d))
return substr($d,5,2)."/".substr($d,8,2)."/".substr($d,2,2);
else
return '';
}

$po_title = array(0 => 'B', 1 => 'C', 2 => 'D' ); 
$userNames = array(1=> 'Sean', 2=> 'Sage', 4=>'Nick', 5=>'frank', 7=>'Jay', 8=>'Lisa', 9=>'Lucky', 10=>'Taisen', 11=>'Randy', 12=>'Cris');
function emailTemplate($type, $param)
{
switch($type){
case 'po':
return "Dear $param[0],<br><br>Attached you will find purchase order # $param[1].  For printed orders the art should be attached.  We ask that you confirm receipt of this order by <a href='www.bluetrack.net/vendors' >clicking here</a>.<br><br> You can also view recent POs and art from BLUETRACK by visiting our Vendor Center at http://www.bluetrack.net/vendors.  If you have any questions please let us know. <br><br>
Sincerely,<br>
Fulfillment Team<br>
BLUETRACK, Inc.<br>
Tel: 201-902-9960<br>
Email: ff@bluetrack.com ";
break;

case 'clayChange':
$ret="Dear $param[0],<br><br>

      The customer requested a change to the Clay Model for PO #$param[1], which is the order for :<br>
	  <ul>";
	  for($i=0;$i<sizeof($param['items']);$i++)
	  $ret.="<li>".$param['items'][$i]."</li>";
	  
	  $ret.="</ul><b>Instructions:&nbsp; </b>$param[2].<br><br>


Sincerely,<br>

Art Dept<br>

BLUETRACK, Inc.<br>

Tel: 201-902-9960<br>

Email: art@bluetrack.com";
return $ret;
break;

case 'prvChange':
$ret="Dear $param[0],<br><br>

      The customer requested a change to the Preview Pictures for PO #$param[1], which is the order for: <ul>";
	  for($i=0;$i<sizeof($param['items']);$i++)
	  $ret.="<li>".$param['items'][$i]."</li>";
	  
	  $ret.="</ul><b>Instructions:&nbsp; </b>$param[2].<br><br>


Sincerely,<br>

Art Dept<br>

BLUETRACK, Inc.<br>

Tel: 201-902-9960<br>

Email: art@bluetrack.com";
return $ret;
break;

case 'clayApproved':
$ret = "Dear $param[0],<br><br>

      The customer approved the clay model for PO # $param[1], the order for :<br>
	  <ul>";
	  for($i=0;$i<sizeof($param['items']);$i++)
	  $ret.="<li>".$param['items'][$i]."</li>";
	  
	  $ret.="</ul><br>  Please check the Bluetrack system at http://www.bluetrack.net/vendors to verify and proceed with the next stage in production. <br><br>

Sincerely,<br>

Fulfillment Team<br>

BLUETRACK, Inc.<br>

Tel: 201-902-9960<br>

Email: ff@bluetrack.com";
return $ret;
break;

case 'prvApproved':
$ret="Dear $param[0],<br><br>

      The customer approved the preview pics for PO# $param[1], the order for :<br>
	  <ul>";
	  for($i=0;$i<sizeof($param['items']);$i++)
	  $ret.="<li>".$param['items'][$i]."</li>";
	  
	  $ret.="</ul><br>  Please check the Bluetrack system at http://www.bluetrack.net/vendors to verify and proceed with the next stage in production. <br><br>

Sincerely,<br>

Fulfillment Team<br>

BLUETRACK, Inc.<br>

Tel: 201-902-9960<br>

Email: ff@bluetrack.com";
return $ret;
break;

case 'emailPassword':
return "Dear $param[0],<br><br>

You have been registered for BLUETRACK's Vendor System. A link to the system will be provided on each PO email but you can also access the system anytime at http://www.bluetrack.net/vendors.<br><br>

User Name :&nbsp; <b>$param[1]</b><br>

Password  :&nbsp; <b>$param[2]</b><br><br>

Please hold onto this email in a secure place for your easy, future reference. If you have any questions let us know.<br><br>



Fulfillment Team<br>

BLUETRACK, Inc.<br>

201-902-9960<br>

ff@bluetrack.com";

}
return FALSE;
}



 
function send_email_attach($too, $sub, $msg, $paths, $names)
{ 
// email fields: to, from, subject, and so on
$files =array();
$filenames = array();
$files = $paths;
$filenames = $names;
$from = "ff@bluetrack.com";
$to = $too; 
$subject =$sub;

$message = $msg;
$headers = "From: $from";
 
// boundary 
$semi_rand = md5(time()); 
$mime_boundary = "==Multipart_Boundary_x{$semi_rand}x"; 
 // headers for attachment 
$headers .= "\nMIME-Version: 1.0\n" . "Content-Type: multipart/mixed;\n" . " boundary=\"{$mime_boundary}\""; 
 // multipart boundary 
$message = "This is a multi-part message in MIME format.\n\n" . "--{$mime_boundary}\n" . "Content-Type: text/html; charset=\"iso-8859-1\"\n" . "Content-Transfer-Encoding: 7bit\n\n" . $message . "\n\n"; 
$message .= "--{$mime_boundary}\n";
 
// preparing attachments
for($x=0;$x<count($files);$x++){
	if (file_exists($files[$x])) {
		$file = fopen($files[$x],"rb");
		$data = fread($file,filesize($files[$x]));
		fclose($file);
		$data = chunk_split(base64_encode($data));
		$message .= "Content-Type: {\"application/octet-stream\"};\n" . " name=\"$files[$x]\"\n" .
			"Content-Disposition: attachment;\n" . " filename=\"$filenames[$x]\"\n" .
			"Content-Transfer-Encoding: base64\n\n" . $data . "\n\n";
		$message .= "--{$mime_boundary}\n";
	}
}
 
// send
// @mail('bluetrack_niladhar@hotmail.com',$subject, $message, $headers);
$ok = @mail($to, $subject, $message, $headers);
$obj = new db();
if($ok)  
{
$qry = "insert into email_conf values(null,'$to','$from',now(),'$sub','yes','success')";
$obj->query($qry);
return 1;
}
else  
{
$qry = "insert into email_conf values(null,'$to','$from',now(),'$sub','yes','failed')";
$obj->query($qry);
return 0;
 }

}

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


function send_email_TEXT($too, $sub, $msg, $frm = 'ff@bluetrack.com')
{ 
// email fields: to, from, subject, and so on
$files =array();
$filenames = array();
$files = $paths;
$filenames = $names;
$from = $frm;
$to = $too; 
$subject =$sub;

$message = $msg;
$headers = "From: $from";
 
// boundary 
$semi_rand = md5(time()); 
$mime_boundary = "==Multipart_Boundary_x{$semi_rand}x"; 
 // headers for attachment 
$headers .= "\nMIME-Version: 1.0\n" . "Content-Type: multipart/mixed;\n" . " boundary=\"{$mime_boundary}\""; 
 // multipart boundary 
$message = "This is a multi-part message in MIME format.\n\n" . "--{$mime_boundary}\n" . "Content-Type: text/html; charset=\"iso-8859-1\"\n" . "Content-Transfer-Encoding: 7bit\n\n" . $message . "\n\n"; 
$message .= "--{$mime_boundary}\n";
 
// preparing attachments
/*for($x=0;$x<count($files);$x++){
	$file = fopen($files[$x],"rb");
	$data = fread($file,filesize($files[$x]));
	fclose($file);
	$data = chunk_split(base64_encode($data));
	$message .= "Content-Type: {\"application/octet-stream\"};\n" . " name=\"$files[$x]\"\n" . 
	"Content-Disposition: attachment;\n" . " filename=\"$filenames[$x]\"\n" . 
	"Content-Transfer-Encoding: base64\n\n" . $data . "\n\n";
	$message .= "--{$mime_boundary}\n";
}*/
 
// send
 // @mail('bluetrack_niladhar@hotmail.com',$subject,$message,$headers);
$ok = @mail($to, $subject, $message, $headers); 
$obj = new db();
if($ok)  
{
$qry = "insert into email_conf values(null,'$to','$from',now(),'$sub','no','success')";
$obj->query($qry);
return 1;
}
else  
{
$qry = "insert into email_conf values(null,'$to','$from',now(),'$sub','no','failed')";
$obj->query($qry);
return 0;
 }

}


function generatePassword($length=6,$level=2){

   list($usec, $sec) = explode(' ', microtime());
   srand((float) $sec + ((float) $usec * 100000));

   $validchars[1] = "0123456789abcdfghjkmnpqrstvwxyz";
   $validchars[2] = "0123456789abcdfghjkmnpqrstvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
   $validchars[3] = "0123456789_!@#$%&*()-=+/abcdfghjkmnpqrstvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ_!@#$%&*()-=+/";

   $password  = "";
   $counter   = 0;

   while ($counter < $length) {
     $actChar = substr($validchars[$level], rand(0, strlen($validchars[$level])-1), 1);

     // All character must be different
     if (!strstr($password, $actChar)) {
        $password .= $actChar;
        $counter++;
     }
   }

   return $password;

}
function ajaxResponse($mdata, $merrors=array()) {
    $aResponse = array(
        'data' => $mdata,
        'errors' => $merrors
    );
    echo(json_encode($aResponse));
    exit;
}

function isAjax() {
    if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
        return TRUE;
    }

    return FALSE;
}

?>


<?php

/** @class: InputFilter (PHP4 & PHP5, with comments)
  * @project: PHP Input Filter
  * @date: 10-05-2005
  * @version: 1.2.2_php4/php5
  * @author: Daniel Morris
  * @contributors: Gianpaolo Racca, Ghislain Picard, Marco Wandschneider, Chris Tobin and Andrew Eddie.
  * @copyright: Daniel Morris
  * @email: dan@rootcube.com
  * @license: GNU General Public License (GPL)
  */
class InputFilter {
	var $tagsArray;			// default = empty array
	var $attrArray;			// default = empty array

	var $tagsMethod;		// default = 0
	var $attrMethod;		// default = 0

	var $xssAuto;           // default = 1
	var $tagBlacklist = array('applet', 'body', 'bgsound', 'base', 'basefont', 'embed', 'frame', 'frameset', 'head', 'html', 'id', 'iframe', 'ilayer', 'layer', 'link', 'meta', 'name', 'object', 'script', 'style', 'title', 'xml');
	var $attrBlacklist = array('action', 'background', 'codebase', 'dynsrc', 'lowsrc');  // also will strip ALL event handlers
		
	/** 
	  * Constructor for inputFilter class. Only first parameter is required.
	  * @access constructor
	  * @param Array $tagsArray - list of user-defined tags
	  * @param Array $attrArray - list of user-defined attributes
	  * @param int $tagsMethod - 0= allow just user-defined, 1= allow all but user-defined
	  * @param int $attrMethod - 0= allow just user-defined, 1= allow all but user-defined
	  * @param int $xssAuto - 0= only auto clean essentials, 1= allow clean blacklisted tags/attr
	  */
	function inputFilter($tagsArray = array(), $attrArray = array(), $tagsMethod = 0, $attrMethod = 0, $xssAuto = 1) {		
		// make sure user defined arrays are in lowercase
		for ($i = 0; $i < count($tagsArray); $i++) $tagsArray[$i] = strtolower($tagsArray[$i]);
		for ($i = 0; $i < count($attrArray); $i++) $attrArray[$i] = strtolower($attrArray[$i]);
		// assign to member vars
		$this->tagsArray = (array) $tagsArray;
		$this->attrArray = (array) $attrArray;
		$this->tagsMethod = $tagsMethod;
		$this->attrMethod = $attrMethod;
		$this->xssAuto = $xssAuto;
	}
	
	/** 
	  * Method to be called by another php script. Processes for XSS and specified bad code.
	  * @access public
	  * @param Mixed $source - input string/array-of-string to be 'cleaned'
	  * @return String $source - 'cleaned' version of input parameter
	  */
	function process($source) {
		// clean all elements in this array
		if (is_array($source)) {
			foreach($source as $key => $value)
				// filter element for XSS and other 'bad' code etc.
				if (is_string($value)) $source[$key] = $this->remove($this->decode($value));
			return $source;
		// clean this string
		} else if (is_string($source)) {
			// filter source for XSS and other 'bad' code etc.
			return $this->remove($this->decode($source));
		// return parameter as given
		} else return $source;	
	}

	/** 
	  * Internal method to iteratively remove all unwanted tags and attributes
	  * @access protected
	  * @param String $source - input string to be 'cleaned'
	  * @return String $source - 'cleaned' version of input parameter
	  */
	function remove($source) {
		$loopCounter=0;
		// provides nested-tag protection
		while($source != $this->filterTags($source)) {
			$source = $this->filterTags($source);
			$loopCounter++;
		}
		return $source;
	}	
	
	/** 
	  * Internal method to strip a string of certain tags
	  * @access protected
	  * @param String $source - input string to be 'cleaned'
	  * @return String $source - 'cleaned' version of input parameter
	  */
	function filterTags($source) {
		// filter pass setup
		$preTag = NULL;
		$postTag = $source;
		// find initial tag's position
		$tagOpen_start = strpos($source, '<');
		// interate through string until no tags left
		while($tagOpen_start !== FALSE) {
			// process tag interatively
			$preTag .= substr($postTag, 0, $tagOpen_start);
			$postTag = substr($postTag, $tagOpen_start);
			$fromTagOpen = substr($postTag, 1);
			// end of tag
			$tagOpen_end = strpos($fromTagOpen, '>');
			if ($tagOpen_end === false) break;
			// next start of tag (for nested tag assessment)
			$tagOpen_nested = strpos($fromTagOpen, '<');
			if (($tagOpen_nested !== false) && ($tagOpen_nested < $tagOpen_end)) {
				$preTag .= substr($postTag, 0, ($tagOpen_nested+1));
				$postTag = substr($postTag, ($tagOpen_nested+1));
				$tagOpen_start = strpos($postTag, '<');
				continue;
			} 
			$tagOpen_nested = (strpos($fromTagOpen, '<') + $tagOpen_start + 1);
			$currentTag = substr($fromTagOpen, 0, $tagOpen_end);
			$tagLength = strlen($currentTag);
			if (!$tagOpen_end) {
				$preTag .= $postTag;
				$tagOpen_start = strpos($postTag, '<');			
			}
			// iterate through tag finding attribute pairs - setup
			$tagLeft = $currentTag;
			$attrSet = array();
			$currentSpace = strpos($tagLeft, ' ');
			// is end tag
			if (substr($currentTag, 0, 1) == "/") {
				$isCloseTag = TRUE;
				list($tagName) = explode(' ', $currentTag);
				$tagName = substr($tagName, 1);
			// is start tag
			} else {
				$isCloseTag = FALSE;
				list($tagName) = explode(' ', $currentTag);
			}		
			// excludes all "non-regular" tagnames OR no tagname OR remove if xssauto is on and tag is blacklisted
			if ((!preg_match("/^[a-z][a-z0-9]*$/i",$tagName)) || (!$tagName) || ((in_array(strtolower($tagName), $this->tagBlacklist)) && ($this->xssAuto))) { 				
				$postTag = substr($postTag, ($tagLength + 2));
				$tagOpen_start = strpos($postTag, '<');
				// don't append this tag
				continue;
			}
			// this while is needed to support attribute values with spaces in!
			while ($currentSpace !== FALSE) {
				$fromSpace = substr($tagLeft, ($currentSpace+1));
				$nextSpace = strpos($fromSpace, ' ');
				$openQuotes = strpos($fromSpace, '"');
				$closeQuotes = strpos(substr($fromSpace, ($openQuotes+1)), '"') + $openQuotes + 1;
				// another equals exists
				if (strpos($fromSpace, '=') !== FALSE) {
					// opening and closing quotes exists
					if (($openQuotes !== FALSE) && (strpos(substr($fromSpace, ($openQuotes+1)), '"') !== FALSE))
						$attr = substr($fromSpace, 0, ($closeQuotes+1));
					// one or neither exist
					else $attr = substr($fromSpace, 0, $nextSpace);
				// no more equals exist
				} else $attr = substr($fromSpace, 0, $nextSpace);
				// last attr pair
				if (!$attr) $attr = $fromSpace;
				// add to attribute pairs array
				$attrSet[] = $attr;
				// next inc
				$tagLeft = substr($fromSpace, strlen($attr));
				$currentSpace = strpos($tagLeft, ' ');
			}
			// appears in array specified by user
			$tagFound = in_array(strtolower($tagName), $this->tagsArray);			
			// remove this tag on condition
			if ((!$tagFound && $this->tagsMethod) || ($tagFound && !$this->tagsMethod)) {
				// reconstruct tag with allowed attributes
				if (!$isCloseTag) {
					$attrSet = $this->filterAttr($attrSet);
					$preTag .= '<' . $tagName;
					for ($i = 0; $i < count($attrSet); $i++)
						$preTag .= ' ' . $attrSet[$i];
					// reformat single tags to XHTML
					if (strpos($fromTagOpen, "</" . $tagName)) $preTag .= '>';
					else $preTag .= ' />';
				// just the tagname
			    } else $preTag .= '</' . $tagName . '>';
			}
			// find next tag's start
			$postTag = substr($postTag, ($tagLength + 2));
			$tagOpen_start = strpos($postTag, '<');			
		}
		// append any code after end of tags
		$preTag .= $postTag;
		return $preTag;
	}

	/** 
	  * Internal method to strip a tag of certain attributes
	  * @access protected
	  * @param Array $attrSet
	  * @return Array $newSet
	  */
	function filterAttr($attrSet) {	
		$newSet = array();
		// process attributes
		for ($i = 0; $i <count($attrSet); $i++) {
			// skip blank spaces in tag
			if (!$attrSet[$i]) continue;
			// split into attr name and value
			$attrSubSet = explode('=', trim($attrSet[$i]));
			list($attrSubSet[0]) = explode(' ', $attrSubSet[0]);
			// removes all "non-regular" attr names AND also attr blacklisted
			if ((!eregi("^[a-z]*$",$attrSubSet[0])) || (($this->xssAuto) && ((in_array(strtolower($attrSubSet[0]), $this->attrBlacklist)) || (substr($attrSubSet[0], 0, 2) == 'on')))) 
				continue;
			// xss attr value filtering
			if ($attrSubSet[1]) {
				// strips unicode, hex, etc
				$attrSubSet[1] = str_replace('&#', '', $attrSubSet[1]);
				// strip normal newline within attr value
				$attrSubSet[1] = preg_replace('/\s+/', '', $attrSubSet[1]);
				// strip double quotes
				$attrSubSet[1] = str_replace('"', '', $attrSubSet[1]);
				// [requested feature] convert single quotes from either side to doubles (Single quotes shouldn't be used to pad attr value)
				if ((substr($attrSubSet[1], 0, 1) == "'") && (substr($attrSubSet[1], (strlen($attrSubSet[1]) - 1), 1) == "'"))
					$attrSubSet[1] = substr($attrSubSet[1], 1, (strlen($attrSubSet[1]) - 2));
				// strip slashes
				$attrSubSet[1] = stripslashes($attrSubSet[1]);
			}
			// auto strip attr's with "javascript:
			if (	((strpos(strtolower($attrSubSet[1]), 'expression') !== false) &&	(strtolower($attrSubSet[0]) == 'style')) ||
					(strpos(strtolower($attrSubSet[1]), 'javascript:') !== false) ||
					(strpos(strtolower($attrSubSet[1]), 'behaviour:') !== false) ||
					(strpos(strtolower($attrSubSet[1]), 'vbscript:') !== false) ||
					(strpos(strtolower($attrSubSet[1]), 'mocha:') !== false) ||
					(strpos(strtolower($attrSubSet[1]), 'livescript:') !== false) 
			) continue;

			// if matches user defined array
			$attrFound = in_array(strtolower($attrSubSet[0]), $this->attrArray);
			// keep this attr on condition
			if ((!$attrFound && $this->attrMethod) || ($attrFound && !$this->attrMethod)) {
				// attr has value
				if ($attrSubSet[1]) $newSet[] = $attrSubSet[0] . '="' . $attrSubSet[1] . '"';
				// attr has decimal zero as value
				else if ($attrSubSet[1] == "0") $newSet[] = $attrSubSet[0] . '="0"';
				// reformat single attributes to XHTML
				else $newSet[] = $attrSubSet[0] . '="' . $attrSubSet[0] . '"';
			}	
		}
		return $newSet;
	}
	
	/** 
	  * Try to convert to plaintext
	  * @access protected
	  * @param String $source
	  * @return String $source
	  */
	function decode($source) {
		// url decode
		$source = html_entity_decode($source, ENT_QUOTES, "ISO-8859-1");
		// convert decimal
		$source = preg_replace('/&#(\d+);/me',"chr(\\1)", $source);				// decimal notation
		// convert hex
		$source = preg_replace('/&#x([a-f0-9]+);/mei',"chr(0x\\1)", $source);	// hex notation
		return $source;
	}

	/** 
	  * Method to be called by another php script. Processes for SQL injection
	  * @access public
	  * @param Mixed $source - input string/array-of-string to be 'cleaned'
	  * @param Buffer $connection - An open MySQL connection
	  * @return String $source - 'cleaned' version of input parameter
	  */
	function safeSQL($source, &$connection) {
		// clean all elements in this array
		if (is_array($source)) {
			foreach($source as $key => $value)
				// filter element for SQL injection
				if (is_string($value)) $source[$key] = $this->quoteSmart($this->decode($value), $connection);
			return $source;
		// clean this string
		} else if (is_string($source)) {
			// filter source for SQL injection
			if (is_string($source)) return $this->quoteSmart($this->decode($source), $connection);
		// return parameter as given
		} else return $source;	
	}

	/** 
	  * @author Chris Tobin
	  * @author Daniel Morris
	  * @access protected
	  * @param String $source
	  * @param Resource $connection - An open MySQL connection
	  * @return String $source
	  */
	function quoteSmart($source, &$connection) {
		// strip slashes
		if (get_magic_quotes_gpc()) $source = stripslashes($source);
		// quote both numeric and text
		$source = $this->escapeString($source, $connection);
		return $source;
	}
	
	/** 
	  * @author Chris Tobin
	  * @author Daniel Morris
	  * @access protected
	  * @param String $source
	  * @param Resource $connection - An open MySQL connection
	  * @return String $source
	  */	
	function escapeString($string, &$connection) {
		// depreciated function
		if (version_compare(phpversion(),"4.3.0", "<")) mysqli_escape_string($string);
		// current function
		else mysqli_real_escape_string($string);
		return $string;
	}
}

?>

<?php
// strpos that takes an array of values to match against a string
// note the stupid argument order (to match strpos)
function strpos_arr($haystack, $needle) {
    if(!is_array($needle)) $needle = array($needle);
    foreach($needle as $what) {
        if(($pos = strpos($haystack, $what))!==false) return $pos;
    }
    return false;
}

if (!function_exists('money_format')) {
	function money_format($format, $total) {
		$decimal = 2;
		$thousdelim = ',';
		if ($total < 0) {
			$output = '-$';
		} else {
			$output = '$';
		}
		$output .= number_format(abs($total), $decimal, '.', $thousdelim);
		return $output;

	}
}
?>