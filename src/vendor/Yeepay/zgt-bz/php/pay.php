<?php
require_once(__DIR__ . "/../inc/config.php");

$requestid = "ZGTPAY" . date("ymd_His") . rand(10, 99);

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">


	<style type="text/css">
		tr.common1Close {
			display: none;
		}
		
		tr.commonClose {
			display: none;
		}
		tr.common2Close {
			display: none;
		}
		
	</style>

	<script type="text/javascript">

		function closeCommon() {
			document.getElementById('common01').className='commonClose';
			document.getElementById('common02').className='commonClose';
		  document.getElementById('common03').className='commonClose';
			document.getElementById('common04').className='commonClose';
                        document.getElementById('common05').className='commonClose';
                        document.getElementById('common06').className='commonClose';
                        document.getElementById('common07').className='commonClose';
                       
                        
 
			 
		}

		function openCommon() {
			document.getElementById('common01').className='';
			document.getElementById('common02').className='';
			document.getElementById('common03').className='';
			document.getElementById('common04').className='';
                        document.getElementById('common05').className='';
                        document.getElementById('common06').className='';
                        document.getElementById('common07').className='';
                        
			
		}
		
			function closeCommon1() {
			document.getElementById('common101').className='common1Close';
		}

		  function openCommon1() {
			document.getElementById('common101').className='';
		}
		
					function closeCommon2() {
			document.getElementById('common201').className='common2Close';
		}

		  function openCommon2() {
			document.getElementById('common201').className='';
		}
			
		
	</script>
	
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=<?=__LOCALE__CODE__?>" />
	<title>订单支付接口</title>	
