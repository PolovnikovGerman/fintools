<?php
//writing class for database connectivity as well as mysql querying and other functions
class db_module
{
//declaring public variables for use in the functions
        var $conn;
        var $res;

        
        //function to connect to the database
        function db_module()
        {
				//dev
               $conn=mysql_connect("localhost","bluetrac_module","angeles1217") or die(mysql_error());
                mysql_select_db("bluetrac_module",$conn);
				//live
              // $conn=mysql_connect("localhost","bluetrac_u253909","blue2311track") or die(mysql_error());
               // mysql_select_db("bluetrac_system",$conn);
			   //localhost
			   //$conn=mysql_connect("localhost","root","") or die(mysql_error());
               // mysql_select_db("modules",$conn);
        }
        //function query sending query string as the parameter
        function query($qry)
        {
                $res=mysql_query($qry) or die('<b>Query Error</b> : '.$qry);
                return $res;
        }
        //to select num of rows in the resulting query result
        function numrow($txt)
        {
                return mysql_num_rows($txt);
        }
        //fetching array from the result set
        function fetch($res)
        {
                return mysql_fetch_array($res,MYSQL_ASSOC);
        }
		function fetch_object($res)
		{
				return mysql_fetch_object($res);
		}
}
?>

