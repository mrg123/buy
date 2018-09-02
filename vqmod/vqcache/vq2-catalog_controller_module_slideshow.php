<?php
class ControllerModuleSlideshow extends Controller {
	public function index($setting) {
		static $module = 0;

		$this->load->model('design/banner');
		$this->load->model('tool/image');

		$this->document->addStyle('catalog/view/javascript/jquery/owl-carousel/owl.carousel.css');
		$this->document->addScript('catalog/view/javascript/jquery/owl-carousel/owl.carousel.min.js');

		$data['banners'] = array();
		
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
						$show = 1;
						
					}else{
						/* 无参数 */
					}
			
		}else{
			$show = 1;	
		}	
			}
			
			
		if(isset($show)){
		$results = $this->model_design_banner->getBanner($setting['banner_id2']);
		}else{
		$results = $this->model_design_banner->getBanner($setting['banner_id']);	
		}
		
		

		foreach ($results as $result) {
			if (is_file(DIR_IMAGE . $result['image'])) {
				$data['banners'][] = array(
					'title' => $result['title'],
					'link'  => $result['link'],
					'image' => $this->model_tool_image->resize($result['image'], $setting['width'], $setting['height'])
				);
			}
		}

		$data['module'] = $module++;

if(IS_MOBILE){
                return $this->load->view('wap/slideshow.tpl', $data);
            }
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/slideshow.tpl')) {
			return $this->load->view($this->config->get('config_template') . '/template/module/slideshow.tpl', $data);
		} else {
			return $this->load->view('default/template/module/slideshow.tpl', $data);
		}
	}
}
