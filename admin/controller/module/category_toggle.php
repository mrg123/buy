<?php
class ControllerModuleCategoryToggle extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('module/category_toggle');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/setting');
		$this->load->model('module/category_toggle');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('category_toggle', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'));
		}

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_edit'] = $this->language->get('text_edit');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');

		$data['entry_status'] = $this->language->get('entry_status');

		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');
		
		$data['column_name'] = $this->language->get('column_name');
		$data['column_category_id'] = $this->language->get('column_category_id');
		$data['column_sort_order'] = $this->language->get('column_sort_order');
		$data['column_action'] = $this->language->get('column_action');

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_module'),
			'href' => $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('module/category_toggle', 'token=' . $this->session->data['token'], 'SSL')
		);

		$data['action'] = $this->url->link('module/category_toggle', 'token=' . $this->session->data['token'], 'SSL');

		$data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');
		
		$data['token'] = $this->session->data['token'];

		if (isset($this->request->post['category_toggle_status'])) {
			$data['category_toggle_status'] = $this->request->post['category_toggle_status'];
		} else {
			$data['category_toggle_status'] = $this->config->get('category_toggle_status');
		}
		
		$data['categories'] = array();
		$results = $this->model_module_category_toggle->getCategories();

		foreach ($results as $result) {
			$toggle = $this->model_module_category_toggle->getToggleByCategoryId($result['category_id']);
			if($toggle){
				if($toggle['toggle']){
					$toggle = 1;
				}else{
					$toggle = 0;
				}
				
			}else{
				$toggle = 0;
			}
			$data['categories'][] = array(
				'toggle' => $toggle,
				'category_id' => $result['category_id'],
				'name'        => $result['name'],
				'sort_order'  => $result['sort_order']
			);
		}

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('module/category_toggle.tpl', $data));
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'module/category_toggle')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}
	
	public function updateToggle(){
		$json = array();
		$this->load->language('module/category_toggle');
		$this->load->model('module/category_toggle');
		
		if(isset($this->request->get['toggle']) && isset($this->request->get['category_id'])){
			$toggle = $this->request->get['toggle'];
			$category_id = $this->request->get['category_id'];
			$this->model_module_category_toggle->updateToggle($category_id,$toggle);
			$json['success'] = $this->language->get('update_success');
		}else{
			$json['error'] = $this->language->get('error_toggle');
		}
		
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
	
	public function install(){
		$this->load->model('module/category_toggle');
		$this->model_module_category_toggle->install();
	}
}