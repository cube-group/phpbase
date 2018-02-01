<?php

require_once(__DIR__ . "/../inc/config.php");
define("__BIZ__", "upload");

if (($_FILES["file"]["type"] == "image/gif") || ($_FILES["file"]["type"] == "image/jpeg") || ($_FILES["file"]["type"] == "image/jpg")|| ($_FILES["file"]["type"] == "image/pjpeg")
|| ($_FILES["file"]["type"] == "image/png")
&& ($_FILES["file"]["size"] < 512000))
  {
  if ($_FILES["file"]["error"] > 0)
    {
    echo "Return Code: " . $_FILES["file"]["error"] . "<br />";
    }
  else
    {
    echo "Upload: " . $_FILES["file"]["name"] . "<br />";
    echo "Type: " . $_FILES["file"]["type"] . "<br />";
    echo "Size: " . ($_FILES["file"]["size"] / 1024) . " Kb<br />";
    echo "Temp file: " . $_FILES["file"]["tmp_name"] . "<br />";

    if (file_exists("upload/" . $_FILES["file"]["name"]))
      {
      echo $_FILES["file"]["name"] . " already exists. ";
      }
    else
      {
      move_uploaded_file($_FILES["file"]["tmp_name"],
      "upload/" . $_FILES["file"]["name"]);
      echo "Stored in: " . "upload/" . $_FILES["file"]["name"];
      }
    }
  }
else
  {
  echo "Invalid file";
  }

$req = new RequestService(__BIZ__);
$req->sendRequest($_REQUEST);
$req->receviceResponse();

$request = $req->getRequest();
$response = $req->getResponseData(); 


?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?=__LOCALE__CODE__?>">
<title>分账方资质上传结果</title>
</head>
	<body>	
		<br /> <br />
		<table width="70%" border="0" align="center" cellpadding="5" cellspacing="0" 
												style="word-break:break-all; border:solid 1px #107929">
			<tr>
		  		<th align="center" height="30" colspan="5" bgcolor="#6BBE18">
					分账方资质上传结果
				</th>
		  	</tr>

			<tr >
				<td width="25%" align="left">&nbsp;主商户编号</td>
				<td width="5%"  align="center"> : </td> 
				<td width="45"  align="left"> <?=$response["customernumber"];?> </td>
				<td width="5%"  align="center"> - </td> 
				<td width="30%" align="left">customernumber</td> 
			</tr>

			<tr>
				<td width="25%" align="left">&nbsp;分账方编号</td>
				<td width="5%"  align="center"> : </td> 
				<td width="35%" align="left"> <?=$response["ledgerno"];?> </td>
				<td width="5%"  align="center"> - </td> 
				<td width="30%" align="left">ledgerno</td> 
			</tr>


			<tr>
				<td width="25%" align="left">&nbsp;返回码</td>
				<td width="5%"  align="center"> : </td> 
				<td width="35%" align="left"> <?=$response["code"];?> </td>
				<td width="5%"  align="center"> - </td> 
				<td width="30%" align="left">code</td> 
			</tr>

		<tr>
				<td width="25%" align="left">&nbsp;文件类型</td>
				<td width="5%"  align="center"> : </td> 
				<td width="35%" align="left"> <?=$response['filetype'];?></td>
				<td width="5%"  align="center"> - </td> 
				<td width="30%" align="left">filetype</td> 
			</tr>

		<tr>
				<td width="25%" align="left">&nbsp;分账方状态</td>
				<td width="5%"  align="center"> : </td> 
				<td width="35%" align="left"> <?=$response['active'];?></td>
				<td width="5%"  align="center"> - </td> 
				<td width="30%" align="left">active</td> 
			</tr>
		</table>
	</body>
</html>