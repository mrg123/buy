<?php
class ControllerInformationWholesaleform extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('information/wholesaleform');
		$this->load->model('tool/wholesaleform');
		$this->load->model('account/address');
		$this->load->model('catalog/product');
		$this->load->model('catalog/category');
		$this->document->setTitle($this->language->get('heading_title'));

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			unset($this->session->data['captcha']);

			$template['text_wholesaleform_enquiry'] = $this->language->get('text_wholesaleform_enquiry');
			$template['text_wholesaleform_enquiryc'] = $this->language->get('text_wholesaleform_enquiryc');
			$template['text_enquiry'] = $this->language->get('text_enquiry');
			$template['text_name'] = $this->language->get('text_name');
			$template['text_address'] = $this->language->get('text_address');
			$template['text_city'] = $this->language->get('text_city');
			$template['text_state'] = $this->language->get('text_state');
			$template['text_country'] = $this->language->get('text_country');
			$template['text_pincode'] = $this->language->get('text_pincode');
			$template['text_phone'] = $this->language->get('text_phone');
			$template['text_mobile'] = $this->language->get('text_mobile');
			$template['text_email'] = $this->language->get('text_email');
			$template['text_nameperson'] = $this->language->get('text_nameperson');
			$template['text_contacttitle'] = $this->language->get('text_contacttitle');
			$template['text_tin'] = $this->language->get('text_tin');
			$template['text_business'] = $this->language->get('text_business');
			$template['text_specify'] = $this->language->get('text_specify');
			$template['text_formation'] = $this->language->get('text_formation');
			$template['text_sales'] = $this->language->get('text_sales');
			$template['text_brands'] = $this->language->get('text_otherbrands');
			$template['text_websiteurl'] = $this->language->get('text_websiteurl');
			$template['text_product'] = $this->language->get('text_product');
			$template['text_category'] = $this->language->get('text_category');
			$template['setting']  = $this->model_tool_wholesaleform->getsetting();

			if (isset($this->request->post['companyname'])) {
				$template['companyname'] = $this->request->post['companyname'];
			}

			if (isset($this->request->post['address'])) {
				$template['address'] = $this->request->post['address'];
			}

			if (isset($this->request->post['city'])) {
				$template['city'] = $this->request->post['city'];
			}

			if (isset($this->request->post['state'])) {
				$template['state'] = $this->request->post['state'];
			}

			if (isset($this->request->post['country'])) {
				$template['country'] = $this->request->post['country'];
			}

			if (isset($this->request->post['pincode'])) {
				$template['pincode'] = $this->request->post['pincode'];
			}

			if (isset($this->request->post['phone'])) {
				$template['phone'] = $this->request->post['phone'];
			}

			if (isset($this->request->post['mobile'])) {
				$template['mobile'] = $this->request->post['mobile'];
			}

			if (isset($this->request->post['email'])) {
				$template['email'] = $this->request->post['email'];
			}

			if (isset($this->request->post['nameperson'])) {
				$template['nameperson'] = $this->request->post['nameperson'];
			}

	 		$titles = array("Owner/Proprietor","CEO","Manager","Purchasing/Merchandising");
	 		
			if (isset($this->request->post['contacttitle'])) {
				$template['contacttitle'] = $titles[$this->request->post['contacttitle']];
			}

			if (isset($this->request->post['vattin'])) {
				$template['vattin'] = $this->request->post['vattin'];
			}

			$businesses = array("Retail","Online","Wholesale","Others");

			if (isset($this->request->post['business'])) {
				$template['business'] = $businesses[$this->request->post['business']];
			}

			if (isset($this->request->post['formation'])) {
				$template['formation'] = $this->request->post['formation'];
			}

			if (isset($this->request->post['sales'])) {
				$template['sales'] = $this->request->post['sales'];
			}

			if (isset($this->request->post['specify'])) {
				$template['specify'] = $this->request->post['specify'];
			}

			if (isset($this->request->post['brands'])) {
				$template['brands'] = $this->request->post['brands'];
			}

			if (isset($this->request->post['sales'])) {
				$template['sales'] = $this->request->post['sales'];
			}

			if (isset($this->request->post['brands'])) {
				$template['brands'] = $this->request->post['brands'];
			}

			if (isset($this->request->post['url'])) {
				$template['url'] = $this->request->post['url'];
			}

			if (isset($this->request->post['enquiryproducts'])) {
				$template['products'] = "";
				foreach ($this->request->post['enquiryproducts']  as $key => $value) {
					$products_info = $this->model_catalog_product->getProduct($value);
					if ($products_info) {
						$template['products'] .= $products_info['name']."<br>";
					}
				}
			} else {
				$template['products']= "";
			}

			if (isset($this->request->post['enquirycategories'])) {
				$template['categories'] = "";
				foreach ($this->request->post['enquirycategories']  as $key => $value) {
					$category_info = $this->model_catalog_category->getCategory($value);
					if ($category_info) {
						$template['categories'] .= $category_info['name']."<br>";
					}
				}
			} else {
				$template['categories']= "";
			}


			if (isset($this->request->post['enquiry'])) {
				$template['enquiry'] = $this->request->post['enquiry'];
			}

			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/information/wholesaleemail.tpl')) {
				$html = $this->load->view($this->config->get('config_template') . '/template/information/wholesaleemail.tpl', $template);
			} else {
				$html = $this->load->view('default/template/information/wholesaleemail.tpl', $template);
			}

			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/information/wholesaleemailc.tpl')) {
				$htmlc = $this->load->view($this->config->get('config_template') . '/template/information/wholesaleemailc.tpl', $template);
			} else {
				$htmlc = $this->load->view('default/template/information/wholesaleemailc.tpl', $template);
			}


			$text = "";
			$mail = new Mail();
			$mail->protocol = $this->config->get('config_mail_protocol');
			$mail->parameter = $this->config->get('config_mail_parameter');
			$mail->smtp_hostname = $this->config->get('config_mail_smtp_hostname');
			$mail->smtp_username = $this->config->get('config_mail_smtp_username');
			$mail->smtp_password = html_entity_decode($this->config->get('config_mail_smtp_password'), ENT_QUOTES, 'UTF-8');
			$mail->smtp_port = $this->config->get('config_mail_smtp_port');
			$mail->smtp_timeout = $this->config->get('config_mail_smtp_timeout');

			$mail->setTo($this->config->get('config_email'));
			$mail->setFrom($this->request->post['email']);
			if(!isset($this->request->post['nameperson'])) {
				$this->request->post['nameperson'] = $this->language->get('text_unknown');
			}
			$mail->setSender(html_entity_decode($this->request->post['nameperson'], ENT_QUOTES, 'UTF-8'));
			$mail->setSubject(html_entity_decode(sprintf($this->language->get('email_subject')), ENT_QUOTES, 'UTF-8'));
			$mail->setHtml($html);
			$mail->setText($text);
			$mail->send();
			$mail->setHtml($htmlc);
			$mail->setTo($this->request->post['email']);
			$mail->send();
			$this->response->redirect($this->url->link('information/wholesaleform/success'));
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/home')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('information/wholesaleform')
		);

		$data['heading_title'] = $this->language->get('heading_title');
		$data['text_wholesaleform'] = $this->language->get('text_wholesaleform');
		
		$data['text_name'] = $this->language->get('text_name');
		$data['text_address'] = $this->language->get('text_address');
		$data['text_city'] = $this->language->get('text_city');
		$data['text_state'] = $this->language->get('text_state');
		$data['text_country'] = $this->language->get('text_country');
		$data['text_pincode'] = $this->language->get('text_pincode');
		$data['text_phone'] = $this->language->get('text_phone');
		$data['text_mobile'] = $this->language->get('text_mobile');
		$data['text_email'] = $this->language->get('text_email');
		$data['text_nameperson'] = $this->language->get('text_nameperson');
		$data['text_contacttitle'] = $this->language->get('text_contacttitle');
		$data['text_tin'] = $this->language->get('text_tin');
		$data['text_business'] = $this->language->get('text_business');
		$data['text_specify'] = $this->language->get('text_specify');
		$data['text_formation'] = $this->language->get('text_formation');
		$data['text_sales'] = $this->language->get('text_sales');
		$data['text_brands'] = $this->language->get('text_otherbrands');
		$data['text_websiteurl'] = $this->language->get('text_websiteurl');
		$data['text_product'] = $this->language->get('text_product');
		$data['text_category'] = $this->language->get('text_category');
		$data['text_enquiry'] = $this->language->get('text_enquiry');
		$data['setting']  = $this->model_tool_wholesaleform->getsetting();
		$data['required']  = $this->model_tool_wholesaleform->getrequired();
		
		

		$data['entry_enquiry'] = $this->language->get('entry_enquiry');
		$data['entry_captcha'] = $this->language->get('entry_captcha');

		$data['button_map'] = $this->language->get('button_map');


		if (isset($this->error['captcha'])) {
			$data['error_captcha'] = $this->error['captcha'];
		} else {
			$data['error_captcha'] = '';
		}

		$data['button_submit'] = $this->language->get('button_submit');

		$data['action'] = $this->url->link('information/wholesaleform');

		$data['store'] = $this->config->get('config_name');


		if (isset($this->error['error_warning'])) {
			$data['error_warning'] = $this->error['error_warning'];
		} else {
			$data['error_warning'] = "";
		}

		if (isset($this->error['error_companyname'])) {
			$data['error_companyname'] = $this->error['error_companyname'];
		} else {
			$data['error_companyname'] = "";
		}

		if (isset($this->error['error_address'])) {
			$data['error_address'] = $this->error['error_address'];
		} else {
			$data['error_address'] = "";
		}

		if (isset($this->error['error_city'])) {
			$data['error_city'] = $this->error['error_city'];
		} else {
			$data['error_city'] = "";
		}

		if (isset($this->error['error_state'])) {
			$data['error_state'] = $this->error['error_state'];
		} else {
			$data['error_state'] = "";
		}

		if (isset($this->error['error_country'])) {
			$data['error_country'] = $this->error['error_country'];
		} else {
			$data['error_country'] = "";
		}

		if (isset($this->error['error_pincode'])) {
			$data['error_pincode'] = $this->error['error_pincode'];
		} else {
			$data['error_pincode'] = "";
		}

		if (isset($this->error['error_phone'])) {
			$data['error_phone'] = $this->error['error_phone'];
		} else {
			$data['error_phone'] = "";
		}

		if (isset($this->error['error_mobile'])) {
			$data['error_mobile'] = $this->error['error_mobile'];
		} else {
			$data['error_mobile'] = "";
		}

		if (isset($this->error['error_email'])) {
			$data['error_email'] = $this->error['error_email'];
		} else {
			$data['error_email'] = "";
		}

		if (isset($this->error['error_nameperson'])) {
			$data['error_nameperson'] = $this->error['error_nameperson'];
		} else {
			$data['error_nameperson'] = "";
		}

		if (isset($this->error['error_contacttitle'])) {
			$data['error_contacttitle'] = $this->error['error_contacttitle'];
		} else {
			$data['error_contacttitle'] = "";
		}

		if (isset($this->error['error_vattin'])) {
			$data['error_vattin'] = $this->error['error_vattin'];
		} else {
			$data['error_vattin'] = "";
		}

		if (isset($this->error['error_business'])) {
			$data['error_business'] = $this->error['error_business'];
		} else {
			$data['error_business'] = "";
		}

		if (isset($this->error['error_specify'])) {
			$data['error_specify'] = $this->error['error_specify'];
		} else {
			$data['error_specify'] = "";
		}

		if (isset($this->error['error_formation'])) {
			$data['error_formation'] = $this->error['error_formation'];
		} else {
			$data['error_formation'] = "";
		}

		if (isset($this->error['error_sales'])) {
			$data['error_sales'] = $this->error['error_sales'];
		} else {
			$data['error_sales'] = "";
		}

		if (isset($this->error['error_brands'])) {
			$data['error_brands'] = $this->error['error_brands'];
		} else {
			$data['error_brands'] = "";
		}

		if (isset($this->error['error_url'])) {
			$data['error_url'] = $this->error['error_url'];
		} else {
			$data['error_url'] = "";
		}

		if (isset($this->error['error_products'])) {
			$data['error_products'] = $this->error['error_products'];
		} else {
			$data['error_products'] = "";
		}

		if (isset($this->error['error_category'])) {
			$data['error_category'] = $this->error['error_category'];
		} else {
			$data['error_category'] = "";
		}

		if (isset($this->error['error_enquiry'])) {
			$data['error_enquiry'] = $this->error['error_enquiry'];
		} else {
			$data['error_enquiry'] = "";
		}
		
		$address_info = $this->model_account_address->getAddress($this->customer->getId());
		if (!$address_info) {
		    $address_info['firstname']  = "";
		    $address_info['lastname']  = "";
		    $address_info['company']  = "";
		    $address_info['address_1']  = "";
		    $address_info['address_2']  = "";
		    $address_info['postcode']  = "";
		    $address_info['city']  = "";
		    $address_info['zone_id']  = "";
		    $address_info['zone']  = "";
		    $address_info['zone_code']  = "";
		    $address_info['country_id']  = "";
		    $address_info['country']  = "";
		    $address_info['iso_code_2']  = "";
		    $address_info['iso_code_3']  = "";
		    $address_info['address_format'] = "";
		    $address_info['custom_field']  = "";
		}

		if (isset($this->request->post['companyname'])) {
			$data['companyname'] = $this->request->post['companyname'];
		} else {
			$data['companyname'] = $address_info['company'];
		}

		if (isset($this->request->post['address'])) {
			$data['address'] = $this->request->post['address'];
		} else {
			$data['address'] =  $address_info['address_1'];
		}

		if (isset($this->request->post['city'])) {
			$data['city'] = $this->request->post['city'];
		} else {
			$data['city'] =  $address_info['city'];
		}

		if (isset($this->request->post['state'])) {
			$data['state'] = $this->request->post['state'];
		} else {
			$data['state'] = "";
		}

		if (isset($this->request->post['country'])) {
			$data['country'] = $this->request->post['country'];
		} else {
			$data['country'] = "";
		}

		if (isset($this->request->post['pincode'])) {
			$data['pincode'] = $this->request->post['pincode'];
		} else {
			$data['pincode'] =  $address_info['postcode'];
		}

		if (isset($this->request->post['phone'])) {
			$data['phone'] = $this->request->post['phone'];
		} else {
			$data['phone'] = $this->customer->getTelephone();
		}

		if (isset($this->request->post['mobile'])) {
			$data['mobile'] = $this->request->post['mobile'];
		} else {
			$data['mobile'] = $this->customer->getTelephone();
		}

		if (isset($this->request->post['email'])) {
			$data['email'] = $this->request->post['email'];
		} else {
			$data['email'] = $this->customer->getEmail();
		}

		if (isset($this->request->post['nameperson'])) {
			$data['nameperson'] = $this->request->post['nameperson'];
		} else {
			$data['nameperson'] = $this->customer->getFirstName();
		}

 		$data['titles'] = array("Owner/Proprietor","CEO","Manager","Purchasing/Merchandising");
 		
		if (isset($this->request->post['contacttitle'])) {
			$data['contacttitle'] = $this->request->post['contacttitle'];
		} else {
			$data['contacttitle'] = "";
		}

		if (isset($this->request->post['vattin'])) {
			$data['vattin'] = $this->request->post['vattin'];
		} else {
			$data['vattin'] = "";
		}

		$data['businesses'] = array("Retail","Online","Wholesale","Others");

		if (isset($this->request->post['business'])) {
			$data['business'] = $this->request->post['business'];
		} else {
			$data['business'] = "";
		}

		if (isset($this->request->post['formation'])) {
			$data['formation'] = $this->request->post['formation'];
		} else {
			$data['formation'] = "";
		}

		if (isset($this->request->post['sales'])) {
			$data['sales'] = $this->request->post['sales'];
		} else {
			$data['sales'] = "";
		}

		if (isset($this->request->post['specify'])) {
			$data['specify'] = $this->request->post['specify'];
		} else {
			$data['specify'] = "";
		}

		if (isset($this->request->post['brands'])) {
			$data['brands'] = $this->request->post['brands'];
		} else {
			$data['brands'] = "";
		}

		if (isset($this->request->post['sales'])) {
			$data['sales'] = $this->request->post['sales'];
		} else {
			$data['sales'] = "";
		}

		if (isset($this->request->post['brands'])) {
			$data['brands'] = $this->request->post['brands'];
		} else {
			$data['brands'] = "";
		}

		if (isset($this->request->post['url'])) {
			$data['url'] = $this->request->post['url'];
		} else {
			$data['url'] = "";
		}

		if (isset($this->request->post['enquiryproducts'])) {
			foreach ($this->request->post['enquiryproducts']  as $key => $value) {
				$products_info = $this->model_catalog_product->getProduct($value);
				if ($products_info) {
					$data['enquiryproducts'][] = array(
						'product_id' => $products_info['product_id'],
						'name'       => $products_info['name']
					);
				}
			}
		} else {
			$data['enquiryproducts'] = array();
		}

		if (isset($this->request->post['enquirycategories'])) {
			foreach ($this->request->post['enquirycategories']  as $key => $value) {
				$category_info = $this->model_catalog_category->getCategory($value);
				if ($category_info) {
					$data['enquirycategories'][] = array(
						'category_id' => $category_info['category_id'],
						'name'       => $category_info['name']
					);
				}
			}
		} else {
			$data['enquirycategories'] = array();
		}

		if (isset($this->request->post['enquiry'])) {
			$data['enquiry'] = $this->request->post['enquiry'];
		} else {
			$data['enquiry'] = "";
		}

		if ($this->config->get('config_google_captcha_status')) {
			$this->document->addScript('https://www.google.com/recaptcha/api.js');

			$data['site_key'] = $this->config->get('config_google_captcha_public');
		} else {
			$data['site_key'] = '';
		}
		
		if (isset($this->request->post['captcha'])) {
			$data['captcha'] = $this->request->post['captcha'];
		} else {
			$data['captcha'] = '';
		}

		$data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/information/wholesaleform.tpl')) {
			$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/information/wholesaleform.tpl', $data));
		} else {
			$this->response->setOutput($this->load->view('default/template/information/wholesaleform.tpl', $data));
		}
	}

	public function success() {
		$this->load->language('information/wholesaleform');

		$this->document->setTitle($this->language->get('heading_title'));

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/home')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('information/wholesaleform')
		);

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_message'] = $this->language->get('text_success');

		$data['button_continue'] = $this->language->get('button_continue');

		$data['continue'] = $this->url->link('common/home');

		$data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/common/success.tpl')) {
			$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/common/success.tpl', $data));
		} else {
			$this->response->setOutput($this->load->view('default/template/common/success.tpl', $data));
		}
	}

	protected function validate() {

		$required  = $this->model_tool_wholesaleform->getrequired();
		$setting  = $this->model_tool_wholesaleform->getsetting();

		if($setting['companyname']) {
			if ($required['companyname'] && (utf8_strlen($this->request->post['companyname']) < 1) || (utf8_strlen($this->request->post['companyname']) > 80)) {
				$this->error['error_companyname'] = $this->language->get('error_companyname');
			}
		}
		if($setting['address']) {
			if ($required['address'] && isset($this->request->post['address']) && (utf8_strlen($this->request->post['address']) < 1) || (utf8_strlen($this->request->post['address']) > 200)) {
				$this->error['error_address'] = $this->language->get('error_address');
			}
		}	

		if($setting['city']) {
			if ($required['city'] && (utf8_strlen($this->request->post['city']) < 1) || (utf8_strlen($this->request->post['city']) > 50)) {
				$this->error['error_city'] = $this->language->get('error_city');
			}
		}	

		if($setting['state']) {
			if ($required['state'] && (utf8_strlen($this->request->post['state']) < 1) || (utf8_strlen($this->request->post['state']) > 50)) {
				$this->error['error_state'] = $this->language->get('error_state');
			}
		}	

		if($setting['country']) {
			if ($required['country'] && (utf8_strlen($this->request->post['country']) < 1) || (utf8_strlen($this->request->post['country']) > 80)) {
				$this->error['error_country'] = $this->language->get('error_country');
			}
		}	

		if($setting['pincode']) {	
			if ($required['pincode'] && (utf8_strlen($this->request->post['pincode']) < 1) || (utf8_strlen($this->request->post['pincode']) > 15)) {
				$this->error['error_pincode'] = $this->language->get('error_pincode');
			}
		}	

		if($setting['phone']) {
			if ($required['phone'] && (utf8_strlen($this->request->post['phone']) < 1) || (utf8_strlen($this->request->post['phone']) > 15)) {
				$this->error['error_phone'] = $this->language->get('error_phone');
			}
		}	

		if($setting['mobile']) {
			if ($required['mobile'] && (utf8_strlen($this->request->post['mobile']) < 1) || (utf8_strlen($this->request->post['mobile']) > 15)) {
				$this->error['error_mobile'] = $this->language->get('error_mobile');
			}
		}	

		if($setting['email']) {
			if ($required['email'] && !preg_match('/^[^\@]+@.*\.[a-z]{2,6}$/i', $this->request->post['email'])) {
				$this->error['error_email'] = $this->language->get('error_email');
			}
		}	

		if($setting['nameperson']) {
			if ($required['nameperson'] && (utf8_strlen($this->request->post['nameperson']) < 1) || (utf8_strlen($this->request->post['nameperson']) > 50)) {
				$this->error['error_nameperson'] = $this->language->get('error_nameperson');
			}
		}	

		if($setting['contacttitle']) {
			if ($required['contacttitle'] && (utf8_strlen($this->request->post['contacttitle']) < 1) || (utf8_strlen($this->request->post['contacttitle']) > 50)) {
				$this->error['error_contacttitle'] = $this->language->get('error_contacttitle');
			}
		}	

		if($setting['vattin']) {
			if ($required['vattin'] && (utf8_strlen($this->request->post['vattin']) < 1) || (utf8_strlen($this->request->post['vattin']) > 80)) {
				$this->error['error_vattin'] = $this->language->get('error_vattin');
			}
		}	

		if($setting['specify']) {
			if ($required['specify'] && (utf8_strlen($this->request->post['specify']) < 1) || (utf8_strlen($this->request->post['specify']) > 15)) {
				$this->error['error_specify'] = $this->language->get('error_specify');
			}
		}	

		if($setting['formation']) {
			if ($required['formation'] && (utf8_strlen($this->request->post['formation']) < 1) || (utf8_strlen($this->request->post['formation']) > 50)) {
				$this->error['error_formation'] = $this->language->get('error_formation');
			}
		}	

		if($setting['sales']) {
			if ($required['sales'] && (utf8_strlen($this->request->post['sales']) < 1) || (utf8_strlen($this->request->post['sales']) > 100)) {
				$this->error['error_sales'] = $this->language->get('error_sales');
			}
		}	

		if($setting['brands']) {
			if ($required['brands'] && (utf8_strlen($this->request->post['brands']) < 1) || (utf8_strlen($this->request->post['brands']) > 80)) {
				$this->error['error_brands'] = $this->language->get('error_brands');
			}
		}

		if($setting['url']) {
			if ($required['url'] && (utf8_strlen($this->request->post['url']) < 1) || (utf8_strlen($this->request->post['url']) > 100)) {
				$this->error['error_url'] = $this->language->get('error_url');
			}
		}	

		if($setting['products']) {
			if ($required['products'] && (empty($this->request->post['enquiryproducts']))) {
				$this->error['error_products'] = $this->language->get('error_products');
			}
		}	
		
		if($setting['category']) {
			if ($required['category'] && (empty($this->request->post['enquirycategories']))) {
				$this->error['error_category'] = $this->language->get('error_category');
			}
		}	

		if($setting['enquiry']) {
			if ($required['enquiry'] && (utf8_strlen($this->request->post['enquiry']) < 10) || (utf8_strlen($this->request->post['enquiry']) > 3000)) {
				$this->error['error_enquiry'] = $this->language->get('error_enquiry');
			}
		}	


		if ($this->config->get('config_google_captcha_status')) {
			$recaptcha = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=' . urlencode($this->config->get('config_google_captcha_secret')) . '&response=' . $this->request->post['g-recaptcha-response'] . '&remoteip=' . $this->request->server['REMOTE_ADDR']);

			$recaptcha = json_decode($recaptcha, true);

			if (!$recaptcha['success']) {
				$this->error['captcha'] = $this->language->get('error_captcha');
			}
		}

		if($this->error){
			$this->error['error_warning'] = $this->language->get('error_warning');
		}
		
		return !$this->error;
	}
	public function autocomplete() {
		$json = array();

		if (isset($this->request->get['filter_name']) || isset($this->request->get['filter_model'])) {
			$this->load->model('catalog/product');

			if (isset($this->request->get['filter_name'])) {
				$filter_name = $this->request->get['filter_name'];
			} else {
				$filter_name = '';
			}

			if (isset($this->request->get['filter_model'])) {
				$filter_model = $this->request->get['filter_model'];
			} else {
				$filter_model = '';
			}

			if (isset($this->request->get['limit'])) {
				$limit = $this->request->get['limit'];
			} else {
				$limit = 5;
			}

			$filter_data = array(
				'filter_name'  => $filter_name,
				'filter_model' => $filter_model,
				'start'        => 0,
				'limit'        => $limit
			);

			$results = $this->model_catalog_product->getProducts($filter_data);

			foreach ($results as $result) {
				$option_data = array();
				$json[] = array(
					'product_id' => $result['product_id'],
					'name'       => strip_tags(html_entity_decode($result['name'], ENT_QUOTES, 'UTF-8')),
					'model'      => $result['model'],
					'option'     => $option_data,
					'price'      => $result['price']
				);
			}
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function autocompletec() {
		$json = array();

		if (isset($this->request->get['filter_name'])) {
			$this->load->model('catalog/category');

			$filter_data = array(
				'filter_name' => $this->request->get['filter_name'],
				'sort'        => 'name',
				'order'       => 'ASC',
				'start'       => 0,
				'limit'       => 5
			);

			$results = $this->model_catalog_category->getCategoriesByName($filter_data);
			
			foreach ($results as $result) {
				$json[] = array(
					'category_id' => $result['category_id'],
					'name'        => strip_tags(html_entity_decode($result['name'], ENT_QUOTES, 'UTF-8'))
				);
			}
		}

		$sort_order = array();

		foreach ($json as $key => $value) {
			$sort_order[$key] = $value['name'];
		}

		array_multisort($sort_order, SORT_ASC, $json);

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
}
