<?php
error_reporting(0);
// composer vendor
require_once('../vendor/autoload.php');

// Version
define('VERSION', '2.1.0.2');

// Configuration
if (is_file('config.php')) {
	require_once('config.php');
}

//VirtualQMOD
require_once('../vqmod/vqmod.php');
VQMod::bootup();

// VQMODDED Startup
require_once(VQMod::modCheck(DIR_SYSTEM . 'startup.php'));


// Registry
$registry = new Registry();

// Config
$config = new Config();
$registry->set('config', $config);

// Database
$db = new DB(DB_DRIVER, DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE, DB_PORT);
$registry->set('db', $db);

// Session
$session = new Session();
$registry->set('session', $session);

// 文件锁,避免重复发送邮件
$lock = 'send.lock';
if(is_file($lock)){
    $life = time() - filemtime($lock);
    if($life > 1200){
        unlink($lock);
    }else {
        die('已经在运行邮件');
    }
}
touch($lock);
chmod($lock,0777);

// 查询send
$sql = 'SELECT * FROM '.DB_PREFIX.'order_send where is_send = 0;';
$to_send = $db->query($sql)->rows;


$request_url = HTTP_CATALOG . 'index.php?route=api/order/history';


if(!empty($to_send)){
	foreach($to_send as $item){
		$new_url = $request_url . '&order_id='.$item['order_id'];
		$new_body = [
			'order_id' => $item['order_id'],
			'order_status_id' => $item['batch_status'],
			'notify'=>$item['batch_notify'],
			'override'=>'0',
			'comment' => $item['batch_comment'],
			'qc_photo' => 1
		];
		if(!empty($item['choose_email'])){
			$new_body['choose_email']=$item['choose_email'];
		}

		$result_send =  post($new_url,$new_body);
		print_r($result_send);
		if(!empty($result_send)){
            if (isset($result_send['success'])) {
                $message = $result_send['success'];
                $is_send = 1;
            }else{
                $message = $result_send['error'];
                $is_send = 2;
            }
		}else{
			$message = '发送失败,请重试!';
			$is_send = 2;
		}
		$sql = "update ".DB_PREFIX."order_send set is_send = ".$is_send.",message = '".$message."' where os_id = ".$item['os_id']; 
		$db->query($sql);
		
		sleep($item['batch_frequency']);
	}
}else{
	echo '没有订单需要发送邮件';
}

unlink($lock);
die('邮件发送脚本运行结束');


/**
 * 发送邮件
 */
function post($url,$body){
	try {
		$options = [
			'form_params' => $body,
		];

		$client = new GuzzleHttp\Client();
		$response = $client->request('POST', $url , $options);

		$return = [];
		if(!empty($response->getBody())){
			$return = json_decode((string)$response->getBody(), true);
		}
		echo (string)$response->getBody();
		return $return;
	} catch (RequestException $e) {
		return $e->getMessage();
	} catch (GuzzleException $e){
		return $e->getMessage();
	} catch (Exception $e){
		return $e->getMessage();
	}
}

