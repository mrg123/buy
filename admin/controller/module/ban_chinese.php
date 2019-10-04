<?php
class ControllerModuleBanChinese extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('module/ban_chinese');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('ban_chinese', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'));
		}

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_edit'] = $this->language->get('text_edit');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');

		$data['entry_status'] = $this->language->get('entry_status');
		$data['entry_title'] = $this->language->get('entry_title');
		$data['entry_description'] = $this->language->get('entry_description');

		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');


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
			'href' => $this->url->link('module/ban_chinese', 'token=' . $this->session->data['token'], 'SSL')
		);

		$data['action'] = $this->url->link('module/ban_chinese', 'token=' . $this->session->data['token'], 'SSL');

		$data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');

		if (isset($this->request->post['ban_chinese_status'])) {
			$data['ban_chinese_status'] = $this->request->post['ban_chinese_status'];
		} else {
			$data['ban_chinese_status'] = $this->config->get('ban_chinese_status');
		}
		if (isset($this->request->post['ban_chinese_description'])) {
			$data['ban_chinese_description'] = $this->request->post['ban_chinese_description'];
		} else {
			$data['ban_chinese_description'] = $this->config->get('ban_chinese_description');
		}
		
		$this->load->model('localisation/language');

		$data['languages'] = $this->model_localisation_language->getLanguages();
		

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('module/ban_chinese.tpl', $data));
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'module/ban_chinese')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		
		

		return !$this->error;
	}
}