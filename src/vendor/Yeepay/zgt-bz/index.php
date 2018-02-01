<?php

require_once(__DIR__ . "/inc/config.php");

?>
<!DOCTYPE html>
<html>
<head>
<meta charset="<?=__LOCALE__CODE__?>">
<title>掌柜通-标准版 接口演示</title>
<style type="text/css">
table { border-collapse:collapse }

td { font-size:18px; text-indent:2em; height:30px; }
</style>
</head>
<body>
<script language="javascript" id="clientEventHandlersJS">
<!--
var number=2;

function LMYC() {
var lbmc;

    for (i=1;i<=number;i++) {
        lbmc = eval('LM' + i);

        lbmc.style.display = 'none';
    }
}

function ShowFLT(i) {
    lbmc = eval('LM' + i);

    if (lbmc.style.display == 'none') {
        LMYC();

        lbmc.style.display = '';
    }
    else {

        lbmc.style.display = 'none';
    }
}
//-->
</script>
<table width="400" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
 <th align="center" height="20" colspan="1" bgcolor="#6BBE18">
					掌柜通-标准版 接口演示
				</th>
  <tr>
    <td  > + <a onclick="javascript:ShowFLT(1)" href="javascript:void(null)"> 支付部分</a></td>
  </tr>

  <tr id="LM1" style="DISPLAY: none">
    <td><table cellspacing="0" cellpadding="0" width="100%" border="0">
        <tr>
          <td style="padding-left:20px;" > -<a  href="php/pay.php" >4.1 订单支付接口 </a></td>
        </tr>
        <tr>
          <td style="padding-left:20px;" > -<a href="php/paymentQuery.php" >4.2 订单查询接口 </a></td>
        </tr>
        <tr>
          <td style="padding-left:20px;" > -<a  href="php/refund.php" >4.3 订单退款接口 </a></td>
        </tr>
           <tr>
          <td style="padding-left:20px;" > -<a  href="php/refundQuery.php" >4.4 订单退款查询接口 </a></td>
        </tr>
            <tr>
          <td style="padding-left:20px;" > -<a  href="php/confirm.php" >4.5 担保确认接口 </a></td>
        </tr>
                 <tr>
          <td style="padding-left:20px;" > -<a  href="php/bindCardsQuery.php" >4.6 查询绑卡列表接口 </a></td>
        </tr>
                 <tr>
          <td style="padding-left:20px;" > -<a  href="php/unbindCard.php" >4.7 解绑接口</a></td>
        </tr>
                 <tr>
          <td style="padding-left:20px;" > -<a  href="php/cardBinQuery.php" >4.8 卡BIN查询接口</a></td>
        </tr>

      </table></td>
  </tr>

  <tr>
    <td> + <a onclick="javascript:ShowFLT(2)" href="javascript:void(null)">关系资金处理部分 </a></td>
  </tr>
  <tr id="LM2" >
    <td><table cellspacing="0" cellpadding="0" width="100%" border="0">
        <tr>
          <td style="padding-left:20px;" > -<a  href="php/register.php" >5.1 子账户注册接口 </a></td>
        </tr>
        <tr>
          <td style="padding-left:20px;" > -<a href="php/upload.php" >5.2 分账方资质上传接口 </a></td>
        </tr>
        <tr>
          <td style="padding-left:20px;" > -<a href="php/modify.php" >5.3 账户信息修改接口 </a></td>
        </tr>
        <tr>
          <td style="padding-left:20px;" > -<a  href="php/modifyQuery.php" >5.4 账户信息修改查询接口 </a></td>
        </tr>
        <tr>
          <td style="padding-left:20px;" > -<a href="php/transfer.php" >5.5 转账接口 </a></td>
        </tr>
        <tr>
          <td style="padding-left:20px;" > -<a href="php/transferQuery.php" >5.6 转账查询接口 </a></td>
        </tr>
        <tr>
          <td style="padding-left:20px;" > -<a  href="php/divide.php" >5.7 分账接口 </a></td>
        </tr>
        <tr>
          <td style="padding-left:20px;" > -<a href="php/divideQuery.php" >5.8 分账查询接口 </a></td>
        </tr>
        <tr>
          <td style="padding-left:20px;" > -<a href="php/balanceQuery.php" >5.9 余额查询接口 </a></td>
        </tr>

        <tr>
          <td style="padding-left:20px;" > -<a  href="php/settlementQuery.php" >5.10 结算结果查询接口 </a></td>
        </tr>
        <tr>
          <td style="padding-left:20px;" > -<a href="php/download.php" >5.11 对账文件下载接口 </a></td>
        </tr>

        <tr>
          <td style="padding-left:20px;" > -<a href="php/checkRecordQuery.php" >5.12 分账方审核结果查询接口 </a></td>
        </tr>

        <tr>
          <td style="padding-left:20px;" > -<a href="php/idCardAuth.php" >5.13 企业法人补充身份证认证 </a></td>
        </tr>
      </table></td>
  </tr>


</table>
</body>
</html></td>
	  </tr>
	</table>

	