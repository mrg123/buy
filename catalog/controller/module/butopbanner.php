<?php
class ControllerModuleButopbanner extends Controller {
	public function index($setting) {
		
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
                
		if (isset($setting['butopbanner_module']) && $setting['status']) {
                    
                    $this->document->addStyle('catalog/view/theme/default/stylesheet/style_common.css');
                    $this->document->addStyle('catalog/view/theme/default/stylesheet/style4.css');
                    $data['status'] = $setting['status'];
                    $data['name'] = $setting['name'];
                    if(!empty($setting['butopbanner_module']))
                    {
                        foreach ($setting['butopbanner_module'] as $key=>$value)
                        {
                            $description = html_entity_decode($value['description'][$this->config->get('config_language_id')], ENT_QUOTES, 'UTF-8');
                            $description = str_replace('<p><br></p>', '', $description);
                            $heading = html_entity_decode($value['heading'][$this->config->get('config_language_id')], ENT_QUOTES, 'UTF-8');
							if(isset($show)){
                            $slider_image = html_entity_decode($value['slider_image2'][$this->config->get('config_language_id')], ENT_QUOTES, 'UTF-8');
							}else{
							$slider_image = html_entity_decode($value['slider_image'][$this->config->get('config_language_id')], ENT_QUOTES, 'UTF-8');	
							}
                            $link = html_entity_decode($value['link'][$this->config->get('config_language_id')], ENT_QUOTES, 'UTF-8');
                            $data['butopbanner'][]=array(
                                        'heading'=>$heading,
                                        'description'=>$description,
                                        'image'=>$slider_image,
                                        'link'=>$link,
                            );
                        }
                    }
                    
			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/butopbanner.tpl')) {
				return $this->load->view($this->config->get('config_template') . '/template/module/butopbanner.tpl', $data);
			} else {
				return $this->load->view('default/template/module/butopbanner.tpl', $data);
			}
		}
	}
        
}