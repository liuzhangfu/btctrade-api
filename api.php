<?php
# 实例化
$api = new btctrade;

# 获取资产
$api->balance();

# 挂单查询
$api->orders();

# 查询订单信息
$api->fetch_order(123);

# 取消挂单
$api->cancel_order(123);

# 挂买单
$api->buy('ltc', 12, 1);

# 挂卖单
$api->sell('ltc', 100, 1);

class btctrade
{
	const ACCESS_KEY = 'xxxxx-xxxxx-xxxxx-xxxxx-xxxxx-xxxxx-xxxxx';
	const SECRET_KEY = '*****************************************';

	/**
	 * 获取账号资产信息
	 */
	public function balance()
	{
		return $this->_request('balance');
	}

	/**
	 * 挂单查询
	 * @param string $coin
	 * @param string $type
	 * @return mixed
	 */
	public function orders($coin = 'btc', $type = 'open')
	{
		return $this->_request('orders', array('coin'=>$coin, 'type'=>$type));
	}

	/**
	 * 查询订单信息
	 * @param int $id
	 * @return mixed
	 */
	public function fetch_order($id)
	{
		return $this->_request('fetch_order', array('id'=>$id));
	}

	/**
	 * 取消挂单
	 * @param int $id
	 * @return mixed
	 */
	public function cancel_order($id)
	{
		return $this->_request('cancel_order', array('id'=>$id));
	}

	/**
	 * 挂买单
	 * @param float $price 价格
	 * @param float $amount 数量
	 * @return bool
	 */
	public function buy($coin, $price, $amount)
	{
		return $this->_request('buy', array('price' => $price, 'coin' => $coin, 'amount' => $amount));
	}

	/**
	 * 挂买单
	 * @param float $price 价格
	 * @param float $amount 数量
	 * @return bool
	 */
	public function sell($coin, $price, $amount)
	{
		return $this->_request('sell', array('price' => $price, 'coin' => $coin, 'amount' => $amount));
	}

	/**
	 * 执行请求
	 */
	private function _request($path, $params = array()){
		static $ch = null;
		if(is_null($ch)){
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; BtcTrade PHP client; ' . php_uname('s') . '; PHP/' . phpversion() . ')');
		}
		# 唯一的数字
		$mt = explode(' ', microtime());
		$params['nonce'] = $mt[1] . substr($mt[0], 2, 3);
		$params['version'] = 2;
		$params['key'] = self::ACCESS_KEY;
		$params['signature'] = hash_hmac('sha256', http_build_query($params, '', '&'), md5(self::SECRET_KEY));
		# 参数设定
		curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params, '', '&'));
		curl_setopt($ch, CURLOPT_URL, 'http://api.btctrade.com/api/' . $path);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		return json_decode(curl_exec($ch), true);
	}
}
?>
							