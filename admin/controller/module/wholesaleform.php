<?php
class Controllermodulewholesaleform extends Controller {
	private $error = array();
 
	public function index() {
		$this->load->language('module/wholesaleform');
 
		$this->document->setTitle($this->language->get('title'));
		$this->document->addLink("view/stylesheet/imdev.css","stylesheet");
 		
		$this->load->model('tool/wholesaleform');
		$this->model_tool_wholesaleform->createTable();
		$this->load->model('setting/setting');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {

			$this->model_setting_setting->editSetting('wholesaleform', array("wholesaleform_showlinkheader"=>$this->request->post['showlinkheader'],"wholesaleform_showlinkfooter"=>$this->request->post['showlinkfooter']));
			
			$this->model_tool_wholesaleform->savesetting($this->request->post);
			
			$this->session->data['success'] = $this->language->get('text_success');
			
			$this->response->redirect($this->url->link('module/wholesaleform', 'token=' . $this->session->data['token'], 'SSL'));
		}

		$data['heading_title'] = $this->language->get('title');

		
		$data['entry_status'] = $this->language->get('entry_status');

		$data['headerinfo1'] = $this->language->get('headerinfo1');
		$data['headerinfo2'] = $this->language->get('headerinfo2');
		$data['text_support'] = $this->language->get('text_support');
		$data['text_helpguide'] = $this->language->get('text_helpguide');
		$data['text_required'] = $this->language->get('text_required');

		$data['text_showlinkheader'] = $this->language->get('text_showlinkheader');
		$data['text_showlinkfooter'] = $this->language->get('text_showlinkfooter');

		$data['text_name'] = $this->language->get('text_name');
		$data['text_address'] = $this->language->get('text_address');
		$data['text_city'] = $this->language->get('text_city');
		$data['text_state'] = $this->language->get('text_state');
		$data['text_country'] = $this->language->get('text_country');
		$data['text_pincode'] = $this->language->get('text_pincode');
		$data['text_phone'] = $this->language->get('text_phone');
		$data['text_mobile'] = $this->language->get('text_mobile');
		$data['text_email'] = $this->language->get('text_email');
		$data['text_nameperson'] = $this->language->get('text_nameperson');
		$data['text_contacttitle'] = $this->language->get('text_contacttitle');
		$data['text_tin'] = $this->language->get('text_tin');
		$data['text_business'] = $this->language->get('text_business');
		$data['text_specify'] = $this->language->get('text_specify');
		$data['text_formation'] = $this->language->get('text_formation');
		$data['text_sales'] = $this->language->get('text_sales');
		$data['text_otherbrands'] = $this->language->get('text_otherbrands');
		$data['text_websiteurl'] = $this->language->get('text_websiteurl');
		$data['text_product'] = $this->language->get('text_product');
		$data['text_category'] = $this->language->get('text_category');
		$data['text_enquiry'] = $this->language->get('text_enquiry');
		
		$data['token'] = $this->session->data['token'];
		$data['text_default'] = $this->language->get('text_default');
		
		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');
		$data['text_yes'] = $this->language->get('text_yes');		
		$data['text_no'] = $this->language->get('text_no');

 		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

  		$data['breadcrumbs'] = array();

  		$data['breadcrumbs'][] = array(
       		'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
       		'text'      => $this->language->get('text_home'),
      		'separator' => FALSE
   		);

  		$data['breadcrumbs'][] = array(
       		'href'      => $this->url->link('module/wholesaleform', 'token=' . $this->session->data['token'], 'SSL'),
       		'text'      => $this->language->get('heading_title'),
      		'separator' => ' :: '
   		);
			

		$data['action'] = $this->url->link('module/wholesaleform', 'token=' . $this->session->data['token'], 'SSL');
		
		$data['token'] = $this->session->data['token'];
		  
    	$data['cancel'] = $this->url->link('module/wholesaleform', 'token=' . $this->session->data['token'], 'SSL');

    	$data['setting']  = $this->model_tool_wholesaleform->getsetting();
    	$data['required']  = $this->model_tool_wholesaleform->getrequired();

    	if (isset($this->request->post['showlinkheader'])) {
			$data['showlinkheader'] = $this->request->post['showlinkheader'];
		} else {
			$data['showlinkheader'] = $this->config->get('wholesaleform_showlinkheader');
		}

		if (isset($this->request->post['showlinkfooter'])) {
			$data['showlinkfooter'] = $this->request->post['showlinkfooter'];
		} else {
			$data['showlinkfooter'] = $this->config->get('wholesaleform_showlinkfooter');
		}
    	
		if (isset($this->error['name'])) {
			$data['error_name'] = $this->error['name'];
		} else {
			$data['error_name'] = array();
		}

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('module/wholesaleform.tpl', $data));
	}

	private function validateForm() {
		
		$this->load->model('tool/wholesaleform');
		
		if (!$this->user->hasPermission('modify', 'module/wholesaleform')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}


}
?>