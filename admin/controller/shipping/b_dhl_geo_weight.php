<?php
class ControllerShippingBDhlGeoWeight extends Controller { 
	private $error = array();

	public function index() {
		$this->load->language('shipping/b_dhl_geo_weight');
		$this->document->setTitle($this->language->get('heading_title1'));		
		$this->load->model('setting/setting');

		
			if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('b_dhl_geo_weight', $this->request->post);
			$this->session->data['success'] = $this->language->get('text_success');
			$this->response->redirect($this->url->link('extension/shipping', 'token=' . $this->session->data['token'], 'SSL'));
		}
		
				
		$data['heading_title'] = $this->language->get('heading_title');
		$data['heading_title1'] = $this->language->get('heading_title1');
		
		$data['text_edit'] = $this->language->get('text_edit');	
		$data['text_none'] = $this->language->get('text_none');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');	
		$data['entry_rate'] = $this->language->get('entry_rate');
		$data['entry_tax_class'] = $this->language->get('entry_tax_class');
		$data['entry_status'] = $this->language->get('entry_status');
		$data['entry_sort_order'] = $this->language->get('entry_sort_order');		
		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');
		$data['tab_general'] = $this->language->get('tab_general');
		$data['entry_min_weight'] = $this->language->get('entry_min_weight');
		$data['entry_max_weight'] = $this->language->get('entry_max_weight');
		$data['entry_hand'] = $this->language->get('entry_hand');
		
