<?php
class ControllerModuleProductToggle extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('module/product_toggle');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('product_toggle', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'));
		}

		$this->load->model('module/product_toggle');
		$this->load->model('catalog/product');
		
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

		if (isset($this->error['product_toggle_parameter'])) {
			$data['error_parameter'] = $this->error['product_toggle_parameter'];
		} else {
			$data['error_parameter'] = '';
		}
		
		if (isset($this->error['product_toggle_expire'])) {
			$data['error_product_toggle_expire'] = $this->error['product_toggle_expire'];
		} else {
			$data['error_product_toggle_expire'] = '';
		}

		if (isset($this->request->post['product_toggle_parameter'])) {
			$data['product_toggle_parameter'] = $this->request->post['product_toggle_parameter'];
		}  else {
			$data['product_toggle_parameter'] = $this->config->get('product_toggle_parameter');
		}

		if (isset($this->request->post['product_toggle_status'])) {
			$data['product_toggle_status'] = $this->request->post['product_toggle_status'];
		} else {
			$data['product_toggle_status'] = $this->config->get('product_toggle_status');
		}
		
		if (isset($this->request->post['product_toggle_chinese_and_robots_status'])) {
			$data['product_toggle_chinese_and_robots_status'] = $this->request->post['product_toggle_chinese_and_robots_status'];
		} else {
			$data['product_toggle_chinese_and_robots_status'] = $this->config->get('product_toggle_chinese_and_robots_status');
		}
		
		if (isset($this->request->post['product_toggle_warning_zh'])) {
			$data['product_toggle_warning_zh'] = $this->request->post['product_toggle_warning_zh'];
		} else {
			$data['product_toggle_warning_zh'] = $this->config->get('product_toggle_warning_zh');
		}
		if (isset($this->request->post['product_toggle_warning_robot'])) {
			$data['product_toggle_warning_robot'] = $this->request->post['product_toggle_warning_robot'];
		} else {
			$data['product_toggle_warning_robot'] = $this->config->get('product_toggle_warning_robot');
		}
		if (isset($this->request->post['product_toggle_expire'])) {
			$data['product_toggle_expire'] = $this->request->post['product_toggle_expire'];
		} else {
			$data['product_toggle_expire'] = $this->config->get('product_toggle_expire');
		}
		
		if (isset($this->request->post['product_toggle_logo'])) {
			$data['product_toggle_logo'] = $this->request->post['product_toggle_logo'];
		} else {
			$data['product_toggle_logo'] = $this->config->get('product_toggle_logo');
		}
		$this->load->model('tool/image');
		if (isset($this->request->post['product_toggle_logo']) && is_file(DIR_IMAGE . $this->request->post['product_toggle_logo'])) {
			$data['logo'] = $this->model_tool_image->resize($this->request->post['product_toggle_logo'], 100, 100);
		} elseif ($this->config->get('product_toggle_logo') && is_file(DIR_IMAGE . $this->config->get('product_toggle_logo'))) {
			$data['logo'] = $this->model_tool_image->resize($this->config->get('product_toggle_logo'), 100, 100);
		} else {
			$data['logo'] = $this->model_tool_image->resize('no_image.png', 100, 100);
		}
		$data['placeholder'] = $this->model_tool_image->resize('no_image.png', 100, 100);
		
		if (isset($this->request->get['filter_name'])) {
			$filter_name = $this->request->get['filter_name'];
		} else {
			$filter_name = null;
		}

		if (isset($this->request->get['filter_model'])) {
			$filter_model = $this->request->get['filter_model'];
		} else {
			$filter_model = null;
		}

		if (isset($this->request->get['filter_price'])) {
			$filter_price = $this->request->get['filter_price'];
		} else {
			$filter_price = null;
		}

		if (isset($this->request->get['filter_quantity'])) {
			$filter_quantity = $this->request->get['filter_quantity'];
		} else {
			$filter_quantity = null;
		}

		if (isset($this->request->get['filter_status'])) {
			$filter_status = $this->request->get['filter_status'];
		} else {
			$filter_status = null;
		}

		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'pd.name';
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
		
		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_model'])) {
			$url .= '&filter_model=' . urlencode(html_entity_decode($this->request->get['filter_model'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_price'])) {
			$url .= '&filter_price=' . $this->request->get['filter_price'];
		}

		if (isset($this->request->get['filter_quantity'])) {
			$url .= '&filter_quantity=' . $this->request->get['filter_quantity'];
		}

		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
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
			'href' => $this->url->link('module/product_toggle', 'token=' . $this->session->data['token'], 'SSL')
		);
		
		$data['action'] = $this->url->link('module/product_toggle', 'token=' . $this->session->data['token'], 'SSL');
		
		$data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');
		
		$data['entry_name'] = $this->language->get('entry_name');
		$data['entry_model'] = $this->language->get('entry_model');
		$data['entry_price'] = $this->language->get('entry_price');
		$data['entry_quantity'] = $this->language->get('entry_quantity');
		$data['entry_status'] = $this->language->get('entry_status');
		$data['entry_parameter'] = $this->language->get('entry_parameter');
		$data['text_related_id'] = $this->language->get('text_related_id');
		
		$data['entry_logo'] = $this->language->get('entry_logo');
		
		$data['button_filter'] = $this->language->get('button_filter');
		
		$data['token'] = $this->session->data['token'];
		
		$data['products'] = array();

		$filter_data = array(
			'filter_name'	  => $filter_name,
			'filter_model'	  => $filter_model,
			'filter_price'	  => $filter_price,
			'filter_quantity' => $filter_quantity,
			'filter_status'   => $filter_status,
			'sort'            => $sort,
			'order'           => $order,
			'start'           => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit'           => $this->config->get('config_limit_admin')
		);

		$this->load->model('tool/image');

		$product_total = $this->model_catalog_product->getTotalProducts($filter_data);

		$results = $this->model_catalog_product->getProducts($filter_data);

		foreach ($results as $result) {
			if (is_file(DIR_IMAGE . $result['image'])) {
				$image = $this->model_tool_image->resize($result['image'], 40, 40);
			} else {
				$image = $this->model_tool_image->resize('no_image.png', 40, 40);
			}

			$special = false;

			$product_specials = $this->model_catalog_product->getProductSpecials($result['product_id']);

			foreach ($product_specials  as $product_special) {
				if (($product_special['date_start'] == '0000-00-00' || strtotime($product_special['date_start']) < time()) && ($product_special['date_end'] == '0000-00-00' || strtotime($product_special['date_end']) > time())) {
					$special = $product_special['price'];

					break;
				}
			}
			$toggle = $this->model_module_product_toggle->getToggleByProductId($result['product_id']);
			if($toggle){
				$related_id = $toggle['related_id'];
				if($toggle['toggle']){
					$toggle = 1;
				}else{
					$toggle = 0;
				}
			}else{
				$toggle = 0;
				$related_id = 0;
			}

			$data['products'][] = array(
				'url' => HTTP_CATALOG . 'index.php?route=product/product&product_id='.$result['product_id'],
				'toggle' => $toggle,
				'related_id' => $related_id,
				'product_id' => $result['product_id'],
				'image'      => $image,
				'name'       => $result['name'],
				'model'      => $result['model'],
				'price'      => $result['price'],
				'special'    => $special,
				'quantity'   => $result['quantity'],
				'status'     => ($result['status']) ? $this->language->get('text_enabled') : $this->language->get('text_disabled'),
				'edit'       => $this->url->link('catalog/product/edit', 'token=' . $this->session->data['token'] . '&product_id=' . $result['product_id'] . $url, 'SSL')
			);
		}
		
		$url = '';

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_model'])) {
			$url .= '&filter_model=' . urlencode(html_entity_decode($this->request->get['filter_model'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_price'])) {
			$url .= '&filter_price=' . $this->request->get['filter_price'];
		}

		if (isset($this->request->get['filter_quantity'])) {
			$url .= '&filter_quantity=' . $this->request->get['filter_quantity'];
		}

		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
		}

		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['sort_name'] = $this->url->link('module/product_toggle', 'token=' . $this->session->data['token'] . '&sort=pd.name' . $url, 'SSL');
		$data['sort_model'] = $this->url->link('module/product_toggle', 'token=' . $this->session->data['token'] . '&sort=p.model' . $url, 'SSL');
		$data['sort_price'] = $this->url->link('module/product_toggle', 'token=' . $this->session->data['token'] . '&sort=p.price' . $url, 'SSL');
		$data['sort_quantity'] = $this->url->link('module/product_toggle', 'token=' . $this->session->data['token'] . '&sort=p.quantity' . $url, 'SSL');
		$data['sort_status'] = $this->url->link('module/product_toggle', 'token=' . $this->session->data['token'] . '&sort=p.status' . $url, 'SSL');
		$data['sort_order'] = $this->url->link('module/product_toggle', 'token=' . $this->session->data['token'] . '&sort=p.sort_order' . $url, 'SSL');

		$url = '';

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_model'])) {
			$url .= '&filter_model=' . urlencode(html_entity_decode($this->request->get['filter_model'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_price'])) {
			$url .= '&filter_price=' . $this->request->get['filter_price'];
		}

		if (isset($this->request->get['filter_quantity'])) {
			$url .= '&filter_quantity=' . $this->request->get['filter_quantity'];
		}

		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
		}

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$pagination = new Pagination();
		$pagination->total = $product_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('module/product_toggle', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($product_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($product_total - $this->config->get('config_limit_admin'))) ? $product_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $product_total, ceil($product_total / $this->config->get('config_limit_admin')));

		$data['filter_name'] = $filter_name;
		$data['filter_model'] = $filter_model;
		$data['filter_price'] = $filter_price;
		$data['filter_quantity'] = $filter_quantity;
		$data['filter_status'] = $filter_status;

		$data['sort'] = $sort;
		$data['order'] = $order;
		

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_edit'] = $this->language->get('text_edit');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		
		$data['column_image'] = $this->language->get('column_image');
		$data['column_name'] = $this->language->get('column_name');
		$data['column_model'] = $this->language->get('column_model');
		$data['column_price'] = $this->language->get('column_price');
		$data['column_quantity'] = $this->language->get('column_quantity');
		$data['column_status'] = $this->language->get('column_status');
		$data['column_action'] = $this->language->get('column_action');
		$data['text_no_results'] = $this->language->get('text_no_results');
		$data['column_product_id'] = $this->language->get('column_product_id');

		$data['entry_name'] = $this->language->get('entry_name');
		$data['entry_parameter'] = $this->language->get('entry_parameter');
		$data['entry_title'] = $this->language->get('entry_title');
		$data['entry_description'] = $this->language->get('entry_description');
		$data['entry_status'] = $this->language->get('entry_status');
		$data['entry_warning_robot'] = $this->language->get('entry_warning_robot');
		$data['entry_warning_zh'] = $this->language->get('entry_warning_zh');
		$data['entry_expire'] = $this->language->get('entry_expire');
		$data['entry_product_toggle_chinese_and_robots_status'] = $this->language->get('entry_product_toggle_chinese_and_robots_status');

		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('module/product_toggle.tpl', $data));
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'module/product_toggle')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if ((utf8_strlen($this->request->post['product_toggle_parameter']) < 1) || (utf8_strlen($this->request->post['product_toggle_parameter']) > 64)) {
			$this->error['product_toggle_parameter'] = $this->language->get('error_parameter');
		}
		
		if ((int)$this->request->post['product_toggle_expire'] > 3600 || (int)$this->request->post['product_toggle_expire'] < 1){
			$this->error['product_toggle_expire'] = $this->language->get('error_product_toggle_expire');
		}

		return !$this->error;
	}
	
	public function updateToggle(){
		$json = array();
		$this->load->language('module/product_toggle');
		$this->load->model('module/product_toggle');
		
		if(isset($this->request->get['toggle']) && isset($this->request->get['product_id'])){
			$toggle = $this->request->get['toggle'];
			$product_id = $this->request->get['product_id'];
			if(isset($this->request->get['related_id'])){
				$related_id = $this->request->get['related_id'];
			}else{
				$related_id = 0;
			}
			$this->model_module_product_toggle->updateToggle($product_id,$toggle,$related_id);
			
			$json['success'] = $this->language->get('update_success');
		}else{
			$json['error'] = $this->language->get('error_toggle');
		}
		
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
	
	public function install(){
		$this->load->model('module/product_toggle');
		$this->model_module_product_toggle->install();
	}
}