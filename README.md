# API开发文档
行情API

获取行情 (GET)

BTC：http://api.btctrade.com/api/ticker?coin=btc <br>
ETH：http://api.btctrade.com/api/ticker?coin=eth <br>
LTC：http://api.btctrade.com/api/ticker?coin=ltc <br>
DOGE：http://api.btctrade.com/api/ticker?coin=doge <br>
YBC：http://api.btctrade.com/api/ticker?coin=ybc <br>
返回结果示例： <br>
{"high":0,"low":0,"buy":1850,"sell":1851.1,"last":1851.1,"vol":10000,"time":1420711226} <br>
返回结果说明： <br>
high: 最高价 <br>
low: 最低价 <br>
buy: 买一价 <br>
sell: 卖一价 <br>
last: 最新成交价 <br>
vol: 成交量(最近的24小时) <br>
time: 返回数据时服务器时间 <br>
深度行情 (GET) <br>
 <br>
BTC：http://api.btctrade.com/api/depth?coin=btc <br>
ETH：http://api.btctrade.com/api/depth?coin=eth <br>
LTC：http://api.btctrade.com/api/depth?coin=ltc <br>
DOGE：http://api.btctrade.com/api/depth?coin=doge <br>
YBC：http://api.btctrade.com/api/depth?coin=ybc <br>
返回结果示例： <br>
{"result":true,"asks":[["2350","2.607"]],"bids":[["1850","1.031"]]} <br>
返回结果说明： <br>
asks: 卖方深度[价格, 委单量]，价格从高到低排序 <br>
bids: 买方深度[价格, 委单量]，价格从高到低排序 <br>
成交记录 (GET) <br>
 <br>
BTC：http://api.btctrade.com/api/trades?coin=btc <br>
ETH：http://api.btctrade.com/api/trades?coin=eth <br>
LTC：http://api.btctrade.com/api/trades?coin=ltc <br>
DOGE：http://api.btctrade.com/api/trades?coin=doge <br>
YBC：http://api.btctrade.com/api/trades?coin=ybc <br>
请求参数： <br>
coin: 交易币种 <br>
since: 根据记录id返回，默认返回最新的100条交易记录 <br>
返回结果示例： <br>
[{"date":"1420713686","price":1773.1,"amount":0.656,"tid":"5236256","type":"buy"}] <br>
返回结果说明： <br>
date: 成交时间 <br>
price: 交易价格 <br>
amount: 交易数量 <br>
tid: 交易ID <br>
type: 交易类型 <br>
交易API <br>
 <br>
安全认证 <br>
 <br>
第一步，获取API认证的公钥和私钥 <br>
请求交易API，需要获取公钥和私钥，点击申请。 <br>
注意：密钥关乎您的账号安全，请不要向任何人泄露 <br>
第二步，生成待签名字符串 <br>
请求API的参数都要参与签名(signature除外)，例如， <br>
请求参数：{key: xxxxxx, coin: btc, amount=1.234, price: 543, version: 2} <br>
生成待签名字符串为：key=xxxxxx&coin=btc&amount=1.234&price=543&version=2 <br>
注意：version参数必选，否则无法通过验证，传值固定为 2 <br>
第三步，签名 <br>
使用 sha256 制作签名，并将签名赋值于参数 signature，一并请求交易API接口。 <br>
PHP示例：hash_hmac('sha256', '#待签名字符串#', md5(私钥)); <br>
获取账户信息 (POST) <br>
 <br>
http://api.btctrade.com/api/balance/ <br>
参数 <br> 
key: 公钥 <br>
signature: 签名 <br>
nonce: 自增数 <br>
返回结果示例： <br>
{"uid":123,"nameauth":0,"moflag":"0","asset":"1861.36","btc_balance":0,"btc_reserved":0,"ltc_balance":0,"ltc_reserved":0, "doge_balance":0,"doge_reserved":0,"ybc_balance":0,"ybc_reserved":0,"cny_balance":0,"cny_reserved":0} <br>
返回结果说明： <br>
uid: 用户id <br>
nameauth: 是否实名认证 1 实名, 0 未实名 <br>
moflag: 是否绑定手机 1 绑定, 0 未绑 <br>
asset: 折合资产 <br>
*_balance: 币种余额 <br>
*_reserved: 币种冻结 <br>
挂单查询 (POST): 指定时间后的挂单，可以根据类型查询，比如查看正在挂单和全部挂单 <br>
 <br>
http://api.btctrade.com/api/orders/ <br>
参数 <br>
coin: 交易币种（btc,eth,ltc,doge,ybc）
key: 公钥
signature: 签名
nonce: 自增数
type: 挂单类型[open:正在挂单, all:所有挂单]
since: 时间戳, 查询某个时间戳之后的挂单
ob: 排序, ASC,DESC
返回结果示例：
[{"id":"123","datetime":"2013-01-02 14:09:01","type":"buy","coin":"1","status":"cancelled","price":543,"amount_original":1.234,"amount_outstanding":1.234}]
返回结果说明：
id: 挂单ID
datetime: 挂单时间
type: 类型（buy, sell）
price: 挂单价格
status: 状态：open(开放), closed(全部成交), cancelled(撤消)
amount_original: 挂单数量
amount_outstanding: 剩余数量
查询订单信息 (POST)

http://api.btctrade.com/api/fetch_order/
参数
key: 公钥
signature: 签名
nonce: 自增数
id: 挂单ID
返回结果示例：
{"id":1,"datetime":"2014-11-19 22:23:17","type":"sell","price":1544,"amount_original":0.18,"amount_outstanding":0,"status":"closed","trades":{"sum_number":"0.180","sum_money":"313.92","avg_price":1244}}
返回结果说明：
id: 挂单ID
datetime: 挂单时间
type: 类型（buy, sell）
price: 挂单价格
amount_original: 挂单数量
amount_outstanding: 剩余数量
status: 状态：open(开放), closed(结束), cancelled(撤消)
sum_number: 成交总数量
sum_money: 成交额
avg_price: 成交均价
完整权限方法列表

取消挂单 (POST)

http://api.btctrade.com/api/cancel_order/
参数
key: 公钥
signature: 签名
nonce: 自增数
id: 挂单ID
返回结果示例：
{"result":true,"message":"success"}
挂买单 (POST)

http://api.btctrade.com/api/buy/
参数
key: 公钥
signature: 签名
nonce: 自增数
coin: 交易币种（btc,eth,ltc,doge,ybc）
amount: 购买数量
price: 购买价格
返回结果示例：
{"result":true,"id":123}
返回结果说明：
id: 挂单ID
result: true(成功), false(失败)
挂卖单 (POST)

http://api.btctrade.com/api/sell/
参数
key: 公钥
signature: 签名
nonce: 自增数
coin: 交易币种（btc,eth,ltc,doge,ybc）
amount: 购买数量
price: 购买价格
返回结果示例：
{"result":true,"id":123}
返回结果说明：
id: 挂单ID
result: true(成功), false(失败)
