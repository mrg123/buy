<?php
class ControllerPaymentMyorder extends Controller {
	private $error = array ();
	
	public function index() {
		$this->load->language ( 'payment/myorder' );
		
		$this->document->setTitle ( $this->language->get ( 'heading_title' ) );
		
		$this->load->model ( 'setting/setting' );
		
		if (($this->request->server ['REQUEST_METHOD'] == 'POST') && ($this->validate ())) {
		//	$this->load->model ( 'setting/setting' );
			
			$this->model_setting_setting->editSetting ( 'myorder', $this->request->post );
			
			$this->session->data ['success'] = $this->language->get ( 'text_success' );
			
			$this->response->redirect($this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL'));
		}
		
		$data ['heading_title'] = $this->language->get ( 'heading_title' );
		
		$data['text_edit'] = $this->language->get('text_edit');
		$data ['text_enabled'] = $this->language->get ( 'text_enabled' );
		$data ['text_disabled'] = $this->language->get ( 'text_disabled' );
		$data ['text_all_zones'] = $this->language->get ( 'text_all_zones' );
		$data ['text_yes'] = $this->language->get ( 'text_yes' );
		$data ['text_no'] = $this->language->get ( 'text_no' );
		$data ['text_eur'] = $this->language->get ( 'text_eur' );
		$data ['text_rmb'] = $this->language->get ( 'text_rmb' );
		$data ['text_usd'] = $this->language->get ( 'text_usd' );
		$data ['text_gbp'] = $this->language->get ( 'text_gbp' );
		
		$data ['text_hkd'] = $this->language->get ( 'text_hkd' );
		$data ['text_jpy'] = $this->language->get ( 'text_jpy' );
		//$data ['text_aud'] = $this->language->get ( 'text_aud' );
		//$data ['text_cad'] = $this->language->get ( 'text_cad' );
		$data ['text_nok'] = $this->language->get ( 'text_nok' );
		$data ['text_dkk'] = $this->language->get ( 'text_dkk' );
		$data ['text_nzd'] = $this->language->get ( 'text_nzd' );
		
		$data['entry_test'] = $this->language->get('entry_test');
		$data ['entry_merchantid'] = $this->language->get ( 'entry_merchantid' );
		$data ['entry_md5key'] = $this->language->get ( 'entry_md5key' );
		//$data ['entry_callback'] = $this->language->get ( 'entry_callback' );
		$data ['entry_transactionurl'] = $this->language->get ( 'entry_transactionurl' );
		
		$data ['entry_currency'] = $this->language->get ( 'entry_currency' );
		
	//	$data ['entry_language'] = $this->language->get ( 'entry_language' );
		$data ['entry_order_status'] = $this->language->get ( 'entry_order_status' );
		$data ['entry_pay_success_order_status'] = $this->language->get ( 'entry_pay_success_order_status' );
		$data ['entry_pay_fail_order_status'] = $this->language->get ( 'entry_pay_fail_order_status' );
		$data ['entry_geo_zone'] = $this->language->get ( 'entry_geo_zone' );
		$data ['entry_status'] = $this->language->get ( 'entry_status' );
		$data ['entry_sort_order'] = $this->language->get ( 'entry_sort_order' );
		
		$data ['button_save'] = $this->language->get ( 'button_save' );
		$data ['button_cancel'] = $this->language->get ( 'button_cancel' );
		
		$data ['tab_general'] = $this->language->get ( 'tab_general' );
		
		if (isset ( $this->error ['warning'] )) {
			$data ['error_warning'] = $this->error ['warning'];
		} else {
			$data ['error_warning'] = '';
		}
		
		if (isset ( $this->error ['merchant'] )) {
			$data ['error_merchant'] = $this->error ['merchant'];
		} else {
			$data ['error_merchant'] = '';
		}
		
		if (isset ( $this->error ['md5key'] )) {
			$data ['error_md5key'] = $this->error ['md5key'];
		} else {
			$data ['error_md5key'] = '';
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_payment'),
			'href' => $this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('payment/myorder', 'token=' . $this->session->data['token'], 'SSL')
		);

		$data['action'] = $this->url->link('payment/myorder', 'token=' . $this->session->data['token'], 'SSL');

		$data['cancel'] = $this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL');

		if (isset ( $this->request->post ['myorder_merchant'] )) {
			$data ['myorder_merchant'] = $this->request->post ['myorder_merchant'];
		} else {
			$data ['myorder_merchant'] = $this->config->get ( 'myorder_merchant' );
		}
		
		if (isset ( $this->request->post ['myorder_md5key'] )) {
			$data ['myorder_md5key'] = $this->request->post ['myorder_md5key'];
		} else {
			$data ['myorder_md5key'] = $this->config->get ( 'myorder_md5key' );
		}
		
		//$data ['callback'] = HTTP_CATALOG . 'index.php?route=payment/epay95/callback';
		//$data ['myorder_default_callbackurl']= HTTP_CATALOG . 'index.php?route=payment/myorder/callback';
		//if(isset ( $this->request->post ['myorder_callbackurl'] )){
		//	$data ['myorder_callbackurl'] = $this->request->post ['myorder_callbackurl'];
		//}else{
	//		$data ['myorder_callbackurl'] = $this->config->get ( 'myorder_callbackurl' );
	//	}
		if (isset ( $this->request->post ['myorder_transactionurl'] )) {
			$data ['myorder_transactionurl'] = $this->request->post ['myorder_transactionurl'];
		} else {
			$data ['myorder_transactionurl'] = $this->config->get ( 'myorder_transactionurl' );
		}
		if (isset ( $this->request->post ['myorder_currency'] )) {
			$data ['myorder_currency'] = $this->request->post ['myorder_currency'];
		} else {
			$data ['myorder_currency'] = $this->config->get ( 'myorder_currency' );
		}
		
			//������ʱ
		if (isset ( $this->request->post ['myorder_order_status_id'] )) {
			$data ['myorder_order_status_id'] = $this->request->post ['myorder_order_status_id'];
		} else {
			$data ['myorder_order_status_id'] = $this->config->get ( 'myorder_order_status_id' );
		}
		//�ɹ�ʱ
		if (isset ( $this->request->post ['myorder_pay_success_order_status_id'] )) {
			$data ['myorder_pay_success_order_status_id'] = $this->request->post ['myorder_pay_success_order_status_id'];
		} else {
			$data ['myorder_pay_success_order_status_id'] = $this->config->get ( 'myorder_pay_success_order_status_id' );
		}
		//ʧ��ʱ
		if (isset ( $this->request->post ['myorder_pay_fail_order_status_id'] )) {
			$data ['myorder_pay_fail_order_status_id'] = $this->request->post ['myorder_pay_fail_order_status_id'];
		} else {
			$data ['myorder_pay_fail_order_status_id'] = $this->config->get ( 'myorder_pay_fail_order_status_id' );
		}
		
		$this->load->model ( 'localisation/order_status' );
		
		$data ['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses ();
		
		if (isset ( $this->request->post ['myorder_geo_zone_id'] )) {
			$data ['myorder_geo_zone_id'] = $this->request->post ['emyorder_geo_zone_id'];
		} else {
			$data ['myorder_geo_zone_id'] = $this->config->get ( 'myorder_geo_zone_id' );
		}
		
		$this->load->model ( 'localisation/geo_zone' );
		
		$data ['geo_zones'] = $this->model_localisation_geo_zone->getGeoZones ();
		
		if (isset ( $this->request->post ['myorder_status'] )) {
			$data ['myorder_status'] = $this->request->post ['myorder_status'];
		} else {
			$data ['myorder_status'] = $this->config->get ( 'myorder_status' );
		}
		
		if (isset ( $this->request->post ['myorder_sort_order'] )) {
			$data ['myorder_sort_order'] = $this->request->post ['myorder_sort_order'];
		} else {
			$data ['myorder_sort_order'] = $this->config->get ( 'myorder_sort_order' );
		}

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('payment/myorder.tpl', $data));
	}
	
	private function validate() {
		if (! $this->user->hasPermission ( 'modify', 'payment/myorder' )) {
			$this->error ['warning'] = $this->language->get ( 'error_permission' );
		}
		
		if (! $this->request->post ['myorder_merchant']) {
			$this->error ['merchant'] = $this->language->get ( 'error_merchant' );
		}
		
		if (! $this->request->post ['myorder_md5key']) {
			$this->error ['md5key'] = $this->language->get ( 'error_md5key' );
		}
		
		if (! $this->error) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
}
?>