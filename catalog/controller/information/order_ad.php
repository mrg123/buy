<?php
class ControllerInformationOrderAd extends Controller {
	
	public function index() {
		$this->load->model('catalog/information');

		$ad_information = $this->config->get('order_ad_description');
		$language_id = $this->config->get('config_language_id');

		$output = '';

		$information_info = $ad_information[$language_id];

		if ($information_info) {
			$output .= html_entity_decode($information_info['description'], ENT_QUOTES, 'UTF-8') . "\n";
		}

		$this->response->setOutput($output);
	}
}