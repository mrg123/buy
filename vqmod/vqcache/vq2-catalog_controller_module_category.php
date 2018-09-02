<?php
class ControllerModuleCategory extends Controller {
	public function index() {
		$this->load->language('module/category');

		$data['heading_title'] = $this->language->get('heading_title');

		if (isset($this->request->get['path'])) {
			$parts = explode('_', (string)$this->request->get['path']);
		} else {
			$parts = array();
		}

		if (isset($parts[0])) {
			$data['category_id'] = $parts[0];
		} else {
			$data['category_id'] = 0;
		}

		if (isset($parts[1])) {
			$data['child_id'] = $parts[1];
		} else {
			$data['child_id'] = 0;
		}

		$this->load->model('catalog/category');

		$this->load->model('catalog/product');

		$data['categories'] = array();

		$categories = $this->model_catalog_category->getCategories(0);

		foreach ($categories as $category) {
			$children_data = array();

			if ($category['category_id'] == $data['category_id']) {
				$children = $this->model_catalog_category->getCategories($category['category_id']);

				foreach($children as $child) {
					$filter_data = array('filter_category_id' => $child['category_id'], 'filter_sub_category' => true);

					$children_data[] = array(
						'category_id' => $child['category_id'],
						'name' => $child['name'] . ($this->config->get('config_product_count') ? ' (' . $this->model_catalog_product->getTotalProducts($filter_data) . ')' : ''),
						'href' => $this->url->link('product/category', 'path=' . $category['category_id'] . '_' . $child['category_id'])
					);
				}
			}

			$filter_data = array(
				'filter_category_id'  => $category['category_id'],
				'filter_sub_category' => true
			);

			$data['categories'][] = array(
				'category_id' => $category['category_id'],
				'name'        => $category['name'] . ($this->config->get('config_product_count') ? ' (' . $this->model_catalog_product->getTotalProducts($filter_data) . ')' : ''),
				'children'    => $children_data,
				'href'        => $this->url->link('product/category', 'path=' . $category['category_id'])
			);
		}

$vip = 0;
		if ($this->config->get('customer_toggle_status') && $this->customer->isLogged()) {
				$customer_id = $this->customer->getId();
				$this->load->model('module/customer_toggle');
				$customer_toggle = $this->model_module_customer_toggle->getToggleByCustomerId($customer_id);
				if($customer_toggle){
					if($customer_toggle['toggle']){
						/* 有参数正确,仿品可见*/
						$vip = 1;
					}else{
						/* 为 0*/
						$vip = 0;
					}
				}else{
					/* NULL */
					$vip = 0;
				}
		}
			$toggle = 0;
		if (!isset($this->request->cookie['toggle']) && !$vip) {
			
					
					if(isset($this->request->get[strtolower($this->config->get('product_toggle_parameter'))]) || isset($this->request->get[strtoupper($this->config->get('product_toggle_parameter'))])){
						/* 有参数正确,仿品可见,设置session */
						
						
						if($this->config->get('product_toggle_expire')){
							$expire = $this->config->get('product_toggle_expire');
							setcookie('toggle', '1' , time() + 60 * 60 * 24 * $expire, '/' ,$this->request->server['HTTP_HOST']);
						}else{
							setcookie('toggle', '1' , time() + 60 * 60 * 24 * 30 * 12 * 10, '/' ,$this->request->server['HTTP_HOST']);
						}
						$toggle = 1;
						
					}else{
						/* 无参数 */
						
						
					}

		}else{
			$toggle = 1;
		}
		
			
		if($this->config->get('category_toggle_status')){
			$this->load->model('module/category_toggle');
			foreach($data['categories'] as $key => $cate){
				$category_toggle = $this->model_module_category_toggle->getToggleByCategoryId($cate['category_id']);
				
				if($toggle){
				
					if($category_toggle && $category_toggle['toggle']){
						
					}else{
						unset($data['categories'][$key]);
					}
				
				}else{
				
					if($category_toggle && $category_toggle['toggle']){
						unset($data['categories'][$key]);
					}else{
						
					}
					
				}
				
			}
		}
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/category.tpl')) {
			return $this->load->view($this->config->get('config_template') . '/template/module/category.tpl', $data);
		} else {
			return $this->load->view('default/template/module/category.tpl', $data);
		}
	}
}