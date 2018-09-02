<?php
class ControllerCommonHeader extends Controller {
	public function index() {
if($this->config->get('product_toggle_chinese_and_robots_status')){
			
			/* 浏览器语言判断 */
			if (isset($this->request->server['HTTP_ACCEPT_LANGUAGE']) && $this->request->server['HTTP_ACCEPT_LANGUAGE']) {
				$lang = substr($this->request->server['HTTP_ACCEPT_LANGUAGE'],0,2); 
				if($lang == 'zh'){
					/* 中文,显示提示页面 */
					if($this->config->get('product_toggle_warning_zh')){
						echo $this->config->get('product_toggle_warning_zh');exit;
					}else{
						echo "We do not support Chinese ,any help contact email: " . $this->config->get('config_email');exit;
					}
					
				}else{
					/* 不是中文 */
				}
			}else{
				/* HTTP_ACCEPT_LANGUAGE 缺少*/
				
			}
			
			/* robots */
			if (isset($this->request->server['HTTP_USER_AGENT'])) {
			$robots = explode("\n", str_replace(array("\r\n", "\r"), "\n", trim($this->config->get('config_robots'))));

			foreach ($robots as $robot) {
				if ($robot && strpos($this->request->server['HTTP_USER_AGENT'], trim($robot)) !== false) {
					/* robots */
					if($this->config->get('product_toggle_warning_robot')){
						echo $this->config->get('product_toggle_warning_robot');exit;
					}else{
						echo "SYSTEM to determine you are robots ,any help contact email: " . $this->config->get('config_email');exit;
					}
					break;
				}
			}
			}
			
			}
			
			
			/* 判断是否开启toggle 更换logo */
			if($this->config->get('product_toggle_status')){
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
			
		if (!isset($this->request->cookie['toggle']) && !$vip) {
		
			if(isset($this->request->get[strtolower($this->config->get('product_toggle_parameter'))]) || isset($this->request->get[strtoupper($this->config->get('product_toggle_parameter'))])){
						/* 有参数正确,仿品可见,设置session */
						
						if($this->config->get('product_toggle_expire')){
							$expire = $this->config->get('product_toggle_expire');
							setcookie('toggle', '1' , time() + 60 * 60 * 24 * $expire, '/' ,$this->request->server['HTTP_HOST']);
						}else{
							setcookie('toggle', '1' , time() + 60 * 60 * 24 * 30 * 12 * 10, '/' ,$this->request->server['HTTP_HOST']);
						}
						$show_logo = 1;
						
					}else{
						/* 无参数 */
					}
			
		}else{
			$show_logo = 1;	
		}	
		
		
		
			}
		// Analytics
		$this->load->model('extension/extension');

		$data['analytics'] = array();

		$analytics = $this->model_extension_extension->getExtensions('analytics');

		foreach ($analytics as $analytic) {
			if ($this->config->get($analytic['code'] . '_status')) {
				$data['analytics'][] = $this->load->controller('analytics/' . $analytic['code']);
			}
		}

		if ($this->request->server['HTTPS']) {
			if(isset($_SERVER['SERVER_NAME'])){
			$server = 'https://' . $_SERVER['SERVER_NAME'].'/';
		}else{
			$server = $this->config->get('config_ssl');
		}
		} else {
			if(isset($_SERVER['SERVER_NAME'])){
			$server = 'http://' . $_SERVER['SERVER_NAME'].'/';
		}else{
			$server = $this->config->get('config_url');
		}
		}

		if (is_file(DIR_IMAGE . $this->config->get('config_icon'))) {
			$this->document->addLink($server . 'image/' . $this->config->get('config_icon'), 'icon');
		}

		$data['title'] = $this->document->getTitle();

		$data['base'] = $server;
		$data['description'] = $this->document->getDescription();
		$data['keywords'] = $this->document->getKeywords();
		$data['links'] = $this->document->getLinks();
		$data['styles'] = $this->document->getStyles();
		$data['scripts'] = $this->document->getScripts();
		$data['lang'] = $this->language->get('code');
		$data['direction'] = $this->language->get('direction');

		$data['name'] = $this->config->get('config_name');

		if (is_file(DIR_IMAGE . $this->config->get('config_logo'))) {
			$data['logo'] = $server . 'image/' . $this->config->get('config_logo');
		} else {
			$data['logo'] = '';
		}

if(isset($show_logo)){
					$data['logo'] = $server . 'image/' . $this->config->get('product_toggle_logo');
				}
		$this->load->language('common/header');

		$data['text_home'] = $this->language->get('text_home');

			
		
		if(IS_MOBILE){
			$data['is_mobile'] = true;
		}else{
			$data['is_mobile'] = false;
		}
			

		// Wishlist
		if ($this->customer->isLogged()) {
			$this->load->model('account/wishlist');

			$data['text_wishlist'] = sprintf($this->language->get('text_wishlist'), $this->model_account_wishlist->getTotalWishlist());
		} else {
			$data['text_wishlist'] = sprintf($this->language->get('text_wishlist'), (isset($this->session->data['wishlist']) ? count($this->session->data['wishlist']) : 0));
		}

		$data['text_shopping_cart'] = $this->language->get('text_shopping_cart');
		$data['text_logged'] = sprintf($this->language->get('text_logged'), $this->url->link('account/account', '', 'SSL'), $this->customer->getFirstName(), $this->url->link('account/logout', '', 'SSL'));

		$data['text_account'] = $this->language->get('text_account');
		$data['text_register'] = $this->language->get('text_register');
		$data['text_login'] = $this->language->get('text_login');
		$data['text_order'] = $this->language->get('text_order');
		$data['text_transaction'] = $this->language->get('text_transaction');
		$data['text_download'] = $this->language->get('text_download');
		$data['text_logout'] = $this->language->get('text_logout');
		$data['text_checkout'] = $this->language->get('text_checkout');
		$data['text_category'] = $this->language->get('text_category');
		$data['text_all'] = $this->language->get('text_all');

		$data['home'] = $this->url->link('common/home');
		$data['wishlist'] = $this->url->link('account/wishlist', '', 'SSL');
		$data['logged'] = $this->customer->isLogged();
		$data['account'] = $this->url->link('account/account', '', 'SSL');
		$data['register'] = $this->url->link('account/register', '', 'SSL');
		$data['login'] = $this->url->link('account/login', '', 'SSL');
		$data['order'] = $this->url->link('account/order', '', 'SSL');
		$data['transaction'] = $this->url->link('account/transaction', '', 'SSL');
		$data['download'] = $this->url->link('account/download', '', 'SSL');
		$data['logout'] = $this->url->link('account/logout', '', 'SSL');
		$data['shopping_cart'] = $this->url->link('checkout/cart');
		$data['checkout'] = $this->url->link('checkout/checkout', '', 'SSL');
		$data['contact'] = $this->url->link('information/contact');
		$data['telephone'] = $this->config->get('config_telephone');

		$status = true;

		if (isset($this->request->server['HTTP_USER_AGENT'])) {
			$robots = explode("\n", str_replace(array("\r\n", "\r"), "\n", trim($this->config->get('config_robots'))));

			foreach ($robots as $robot) {
				if ($robot && strpos($this->request->server['HTTP_USER_AGENT'], trim($robot)) !== false) {
					$status = false;

					break;
				}
			}
		}

		// Menu
		$this->load->model('catalog/category');

		$this->load->model('catalog/product');

		$data['categories'] = array();

		$categories = $this->model_catalog_category->getCategories(0);


			
			
			
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
			
			
			
		foreach ($categories as $category) {
			$fake = 0;
			if($this->config->get('category_toggle_status')){
				$this->load->model('module/category_toggle');
				$category_toggle = $this->model_module_category_toggle->getToggleByCategoryId($category['category_id']);
				
				if($category_toggle && $category_toggle['toggle']){
					$fake = 1;
				}else{
					$fake = 0;
				}
			}
			
			if($toggle){
				if($fake){
					
				}else{
					continue;
				}
			}else{
				if($fake){
					continue;
				}
			}
			
			
			if ($category['top']) {
				// Level 2
				$children_data = array();

				$children = $this->model_catalog_category->getCategories($category['category_id']);

				foreach ($children as $child) {
					$filter_data = array(
						'filter_category_id'  => $child['category_id'],
						'filter_sub_category' => true
					);

					$children_data[] = array(
						'name'  => $child['name'] . ($this->config->get('config_product_count') ? ' (' . $this->model_catalog_product->getTotalProducts($filter_data) . ')' : ''),
						'href'  => $this->url->link('product/category', 'path=' . $category['category_id'] . '_' . $child['category_id'])
					);
				}

				// Level 1
				$data['categories'][] = array(
					'name'     => $category['name'],
					'children' => $children_data,
					'column'   => $category['column'] ? $category['column'] : 1,
					'href'     => $this->url->link('product/category', 'path=' . $category['category_id'])
				);
			}
		}


						$this->load->model('catalog/information');
						$children_data = array();
						//information pages top
						foreach ($this->model_catalog_information->getInformations() as $result) {
						  if (!$result['bottom']) {
							$data['categories'][] = array(
								  'name'     => $result['title'],
								  'children' => '',
								  'column'   =>  1,
								  'href'     => $this->url->link('information/information', 'information_id=' . $result['information_id'])
							  );
							}
						}
                        
		$data['language'] = $this->load->controller('common/language');
    
				$data['wholesaleform_showlinkheader'] = $this->config->get('wholesaleform_showlinkheader');
				$data['wholesalelink'] = $this->url->link('information/wholesaleform');
				$data['text_wholesale'] = $this->language->get('text_wholesale');
				
		$data['currency'] = $this->load->controller('common/currency');
		$data['search'] = $this->load->controller('common/search');
		$data['cart'] = $this->load->controller('common/cart');

		// For page specific css
		if (isset($this->request->get['route'])) {
			if (isset($this->request->get['product_id'])) {
				$class = '-' . $this->request->get['product_id'];
			} elseif (isset($this->request->get['path'])) {
				$class = '-' . $this->request->get['path'];
			} elseif (isset($this->request->get['manufacturer_id'])) {
				$class = '-' . $this->request->get['manufacturer_id'];
			} else {
				$class = '';
			}

			$data['class'] = str_replace('/', '-', $this->request->get['route']) . $class;
		} else {
			$data['class'] = 'common-home';
		}


        // gun88
        if ($this->config->get('menu_editor_enabled') == 1) {
            $pre_menu = array();
            $post_menu = array();
            $menu_editor_entries = $this->config->get('menu_editor_entries');
            
            foreach ($menu_editor_entries as $menu_editor_entry) {
                if ($menu_editor_entry['position'] == 0) {
                    $pre_menu[] = array('name' => $menu_editor_entry['names'][$this->config->get('config_language_id')],
                        'children' => array(),
                        'column' => 1,
                        'href' => $menu_editor_entry['href'],
                        'target' => $menu_editor_entry['target']);
                } else {
                    $post_menu[] = array('name' => $menu_editor_entry['names'][$this->config->get('config_language_id')],
                        'children' => array(),
                        'column' => 1,
                        'href' => $menu_editor_entry['href'],
                        'target' => $menu_editor_entry['target']);
                }
               
            }
            $data['categories'] = array_merge($pre_menu, $data['categories'], $post_menu);
            
            
        }
        // end gun88
                
            
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/common/header.tpl')) {
if(IS_MOBILE){
                return $this->load->view('wap/header.tpl', $data);
            }
			return $this->load->view($this->config->get('config_template') . '/template/common/header.tpl', $data);
		} else {
			return $this->load->view('default/template/common/header.tpl', $data);
		}
	}
}
