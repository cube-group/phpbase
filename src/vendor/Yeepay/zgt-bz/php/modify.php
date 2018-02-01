<?php
require_once(__DIR__ . "/../inc/config.php");

$requestid = "ZGTREGISTER" . date("ymd_His") . rand(10, 99);

?>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=<?=__LOCALE__CODE__?>" />
	<title>账户信息修改接口</title>
</head>
	<body>
		<table width="80%" border="0" align="center" cellpadding="5" cellspacing="0" style="border:solid 1px #107929">
			<tr>
		  		<th align="center" height="30" colspan="5" bgcolor="#6BBE18">
					账户信息修改接口
				</th>
		  	</tr> 

			<form method="POST" action="../php/sendModify.php" target="_blank" accept-charset="<?=__LOCALE__CODE__?>">
				<tr >
					<td width="20%" align="left">&nbsp;修改请求号</td>
					<td width="5%"  align="center"> : &nbsp;</td> 
					<td width="55%" align="left"> 
						<input size="70" type="text" name="requestid" value="<?=$requestid?>"/>
						<span style="color:#FF0000;font-weight:100;">*</span>
					</td>
					<td width="5%"  align="center"> - </td> 
					<td width="15%" align="left">requestid</td> 
				</tr>

				<tr >
					<td width="20%" align="left">&nbsp;子账户商编</td>
					<td width="5%"  align="center"> : &nbsp;</td> 
					<td width="55%" align="left"> 
						<input size="70" type="text" name="ledgerno" value="" />
				
					</td>
					<td width="5%"  align="center"> - </td> 
					<td width="15%" align="left">ledgerno</td> 
				</tr>

				<tr >
					<td width="20%" align="left">&nbsp;银行卡号</td>
					<td width="5%"  align="center"> : &nbsp;</td> 
					<td width="55%" align="left"> 
						<input size="70" type="text" name="bankaccountnumber" value=""/>
						<span style="color:#FF0000;font-weight:100;">*</span>
					</td>
					<td width="5%"  align="center"> - </td> 
					<td width="15%" align="left">bankaccountnumber</td> 
				</tr> 


				<tr >
					<td width="20%" align="left">&nbsp;开户行</td>
					<td width="5%"  align="center"> : &nbsp;</td> 
					<td width="55%" align="left"> 
						<input size="70" type="text" name="bankname" value="" />
						<span style="color:#FF0000;font-weight:100;">*</span>
					</td>
					<td width="5%"  align="center"> - </td> 
					<td width="15%" align="left">bankname</td> 
				</tr>

				<tr >
					<td width="20%" align="left">&nbsp;开户名</td>
					<td width="5%"  align="center"> : &nbsp;</td> 
					<td width="55%" align="left"> 
						<input size="70" type="text" name="accountname" value="" />
						<span style="color:#FF0000;font-weight:100;">*</span>
					</td>
					<td width="5%"  align="center"> - </td> 
					<td width="15%" align="left">accountname</td> 
				</tr>

				<tr >
					<td width="20%" align="left">&nbsp;银行卡类别</td>
					<td width="5%"  align="center"> : &nbsp;</td> 
					<td width="55%" align="left"> 
						<input size="70" type="text" name="bankaccounttype" value="PrivateCash" />
					</td>
					<td width="5%"  align="center"> - </td> 
					<td width="15%" align="left">bankaccounttype</td> 
				</tr>


				<tr >
					<td width="20%" align="left">&nbsp;开户省</td>
					<td width="5%"  align="center"> : &nbsp;</td> 
					<td width="55%" align="left"> 
						<input size="70" type="text" name="bankprovince" value="" />
					</td>
					<td width="5%"  align="center"> - </td> 
					<td width="15%" align="left">bankprovince</td> 
				</tr>

				

				<tr >
					<td width="20%" align="left">&nbsp;开户市</td>
					<td width="5%"  align="center"> : &nbsp;</td> 
					<td width="55%" align="left"> 
						<input size="70" type="text" name="bankcity" value="" />
						<span style="color:#FF0000;font-weight:100;">*</span>
					</td>
					<td width="5%"  align="center"> - </td> 
					<td width="15%" align="left">bankcity</td> 
				</tr>

		

				<tr >
					<td width="20%" align="left">&nbsp;起结金额</td>
					<td width="5%"  align="center"> : &nbsp;</td> 
					<td width="55%" align="left"> 
						<input size="70" type="text" name="minsettleamount" value="1" />
						<span style="color:#FF0000;font-weight:100;">*</span>
					</td>
					<td width="5%"  align="center"> - </td> 
					<td width="15%" align="left">minsettleamount</td> 
				</tr>

				<tr >
					<td width="20%" align="left">&nbsp;结算周期</td>
					<td width="5%"  align="center"> : &nbsp;</td> 
					<td width="55%" align="left"> 
						<input size="70" type="text" name="riskreserveday" value="1" />
						<span style="color:#FF0000;font-weight:100;">*</span>
					</td>
					<td width="5%"  align="center"> - </td> 
					<td width="15%" align="left">riskreserveday</td> 
				</tr>

				<tr >
					<td width="20%" align="left">&nbsp;自助结算</td>
					<td width="5%"  align="center"> : &nbsp;</td> 
					<td width="55%" align="left"> 
						<input size="70" type="text" name="manualsettle" value="" />
					
					</td>
					<td width="5%"  align="center"> - </td> 
					<td width="15%" align="left">manualsettle</td> 
				</tr>

				<tr >
					<td width="20%" align="left">&nbsp;后台回调地址</td>
					<td width="5%"  align="center"> : &nbsp;</td> 
					<td width="55%" align="left"> 
						<input size="70" type="text" name="callbackurl" value="" />
						<span style="color:#FF0000;font-weight:100;">*</span>
					</td>
					<td width="5%"  align="center"> - </td> 
					<td width="15%" align="left">callbackurl</td> 
				</tr>

				<tr >
					<td width="20%" align="left">&nbsp;绑定手机号</td>
					<td width="5%"  align="center"> : &nbsp;</td> 
					<td width="55%" align="left"> 
						<input size="70" type="text" name="bindmobile" value="" />
						<span style="color:#FF0000;font-weight:100;">*</span>
					</td>
					<td width="5%"  align="center"> - </td> 
					<td width="15%" align="left">bindmobile</td> 
				</tr>

			

				<tr >
					<td width="20%" align="left">&nbsp;</td>
					<td width="5%"  align="center">&nbsp;</td> 
					<td width="55%" align="left"> 
						<input type="submit" value="提交" />
					</td>
					<td width="5%"  align="center">&nbsp;</td> 
					<td width="15%" align="left">&nbsp;</td> 
				</tr>

			</form>
		</table>
</body>
</html>
