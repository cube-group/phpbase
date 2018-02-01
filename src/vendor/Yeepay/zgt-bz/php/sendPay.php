<?php
//ob_start();
require_once(__DIR__ . "/../inc/config.php");

define("__BIZ__", "pay");
 
 function hex2byte( $str ) {
        $sbin = "";
        $len = strlen( $str );
        for ( $i = 0; $i < $len; $i += 2 ) {
            $sbin .= pack( "H*", substr( $str, $i, 2 ) );
        }

        return $sbin;
    }
//根据支付的类型（网银，一键支付，账号支付，微信支付，无卡直连，将必填参数配置扩展）
if ( !array_key_exists("payproducttype", $_REQUEST) ) {
			
	throw new ZGTException("payproducttype of request is not found.");
}
$infConfig[__BIZ__]["mustFillRequest"]
	 = array_merge($infConfig[__BIZ__]["mustFillRequest"],
	 				 $infConfig[__BIZ__]["mustFillRequest_" . strtoupper($_REQUEST["payproducttype"])]);
//print_r($infConfig[__BIZ__]["mustFillRequest"]);
//exit();

$req = new RequestService(__BIZ__);
$req->sendRequest($_REQUEST);
$req->receviceResponse();

$request = $req->getRequest();
$response = $req->getResponseData();
if ($request["payproducttype"] == "WECHATU")
{
	
	      $img= hex2byte($response["payurl"]);   
				$path='./2weima/';
        $filename = @"$path".'/'.time().".png";    // 写入的文件   // 写入的文件     
        $file = fopen($filename,"w");//打开文件准备写入 
        fwrite($file,$img);//写入 
        fclose($file);//关闭  
       
        echo "<img src=$filename> ";
        return;
    
} 
  


if( $response["payurl"] ) {

	//如果有支付链接，如需自动跳转，请打开下面两行的注释。以及页头ob_start()的注释
	//header("Location: ${response["payurl"]}");
	//exit();
	
}

?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gbk">
<title>订单支付结果</title>
</head>
	<body>
		<br /> <br />
		<table width="70%" border="0" align="center" cellpadding="5" cellspacing="0" 
							style="word-break:break-all; border:solid 1px #107929">
			<tr>
		  		<th align="center" height="30" colspan="5" bgcolor="#6BBE18">
					订单支付结果
				</th>
		  	</tr>

			<tr>
				<td width="15%" align="left">&nbsp;商户编号</td>
				<td width="5%"  align="center"> : </td> 
				<td width="60%" align="left"> <?php  echo $response["customernumber"]?> </td>
				<td width="5%"  align="center"> - </td> 
				<td width="15%" align="left">customernumber</td> 
			</tr>

			<tr>
				<td width="15%" align="left">&nbsp;返回码</td>
				<td width="5%"  align="center"> : </td> 
				<td width="60%" align="left"> <?php  echo $response["code"]?> </td>
				<td width="5%"  align="center"> - </td> 
				<td width="15%" align="left">code</td> 
			</tr>

			<tr>
				<td width="15%" align="left">&nbsp;商户订单号</td>
				<td width="5%"  align="center"> : </td> 
				<td width="60%" align="left"> <?php  echo $response["requestid"]?> </td>
				<td width="5%"  align="center"> - </td> 
				<td width="15%" align="left">requestid</td> 
			</tr>

			<tr>
				<td width="15%" align="left">&nbsp;易宝流水号</td>
				<td width="5%"  align="center"> : </td> 
				<td width="60%" align="left"> <?php  echo $response["externalid"]?> </td>
				<td width="5%"  align="center"> - </td> 
				<td width="15%" align="left">externalid</td> 
			</tr>

			<tr>
				<td width="15%" align="left">&nbsp;订单金额</td>
				<td width="5%"  align="center"> : </td> 
				<td width="60%" align="left"> <?php  echo $response["amount"]?> </td>
				<td width="5%"  align="center"> - </td> 
				<td width="15%" align="left">amount</td> 
			</tr>

			

			<tr>
				<td width="15%" align="left"  >&nbsp;支付链接</td>
				<td width="5%"  align="center"  > : </td> 
				<td width="60%" align="left"  > 				
					<a href=<?php  echo $response["payurl"]?> style="text-decoration:none" target="_blank"> 
						<?php  echo $response["payurl"]?>
					</a> 
				
				</td>
				<td width="5%"  align="center" > - </td> 
				<td width="15%" align="left" >payurl</td> 
			</tr>

		</table>

	</body>
</html>
