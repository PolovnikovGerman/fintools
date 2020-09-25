<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>BT System :: Login</title>
<link rel="stylesheet" href="images/style.css">
</head>

<body>

<div style="width:800px; margin:auto; color: #1D1D1D; margin-top:20px; border:1px #2D2D2D solid; height:400px; padding:15px;">

<div >
    <div style="float:left;"><img src="/images/login_newlogo.png"/></div>
<div style="float:left; margin-top:30px; font-size:19px; ">&nbsp;&nbsp;&nbsp;&nbsp;<b>BT System 2.0</b></div>

<div class="clear"></div>
<hr />
</div>
<div style="width:400px; text-align:center; margin:auto; height:40px;"><?php if(isset($_GET['id']) && $_GET['id'] == 'notLogin' ) echo "<span style=\"color:red;\">Invalid username and password</span>"; ?></div> 
<div style="width:400px; margin:auto;  padding:20px 10px 10px 10px; height:150px; border:1px #424242 solid;">
<form name="frm_login" action="<?php echo "check_login.php"; ?>" method=POST >
<table width="390px;" border="0" cellpadding="5px">

<tr><td align="right"><b>email address:</b></td><td align="right"><input type="text" name="username" size="34" /></td></tr>
<tr><td align="right"><b>password:</b></td><td align="right"><input type="password" name="password" size="34" /></td></tr>
<tr><td colspan="2" align="right"><input type="submit" class="btn_blueg" value="login" /></td></tr>

</table>

</div>

</div>
<br />
<div style="width:830px; margin:auto; text-align:right; font-size:12px;">Copyright &copy; 2010 BLUETRACK,Inc. All Rights Reserved.</div>
</body>
</html>