		$data['entry_shipdisplayoption'] = $this->language->get('entry_shipdisplayoption');
		$data['entry_logo_only'] = $this->language->get('entry_logo_only');
		$data['entry_text_only'] = $this->language->get('entry_text_only');
		$data['entry_logoandtext'] = $this->language->get('entry_logoandtext');
		$data['entry_shipdisplay'] = $this->language->get('entry_shipdisplay');
		$data['icon_shipping_1'] = $this->language->get('icon_shipping_1');
		$data['icon_shipping_2'] = $this->language->get('icon_shipping_2');
		$data['icon_shipping_3'] = $this->language->get('icon_shipping_3');

 		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}
		
		if (isset($this->session->data['success'])) {
            $data['success'] = $this->session->data['success'];
            unset($this->session->data['success']);
        } else {
            $data['success'] = '';
        }

  		$data['breadcrumbs'] = array();

   		$data['breadcrumbs'][] = array(
       		'text'=> $this->language->get('text_home'),
			'href'=> $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL'),
      		
   		);

   		$data['breadcrumbs'][] = array(
       		'text'=> $this->language->get('text_shipping'),
			'href'=> $this->url->link('extension/shipping', 'token=' . $this->session->data['token'], 'SSL'),
      		
   		);
		
   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('shipping/b_dhl_geo_weight', 'token=' . $this->session->data['token'], 'SSL'),
      		
   		);
		
		$data['action'] = $this->url->link('shipping/b_dhl_geo_weight', 'token=' . $this->session->data['token'], 'SSL');
		
		$data['cancel'] = $this->url->link('extension/shipping', 'token=' . $this->session->data['token'], 'SSL'); 

		$this->load->model('localisation/geo_zone');
		
		$geo_zones = $this->model_localisation_geo_zone->getGeoZones();
		
		foreach ($geo_zones as $geo_zone) {
			if (isset($this->request->post['b_dhl_geo_weight_' . $geo_zone['geo_zone_id'] . '_rate'])) {
				$data['b_dhl_geo_weight_' . $geo_zone['geo_zone_id'] . '_rate'] = $this->request->post['b_dhl_geo_weight_' . $geo_zone['geo_zone_id'] . '_rate'];
			} else {
				$data['b_dhl_geo_weight_' . $geo_zone['geo_zone_id'] . '_rate'] = $this->config->get('b_dhl_geo_weight_' . $geo_zone['geo_zone_id'] . '_rate');
			}	
			
			if (isset($this->request->post['b_dhl_geo_weight_' . $geo_zone['geo_zone_id'] . '_min'])) {
				$this->data['b_dhl_geo_weight_' . $geo_zone['geo_zone_id'] . '_min'] = $this->request->post['b_dhl_geo_weight_' . $geo_zone['geo_zone_id'] . '_min'];
			} else {
				$data['b_dhl_geo_weight_' . $geo_zone['geo_zone_id'] . '_min'] = $this->config->get('b_dhl_geo_weight_' . $geo_zone['geo_zone_id'] . '_min');
			}	
			
			if (isset($this->request->post['b_dhl_geo_weight_' . $geo_zone['geo_zone_id'] . '_max'])) {
				$data['b_dhl_geo_weight_' . $geo_zone['geo_zone_id'] . '_max'] = $this->request->post['b_dhl_geo_weight_' . $geo_zone['geo_zone_id'] . '_max'];
			} else {
				$data['b_dhl_geo_weight_' . $geo_zone['geo_zone_id'] . '_max'] = $this->config->get('b_dhl_geo_weight_' . $geo_zone['geo_zone_id'] . '_max');
			}
			
			if (isset($this->request->post['b_dhl_geo_weight_' . $geo_zone['geo_zone_id'] . '_hand'])) {
				$data['b_dhl_geo_weight_' . $geo_zone['geo_zone_id'] . '_hand'] = $this->request->post['b_dhl_geo_weight_' . $geo_zone['geo_zone_id'] . '_hand'];
			} else {
				$data['b_dhl_geo_weight_' . $geo_zone['geo_zone_id'] . '_hand'] = $this->config->get('b_dhl_geo_weight_' . $geo_zone['geo_zone_id'] . '_hand');
			}
			
			if (isset($this->request->post['b_dhl_geo_weight_' . $geo_zone['geo_zone_id'] . '_status'])) {
				$data['b_dhl_geo_weight_' . $geo_zone['geo_zone_id'] . '_status'] = $this->request->post['b_dhl_geo_weight_' . $geo_zone['geo_zone_id'] . '_status'];
			} else {
				$data['b_dhl_geo_weight_' . $geo_zone['geo_zone_id'] . '_status'] = $this->config->get('b_dhl_geo_weight_' . $geo_zone['geo_zone_id'] . '_status');
			}		
		}
		
		$data['geo_zones'] = $geo_zones;

		if (isset($this->request->post['b_dhl_geo_weight_tax_class_id'])) {
			$data['b_dhl_geo_weight_tax_class_id'] = $this->request->post['b_dhl_geo_weight_tax_class_id'];
		} else {
			$data['b_dhl_geo_weight_tax_class_id'] = $this->config->get('b_dhl_geo_weight_tax_class_id');
		}
		
		$this->load->model('localisation/tax_class');
				
		$data['tax_classes'] = $this->model_localisation_tax_class->getTaxClasses();
		
		if (isset($this->request->post['b_dhl_geo_weight_status'])) {
			$data['b_dhl_geo_weight_status'] = $this->request->post['b_dhl_geo_weight_status'];
		} else {
			$data['b_dhl_geo_weight_status'] = $this->config->get('b_dhl_geo_weight_status');
		}
		
		if (isset($this->request->post['b_dhl_geo_weight_sort_order'])) {
			$data['b_dhl_geo_weight_sort_order'] = $this->request->post['b_dhl_geo_weight_sort_order'];
		} else {
			$data['b_dhl_geo_weight_sort_order'] = $this->config->get('b_dhl_geo_weight_sort_order');
		}
		
		if (isset($this->request->post['b_dhl_geo_weight_shipdisplayoption'])) {
			$data['b_dhl_geo_weight_shipdisplayoption'] = $this->request->post['b_dhl_geo_weight_shipdisplayoption'];
		} else {
			$data['b_dhl_geo_weight_shipdisplayoption'] = $this->config->get('b_dhl_geo_weight_shipdisplayoption'); 
		}
			

	/*	old opencart template calling
				
	$this->template = 'shipping/b_dhl_geo_weight.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);
				
	//$this->response->setOutput($this->render('shipping/b_dhl_geo_weight.tpl', $data));	
		*/
				
		
		
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
		
		
		$this->response->setOutput($this->load->view('shipping/b_dhl_geo_weight.tpl', $data));
	}
		
	protected function validate() {
		if (!$this->user->hasPermission('modify', 'shipping/b_dhl_geo_weight')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		
		if (!$this->error) {
			return true;
		} else {
			return false;
		}	
	}
}
?>