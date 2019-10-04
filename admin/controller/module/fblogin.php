<?php
require_once(substr_replace(DIR_SYSTEM, '', -7) . 'vendor/equotix/fblogin/equotix.php');
class ControllerModuleFBLogin extends Equotix {
	protected $version = '1.2.8';
	protected $code = 'fblogin';
	protected $extension = 'Facebook Login';
	protected $extension_id = '22';
	protected $purchase_url = 'facebook-login';
	protected $purchase_id = '14707';
	protected $error = array();

	public function index() {
		$this->language->load('module/fblogin');

		$this->document->setTitle(strip_tags($this->language->get('heading_title')));
		
		$this->load->model('setting/setting');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && ($this->validate())) {
			$this->model_setting_setting->editSetting('fblogin', $this->request->post);		
			
			$this->session->data['success'] = $this->language->get('text_success');
		
			$this->response->redirect($this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'));
		}
		
		$data['heading_title'] = $this->language->get('heading_title');
	
		$data['entry_status'] = $this->language->get('entry_status');
		$data['entry_app_id'] = $this->language->get('entry_app_id');
		$data['entry_customer_group'] = $this->language->get('entry_customer_group');
		$data['entry_box'] = $this->language->get('entry_box');
		$data['entry_text'] = $this->language->get('entry_text');
		$data['entry_heading'] = $this->language->get('entry_heading');
		$data['entry_button_text'] = $this->language->get('entry_button_text');
		$data['entry_align'] = $this->language->get('entry_align');
		
		$data['text_edit'] = $this->language->get('text_edit');
		$data['text_enabled']	= $this->language->get('text_enabled');
		$data['text_disabled']	= $this->language->get('text_disabled');
		
		$data['help_app_id']	= $this->language->get('help_app_id');
		
		$data['tab_general'] = $this->language->get('tab_general');
		        
		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');
		
 		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}
		
  		$data['breadcrumbs'] = array();

   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL')
   		);

   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_module'),
			'href'      => $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL')
   		);
		
   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('module/fblogin', 'token=' . $this->session->data['token'], 'SSL')
   		);
		
		$data['action'] = $this->url->link('module/fblogin', 'token=' . $this->session->data['token'], 'SSL');
		$data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');
		
		if (isset($this->request->post['fblogin_status'])) { 
			$data['fblogin_status'] = $this->request->post['fblogin_status']; 
		} else { 
			$data['fblogin_status'] = $this->config->get('fblogin_status');
		} 
		
		if (isset($this->request->post['fblogin_app_id'])) {
			$data['fblogin_app_id'] = $this->request->post['fblogin_app_id'];
		} elseif ($this->config->get('fblogin_app_id')) { 
			$data['fblogin_app_id'] = $this->config->get('fblogin_app_id');
		} else {
			$data['fblogin_app_id'] = '';
		}
		
		if (isset($this->request->post['fblogin_customer_group_id'])) {
			$data['fblogin_customer_group_id'] = $this->request->post['fblogin_customer_group_id'];
		} elseif ($this->config->get('fblogin_customer_group_id')) { 
			$data['fblogin_customer_group_id'] = $this->config->get('fblogin_customer_group_id');
		} else {
			$data['fblogin_customer_group_id'] = '';
		}
		
		if (isset($this->request->post['fblogin_box'])) {
			$data['fblogin_box'] = $this->request->post['fblogin_box'];
		} elseif ($this->config->get('fblogin_box')) { 
			$data['fblogin_box'] = $this->config->get('fblogin_box');
		} else {
			$data['fblogin_box'] = '';
		}
		
		if (isset($this->request->post['fblogin_text'])) {
			$data['fblogin_text'] = $this->request->post['fblogin_text'];
		} elseif ($this->config->get('fblogin_text')) { 
			$data['fblogin_text'] = $this->config->get('fblogin_text');
		} else {
			$data['fblogin_text'] = '';
		}
		
		if (isset($this->request->post['fblogin_heading'])) {
			$data['fblogin_heading'] = $this->request->post['fblogin_heading'];
		} elseif ($this->config->get('fblogin_heading')) { 
			$data['fblogin_heading'] = $this->config->get('fblogin_heading');
		} else {
			$data['fblogin_heading'] = '';
		}
		
		if (isset($this->request->post['fblogin_button_text'])) {
			$data['fblogin_button_text'] = $this->request->post['fblogin_button_text'];
		} elseif ($this->config->get('fblogin_button_text')) { 
			$data['fblogin_button_text'] = $this->config->get('fblogin_button_text');
		} else {
			$data['fblogin_button_text'] = '';
		}
		
		if (isset($this->request->post['fblogin_align'])) {
			$data['fblogin_align'] = $this->request->post['fblogin_align'];
		} elseif ($this->config->get('fblogin_align')) { 
			$data['fblogin_align'] = $this->config->get('fblogin_align');
		} else {
			$data['fblogin_align'] = 'CENTER';
		}
		
		if (version_compare(VERSION, '2.0.4.0', '<')) {
			$this->load->model('sale/customer_group');
			
			$data['customer_groups'] = $this->model_sale_customer_group->getCustomerGroups();
		} else {
			$this->load->model('customer/customer_group');
			
			$data['customer_groups'] = $this->model_customer_customer_group->getCustomerGroups();
		}
		
		$this->load->model('localisation/language');
		
		$data['languages'] = $this->model_localisation_language->getLanguages();
		
		$this->load->model('setting/store');
		
		$data['stores'] = array();
		
		$data['stores'][] = array(
			'store_id'		=> 0,
			'name'			=> 'Default'
		);
		
		$stores = $this->model_setting_store->getStores();
		
		foreach ($stores as $store) {
			$data['stores'][] = array(
				'store_id'		=> $store['store_id'],
				'name'			=> $store['name']
			);
		}
		
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->generateOutput('module/fblogin.tpl', $data);
	}
	
	protected function validate() {
		if (!$this->user->hasPermission('modify', 'module/fblogin') || !$this->validated()) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		
		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}
}