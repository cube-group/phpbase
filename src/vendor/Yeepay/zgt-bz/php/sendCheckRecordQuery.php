<?php
require_once(__DIR__ . "/../inc/config.php");

define("__BIZ__", "checkRecordQuery");

$req = new RequestService(__BIZ__);
$req->sendRequest($_REQUEST);
$req->receviceResponse();

$request = $req->getRequest();
$response = $req->getResponseData();


?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?=__LOCALE__CODE__?>">
<title>分账方审核结果</title>
</head>
	<body>
		<br /> <br />
		<table width="70%" border="0" align="center" cellpadding="5" cellspacing="0" 
							style="word-break:break-all; border:solid 1px #107929">
			<tr>
		  		<th align="center" height="30" colspan="5" bgcolor="#6BBE18">
					分账方审核结果
				</th>
		  	</tr>

			<tr>
				<td width="25%" align="left">&nbsp;主账户商户编号</td>
				<td width="5%"  align="center"> : </td> 
				<td width="50%" align="left"> <?=$response["customernumber"]?> </td>
				<td width="5%"  align="center"> - </td> 
				<td width="15%" align="left">customernumber</td> 
			</tr>

			<tr>
				<td width="25%" align="left">&nbsp;子账户商户编号</td>
				<td width="5%"  align="center"> : </td> 
				<td width="50%" align="left"> <?=$response["ledgerno"]?> </td>
				<td width="5%"  align="center"> - </td> 
				<td width="15%" align="left">ledgerno</td> 
			</tr>

			<tr>
				<td width="25%" align="left">&nbsp;审核结果</td>
				<td width="5%"  align="center"> : </td> 
				<td width="50%" align="left"> <?=$response["status"]?> </td>
				<td width="5%"  align="center"> - </td> 
				<td width="15%" align="left">status</td> 
			</tr>

			<tr>
				<td width="25%" align="left">&nbsp;审核时间</td>
				<td width="5%"  align="center"> : </td> 
				<td width="50%" align="left"> <?=$response["checkdate"]?> </td>
				<td width="5%"  align="center"> - </td> 
				<td width="15%" align="left">checkdate</td> 
			</tr>

			<tr>
				<td width="25%" align="left">&nbsp;审核原因</td>
				<td width="5%"  align="center"> : </td> 
				<td width="50%" align="left"> <?=$response["reason"]?> </td>
				<td width="5%"  align="center"> - </td> 
				<td width="15%" align="left">reason</td> 
			</tr>

		</table>

	</body>
</html>
