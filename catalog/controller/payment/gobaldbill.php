<?php

class ControllerPaymentGobaldbill extends Controller {

    public function index() {

        $data['button_confirm'] = $this->language->get('button_confirm');

        $this->load->model('checkout/order');
        $this->language->load('payment/gobaldbill');

        $data['text_credit_card'] = $this->language->get('text_credit_card');
        $data['text_wait'] = $this->language->get('text_wait');

        $data['entry_cc_owner'] = $this->language->get('entry_cc_owner');
        $data['entry_cc_number'] = $this->language->get('entry_cc_number');
        $data['entry_cc_expire_date'] = $this->language->get('entry_cc_expire_date');
        $data['entry_cc_cvv2'] = $this->language->get('entry_cc_cvv2');
		$data['entry_cc_type'] = $this->language->get('entry_cc_type');

        $data['months'] = array();

        for ($i = 1; $i <= 12; $i++) {
            $data['months'][] = array(
                'text' => strftime('%B', mktime(0, 0, 0, $i, 1, 2000)),
                'value' => sprintf('%02d', $i)
            );
        }

        $today = getdate();

        $data['year_expire'] = array();

        for ($i = $today['year']; $i < $today['year'] + 11; $i++) {
            $data['year_expire'][] = array(
                'text' => strftime('%Y', mktime(0, 0, 0, 1, 1, $i)),
                'value' => strftime('%Y', mktime(0, 0, 0, 1, 1, $i))
            );
        }

        $this->id = 'payment';

        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/payment/gobaldbill.tpl')) {
            return $this->load->view($this->config->get('config_template') . '/template/payment/gobaldbill.tpl', $data);
        } else {
            return $this->load->view('default/template/payment/gobaldbill.tpl', $data);
        }
    }

    public function send() {

        $this->load->model('checkout/order');
		$this->load->model('account/order');

        $order_info = $this->model_checkout_order->getOrder($this->session->data['order_id']);

        $miyao = trim($this->config->get('gobaldbill_key'));

        $var = array();

        $var['merNo'] = trim($this->config->get('gobaldbill_merchantno'));

        //商户订单编号
        $var['orderNo'] = $this->session->data['order_id'];
        ;

        //支付币种
        $var['currency'] = $order_info['currency_code'];

        //订单金额
        $var['amount'] = number_format($this->currency->format($order_info['total'], $order_info['currency_code'], $order_info['currency_value'], false), 2, '.', '');

        $var['productType'] = '0';

        //界面语言  GB---GB中文（缺省）、EN---英文、BIG5---BIG5中文、JP---日文、FR---法文
        $lang_array = array('en', 'it', 'jp', 'ja', 'pt', 'de', 'fr', 'es', 'ru');
        $browser_lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 4);
        $lang = 'en'; //默认en
        foreach ($lang_array as $l) {
            if (preg_match("/{$l}/i", $browser_lang)) {
                $lang = $l;
                break;
            }
        }
        $var['language'] = $lang;

        //商品名称、商品描述、商户数据包
		$products = $this->model_account_order->getOrderProducts($this->session->data['order_id']);
        foreach ($products as $v) {
            $goodsName[] = $v['name'];
            $goodsPrice[] = $this->currency->format($v['price'], $order_info['currency_code'], $order_info['currency_value'], FALSE);
            $goodsNumber[] = $v['quantity'];
        }
        $var["goodsName"] = join(',', $goodsName);
        $var["goodsPrice"] = join(',', $goodsPrice);
        $var["goodsNumber"] = join(',', $goodsNumber);

        //返回URL
        $var['returnURL'] = ($this->config->get('config_secure') ? HTTPS_SERVER : HTTP_SERVER) . 'index.php?route=payment/gobaldbill/postback';

		$var['accessVersion']='1';

        $var['shipEmail']=$var['email'] = $order_info['email'];
        $var['phone'] = $order_info['telephone'];
        //货运信息
        $var['shipFirstName'] = $order_info['shipping_firstname'] ? $order_info['shipping_firstname'] : $order_info['firstname'];
        $var['shipLastName'] = $order_info['shipping_firstname'] ? $order_info['shipping_lastname'] : $order_info['lastname'];
        $var['shipAddress'] = $order_info['shipping_address_1'] ? $order_info['shipping_address_1'] : $order_info['shipping_address_2'];
        $var['shipCity'] = $order_info['shipping_city'];
        $var['shipState'] = $order_info['payment_zone'];
        $var['shipZipCode'] = $order_info['shipping_postcode'];
        $var['shipCountry'] = $order_info['shipping_iso_code_2'];

        $var['billFirstName'] = $order_info['payment_firstname'] ? $order_info['payment_firstname'] : $order_info['firstname'];
        $var['billLastName'] = $order_info['payment_lastname'] ? $order_info['payment_lastname'] : $order_info['lastname'];
        $var['billAddress'] = $order_info['payment_address_1'] ? $order_info['payment_address_1'] : $order_info['payment_address_2'];
        $var['billCity'] = $order_info['payment_city'];
        $var['billState'] = $order_info['payment_zone'];
        $var['billZipCode'] = $order_info['payment_postcode'];
        $var['billCountry'] = $order_info['payment_iso_code_2'];

        //签名
        $var['md5Info'] = strtoupper(md5($var['merNo'] . $var['orderNo'] . $var['amount'] . $var['currency'] . $miyao . $var['email']));

        $var['clientIp'] = $this->request->server['REMOTE_ADDR'];
        $var['acceptLanguage'] = $_SERVER['HTTP_ACCEPT_LANGUAGE'];
        $var['userAgent'] = $_SERVER['HTTP_USER_AGENT'];
        $var['referer'] = trim($this->config->get('gobaldbill_referer'));
        $var['shopName'] = 'Opencart' . VERSION;
        $var['remark'] = '';
        $var['bankAccountNumber'] = str_replace(' ', '', $this->request->post['cc_number']);
        $var['cvv'] = $this->request->post['cc_cvv2'];
        $var['expireMonth'] = $this->request->post['cc_expire_date_month'];
        $var['expireYear'] = $this->request->post['cc_expire_date_year'];
        $var['bankName'] = $var['bankAccountNumber'][0] == '4' ? 'Visa' : ($var['bankAccountNumber'][0] == '5' ? 'MasterCard' : 'JCB');
        $var['payMethod'] = 0;

        $url = trim($this->config->get('gobaldbill_gateway'));
        $response = $this->payment_submit($url, $var);

        $json = array(
            'url' => ($this->config->get('config_secure') ? HTTPS_SERVER : HTTP_SERVER) . 'index.php?route=payment/gobaldbill/callback&' . $response
        );

        $this->response->setOutput(json_encode($json));
    }

    public function callback() {
        $this->load->model('checkout/order');
        $orderNo = $_REQUEST['orderNo'];
        $tradeNo = $_REQUEST['tradeNo'];
        $currency = $_REQUEST['currency'];
        $amount = $_REQUEST['amount'];
        $succeed = $_REQUEST['succeed'];
        $errcode = $_REQUEST['errcode'];
        $md5info = $_REQUEST['md5info'];
        $miyao = trim($this->config->get('gobaldbill_key'));
        $merno = trim($this->config->get('gobaldbill_merchantno'));
        $this->language->load('payment/gobaldbill');
        $error = 'Pay failed';
        if (strtolower($md5info) == md5($miyao . $merno . $orderNo . $amount . $currency . $succeed)) {
            $orderNo = $this->session->data['order_id'];
			$order_info = $this->model_checkout_order->getOrder($orderNo);

            if ($succeed === '1') {
                $status_id = $this->config->get('gobaldbill_order_status_id');
                $error = '';
            } else {
                $status_id = $this->config->get('gobaldbill_order_fail_status_id');
                $error = 'Transaction Failed';
                $title = 'Transaction Failed';
                $msg = $errcode;
            }
			$this->model_checkout_order->addOrderHistory($orderNo, $status_id);
        } else {
            $error = 'Transaction Failed';
            $title = 'Transaction Failed';
            $msg = 'Signature incorrect';
        }

        if ($error != '') {
            $data['heading_title'] = $title;
            $data['text_message'] = $msg;
            $data['button_continue'] = $this->language->get('button_continue');
            $data['continue'] = $this->url->link('common/home');

            if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/payment/gobaldbill_result.tpl')) {
                $this->template = $this->config->get('config_template') . '/template/payment/gobaldbill_result.tpl';
            } else {
                $this->template = 'default/template/payment/gobaldbill_result.tpl';
            }

			$data['column_left'] = $this->load->controller('common/column_left');
			$data['column_right'] = $this->load->controller('common/column_right');
			$data['content_top'] = $this->load->controller('common/content_top');
			$data['content_bottom'] = $this->load->controller('common/content_bottom');
			$data['footer'] = $this->load->controller('common/footer');
			$data['header'] = $this->load->controller('common/header');

            $this->response->setOutput($this->load->view($this->template, $data));
        } else {
            $this->response->redirect($this->url->link('checkout/success'));
        }
    }

    public function postback() {
        $this->load->model('checkout/order');
        $orderNo = $_REQUEST['orderNo'];
        //$tradeNo = $_REQUEST['tradeNo'];
        $currency = $_REQUEST['currency'];
        $amount = $_REQUEST['amount'];
        $succeed = $_REQUEST['succeed'];
        $errcode = $_REQUEST['errcode'];
        $md5info = $_REQUEST['md5info'];
        $miyao = trim($this->config->get('gobaldbill_key'));
        $merno = trim($this->config->get('gobaldbill_merchantno'));
        $this->language->load('payment/gobaldbill');
        $error = 'Pay failed';

        if (strtolower($md5info) == md5($miyao . $merno . $orderNo . $amount . $currency . $succeed)) {
            $order_info = $this->model_checkout_order->getOrder($orderNo);

            if ($succeed === '1') {
                $status_id = $this->config->get('gobaldbill_order_status_id');
            } else {
                $status_id = $this->config->get('gobaldbill_order_fail_status_id');
            }
			
			$this->model_checkout_order->addOrderHistory($orderNo, $status_id);
        }
    }

    function payment_submit($url, $data) {
        if (extension_loaded('curl')) {
            $returnInfo = $this->curl_post($url, $data);
        } else {
            $returnInfo = $this->http_post($url, $data);
        }

        return $returnInfo;
    }

    function curl_post($url, $data) {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($curl, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
        curl_setopt($curl, CURLOPT_REFERER, '');
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($curl, CURLOPT_TIMEOUT, 300);
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_SSLVERSION, '1');
        $returnInfo = curl_exec($curl);
        curl_close($curl);
        return $returnInfo;
    }

    function http_post($url, $data) {
        $options = array('http' => array('method' => "POST", 'header' => "Accept-language: en\r\n" . "Cookie: foo=bar\r\n", 'content-type' => "multipart/form-data", 'content' => $data, 'timeout' => 15 * 60));
        $context = stream_context_create($options);
        $result = file_get_contents($url, false, $context);
        return $result;
    }

}

?>