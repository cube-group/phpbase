

<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">

<html>
<head>
	<meta charset="UTF-8" />
	<title>分账方资质上传接口</title>
</head>

<body>
	<br><br>
	<table width="80%" border="0" align="center" cellpadding="9" cellspacing="0" style="border:solid 1px #107929">
		<tr>
	  		<th align="center" height="30" colspan="2" bgcolor="#6BBE18">
				分账方资质上传接口
			</th>
	  	</tr> 

		<form method="post" action="../php/sendUpload.php" target="_blank" enctype="multipart/form-data" accept-charset="UTF-8">

			<tr >
				<td width="30%" align="right">分账方编号[ledgerno]:</td>
				<td width="70%" align="left"> 
					<input size="50" type="text" name="ledgerno" value="10013395720" >
					<span style="color:#FF0000;font-weight:100;">*</span>
				</td>
			</tr>

			<tr >
				<td width="30%" align="right">文件类型[filetype]:</td>
				<td width="70%" align="left"> 

					<select name="filetype">
						<option value="ID_CARD_FRONT">ID_CARD_FRONT－身份证正面</option>
						<option value="ID_CARD_BACK">ID_CARD_BACK－身份证背面</option>
						<option value="BANK_CARD_FRONT">BANK_CARD_FRONT－银行卡正面</option>
						<option value="BANK_CARD_BACK">BANK_CARD_BACK－银行卡背面</option>
						<option value="PERSON_PHOTO">PERSON_PHOTO－手持身份证照片</option>
						<option value="BUSSINESS_LICENSE">BUSSINESS_LICENSE－营业执照</option>
						<option value="BUSSINESS_CERTIFICATES">BUSSINESS_CERTIFICATES－工商证</option>
						<option value="ORGANIZATION_CODE">ORGANIZATION_CODE－组织机构代码证</option>
						<option value="TAX_REGISTRATION">TAX_REGISTRATION－税务登记证</option>
						<option value="BANK_ACCOUNT_LICENCE">BANK_ACCOUNT_LICENCE－银行开户许可证</option>
					</select>
					<span style="color:#FF0000;font-weight:100;">*</span>
				</td>
			</tr>

			<tr >
				<td width="30%" align="right">上传图片:</td>
				<td width="70%" align="left"> 
					<input size="70" type=file id="file" name="file" >
				</td>
			</tr>
			
			<tr >
				<td width="30%" align="left">&nbsp;</td>
				<td width="70%" align="left"> 
					<input type="submit" value="submit" />
				</td>
			</tr>
		</form>
	</table>
</body>
</html>

