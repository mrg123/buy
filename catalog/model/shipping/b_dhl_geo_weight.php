<?php 
class ModelShippingBDhlGeoWeight extends Model {    
  	public function getQuote($address) {
		$this->load->language('shipping/b_dhl_geo_weight');
		
		$quote_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "geo_zone ORDER BY name");
	
		foreach ($query->rows as $result) {
			if ($this->config->get('b_dhl_geo_weight_' . $result['geo_zone_id'] . '_status')) {
				$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "zone_to_geo_zone WHERE geo_zone_id = '" . (int)$result['geo_zone_id'] . "' AND country_id = '" . (int)$address['country_id'] . "' AND (zone_id = '" . (int)$address['zone_id'] . "' OR zone_id = '0')");
			
				if ($query->num_rows) {
					$status = true;
				} else {
					$status = false;
				}
			} else {
				$status = false;
			}
		     
		     
		    $min_weight = $this->config->get('b_dhl_geo_weight_' . $result['geo_zone_id'] . '_min');
		    $max_weight = $this->config->get('b_dhl_geo_weight_' . $result['geo_zone_id'] . '_max');
		    
		    if (($this->cart->getWeight() < $min_weight) || ($this->cart->getWeight() > $max_weight)) {
                $status = false;
             }

			if ($status) {
				$cost = '';
				$weight = $this->cart->getWeight();
				
				$hand = $this->config->get('b_dhl_geo_weight_' . $result['geo_zone_id'] . '_hand');
				$rates = explode(',', $this->config->get('b_dhl_geo_weight_' . $result['geo_zone_id'] . '_rate'));
				
				foreach ($rates as $rate) {
					$data = explode(':', $rate);
				
					if ($data[0] >= $weight) {
						if (isset($data[1])) {
							$cost = $data[1];
						}
				
						break;
					}
				}
				
				
				
				if ((string)$cost != '') {
				 
				 $p2 = round($hand/100, 2)*$cost;
				 $costnew = $cost + $p2;
				  
				    if ($this->config->get('b_dhl_geo_weight_shipdisplayoption') =='1') { 
					    $quote_data['b_dhl_geo_weight_' . $result['geo_zone_id']] = array(
						'code'         => 'b_dhl_geo_weight.b_dhl_geo_weight_' . $result['geo_zone_id'],
						'keycode'      => '1',
						'title'        => $this->language->get('text_title'),
						'icon_shipping'=> $this->language->get('icon_shipping_1'),
						'cost'         => $costnew,
						'tax_class_id' => $this->config->get('b_dhl_geo_weight_tax_class_id'),
						'text'         => $this->currency->format($this->tax->calculate($costnew, $this->config->get('b_dhl_geo_weight_tax_class_id'), $this->config->get('config_tax')))
					    );
					    
					} elseif ($this->config->get('b_dhl_geo_weight_shipdisplayoption') =='2') {
					    $quote_data['b_dhl_geo_weight_' . $result['geo_zone_id']] = array(
						'code'         => 'b_dhl_geo_weight.b_dhl_geo_weight_' . $result['geo_zone_id'],
						'keycode'      => '1',
						'title'        => $this->language->get('text_title'),
						'icon_shipping'=> $this->language->get('icon_shipping_2'),
						'cost'         => $costnew,
						'tax_class_id' => $this->config->get('b_dhl_geo_weight_tax_class_id'),
						'text'         => $this->currency->format($this->tax->calculate($costnew, $this->config->get('b_dhl_geo_weight_tax_class_id'), $this->config->get('config_tax')))
					    );
					 
					} else {
					    $quote_data['b_dhl_geo_weight_' . $result['geo_zone_id']] = array(
						'code'         => 'b_dhl_geo_weight.b_dhl_geo_weight_' . $result['geo_zone_id'],
						'keycode'      => '1',
						'title'        => $this->language->get('text_title'),
						'icon_shipping'=> $this->language->get('icon_shipping_3'),
						'cost'         => $costnew,
						'tax_class_id' => $this->config->get('b_dhl_geo_weight_tax_class_id'),
						'text'         => $this->currency->format($this->tax->calculate($costnew, $this->config->get('b_dhl_geo_weight_tax_class_id'), $this->config->get('config_tax')))
					    );
					 	
				 }
			   }
			
			
			
			}
		}
		
		
		$method_data = array();
	
		if ($quote_data) {
      		$method_data = array(
        		'code'       => 'b_dhl_geo_weight',
        		'title'      => $this->language->get('text_title'),
        		'quote'      => $quote_data,
				'sort_order' => $this->config->get('b_dhl_geo_weight_sort_order'),
        		'error'      => false
      		);
		}
	
		return $method_data;
  	}
}
?>