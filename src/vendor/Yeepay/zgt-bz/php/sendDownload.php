<?php

header("Content-type: text/html; charset=utf-8");
require_once(__DIR__ . "/../inc/config.php");
require_once(__DIR__ . "/../inc/RequestService.php");
define("__BIZ__", "download");


$req = new RequestService(__BIZ__);
$req->sendRequest($_REQUEST);
$filepath = $req->filedownResponse();


?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?=__LOCALE__CODE__?>">


<title>对账文件下载</title>
</head>
	<body>	
		<br /> <br />
		<table width="70%" border="0" align="center" cellpadding="5" cellspacing="0" 
												style="word-break:break-all; border:solid 1px #107929">
			<tr>
		  		<th align="center" height="30" colspan="5" bgcolor="#6BBE18">
					对账文件下载
					
				</th>
		  	</tr>

			<tr >
				<td width="25%" align="left">&nbsp;文件路径</td>
				<td width="5%"  align="center"> : </td> 
				<td width="45"  align="left"> <?php  echo $filepath ?>  </td>
			</tr>

		
		</table>
	</body>
</html>