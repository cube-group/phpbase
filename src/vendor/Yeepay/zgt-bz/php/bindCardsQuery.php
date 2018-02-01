<?php
require_once(__DIR__ . "/../inc/config.php");
?>
<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html;charset=gbk" />
		<title> 查询绑卡列表接口</title>
	</head>
<body>
<br> <br>
	<table width="80%" border="0" align="center" cellpadding="9" cellspacing="0" style="border:solid 1px #107929">
			<tr>
		  		<th align="center" height="30" colspan="5" bgcolor="#6BBE18">
					 查询绑卡列表接口	
				</th>
		  	</tr> 

			<form method="post" action="../php/sendBindCardsQuery.php" target="_blank" accept-charset="gbk">
							<tr >
					<td width="20%" align="left">&nbsp;用户标识</td>
					<td width="5%"  align="center"> : &nbsp;</td> 
					<td width="55%" align="left"> 
						<input size="70" type="text" name="userno" value="" />
						<span style="color:#FF0000;font-weight:100;">*</span>
					</td>
					<td width="5%"  align="center"> - </td> 
					<td width="15%" align="left">userno</td> 
				</tr>
				
										<tr >
					<td width="20%" align="left">&nbsp;绑卡 ID</td>
					<td width="5%"  align="center"> : &nbsp;</td> 
					<td width="55%" align="left"> 
						<input size="70" type="text" name="bindid" value="" />
						
					</td>
					<td width="5%"  align="center"> - </td> 
					<td width="15%" align="left">bindid</td> 
				</tr>
				
				<tr >
					<td width="20%" align="left">&nbsp;</td>
					<td width="5%"  align="center">&nbsp;</td> 
					<td width="55%" align="left"> 
						<input type="submit" value="单击查询" />
					</td>
					<td width="5%"  align="center">&nbsp;</td> 
					<td width="15%" align="left">&nbsp;</td> 
				</tr>
				
			</form>
		</table>
</body>
</html>
