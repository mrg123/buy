<?php
require_once(substr_replace(DIR_SYSTEM, '', -7) . 'vendor/equotix/fblogin/equotix.php');
class ControllerModuleFBLogin extends Equotix {
	protected $code = 'fblogin';
	protected $extension_id = '22';
	
	public function index() {
		$heading_title = $this->config->get('fblogin_heading');
		
    	$data['heading_title'] = !empty($heading_title[$this->config->get('config_language_id')]) ? $heading_title[$this->config->get('config_language_id')] : '';

		$text = $this->config->get('fblogin_text');
		
    	$data['text'] = !empty($text[$this->config->get('config_language_id')]) ? $text[$this->config->get('config_language_id')] : '';

		$button_text = $this->config->get('fblogin_button_text');
		
    	$data['button_text'] = !empty($button_text[$this->config->get('config_language_id')]) ? $button_text[$this->config->get('config_language_id')] : '';

		$app_id = $this->config->get('fblogin_app_id');
		
		$data['app_id'] = $app_id[$this->config->get('config_store_id')];
		$data['align'] = $this->config->get('fblogin_align');
		$data['box'] = $this->config->get('fblogin_box');
		
		if (isset($this->session->data['facebook_error'])) {
			$data['facebook_error'] = $this->session->data['facebook_error'];
			
			unset($this->session->data['facebook_error']);
		} else {
			$data['facebook_error'] = false;
		}
		
		if ((isset($this->request->get['route']) && $this->request->get['route'] == 'account/logout') || ($this->customer->isLogged()) || empty($data['app_id']) || !$this->validated()) {
			return;
		}

		if (version_compare(VERSION, '2.2.0.0', '<')) {
			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/fblogin.tpl')) {
				return $this->load->view($this->config->get('config_template') . '/template/module/fblogin.tpl', $data);
			} else {
				return $this->load->view('default/template/module/fblogin.tpl', $data);
			}
		} else {
			return $this->load->view('module/fblogin', $data);
		}
	}
	
	public function auth() {
		$this->language->load('module/fblogin');
		
		$this->load->model('module/fblogin');
		
		$json = array();
		
		if (isset($this->request->post['firstname'])) {
			$firstname = $this->request->post['firstname'];
		} else {
			$firstname = '';
		}
		
		if (isset($this->request->post['lastname'])) {
			$lastname = $this->request->post['lastname'];
		} else {
			$lastname = '';
		}
		
		if (isset($this->request->post['email'])) {
			$email = $this->request->post['email'];
		} else {
			$email = '';
		}
		
		if (empty($email)) {
			$this->session->data['facebook_error'] = $this->language->get('error_email');
			
			$json['reload'] = true;
		}
		
		if (!$json) {
			$json['reload'] = false;
			
			if (version_compare(VERSION, '1.5.1.3', '>')) {
				$this->load->model('account/customer_group');
			
				$customer_group_info = $this->model_account_customer_group->getCustomerGroup($this->config->get('fblogin_customer_group_id'));
			
				if ($customer_group_info) {
					$approved = !$customer_group_info['approval'];
				} else {
					$approved = 1;
				}
			} else {
				if (!$this->config->get('config_customer_approval')) {
					$approved = '1';
				} else {
					$approved = '0';
				}
			}
			
			$data = array(
				'store_id'			=> $this->config->get('config_store_id'),
				'firstname'			=> $firstname,
				'lastname'			=> $lastname,
				'email'				=> $email,
				'password'			=> md5(uniqid(rand(), true)),
				'customer_group_id'	=> $this->config->get('fblogin_customer_group_id'),
				'newsletter'		=> 1,
				'ip'				=> $this->request->server['REMOTE_ADDR'],
				'approved'			=> $approved
			);
			
			$customer = $this->model_module_fblogin->getCustomer($email);

			if (!$customer) {
				$address_id = $this->model_module_fblogin->addCustomer($data);
				
				$customer = $this->model_module_fblogin->getCustomer($email);
				
				if ($customer['approved']) {
					$login = $this->customer->login($email, '', true);
					
					$json['redirect'] = $this->url->link('account/address/edit', 'address_id=' . (int)$address_id, 'SSL');
				} else {
					$this->session->data['facebook_error'] = $this->language->get('error_approved');
				
					$json['reload'] = true;
				}
			} else {
				if ($customer['approved']) {
					$login = $this->customer->login($email, '', true);
					
					$json['reload'] = true;
				} else {
					$this->session->data['facebook_error'] = $this->language->get('error_approved');
				
					$json['reload'] = true;
				}
			}
		}

		$this->response->setOutput(json_encode($json));
	}
}