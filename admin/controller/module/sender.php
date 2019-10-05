<?php
class ControllerModuleSender extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('module/sender');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('sender', $this->request->post);

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
			'href' => $this->url->link('module/sender', 'token=' . $this->session->data['token'], 'SSL')
		);

		$data['action'] = $this->url->link('module/sender', 'token=' . $this->session->data['token'], 'SSL');

		$data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');

		if (isset($this->request->post['sender_status'])) {
			$data['sender_status'] = $this->request->post['sender_status'];
		} else {
			$data['sender_status'] = $this->config->get('sender_status');
		}

		if (isset($this->request->post['sender_email1'])) {
			$data['sender_email1'] = $this->request->post['sender_email1'];
		} else {
			$data['sender_email1'] = $this->config->get('sender_email1');
		}
		if (isset($this->request->post['sender_email2'])) {
			$data['sender_email2'] = $this->request->post['sender_email2'];
		} else {
			$data['sender_email2'] = $this->config->get('sender_email2');
		}
		if (isset($this->request->post['sender_email3'])) {
			$data['sender_email3'] = $this->request->post['sender_email3'];
		} else {
			$data['sender_email3'] = $this->config->get('sender_email3');
		}

		$data['emails'] = [1,2,3];
		

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('module/sender.tpl', $data));
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'module/sender')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		
		return !$this->error;
	}
}