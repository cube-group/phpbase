<?php

require_once(__DIR__ . "/../inc/config.php");

define("__BIZ__", "unbindCard");

$req = new RequestService(__BIZ__);
$req->sendRequest($_REQUEST);
$req->receviceResponse();

$request = $req->getRequest();
$response = $req->getResponseData();

?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gbk">
<title>解绑结果</title>
</head>
	<body>	
		<br /> <br />
		<table width="70%" border="0" align="center" cellpadding="5" cellspacing="0" 
												style="word-break:break-all; border:solid 1px #107929">
			<tr>
		  		<th align="center" height="30" colspan="5" bgcolor="#6BBE18">
					解绑结果
				</th>
		  	</tr>

			<tr >
				<td width="25%" align="left">&nbsp;主商户编号</td>
				<td width="5%"  align="center"> : </td> 
				<td width="45"  align="left"> <?php  echo $response["customernumber"];?> </td>
				<td width="5%"  align="center"> - </td> 
				<td width="30%" align="left">customernumber</td> 
			</tr>

			<tr>
				<td width="25%" align="left">&nbsp;用户标识</td>
				<td width="5%"  align="center"> : </td> 
				<td width="35%" align="left"> <?php  echo $response["userno"];?> </td>
				<td width="5%"  align="center"> - </td> 
				<td width="30%" align="left">userno</td> 
			</tr>

		<tr>
				<td width="25%" align="left">&nbsp;绑卡 ID</td>
				<td width="5%"  align="center"> : </td> 
				<td width="35%" align="left"> <?php  echo $response['bindid'];?></td>
				<td width="5%"  align="center"> - </td> 
				<td width="30%" align="left">bindid</td> 
			</tr>
			<tr>
				<td width="25%" align="left">&nbsp;返回码</td>
				<td width="5%"  align="center"> : </td> 
				<td width="35%" align="left"> <?php  echo $response["code"];?> </td>
				<td width="5%"  align="center"> - </td> 
				<td width="30%" align="left">code</td> 
			</tr>



		</table>
	</body>
</html>