</head>
	<body>
		<table width="80%" border="0" align="center" cellpadding="5" cellspacing="0" style="border:solid 1px #107929">
			<tr>
		  		<th align="center" height="30" colspan="5" bgcolor="#6BBE18">
					请输入订单请求参数	
				</th>
		  	</tr> 

			<form method="post" action="../php/sendPay.php" target="_blank" accept-charset="<?=__LOCALE__CODE__?>">
				<tr >
					<td width="20%" align="left">&nbsp;商户订单号</td>
					<td width="5%"  align="center"> : &nbsp;</td> 
					<td width="55%" align="left"> 
						<input size="70" type="text" name="requestid" value="<?php echo $requestid?>"/>
						<span style="color:#FF0000;font-weight:100;">*</span>
					</td>
					<td width="5%"  align="center"> - </td> 
					<td width="15%" align="left">requestid</td> 
				</tr>

				<tr >
					<td width="20%" align="left">&nbsp;支付金额</td>
					<td width="5%"  align="center"> : &nbsp;</td> 
					<td width="55%" align="left"> 
						<input size="70" type="text" name="amount" value="0.01" />
						<span style="color:#FF0000;font-weight:100;">*</span>
					</td>
					<td width="5%"  align="center"> - </td> 
					<td width="15%" align="left">amount</td> 
				</tr>

				<tr >
					<td width="20%" align="left">&nbsp;是否担保</td>
					<td width="5%"  align="center"> : &nbsp;</td> 
					<td width="55%" align="left"> 
						<input type="radio" name="assure" id="assure_0" value="0" checked />
						<label for="assure_0">非担保交易</label>
						<input type="radio" name="assure" id="assure_1" value="1"/>
						<label for="assure_1">担保交易</label>
					</td>
					<td width="5%"  align="center"> - </td> 
					<td width="15%" align="left">assure</td> 
				</tr> 

				<tr >
					<td width="20%" align="left">&nbsp;商品名称</td>
					<td width="5%"  align="center"> : &nbsp;</td> 
					<td width="55%" align="left"> 
						<input size="70" type="text" name="productname" value="productname" />
					</td>
					<td width="5%"  align="center"> - </td> 
					<td width="15%" align="left">productname</td> 
				</tr>

				<tr >
					<td width="20%" align="left">&nbsp;商品种类</td>
					<td width="5%"  align="center"> : &nbsp;</td> 
					<td width="55%" align="left"> 
						<input size="70" type="text" name="productcat" value="productcat" />
					</td>
					<td width="5%"  align="center"> - </td> 
					<td width="15%" align="left">productcat</td> 
				</tr>

				<tr >
					<td width="20%" align="left">&nbsp;商品描述</td>
					<td width="5%"  align="center"> : &nbsp;</td> 
					<td width="55%" align="left"> 
						<input size="70" type="text" name="productdesc"  placeholder="微信支付时，必填。" />
					</td>
					<td width="5%"  align="center"> - </td> 
					<td width="15%" align="left">productdesc</td> 
				</tr>

				<tr >
					<td width="20%" align="left">&nbsp;分账详情</td>
					<td width="5%"  align="center"> : &nbsp;</td> 
					<td width="55%" align="left"> 
						<input size="70" type="text" name="divideinfo" value="" />
					</td>
					<td width="5%"  align="center"> - </td> 
					<td width="15%" align="left">divideinfo</td> 
				</tr>

				<tr >
					<td width="20%" align="left">&nbsp;后台通知地址</td>
					<td width="5%"  align="center"> : &nbsp;</td> 
					<td width="55%" align="left"> 
						<input size="70" type="text" name="callbackurl" value="http://172.21.0.84/demo/zgt-bz/php/callback.php" />
						<span style="color:#FF0000;font-weight:100;">*</span>
					</td>
					<td width="5%"  align="center"> - </td> 
					<td width="15%" align="left">callbackurl</td> 
				</tr>

				<tr >
					<td width="20%" align="left">&nbsp;页面通知地址</td>
					<td width="5%"  align="center"> : &nbsp;</td> 
					<td width="55%" align="left"> 
						<input size="70" type="text" name="webcallbackurl" value="http://172.21.0.84/demo/zgt-bz/php/callback.php" />
					</td>
					<td width="5%"  align="center"> - </td> 
					<td width="15%" align="left">webcallbackurl</td> 
				</tr>

				<tr >
					<td width="20%" align="left">&nbsp;银行编码</td>
					<td width="5%"  align="center"> : &nbsp;</td> 
					<td width="55%" align="left"> 
						<input size="70" type="text" name="bankid" value="" />
					</td>
					<td width="5%"  align="center"> - </td> 
					<td width="15%" align="left">bankid</td> 
				</tr>

				<tr >
					<td width="20%" align="left">&nbsp;担保有效期时间</td>
					<td width="5%"  align="center"> : &nbsp;</td> 
					<td width="55%" align="left"> 
						<input size="70" type="text" name="period" placeholder="担保交易时必填，最大值30。"value="" />
					</td>
					<td width="5%"  align="center"> - </td> 
					<td width="15%" align="left">period</td> 
				</tr>

				<tr >
					<td width="20%" align="left">&nbsp;商户备注</td>
					<td width="5%"  align="center"> : &nbsp;</td> 
					<td width="55%" align="left"> 
						<input size="70" type="text" name="memo" value="" />
					</td>
					<td width="5%"  align="center"> - </td> 
					<td width="15%" align="left">memo</td> 
				</tr>


				<tr >
					<td width="20%" align="left">&nbsp;订单有效期</td>
					<td width="5%"  align="center"> : &nbsp;</td> 
					<td width="55%" align="left"> 
						<input size="70" type="text" name="orderexpdate" value="" />
					</td>
					<td width="5%"  align="center"> - </td> 
					<td width="15%" align="left">orderexpdate</td> 
				</tr>
				
			
				
				<tr >
					<td width="20%" align="left">&nbsp;支付类型 </td>
					<td width="5%"  align="center"> : &nbsp;</td> 
					<td width="55%" align="left"> 
						
						<input type="radio" name="payproducttype" id="sales_payproducttype" value="SALES" 
						onclick= "openCommon();openCommon1();closeCommon2();"  />
						<label for="SALES"> 网银支付 </label>
						
						<input type="radio" name="payproducttype" id="onekey_payproducttype" value="ONEKEY"
							   onclick="openCommon();openCommon1();openCommon2();"/>
						<label for="ONEKEY"> 移动收银台 </label>
						
						
						<input type="radio" name="payproducttype" id="wechatu_payproducttype" value="WECHATU"
							   onclick="closeCommon();openCommon1();openCommon2();" />
						<label for="WECHATU"> 微信扫码支付 </label>

						<input type="radio" name="payproducttype" id="wx_payproducttype" value="WECHATAPP"
							   onclick="closeCommon();closeCommon1();openCommon2();" />
						<label for="WECHATAPP"> APP-微信支付 </label>
						
		         <input type="radio" name="payproducttype" id="zfb_payproducttype" value="ALIPAYAPP"
							   onclick="closeCommon();closeCommon1();openCommon2();" />
						<label for="ALIPAYAPP"> APP-支付宝 </label>
						
					</td>
					<td width="5%"  align="center"> - </td> 
					<td width="15%" align="left">payproducttype</td> 
				</tr> 



				<tr class="common1Close" id="common101">
					<td width="20%" align="left">&nbsp;用户标识</td>
					<td width="5%"  align="center"> : &nbsp;</td> 
					<td width="55%" align="left"> 
						<input size="70" type="text" name="userno" value="" placeholder="微信公众账号支付时，必填" />
					</td>
					<td width="5%"  align="center"> - </td> 
					<td width="15%" align="left">userno</td> 
				</tr>
				
				<tr class="commonClose" id="common01">
					<td width="20%" align="left">&nbsp;持卡人姓名</td>
					<td width="5%"  align="center"> : &nbsp;</td> 
					<td width="55%" align="left"> 
						<input size="70" type="text" name="cardname"  value="" />
					</td>
					<td width="5%"  align="center"> - </td> 
					<td width="15%" align="left">cardname</td> 
				</tr>

				<tr class="commonClose" id="common02">
					<td width="20%" align="left">&nbsp;身份证号</td>
					<td width="5%"  align="center"> : &nbsp;</td> 
					<td width="55%" align="left"> 
						<input size="70" type="text" name="idcard" value="" />
					</td>
					<td width="5%"  align="center"> - </td> 
					<td width="15%" align="left">idcard</td> 
				</tr>

				<tr class="commonClose" id="common03">
					<td width="20%" align="left">&nbsp;银行卡号</td>
					<td width="5%"  align="center"> : &nbsp;</td> 
					<td width="55%" align="left"> 
						<input size="70" type="text" name="bankcardnum"   value="" />
					</td>
					<td width="5%"  align="center"> - </td> 
					<td width="15%" align="left">bankcardnum</td> 
				</tr>
	
					<tr class="commonClose" id="common04">
					<td width="20%" align="left">&nbsp;预留手机号</td>
					<td width="5%"  align="center"> : &nbsp;</td> 
					<td width="55%" align="left"> 
						<input size="70" type="text" name="mobilephone"   value="" />
					</td>
					<td width="5%"  align="center"> - </td> 
					<td width="15%" align="left">mobilephone</td> 
				</tr>
                                </tr>
	
					<tr class="commonClose" id="common05">
					<td width="20%" align="left">&nbsp;微信公众号appid</td>
					<td width="5%"  align="center"> : &nbsp;</td> 
					<td width="55%" align="left"> 
						<input size="70" type="text" name="appid" value="" />
					</td>
					<td width="5%"  align="center"> - </td> 
					<td width="15%" align="left">appid</td> 
				</tr>
                                
                                   </tr>
	
					<tr class="commonClose" id="common06">
					<td width="20%" align="left">&nbsp;公众号用户openid</td>
					<td width="5%"  align="center"> : &nbsp;</td> 
					<td width="55%" align="left"> 
						<input size="70" type="text" name="openid" value="" />
					</td>
					<td width="5%"  align="center"> - </td> 
					<td width="15%" align="left">openid</td> 
				</tr>
                                
                                 </tr>
	
					<tr class="commonClose" id="common07">
					<td width="20%" align="left">&nbsp;直联代码</td>
					<td width="5%"  align="center"> : &nbsp;</td> 
					<td width="55%" align="left"> 
						<input size="70" type="text" name="directcode" value="" placeholder="WAP-ZHT:一键支付，WAP_WECHATAPP:微信支付，WAP_ALIPAYAP：支付宝，WAP_WECHATG:公众号"/>
					</td>
					<td width="5%"  align="center"> - </td> 
					<td width="15%" align="left">directcode</td> 
				</tr>
				
					<tr class="common2Close" id="common201">
					<td width="20%" align="left">&nbsp;用户IP</td>
					<td width="5%"  align="center"> : &nbsp;</td> 
					<td width="55%" align="left"> 
						<input size="70" type="text" name="ip" value="" />
					</td>
					<td width="5%"  align="center"> - </td> 
					<td width="15%" align="left">ip</td> 
				</tr>
			

				<tr >
					<td width="20%" align="left">&nbsp;</td>
					<td width="5%"  align="center">&nbsp;</td> 
					<td width="55%" align="left"> 
						<input type="submit" value="提交订单" />
					</td>
					<td width="5%"  align="center">&nbsp;</td> 
					<td width="15%" align="left">&nbsp;</td> 
				</tr>

			</form>
		</table>
</body>
</html>
