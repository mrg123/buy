<?php
class ControllerModuleTrack extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('module/track');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/setting');
		$this->load->model('module/track');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			
			$this->model_setting_setting->editSetting('track', $this->request->post);
			

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'));
		}

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_edit'] = $this->language->get('text_edit');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		
		$data['text_list'] = $this->language->get('text_list');
		$data['text_yes'] = $this->language->get('text_yes');
		$data['text_no'] = $this->language->get('text_no');
		$data['text_default'] = $this->language->get('text_default');
		$data['text_no_results'] = $this->language->get('text_no_results');
		$data['text_confirm'] = $this->language->get('text_confirm');

		$data['entry_name'] = $this->language->get('entry_name');
		$data['entry_nation'] = $this->language->get('entry_nation');
		$data['entry_referer'] = $this->language->get('entry_referer');
		$data['entry_landing_url'] = $this->language->get('entry_landing_url');
		
		
		$data['entry_title'] = $this->language->get('entry_title');
		$data['entry_description'] = $this->language->get('entry_description');
		$data['entry_status'] = $this->language->get('entry_status');

		$data['entry_email'] = $this->language->get('entry_email');
		$data['entry_customer_group'] = $this->language->get('entry_customer_group');

		$data['entry_approved'] = $this->language->get('entry_approved');
		$data['entry_ip'] = $this->language->get('entry_ip');
		$data['entry_date_added'] = $this->language->get('entry_date_added');
		$data['entry_track_sign'] = $this->language->get('entry_track_sign');

		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');
		
		$data['button_approve'] = $this->language->get('button_approve');
		$data['button_add'] = $this->language->get('button_add');
		$data['button_edit'] = $this->language->get('button_edit');
		$data['button_delete'] = $this->language->get('button_delete');
		$data['button_filter'] = $this->language->get('button_filter');
		$data['button_login'] = $this->language->get('button_login');
		$data['button_unlock'] = $this->language->get('button_unlock');
		
		$data['column_name'] = $this->language->get('column_name');
		$data['column_visitor'] = $this->language->get('column_visitor');
		$data['column_nation'] = $this->language->get('column_nation');
		$data['column_referer'] = $this->language->get('column_referer');
		$data['column_landing_url'] = $this->language->get('column_landing_url');
		$data['column_email'] = $this->language->get('column_email');
		$data['column_customer_group'] = $this->language->get('column_customer_group');
		$data['column_status'] = $this->language->get('column_status');
		$data['column_approved'] = $this->language->get('column_approved');
		$data['column_ip'] = $this->language->get('column_ip');
		$data['column_date_added'] = $this->language->get('column_date_added');
		$data['column_action'] = $this->language->get('column_action');
		$data['column_customer_id'] = $this->language->get('column_customer_id');
		$data['column_order_id'] = $this->language->get('column_order_id');
		$data['entry_total_visitor'] = $this->language->get('entry_total_visitor');
		$data['entry_total_order_id'] = $this->language->get('entry_total_order_id');

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
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_module'),
			'href' => $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL')
		);

		if (!isset($this->request->get['module_id'])) {
			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('heading_title'),
				'href' => $this->url->link('module/track', 'token=' . $this->session->data['token'], 'SSL')
			);
		} else {
			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('heading_title'),
				'href' => $this->url->link('module/track', 'token=' . $this->session->data['token'] . '&module_id=' . $this->request->get['module_id'], 'SSL')
			);
		}

		
		$data['action'] = $this->url->link('module/track', 'token=' . $this->session->data['token'], 'SSL');
		

		$data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');

		if (isset($this->request->post['track_status'])) {
			$data['track_status'] = $this->request->post['track_status'];
		}  else {
			$data['track_status'] = $this->config->get('track_status');
		}
		
		if (isset($this->request->post['track_sign'])) {
			$data['track_sign'] = $this->request->post['track_sign'];
		}  else {
			$data['track_sign'] = $this->config->get('track_sign');
		}
		
		
		if (isset($this->request->get['filter_visitor'])) {
			$filter_visitor = $this->request->get['filter_visitor'];
		} else {
			$filter_visitor = null;
		}

		if (isset($this->request->get['filter_ip'])) {
			$filter_ip = $this->request->get['filter_ip'];
		} else {
			$filter_ip = null;
		}

		if (isset($this->request->get['filter_nation'])) {
			$filter_nation = $this->request->get['filter_nation'];
		} else {
			$filter_nation = null;
		}

		if (isset($this->request->get['filter_referer'])) {
			$filter_referer = $this->request->get['filter_referer'];
		} else {
			$filter_referer = null;
		}

		if (isset($this->request->get['filter_landing_url'])) {
			$filter_landing_url = $this->request->get['filter_landing_url'];
		} else {
			$filter_landing_url = null;
		}

		if (isset($this->request->get['filter_date_added'])) {
			$filter_date_added = $this->request->get['filter_date_added'];
		} else {
			$filter_date_added = null;
		}

		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'track_id';
		}

		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = 'ASC';
		}

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}

		$url = '';

		if (isset($this->request->get['filter_visitor'])) {
			$url .= '&filter_visitor=' . urlencode(html_entity_decode($this->request->get['filter_visitor'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_ip'])) {
			$url .= '&filter_ip=' . $this->request->get['filter_ip'];
		}

		if (isset($this->request->get['filter_nation'])) {
			$url .= '&filter_nation=' . $this->request->get['filter_nation'];
		}

		if (isset($this->request->get['filter_referer'])) {
			$url .= '&filter_referer=' . $this->request->get['filter_referer'];
		}

		if (isset($this->request->get['filter_landing_url'])) {
			$url .= '&filter_landing_url=' . $this->request->get['filter_landing_url'];
		}

		if (isset($this->request->get['filter_date_added'])) {
			$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
		}

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}
		
		$data['customers'] = array();

		$filter_data = array(
			'filter_visitor'              => $filter_visitor,
			'filter_nation' => $filter_nation,
			'filter_referer'            => $filter_referer,
			'filter_landing_url'          => $filter_landing_url,
			'filter_ip'             => $filter_ip,
			'filter_date_added'        => $filter_date_added,
			'sort'                     => $sort,
			'order'                    => $order,
			'start'                    => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit'                    => $this->config->get('config_limit_admin')
		);

		$track_total = $this->model_module_track->getTotalTracks($filter_data);

		$results = $this->model_module_track->getTracks($filter_data);
		
		$data['tracks'] = array();

		foreach ($results as $result) {

			$data['tracks'][] = array(
				'track_id'    => $result['track_id'],
				'visitor'           => $result['visitor'],
				'nation'          => $result['nation'],
				'referer' => $result['referer'],
				'landing_url' => $result['landing_url'],
				'ip'             => $result['ip'],
				'date_added'     => $result['date_added'],
				'order_id' => $result['order_id']
			);
		}
		
		$data['token'] = $this->session->data['token'];
		
		$url = '';

		if (isset($this->request->get['filter_visitor'])) {
			$url .= '&filter_visitor=' . $this->request->get['filter_visitor'];
		}

		if (isset($this->request->get['filter_ip'])) {
			$url .= '&filter_ip=' . $this->request->get['filter_ip'];
		}

		if (isset($this->request->get['filter_nation'])) {
			$url .= '&filter_nation=' . $this->request->get['filter_nation'];
		}

		if (isset($this->request->get['filter_referer'])) {
			$url .= '&filter_referer=' . $this->request->get['filter_referer'];
		}

		if (isset($this->request->get['filter_landing_url'])) {
			$url .= '&filter_landing_url=' . $this->request->get['filter_landing_url'];
		}

		if (isset($this->request->get['filter_date_added'])) {
			$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
		}

		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['sort_track_id'] = $this->url->link('module/track', 'token=' . $this->session->data['token'] . '&sort=track_id' . $url, 'SSL');
		$data['sort_visitor'] = $this->url->link('module/track', 'token=' . $this->session->data['token'] . '&sort=visitor' . $url, 'SSL');
		$data['sort_nation'] = $this->url->link('module/track', 'token=' . $this->session->data['token'] . '&sort=nation' . $url, 'SSL');
		$data['sort_referer'] = $this->url->link('module/track', 'token=' . $this->session->data['token'] . '&sort=referer' . $url, 'SSL');
		$data['sort_landing_url'] = $this->url->link('module/track', 'token=' . $this->session->data['token'] . '&sort=landing_url' . $url, 'SSL');
		$data['sort_ip'] = $this->url->link('module/track', 'token=' . $this->session->data['token'] . '&sort=ip' . $url, 'SSL');
		$data['sort_date_added'] = $this->url->link('module/track', 'token=' . $this->session->data['token'] . '&sort=date_added' . $url, 'SSL');
		$data['sort_order_id'] = $this->url->link('module/track', 'token=' . $this->session->data['token'] . '&sort=order_id' . $url, 'SSL');

		$url = '';

		if (isset($this->request->get['filter_visitor'])) {
			$url .= '&filter_visitor=' . $this->request->get['filter_visitor'];
		}

		if (isset($this->request->get['filter_nation'])) {
			$url .= '&filter_nation=' . $this->request->get['filter_nation'];
		}

		if (isset($this->request->get['filter_referer'])) {
			$url .= '&filter_referer=' . $this->request->get['filter_referer'];
		}

		if (isset($this->request->get['filter_landing_url'])) {
			$url .= '&filter_landing_url=' . $this->request->get['filter_landing_url'];
		}

		if (isset($this->request->get['filter_ip'])) {
			$url .= '&filter_ip=' . $this->request->get['filter_ip'];
		}

		if (isset($this->request->get['filter_date_added'])) {
			$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
		}

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$pagination = new Pagination();
		$pagination->total = $track_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('module/track', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($track_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($track_total - $this->config->get('config_limit_admin'))) ? $track_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $track_total, ceil($track_total / $this->config->get('config_limit_admin')));
		
		/* TOtal */
		$track_total = $this->model_module_track->getTotalOrderIdAndVisitor();
		$data['total_visitor'] = $track_total['total_visitor'];
		$arr = array_unique(explode(',',$track_total['total_order_id']));
		foreach($arr as $key=>$value){
			if($value==0){
				unset($arr[$key]);
			}
		}
		$data['total_order_id'] = count($arr);
		
		/* track url */
		$data['track_urls'] = $this->model_module_track->getTrackUrls();
		
		$products = $this->model_module_track->getTrackCarts();
		
		$data['products'] = array();
		
		$this->load->model('tool/image');
		
		foreach ($products as $product) {
				$product_total = 0;

				foreach ($products as $product_2) {
					if ($product_2['product_id'] == $product['product_id']) {
						$product_total += $product_2['quantity'];
					}
				}

				if ($product['minimum'] > $product_total) {
					$data['error_warning'] = sprintf($this->language->get('error_minimum'), $product['name'], $product['minimum']);
				}

				if ($product['image']) {
					$image = $this->model_tool_image->resize($product['image'], $this->config->get('config_image_cart_width'), $this->config->get('config_image_cart_height'));
				} else {
					$image = '';
				}

				$option_data = array();

				foreach ($product['option'] as $option) {
					if ($option['type'] != 'file') {
						$value = $option['value'];
					} else {
						$upload_info = $this->model_tool_upload->getUploadByCode($option['value']);

						if ($upload_info) {
							$value = $upload_info['name'];
						} else {
							$value = '';
						}
					}

					$option_data[] = array(
						'name'  => $option['name'],
						'value' => (utf8_strlen($value) > 20 ? utf8_substr($value, 0, 20) . '..' : $value)
					);
				}

				// Display prices
				$price = $product['price'];
				

				// Display prices
				$total = $product['price'] * $product['quantity'];
				
				$product_visitor = $this->model_module_track->getVisitor($product['track_id']);

				$data['products'][] = array(
					'cart_id'   => $product['cart_id'],
					'thumb'     => $image,
					'name'      => $product['name'],
					'model'     => $product['model'],
					'option'    => $option_data,
					'quantity'  => $product['quantity'],
					'stock'     => $product['stock'] ? true : !(!$this->config->get('config_stock_checkout') || $this->config->get('config_stock_warning')),
					'reward'    => ($product['reward'] ? sprintf($this->language->get('text_points'), $product['reward']) : ''),
					'price'     => $price,
					'total'     => $total,
					'href'      => $this->url->link('product/product', 'product_id=' . $product['product_id']),
					'date_added' => $product['date_added'],
					'track_id' => $product['track_id'],
					'visitor' => $product_visitor
				);
		}
		
		
		

		$data['filter_visitor'] = $filter_visitor;
		$data['filter_ip'] = $filter_ip;
		$data['filter_nation'] = $filter_nation;
		$data['filter_referer'] = $filter_referer;
		$data['filter_landing_url'] = $filter_landing_url;
		$data['filter_date_added'] = $filter_date_added;
	
		$data['sort'] = $sort;
		$data['order'] = $order;
		
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('module/track.tpl', $data));
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'module/track')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		
		if (trim($this->request->post['track_sign']=='')){
			$this->error['warning'] = $this->language->get('error_track_sign');	
		}


		return !$this->error;
	}
	
	public function track(){
		$json = array();
		$this->load->language('module/track');
		$this->load->model('module/track');
		
		if(isset($this->request->post['track_id'])){
			$track_id = $this->request->post['track_id'];
			$json['data'] = $this->model_module_track->getTrack($track_id);
		}else{
			$json['error'] = $this->language->get('error_track');
		}
		
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
	
	public function trackNation(){
		$json = array();
		$this->load->language('module/track');
		$this->load->model('module/track');
		
		if(isset($this->request->post['ip'])){
			$ip = $this->request->post['ip'];
			$result = $this->model_module_track->getTrackNation($ip);
			if($result===false){
				$json['error'] = $this->language->get('error_nation');
			}else{
				$json['data'] = $result;
			}
		}else{
			$json['error'] = $this->language->get('error_nation_ip');
		}
		
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
	
	public function install(){
		$this->load->model('module/track');
		$this->model_module_track->install();
	}
}