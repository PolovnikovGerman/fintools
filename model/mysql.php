<?php
//writing class for database connectivity as well as mysql querying and other functions
class db
{
//declaring public variables for use in the functions
        var $conn;
        var $res;

        function __construct()
		{
			$this->db();
		}

	//function to connect to the database
        function db()
        {
				//dev
                //$conn=mysql_connect("db2424.perfora.net","dbo329296858","blue2311track") or die(mysql_error());
                //mysql_select_db("db329296858",$conn);
				//live
               $this->conn=mysqli_connect("localhost","bluetrac_system","angeles1217") or die(mysqli_error());
                mysqli_select_db($this->conn, "bluetrac_system");
			   //localhost
			    //$conn=mysql_connect("localhost","root","") or die(mysql_error());
                //mysql_select_db("system",$conn);
        }
        //function query sending query string as the parameter
        function query($qry)
        {
                $this->res=mysqli_query($this->conn, $qry) or die(mysqli_error());
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
		function write_to_vendor_history($table,$parent,$msg,$user,$type)
		{
			
			$qry="insert into $table values(null,'$parent','$msg',now(),'$user','$type')";
			if(mysqli_query($qry))
			return 1;
			else
			return 0;
		
		}
		function write_to_r2_history($parent,$msg,$user)
		{
			
			$qry="insert into r2_history values(null,'$parent','$msg','$user',now())";
			if(mysqli_query($qry))
			return 1;
			else
			return 0;
		
		}
		
		function get_start_point()
		{
		echo $qry="select af_order_id,ch_datetime from af_child where ch_datetime!= '0000-00-00' && ch_datetime!='2096-12-31'  order by ch_datetime desc limit 0,1";
		$res = mysqli_query($qry);
	$data = mysqli_fetch_array($res);
		if(mysqli_num_rows($res) == 0)
		return 22000;
		if(substr($data['af_order_id'],2,1) >= 5)
		return substr($data['af_order_id'],0,2).'500';
		else
		return substr($data['af_order_id'],0,2).'000';
		}
		
		function read_vendor_history($table,$parent,$parent_col)
		{
			$qry="select * from $table where $parent_col = $parent order by vhist_id DESC";
			$res=mysqli_query($qry);
			$hist['attach_size']=0;
			while($data = mysqli_fetch_array($res))
			{
				$hist['id'][]=$data['vhist_id'];
				$hist['vid'][]=$data['vendor_id'];
				//$hist['msg'][]=$data['vhist_message'];
				$hist['datetime'][]=substr($data['vhist_datetime'],5,2)."/".substr($data['vhist_datetime'],8,2)."/".substr($data['vhist_datetime'],2,2);
				$hist['time'][]=substr($data['vhist_datetime'],11,5);
				$hist['userid'][]=$data['vhist_userid'];
				$hist['isattach'][]=$data['vhist_isattach'];
				if($data['vhist_isattach']=='yes')
				{
				$hist['attach'][]=substr($data['vhist_message'],0,-9);
				$arr=explode("_",$data['vhist_message']);
				$hist['msg'][]=$arr[sizeof($arr)-1];
				$hist['attach_size']++;
				}
				else
				$hist['msg'][]=$data['vhist_message'];
			
			}
			return $hist;
			
		}
		
		
		function is_present_itemid($item_id)
		{
			$qry="select * from is_info where is_itemid = '$item_id' ";
			$res=mysqli_query($qry) or die("Invalid SQL Query String");
			if(mysqli_num_rows($res) > 0 )
			return 1;
			else
			return 0;
			
		}
			function read_item_history($table,$parent,$parent_col)
		{
			$qry="select * from $table where $parent_col = $parent order by ishist_id DESC";
			$res=mysqli_query($qry);
			$hist['attach_size']=0;
			while($data = mysqli_fetch_array($res))
			{
				$hist['id'][]=$data['is_id'];
				$hist['isid'][]=$data['is_id'];
				//$hist['msg'][]=$data['vhist_message'];
				$hist['datetime'][]=substr($data['ishist_datetime'],5,2)."/".substr($data['ishist_datetime'],8,2)."/".substr($data['ishist_datetime'],2,2);
				$hist['time'][]=substr($data['ishist_datetime'],11,5);
				$hist['userid'][]=$data['ishist_userid'];
				$hist['isattach'][]=$data['ishist_isattach'];
				if($data['ishist_isattach']=='yes')
				{
				$hist['attach'][]=substr($data['ishist_message'],0,-9);
				$arr=explode("_",$data['ishist_message']);
				$hist['msg'][]=$arr[sizeof($arr)-2]."_".$arr[sizeof($arr)-1];
				$hist['attach_size']++;
				}
				else
				$hist['msg'][]=$data['ishist_message'];
			
			}
			return $hist;
			
		}
			function get_next_inc($col, $table)
		{
			if($table == 'is_info')
				$qry="select * from is_info where $col  = '' or $col = null LIMIT 0,1";
			else if($table == 'iw_info')
				$qry="select * from is_info a, iw_info b where a.is_id = b.is_id_fk and b.".$col." = '' or b.".$col." = null LIMIT 0,1";
			else if($table == 'is_vendor')
				$qry="select * from is_info a, is_vendor b where a.is_id = b.is_id and b.".$col." = '' or b.".$col." = null LIMIT 0,1";
			else if($table == 'iw_imprint')
				$qry="select * from is_info where is_id not in (select is_id_fk from iw_info a, iw_imprint b where a.iw_id = b.iw_id) LIMIT 0,1 ";
				
				$res=mysqli_query($qry);
				if($res)
				{
					if(mysqli_num_rows($res) == 1)
					{
						$inc=mysqli_fetch_array($res);
						return $inc['is_id'];
					}
					else if(mysqli_num_rows($res) == 0)
					{
						return "end";
					}
				}
				else
				{
					return "error";
				}
		}	
		
		function get_next_inc_itemw($val)
		{
			if(!empty($val))
			$qry="select is_title from is_info where is_id = $val";
			else
			return "error";
			
			$res=mysqli_query($qry);
			if(mysqli_num_rows($res) == 1)
			{
				$inc_w=mysqli_fetch_array($res);
				return $inc_w['is_title'];
			}
			else
				return "error";
		}
		
		function insert_sort($id,$secid, $cat)
		{
		$qry = "select * from task_sort where sort_sec = ".$secid." and sort_cat = ".$cat."";
		$res=mysqli_query($qry);
		$data = mysqli_fetch_array($res);
		$sort_array = array();
		$sort_array = unserialize($data['sort_array']);
		if(empty($sort_array))
		$sort_array = (array) $id;
		else
		$sort_array = array_merge((array) $id, (array) $sort_array);
		$qry = "update task_sort set sort_array = '".serialize($sort_array)."' where sort_sec = ".$secid." and sort_cat = ".$cat." ";
		$res = mysqli_query($qry);
		
		
		}	
		function get_sort_order($secid, $cat)
		{
		$qry = "select * from task_sort where sort_sec = ".$secid." and sort_cat = '".$cat."'";
		$res=mysqli_query($qry);
		$data = mysqli_fetch_array($res);
		
		
		return unserialize($data['sort_array']);
		
		}
		function get_sort_dead_order($secid, $cat)
		{
		$qry = "select * from task_dead_sort where dead_sec = ".$secid." and dead_cat = '".$cat."'";
		$res=mysqli_query($qry);
		$data = mysqli_fetch_array($res);
		
		
		return unserialize($data['dead_array']);
		
		}
		function remove_task_from_sort($taskid,$secid,$cat)
		{
			$qry = "select * from task_sort where sort_sec = ".$secid." and sort_cat = '".$cat."'";
			$res = mysqli_query($qry);
			$data = mysqli_fetch_array($res);
			
			$sort_array = array();
			$sort_array = unserialize($data['sort_array']); 
			
			if(is_array($sort_array) && in_array($taskid,$sort_array))
			{
				$key = array_search($taskid, $sort_array); 
				array_splice($sort_array, $key, 1); 
				$qry = "update task_sort set sort_array = '".serialize($sort_array)."' where sort_sec = ".$secid." and sort_cat = '".$cat."' ";
				$res = mysqli_query($qry);
			}
			
		return 1;	
			
		}
		
		function remove_task_from_dead_sort($taskid,$secid,$cat)
		{
			$qry = "select * from task_dead_sort where dead_sec = ".$secid." and dead_cat = '".$cat."'";
			$res = mysqli_query($qry);
			$data = mysqli_fetch_array($res);
			
			$sort_array = array();
			$sort_array = unserialize($data['dead_array']); 
			
			if(is_array($sort_array) && in_array($taskid,$sort_array))
			{
				$key = array_search($taskid, $sort_array); 
				array_splice($sort_array, $key, 1); 
				$qry = "update task_dead_sort set dead_array = '".serialize($sort_array)."' where dead_sec = ".$secid." and dead_cat = '".$cat."' ";
				$res = mysqli_query($qry);
			}
			
		return 1;	
			
		}
		
		function insert_dead_sort($id,$secid, $cat)
		{
		$qry = "select * from task_dead_sort where dead_sec = ".$secid." and dead_cat = ".$cat."";
		$res=mysqli_query($qry);
		$data = mysqli_fetch_array($res);
		$sort_array = array();
		$sort_array = unserialize($data['dead_array']);
		if(empty($sort_array))
		$sort_array = (array) $id;
		else
		$sort_array = array_merge((array) $id, (array) $sort_array);
		$qry = "update task_dead_sort set dead_array = '".serialize($sort_array)."' where dead_sec = ".$secid." and dead_cat = ".$cat." ";
		$res = mysqli_query($qry);
		
		
		}	
		function isin_section($tid,$live)
		{
		$qry = "select * from task_active where task_id = $tid and section_id = $live";
		$res=mysqli_query($qry);
		if(mysqli_num_rows($res) > 0)
		return 1;
		else
		return 0;
		
		}
		
		function _get_chid($val)
		{
		$qry = "select ch_id from af_child where af_order_id = $val and ch_po = 'A' ";
		$res = mysqli_query($qry);
		$data = mysqli_fetch_array($res);
		//$data = $obj->fetch($obj->query($qry));
		return $data['ch_id'];
		}
		
		function get_ven_list()
 		{
 		$obj=new db();
 
	 	$qry = "select * from af_vendor order by v_name";
 		$res = $obj->query($qry);
 		while($data = $obj->fetch($res) )
 		{
 			
 		$key_vi['v_id'][]=$data['v_id'];
	 	$key_vi['v_name'][]=$data['v_name'];
	 	$key_vi['v_abbr'][]=$data['v_abbr'];
	 	$key_vi['v_email'][]=$data['v_email'];
	 	$key_vi['v_type'][]=$data['v_type'];
	 	$key_vi['v_address'][]=$data['v_address'];
		$key_vi['v_memos'][]=$data['v_memos'];
	 	$key_vi['v_phone'][]=$data['v_phone'];
	
 		}
 
		return $key_vi;
 		}
 
 
		function get_item_list()
 		{
 		$obj=new db();
 
	 	$qry = "select i_id,i_itemid from af_items order by i_itemid ASC";
 		$res = $obj->query($qry);
 		while($data = $obj->fetch($res) )
 		{
 			
 		$key_vi['i_id'][]=$data['i_id'];
	 	$key_vi['i_itemid'][]=$data['i_itemid'];
	
 		}
 
		return $key_vi;
 		}
 		
		function get_email_data($child)
		{
		$obj=new db();
 
	 	$qry = "select * from af_child where ch_id = ".$child;
 		$res = $obj->query($qry);
 		$data = $obj->fetch($res); 
 		$qry = "select v_name, v_email from af_vendor where v_abbr ='".$data['ch_vendor']."'";
		$res = $obj->query($qry);
 		$data2 = $obj->fetch($res); 
		$qry = "select r2i_desc from af_r2_items where r2_id = ".$child;
		$res = $obj->query($qry);
		while($data3 = $obj->fetch($res))
		$data4[] = $data3['r2i_desc'];
		
		$arr=array('af_order_id'=>$data['af_order_id'],'chpo'=>$data['ch_po'],'v_name'=>$data2['v_name'],'v_email'=>$data2['v_email'],'items'=>$data4);
		print_r($arr);
		
		return $arr;
 		}
		function get_PONAME($child)
		{
		$obj=new db();
 
	 	$qry = "select af_order_id, ch_po from af_child where ch_id = ".$child;
 		$res = $obj->query($qry);
 		$data = $obj->fetch($res); 
		return $data;
		}
		function get_CHILD($af)
		{
		$obj=new db();
 
	 	$qry = "select ch_id from af_child where ch_po = 'A' and af_order_id = ".$af;
 		$res = $obj->query($qry);
 		$data = $obj->fetch($res); 
		return $data['ch_id'];
		}
}
?>

