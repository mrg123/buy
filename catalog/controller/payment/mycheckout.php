<?php
class ControllerPaymentMycheckout extends Controller {
	public function index() {
		$data['button_confirm'] = $this->language->get('button_confirm');
		if ($this->config->get('mycheckout_type') == '3') {
			$this->language->load('payment/mycheckout');
			$data['action'] = $this->url->link('payment/mycheckout/result', '', 'SSL');
			
			$data['entry_cc_number']       = $this->language->get('entry_card_number');
			$data['entry_cc_expire_date']  = $this->language->get('entry_expiry_date');
			$data['entry_cc_cvv2']         = $this->language->get('entry_cvv');
			$data['entry_cc_expire_month'] = $this->language->get('entry_cc_expire_month');
			$data['entry_cc_expire_year']  = $this->language->get('entry_cc_expire_year');
			$data['whats_cvv']             = $this->language->get('entry_whats_cvv');
			
			$data['text_processing'] 	   = $this->language->get('text_processing');
			$data['button_confirm']  	   = $this->language->get('mycheckout_button_confirm');
		} elseif ($this->config->get('mycheckout_type') == '2') {
			$data['continue'] = $this->url->link('payment/mycheckout/checkout', '', 'SSL');
		} else {
			$data['continue'] = $this->url->link('payment/mycheckout/process', '', 'SSL');
		}
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/payment/mycheckout/index.tpl')) {
			return $this->load->view($this->config->get('config_template') . '/template/payment/mycheckout/index.tpl', $data);
		} else {
			return $this->load->view('default/template/payment/mycheckout/index.tpl', $data);
		}
	}

	public function process() {
		$this->language->load('payment/mycheckout');
		$this->load->model('checkout/order');
		$orderInfo = $this->model_checkout_order->getOrder($this->session->data['order_id']);
		$this->model_checkout_order->addOrderHistory($this->session->data['order_id'], $this->config->get('mycheckout_order_status_id'), '', false);
		$data['order_id'] = $this->config->get('mycheckout_transno') . '-' . $orderInfo['order_id'];
		$data['currency'] = $orderInfo['currency_code'];
		$data['amount']   = number_format($orderInfo['total'] * $orderInfo['currency_value'], 2, '.', '');
		$data['action']   = $this->url->link('payment/mycheckout/result', '', 'SSL');
		if (isset($this->request->server['HTTPS'])
			&& (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) {
			$data['base'] = $this->config->get('config_ssl');
		} else {
			$data['base'] = $this->config->get('config_url');
		}
		$data['direction'] = $this->language->get('direction');
		$data['lang']      = $this->language->get('code');
		$data['charset']   = $this->language->get('charset');

		$data['heading_title']         = $this->language->get('process_heading_title');
		$data['entry_order_number']    = $this->language->get('entry_order_number');
		$data['entry_amount']          = $this->language->get('entry_amount');
		$data['entry_card_type']       = $this->language->get('process_entry_card_type');
		$data['entry_card_number']     = $this->language->get('entry_card_number');
		$data['entry_expiry_date']     = $this->language->get('entry_expiry_date');
		$data['entry_cvv']             = $this->language->get('entry_cvv');
		$data['entry_cc_expire_month'] = $this->language->get('entry_cc_expire_month');
		$data['entry_cc_expire_year']  = $this->language->get('entry_cc_expire_year');
		$data['text_processing']       = $this->language->get('text_processing');
		$data['text_submit']           = $this->language->get('process_text_submit');
		$data['whats_cvv']             = $this->language->get('entry_whats_cvv'); 

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/payment/mycheckout/process.tpl')) {
			echo $this->load->view($this->config->get('config_template') . '/template/payment/mycheckout/process.tpl', $data);
		} else {
			echo $this->load->view('default/template/payment/mycheckout/process.tpl', $data);
		}
	}

	public function checkout() {
		$data['action'] = $this->url->link('payment/mycheckout/process', '', 'SSL');
		$data['column_left']    = $this->load->controller('common/column_left');
		$data['column_right']   = $this->load->controller('common/column_right');
		$data['content_top']    = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer']         = $this->load->controller('common/footer');
		$data['header']         = $this->load->controller('common/header');

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/payment/mycheckout/checkout.tpl')) {
			echo $this->load->view($this->config->get('config_template') . '/template/payment/mycheckout/checkout.tpl', $data);
		} else {
			echo $this->load->view('default/template/payment/mycheckout/checkout.tpl', $data);
		}
	}

	public function result() {
		$this->language->load('payment/mycheckout');
		$this->load->model('checkout/order');
		$orderInfo = $this->model_checkout_order->getOrder($this->session->data['order_id']);
		$post['MerchantID'] = $this->config->get('mycheckout_merchantid');
		$post['TransNo']    = $this->config->get('mycheckout_transno');
		$MD5key             = $this->config->get('mycheckout_md5key');
		$post['OrderID']    = $this->config->get('mycheckout_transno') . '-' . $orderInfo['order_id'];
		$post['Currency']   = $orderInfo['currency_code'];
		$post['Amount']     = number_format($orderInfo['total'] * $orderInfo['currency_value'], 2, '.', '');
		$post['MD5info']    = strtoupper(md5($MD5key . $post['MerchantID'] . $post['TransNo'] . $post['OrderID'] . $post['Currency'] . $post['Amount']));
		$post['Version']    = 'V4.51';
		
		$post['BName']      = $orderInfo['payment_firstname'] . ' ' . $orderInfo['payment_lastname'];
		$post['BEmail']     = $orderInfo['email'];
		$post['BAddress']   = trim($orderInfo['payment_address_1'] . ' ' . $orderInfo['payment_address_2']);
		$post['BCity']      = $orderInfo['payment_city'];
		$post['BState']     = $orderInfo['payment_zone'];
		$post['BPostcode']  = $orderInfo['payment_postcode'];
		$post['BCountry']   = $orderInfo['payment_iso_code_2'];
		$post['BPhone']     = $orderInfo['telephone'];
		
		$post['DName']      = $orderInfo['shipping_firstname'] . ' ' . $orderInfo['shipping_lastname'];
		$post['DEmail']     = $orderInfo['email'];
		$post['DAddress']   = trim($orderInfo['shipping_address_1'] . ' ' . $orderInfo['shipping_address_2']);
		$post['DCity']      = $orderInfo['shipping_city'];
		$post['DState']     = $orderInfo['shipping_zone'];
		$post['DPostcode']  = $orderInfo['shipping_postcode'];
		$post['DCountry']   = $orderInfo['shipping_iso_code_2'];
		$post['DPhone']     = $orderInfo['telephone'];

		$post['CardNumber'] = $this->request->post['card_number'];
		$post['CardMonth']  = $this->request->post['card_month'];
		$post['CardYear']   = $this->request->post['card_year'];
		$post['CardCvv']    = $this->request->post['card_cvv'];

		$post['URL']            = $this->request->server['HTTP_HOST'];
		$post['IP']             = $this->request->server['REMOTE_ADDR'];
		$post['UserAgent']      = $this->request->server['HTTP_USER_AGENT'];
		$post['AcceptLanguage'] = $this->request->server['HTTP_ACCEPT_LANGUAGE'];
		$post['McCookie']       = isset($this->request->cookie['McCookie']) ? $this->request->cookie['McCookie'] : '';
		$post['csid']           = isset($this->request->post['csid']) ? $this->request->post['csid'] : '';

		$order_product_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_product WHERE order_id = '" . (int)$this->session->data['order_id'] . "'");
		$products = array();
		foreach ($order_product_query->rows as $product) {
			$products[] = $product['quantity'] . 'x' . $product['name'];
		}
		$post['Products'] = implode(',', $products);

		$result = json_decode($this->_post('http://wru8zys.zwbpay.com/payment/interface/do', $post), true);
		if (!is_array($result)) {
			$result = json_decode($this->_post('http://wru8zys.gtopay.com/payment/interface/do', $post), true);
		}
		if (!is_array($result)) {
			$this->model_checkout_order->addOrderHistory($this->session->data['order_id'], $this->config->get('mycheckout_pay_fail_order_status_id'), 'Code:2001', false);
			$data['status'] = 0;
		}
		if ($result['error'] == true) {
			$this->model_checkout_order->addOrderHistory($this->session->data['order_id'], $this->config->get('mycheckout_pay_fail_order_status_id'), 'Code:' . $result['code'], false);
			$data['status'] = 0;
		} else {
			$OrderID  = $result['order']['OrderID'];
			$Currency = $result['order']['Currency'];
			$Amount   = $result['order']['Amount'];
			$Code     = $result['order']['Code'];
			$Status   = $result['order']['Status'];
			$MD5info  = $result['order']['MD5info'];
			
			$TransNo  = $this->config->get('mycheckout_transno');
			$MD5key   = $this->config->get('mycheckout_md5key');
			$MD5src   = $MD5key . $TransNo . $OrderID . $Currency . $Amount . $Code . $Status;
			$MD5sign  = strtoupper(md5($MD5src));
			if ($MD5sign == $MD5info) {
				if($Status == '1') {
					$this->model_checkout_order->addOrderHistory($this->session->data['order_id'], $this->config->get('mycheckout_pay_success_order_status_id'), '', false);
					$data['status'] = 1;
				} else {
					$this->model_checkout_order->addOrderHistory($this->session->data['order_id'], $this->config->get('mycheckout_pay_fail_order_status_id'), '', false);
					$data['status'] = 0;
				}
			} else {
				$this->model_checkout_order->addOrderHistory($this->session->data['order_id'], $this->config->get('mycheckout_pay_fail_order_status_id'), 'Verify MAC Failed!', false);
				$data['status'] = 0;
			}
		}

		if (isset($this->request->server['HTTPS'])
			&& (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) {
			$data['base'] = $this->config->get('config_ssl');
		} else {
			$data['base'] = $this->config->get('config_url');
		}
		$data['direction'] = $this->language->get('direction');
		$data['lang']      = $this->language->get('code');
		$data['charset']   = $this->language->get('charset');
		if ($this->customer->isLogged()) {
			$data['return_url'] = $this->url->link('account/order', '', 'SSL');
		} else {
			$data['return_url'] = $this->url->link('information/contact', '', 'SSL');
		}

		$data['heading_title']      = $this->language->get('result_heading_title');
		$data['entry_order_number'] = $this->language->get('entry_order_number');
		$data['entry_amount']       = $this->language->get('entry_amount');
		$data['entry_status']       = $this->language->get('result_entry_status');
		$data['text_successful']    = $this->language->get('result_text_successful');
		$data['text_failure']       = $this->language->get('result_text_failure');
		$data['order_id']           = $post['OrderID'];
		$data['currency']           = $post['Currency'];
		$data['amount']             = $post['Amount'];

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/payment/mycheckout/result.tpl')) {
			echo $this->load->view($this->config->get('config_template') . '/template/payment/mycheckout/result.tpl', $data);
		} else {
			echo $this->load->view('default/template/payment/mycheckout/result.tpl', $data);
		}
	}

	function _post($url, $data) 
	{
	    if (empty($url)) return false;

	    $ch = curl_init();
	    curl_setopt($ch, CURLOPT_URL, $url);
	    curl_setopt($ch, CURLOPT_POST, 1);
	    curl_setopt($ch, CURLOPT_HEADER, 0);
	    curl_setopt($ch ,CURLOPT_RETURNTRANSFER, 1);
	    curl_setopt($ch ,CURLOPT_POSTFIELDS, $data);
	    curl_setopt($ch, CURLOPT_TIMEOUT, 120);
	    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
	    $result = curl_exec($ch);
	    curl_close($ch);

	    return $result;
	}
}
?>