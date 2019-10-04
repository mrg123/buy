<?php
class ControllerPaymentMycheckout extends Controller {
	private $error = array ();
	
	public function index() {
		$this->load->language('payment/mycheckout');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('mycheckout', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL'));
		}
		
		$data['heading_title']  = $this->language->get('heading_title');
		$data['text_edit']      = $this->language->get('text_edit');
		$data['text_enabled']   = $this->language->get('text_enabled');
		$data['text_disabled']  = $this->language->get('text_disabled');
		$data['text_all_zones'] = $this->language->get('text_all_zones');
		$data['text_yes']       = $this->language->get('text_yes');
		$data['text_no']        = $this->language->get('text_no');
		
		$data['entry_type']       = $this->language->get('entry_type');
		$data['entry_merchantid'] = $this->language->get('entry_merchantid');
		$data['entry_transno']    = $this->language->get('entry_transno');
		$data['entry_md5key']     = $this->language->get('entry_md5key');

		$data['entry_order_status']             = $this->language->get('entry_order_status');
		$data['entry_pay_success_order_status'] = $this->language->get('entry_pay_success_order_status');
		$data['entry_pay_fail_order_status']    = $this->language->get('entry_pay_fail_order_status');
		
		$data['entry_geo_zone']   = $this->language->get('entry_geo_zone');
		$data['entry_status']     = $this->language->get('entry_status');
		$data['entry_sort_order'] = $this->language->get('entry_sort_order');
		$data['button_save']      = $this->language->get('button_save');
		$data['button_cancel']    = $this->language->get('button_cancel');
		$data['tab_general']      = $this->language->get('tab_general');
		
		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->error['merchantid'] )) {
			$data['error_merchantid'] = $this->error['merchantid'];
		} else {
			$data['error_merchantid'] = '';
		}

		if (isset($this->error['transno'])) {
			$data['error_transno'] = $this->error['transno'];
		} else {
			$data['error_transno'] = '';
		}
		
		if (isset($this->error['md5key'])) {
			$data['error_md5key'] = $this->error['md5key'];
		} else {
			$data['error_md5key'] = '';
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'href' => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
			'text' => $this->language->get('text_home')
		);

		$data['breadcrumbs'][] = array(
			'href' => $this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL'),
			'text' => $this->language->get('text_payment')
		);

		$data['breadcrumbs'][] = array(
			'href' => $this->url->link('payment/mycheckout', 'token=' . $this->session->data['token'], 'SSL'),
			'text' => $this->language->get('heading_title')
		);

		$data['action'] = $this->url->link('payment/mycheckout', 'token=' . $this->session->data['token'], 'SSL');

		$data['cancel'] = $this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL');

		if (isset($this->request->post['mycheckout_type'] )) {
			$data['mycheckout_type'] = $this->request->post['mycheckout_type'];
		} else {
			$data['mycheckout_type'] = $this->config->get('mycheckout_type');
		}

		if (isset($this->request->post['mycheckout_merchantid'] )) {
			$data['mycheckout_merchantid'] = $this->request->post['mycheckout_merchantid'];
		} else {
			$data['mycheckout_merchantid'] = $this->config->get('mycheckout_merchantid');
		}

		if (isset($this->request->post['mycheckout_transno'] )) {
			$data['mycheckout_transno'] = $this->request->post['mycheckout_transno'];
		} else {
			$data['mycheckout_transno'] = $this->config->get('mycheckout_transno');
		}

		if (isset($this->request->post['mycheckout_md5key'])) {
			$data['mycheckout_md5key'] = $this->request->post['mycheckout_md5key'];
		} else {
			$data['mycheckout_md5key'] = $this->config->get('mycheckout_md5key');
		}

		if (isset($this->request->post['mycheckout_order_status_id'] )) {
			$data['mycheckout_order_status_id'] = $this->request->post['mycheckout_order_status_id'];
		} else {
			$data['mycheckout_order_status_id'] = $this->config->get('mycheckout_order_status_id');
		}

		if (isset($this->request->post['mycheckout_pay_success_order_status_id'] )) {
			$data['mycheckout_pay_success_order_status_id'] = $this->request->post['mycheckout_pay_success_order_status_id'];
		} else {
			$data['mycheckout_pay_success_order_status_id'] = $this->config->get('mycheckout_pay_success_order_status_id');
		}

		if (isset($this->request->post['mycheckout_pay_fail_order_status_id'] )) {
			$data['mycheckout_pay_fail_order_status_id'] = $this->request->post['mycheckout_pay_fail_order_status_id'];
		} else {
			$data['mycheckout_pay_fail_order_status_id'] = $this->config->get('mycheckout_pay_fail_order_status_id');
		}
		
		$this->load->model('localisation/order_status');
		
		$data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();
		
		if (isset($this->request->post['mycheckout_geo_zone_id'] )) {
			$data['mycheckout_geo_zone_id'] = $this->request->post['mycheckout_geo_zone_id'];
		} else {
			$data['mycheckout_geo_zone_id'] = $this->config->get('mycheckout_geo_zone_id');
		}
		
		$this->load->model('localisation/geo_zone');
		
		$data['geo_zones'] = $this->model_localisation_geo_zone->getGeoZones();
		
		if (isset($this->request->post['mycheckout_status'] )) {
			$data['mycheckout_status'] = $this->request->post['mycheckout_status'];
		} else {
			$data['mycheckout_status'] = $this->config->get('mycheckout_status');
		}
		
		if (isset($this->request->post['mycheckout_sort_order'] )) {
			$data['mycheckout_sort_order'] = $this->request->post['mycheckout_sort_order'];
		} else {
			$data['mycheckout_sort_order'] = $this->config->get('mycheckout_sort_order');
		}
		
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
		
		$this->response->setOutput($this->load->view('payment/mycheckout.tpl', $data));
	}
	
	private function validate() {
		if (!$this->user->hasPermission('modify', 'payment/mycheckout')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if (!$this->request->post['mycheckout_merchantid']) {
			$this->error['merchantid'] = $this->language->get('error_merchantid');
		}

		if (!$this->request->post['mycheckout_transno']) {
			$this->error['transno'] = $this->language->get('error_transno');
		}

		if (!$this->request->post['mycheckout_md5key']) {
			$this->error['md5key'] = $this->language->get('error_md5key');
		}

		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}
}
?>