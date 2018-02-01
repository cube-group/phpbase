<?php
require_once(__DIR__ . "/../inc/config.php");

define("__BIZ__", "cardBinQuery");

$req = new RequestService(__BIZ__);
$req->sendRequest($_REQUEST);
$req->receviceResponse();

$request = $req->getRequest();
$response = $req->getResponseData();

//验证请求的requestid和返回的requestid是否一致
/*if ( $request["requestid"] != $response["requestid"] ) {

	throw new ZGTException("requestid not equals, response is [" . $response["requestid"] . "], requestid is [" . $request["requestid"] . "].");	
}
*/
?>


<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?=__LOCALE__CODE__ ?>">
<title>卡BIN查询结果</title>
</head>
	<body>
		<br /> <br />
		<table width="70%" border="0" align="center" cellpadding="5" cellspacing="0" 
							style="word-break:break-all; border:solid 1px #107929">
			<tr>
		  		<th align="center" height="30" colspan="5" bgcolor="#6BBE18">
					卡BIN查询返回参数
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
				<td width="25%" align="left">&nbsp;银行卡号</td>
				<td width="5%"  align="center"> : </td> 
				<td width="50%" align="left"> <?=$response["bankcardnum"]?> </td>
				<td width="5%"  align="center"> - </td> 
				<td width="15%" align="left">bankcardnum</td> 
			</tr>

			<tr>
				<td width="25%" align="left">&nbsp;返回码</td>
				<td width="5%"  align="center"> : </td> 
				<td width="50%" align="left"> <?=$response["code"]?> </td>
				<td width="5%"  align="center"> - </td> 
				<td width="15%" align="left">code</td> 
			</tr>


			<tr>
				<td width="25%" align="left">&nbsp;银行编码</td>
				<td width="5%"  align="center"> : </td> 
				<td width="50%" align="left"> <?=$response["bankcode"]?> </td>
				<td width="5%"  align="center"> - </td> 
				<td width="15%" align="left">bankcode</td> 
			</tr>


			<tr>
				<td width="25%" align="left">&nbsp;银行名称</td>
				<td width="5%"  align="center"> : </td> 
				<td width="50%" align="left"> <?=$response["bankname"]?> </td>
				<td width="5%"  align="center"> - </td> 
				<td width="15%" align="left">bankname</td> 
			</tr>



			<tr>
				<td width="25%" align="left">&nbsp;银行卡名称</td>
				<td width="5%"  align="center"> : </td> 
				<td width="50%" align="left"> <?=$response["cardname"]?> </td>
				<td width="5%"  align="center"> - </td> 
				<td width="15%" align="left">cardname</td> 
			</tr>
			
						<tr>
				<td width="25%" align="left">&nbsp;银行卡类型</td>
				<td width="5%"  align="center"> : </td> 
				<td width="50%" align="left"> <?=$response["cardtype"]?> </td>
				<td width="5%"  align="center"> - </td> 
				<td width="15%" align="left">cardtype</td> 
			</tr>




		</table>

	</body>
</html>
