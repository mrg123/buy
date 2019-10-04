<?php
class ControllerShippingFlatems extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('shipping/flatems');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('flatems', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('extension/shipping', 'token=' . $this->session->data['token'], 'SSL'));
		}

		$data['heading_title'] = $this->language->get('heading_title');
		
		$data['text_edit'] = $this->language->get('text_edit');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['text_all_zones'] = $this->language->get('text_all_zones');
		$data['text_none'] = $this->language->get('text_none');

		$data['entry_cost'] = $this->language->get('entry_cost');
		$data['entry_tax_class'] = $this->language->get('entry_tax_class');
		$data['entry_geo_zone'] = $this->language->get('entry_geo_zone');
		$data['entry_status'] = $this->language->get('entry_status');
		$data['entry_sort_order'] = $this->language->get('entry_sort_order');
		$data['entry_total'] = $this->language->get('entry_total');

		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');
		
		$data['tab_general'] = $this->language->get('tab_general');
		$data['help_rate'] = $this->language->get('help_rate');
		$data['entry_rate'] = $this->language->get('entry_rate');
		
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
			'text' => $this->language->get('text_shipping'),
			'href' => $this->url->link('extension/shipping', 'token=' . $this->session->data['token'], 'SSL')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('shipping/flatems', 'token=' . $this->session->data['token'], 'SSL')
		);

		$data['action'] = $this->url->link('shipping/flatems', 'token=' . $this->session->data['token'], 'SSL');

		$data['cancel'] = $this->url->link('extension/shipping', 'token=' . $this->session->data['token'], 'SSL');

		if (isset($this->request->post['flatems_cost'])) {
			$data['flatems_cost'] = $this->request->post['flatems_cost'];
		} else {
			$data['flatems_cost'] = $this->config->get('flatems_cost');
		}
		
		if (isset($this->request->post['flatems_total'])) {
			$data['flatems_total'] = $this->request->post['flatems_total'];
		} else {
			$data['flatems_total'] = $this->config->get('flatems_total');
		}
		
		if (isset($this->request->post['flatems_rate'])) {
			$data['flatems_rate'] = $this->request->post['flatems_rate'];
		} else {
			$data['flatems_rate'] = $this->config->get('flatems_rate');
		}

		if (isset($this->request->post['flatems_tax_class_id'])) {
			$data['flatems_tax_class_id'] = $this->request->post['flatems_tax_class_id'];
		} else {
			$data['flatems_tax_class_id'] = $this->config->get('flatems_tax_class_id');
		}

		$this->load->model('localisation/tax_class');

		$data['tax_classes'] = $this->model_localisation_tax_class->getTaxClasses();

		if (isset($this->request->post['flatems_geo_zone_id'])) {
			$data['flatems_geo_zone_id'] = $this->request->post['flatems_geo_zone_id'];
		} else {
			$data['flatems_geo_zone_id'] = $this->config->get('flatems_geo_zone_id');
		}

		$this->load->model('localisation/geo_zone');

		$geo_zones = $this->model_localisation_geo_zone->getGeoZones();
		
		foreach ($geo_zones as $geo_zone) {
			if (isset($this->request->post['flatems_' . $geo_zone['geo_zone_id'] . '_rate'])) {
				$data['flatems_' . $geo_zone['geo_zone_id'] . '_rate'] = $this->request->post['flatems_' . $geo_zone['geo_zone_id'] . '_rate'];
			} else {
				$data['flatems_' . $geo_zone['geo_zone_id'] . '_rate'] = $this->config->get('flatems_' . $geo_zone['geo_zone_id'] . '_rate');
			}

			if (isset($this->request->post['flatems_' . $geo_zone['geo_zone_id'] . '_status'])) {
				$data['flatems_' . $geo_zone['geo_zone_id'] . '_status'] = $this->request->post['flatems_' . $geo_zone['geo_zone_id'] . '_status'];
			} else {
				$data['flatems_' . $geo_zone['geo_zone_id'] . '_status'] = $this->config->get('flatems_' . $geo_zone['geo_zone_id'] . '_status');
			}
		}
		
		$data['geo_zones'] = $geo_zones;

		if (isset($this->request->post['flatems_status'])) {
			$data['flatems_status'] = $this->request->post['flatems_status'];
		} else {
			$data['flatems_status'] = $this->config->get('flatems_status');
		}

		if (isset($this->request->post['flatems_sort_order'])) {
			$data['flatems_sort_order'] = $this->request->post['flatems_sort_order'];
		} else {
			$data['flatems_sort_order'] = $this->config->get('flatems_sort_order');
		}

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('shipping/flatems.tpl', $data));
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'shipping/flatems')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}
}