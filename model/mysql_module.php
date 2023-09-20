<?php
//writing class for database connectivity as well as mysql querying and other functions
class db_module
{
//declaring public variables for use in the functions
        var $conn;
        var $res;

        function __construct()
        {
                $this->db_module();
        }

        //function to connect to the database
        function db_module()
        {
				//dev
               $this->conn=mysqli_connect("localhost","bluetrac_module","angeles1217") or die(mysqli_error());
                mysqli_select_db($this->conn, "bluetrac_module");
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
                $this->res=mysqli_query($this->conn, $qry) or die('<b>Query Error</b> : '.$qry);
                return $this->res;
        }
        //to select num of rows in the resulting query result
        function numrow($txt)
        {
                return mysqli_num_rows($txt);
        }
        //fetching array from the result set
        function fetch($res)
        {
                return mysqli_fetch_array($res,MYSQLI_ASSOC);
        }
		function fetch_object($res)
		{
				return mysqli_fetch_object($res);
		}
}
?>

