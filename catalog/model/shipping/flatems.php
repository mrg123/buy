<?php
class ModelShippingFlatems extends Model {
	function getQuote($address) {
		$this->load->language('shipping/flatems');
		
		
		
		/*
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "geo_zone ORDER BY name");

		foreach($query->rows as $result) {
			if($this->config->get('flatems_' . $result['geo_zone_id'] . '_status')){
				$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "zone_to_geo_zone WHERE geo_zone_id = '" . (int)$result['geo_zone_id'] . "' AND country_id = '" . (int)$address['country_id'] . "' AND (zone_id = '" . (int)$address['zone_id'] . "' OR zone_id = '0')");
				
				if($query->num_rows) {
					$status = true;
				}else{
					$status = false;
				}
			}else{
				$status = false;
			}
			
			if ($this->cart->getSubTotal() >= $this->config->get('flatems_total')) {
			$status = false;
			}
			
			if($status) {
				$cost = '';
				$cost = $this->config->get('flatems_' . $result['geo_zone_id'] . '_rate');
			if((string)$cost != ''){
			$quote_data['flatems'] = array(
				'code'         => 'flatems.flatems',
				'title'        => $this->language->get('text_description'),
				'cost'         => $cost,
				'tax_class_id' => $this->config->get('flatems_tax_class_id'),
				'text'         => $this->currency->format($cost, $this->config->get('flatems_tax_class_id'), $this->config->get('config_tax'))
			);
			}
			}
		}
		*/
		
		if ($this->cart->getSubTotal() >= $this->config->get('flatems_total')) {
			$status = false;
		}else{
			$status = true;
		}
		
		$method_data = array();
			
		if($status) {
				
				$quote_data = array();
				$cost = '';
				$cost = $this->config->get('flatems_rate');
			if((string)$cost != ''){
			$quote_data['flatems'] = array(
				'code'         => 'flatems.flatems',
				'title'        => $this->language->get('text_description'),
				'cost'         => $cost,
				'tax_class_id' => $this->config->get('flatems_tax_class_id'),
				'text'         => $this->currency->format($cost, $this->config->get('flatems_tax_class_id'), $this->config->get('config_tax'))
			);
			}
			
			if ($quote_data) {
			$method_data = array(
				'code'       => 'flatems',
				'title'      => $this->language->get('text_title'),
				'quote'      => $quote_data,
				'sort_order' => $this->config->get('flatems_sort_order'),
				'error'      => false
			);
			}
		}
		
		
		/*
		if ($this->customer->getGroupId()==4||$this->customer->getGroupId()==5||$this->customer->getGroupId()==6) {
			$status = false;
		}
		*/

		

		

		return $method_data;
	}
}