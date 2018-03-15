## LWechatPay
### LWechatPayApp-微信开放平台APP支付
```
$obj = LPay::create(LPayConfig::TYPE_WECHAT_APP, LSConfig::env()->pay->wechatOpen->toArray());
$data = $obj->run(['price' => 1, 'orderSn' => time(), 'body' => '支付物品名称', 'notifyUrl' => '回调地址']);
dump($data);
```
### 微信app支付run之后得到正确结果结构
```
[▼
  "tradeNumber" => "201706271946541498564014"
  "result" => array:7 [▼
    "appid" => "wx514c13c6d4e9ddb9"
    "partnerid" => "1482160102"
    "prepayid" => "wx20170627194651360b7b483b0012252879"
    "package" => "Sign=WXPay"
    "noncestr" => "af5de7edb483cc6738568c13fdc1098a"
    "timestamp" => 1498564014
    "sign" => "FC05283DD7D4B955757B475B5C1630E4"
  ]
]
```
### LWechatPayQrcode-微信公众平台扫码支付
```
$obj = LPay::create(LPayConfig::TYPE_WECHAT_QRCODE, LSConfig::env()->pay->wechatOpen->toArray());
$data = $obj->run(['price' => 1, 'orderSn' => time(), 'body' => '支付物品名称', 'notifyUrl' => '回调地址']);
dump($data);
```
### 微信扫码支付run之后得到正确结果结构
```
[▼
  "tradeNumber" => "201706271949511498564191"
  "result" => "weixin://wxpay/bizpayurl?pr=Xz75ZvV"
]
```
### LWechatPayQrcode-微信公众平台支付回调
```
class MyWechatCallbackReturn implements ILPayReturn
{
    public function returns($originalResult, $result)
    {
        // TODO: $result['price'] 金额(单位:分)
        // TODO: $result['orderSn'] 单号
        // TODO: $result['transactionId'] 此次微信支付的唯一微信支付号
        // TODO: $result['tradeNumber'] 此次微信支付的唯一商户号
        // TODO: $result['time'] 正式支付的时间戳
        // TODO: $result['result'] bool是否支付成功
        // TODO: $result['bank'] 用户支付的银行卡编号
        // TODO: $result['orderSn']已经处理过SUCCESS了请不要重复录库操作
        // TODO: $result maybe null
        // TODO: start your logic with $result
        // TODO: db、i/o、curl and so on
    }
}

$callback = LPay::callback(LPayConfig::CALLBACK_WECHAT, LSConfig::env()->pay->wechatOpen->toArray());
$callback->returns(new MyWechatCallbackReturn());
```
### LWechatPayApp-微信公众平台支付回调
```
class MyWechatCallbackReturn implements ILPayReturn
{
    public function returns($originalResult, $result)
    {
        // TODO: $result['price'] 金额(单位:分)
        // TODO: $result['orderSn'] 单号
        // TODO: $result['transactionId'] 此次微信支付的唯一微信支付号
        // TODO: $result['tradeNumber'] 此次微信支付的唯一商户号
        // TODO: $result['time'] 正式支付的时间戳
        // TODO: $result['result'] bool是否支付成功
        // TODO: $result['bank'] 用户支付的银行卡编号
        // TODO: $result['orderSn']已经处理过SUCCESS了请不要重复录库操作
        // TODO: $result maybe null
        // TODO: start your logic with $result
        // TODO: db、i/o、curl and so on
    }
}

$callback = LPay::callback(LPayConfig::CALLBACK_WECHAT, LSConfig::env()->pay->wechatPublic->toArray());
$callback->returns(new MyWechatCallbackReturn());
```
