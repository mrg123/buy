<?php
class ControllerModuleQcPhoto extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('module/qc_photo');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('qc_photo', $this->request->post);

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
			'href' => $this->url->link('module/qc_photo', 'token=' . $this->session->data['token'], 'SSL')
		);

		$data['action'] = $this->url->link('module/qc_photo', 'token=' . $this->session->data['token'], 'SSL');

		$data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');

		if (isset($this->request->post['qc_photo_status'])) {
			$data['qc_photo_status'] = $this->request->post['qc_photo_status'];
		} else {
			$data['qc_photo_status'] = $this->config->get('qc_photo_status');
		}

		$this->load->model('localisation/order_status');

		$data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();

		if (isset($this->request->post['qc_photo_upload_status_id'])) {
			$data['qc_photo_upload_status_id'] = $this->request->post['qc_photo_upload_status_id'];
		} else {
			$data['qc_photo_upload_status_id'] = $this->config->get('qc_photo_upload_status_id');
		}

		if (isset($this->request->post['qc_photo_gl_status_id'])) {
			$data['qc_photo_gl_status_id'] = $this->request->post['qc_photo_gl_status_id'];
		} else {
			$data['qc_photo_gl_status_id'] = $this->config->get('qc_photo_gl_status_id');
		}

		if (isset($this->request->post['qc_photo_rl_status_id'])) {
			$data['qc_photo_rl_status_id'] = $this->request->post['qc_photo_rl_status_id'];
		} else {
			$data['qc_photo_rl_status_id'] = $this->config->get('qc_photo_rl_status_id');
		}

		if (isset($this->request->post['qc_photo_welcome'])) {
			$data['qc_photo_welcome'] = $this->request->post['qc_photo_welcome'];
		} else {
			$data['qc_photo_welcome'] = $this->config->get('qc_photo_welcome');
		}



		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('module/qc_photo.tpl', $data));
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'module/qc_photo')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}
}