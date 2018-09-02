<?php
class ControllerAccountLogin extends Controller {
	private $error = array();

	public function index() {
		$this->load->model('account/customer');

		// Login override for admin users

            
            $this->load->model('account/socl_login');
            
            $socl_check_installed = $this->model_account_socl_login->checkInstalled();
            
            if(!empty($this->request->get['soclid'])) {
                if ($socl_check_installed) {
                    $data['socl_id'] = $this->request->get['soclid'];
                    $data['socl_network'] = $this->request->get['network'];
                    $data['socl_email'] = (!empty($this->request->get['email'])) ? $this->request->get['email'] : '';
                    $data['socl_firstname'] = (!empty($this->request->get['firstname'])) ? $this->request->get['firstname'] : '';
                    $data['socl_lastname'] = (!empty($this->request->get['lastname'])) ? $this->request->get['lastname'] : '';
                    
                    $this->document->addScript('catalog/view/javascript/jquery/datetimepicker/moment.js');
            		$this->document->addScript('catalog/view/javascript/jquery/datetimepicker/bootstrap-datetimepicker.min.js');
            		$this->document->addStyle('catalog/view/javascript/jquery/datetimepicker/bootstrap-datetimepicker.min.css');
                    
                    $this->load->language('account/socl_login');
                    
                    $data['text_select'] = $this->language->get('text_select');
                    $data['text_none'] = $this->language->get('text_none');
                    $data['text_please_wait'] = $this->language->get('text_please_wait');
                    
                    if($this->config->get('soclall_required_details')){
                        $soclall_required_details = $this->config->get('soclall_required_details');
                        if(is_array($soclall_required_details)) {
                            if(in_array('country', $soclall_required_details)) {
                                $data['country_display'] = 1;
                                
                                if(in_array('postcode', $soclall_required_details))
                                    $data['postcode_display'] = 1;
                                else $data['postcode_display'] = 0;
                                
                                if(in_array('region', $soclall_required_details))
                                    $data['region_display'] = 1;
                                else $data['region_display'] = 0; 
                                                   
                            } else $data['country_display'] = 0;
                        
                            if(count($soclall_required_details) == 2 && in_array('firstname', $soclall_required_details) && in_array('lastname', $soclall_required_details)) {
                                if(!empty($data['socl_firstname']) && !empty($data['socl_lastname']))
                                    $data['socl_required_entry_empty'] = 1;
                            }
                        }
                    } else {
                        $data['socl_required_entry_empty'] = 1;
                    }
                    
                    $this->load->model('account/custom_field');
                    if ($this->config->get('soclall_customer_group_id')) {
            			$customer_group_id = $this->config->get('soclall_customer_group_id');
            		} else {
            			$customer_group_id = $this->config->get('config_customer_group_id');
            		}
            
            		if(!count($this->model_account_custom_field->getCustomFields($customer_group_id)))
                        $data['socl_custom_fields_empty'] = 1;
                    else $data['socl_custom_fields_empty'] = 0;
                }
            }
               
			
		if (!empty($this->request->get['token'])) {
			$this->customer->logout();
			$this->cart->clear();

			unset($this->session->data['order_id']);
			unset($this->session->data['payment_address']);
			unset($this->session->data['payment_method']);
			unset($this->session->data['payment_methods']);
			unset($this->session->data['shipping_address']);
			unset($this->session->data['shipping_method']);
			unset($this->session->data['shipping_methods']);
			unset($this->session->data['comment']);
			unset($this->session->data['coupon']);
			unset($this->session->data['reward']);
			unset($this->session->data['voucher']);
			unset($this->session->data['vouchers']);

			$customer_info = $this->model_account_customer->getCustomerByToken($this->request->get['token']);

			if ($customer_info && $this->customer->login($customer_info['email'], '', true)) {
				// Default Addresses
				$this->load->model('account/address');

				if ($this->config->get('config_tax_customer') == 'payment') {
					$this->session->data['payment_address'] = $this->model_account_address->getAddress($this->customer->getAddressId());
				}

				if ($this->config->get('config_tax_customer') == 'shipping') {
					$this->session->data['shipping_address'] = $this->model_account_address->getAddress($this->customer->getAddressId());
				}


				$this->response->redirect($this->url->link('account/account', '', 'SSL'));
			}
		}

		if ($this->customer->isLogged()) {
			$this->response->redirect($this->url->link('account/account', '', 'SSL'));
		}

		$this->load->language('account/login');

		$this->document->setTitle($this->language->get('heading_title'));

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			// Trigger customer pre login event
			$this->event->trigger('pre.customer.login');

			// Unset guest
			unset($this->session->data['guest']);

			// Default Shipping Address
			$this->load->model('account/address');

			if ($this->config->get('config_tax_customer') == 'payment') {
				$this->session->data['payment_address'] = $this->model_account_address->getAddress($this->customer->getAddressId());
			}

			if ($this->config->get('config_tax_customer') == 'shipping') {
				$this->session->data['shipping_address'] = $this->model_account_address->getAddress($this->customer->getAddressId());
			}

			// Wishlist
			if (isset($this->session->data['wishlist']) && is_array($this->session->data['wishlist'])) {
				$this->load->model('account/wishlist');

				foreach ($this->session->data['wishlist'] as $key => $product_id) {
					$this->model_account_wishlist->addWishlist($product_id);

					unset($this->session->data['wishlist'][$key]);
				}
			}

			// Add to activity log
			$this->load->model('account/activity');

			$activity_data = array(
				'customer_id' => $this->customer->getId(),
				'name'        => $this->customer->getFirstName() . ' ' . $this->customer->getLastName()
			);

			$this->model_account_activity->addActivity('login', $activity_data);

			// Trigger customer post login event
			$this->event->trigger('post.customer.login');

			// Added strpos check to pass McAfee PCI compliance test (http://forum.opencart.com/viewtopic.php?f=10&t=12043&p=151494#p151295)
			if (isset($this->request->post['redirect']) && (strpos($this->request->post['redirect'], $this->config->get('config_url')) !== false || strpos($this->request->post['redirect'], $this->config->get('config_ssl')) !== false)) {
				$this->response->redirect(str_replace('&amp;', '&', $this->request->post['redirect']));
			} else {
				$this->response->redirect($this->url->link('account/account', '', 'SSL'));
			}
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/home')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_account'),
			'href' => $this->url->link('account/account', '', 'SSL')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_login'),
			'href' => $this->url->link('account/login', '', 'SSL')
		);

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_new_customer'] = $this->language->get('text_new_customer');
		$data['text_register'] = $this->language->get('text_register');
		$data['text_register_account'] = $this->language->get('text_register_account');
		$data['text_returning_customer'] = $this->language->get('text_returning_customer');
		$data['text_i_am_returning_customer'] = $this->language->get('text_i_am_returning_customer');
		$data['text_forgotten'] = $this->language->get('text_forgotten');

		$data['entry_email'] = $this->language->get('entry_email');
		$data['entry_password'] = $this->language->get('entry_password');

		$data['button_continue'] = $this->language->get('button_continue');
		$data['button_login'] = $this->language->get('button_login');
            
            
            if($socl_check_installed) {
                $this->document->addStyle('catalog/view/javascript/socl_login/socl_login_theme.css');
                
                $this->load->language('account/socl_login');
                $data['text_socl_login'] = $this->language->get('text_socl_login');
                
                $data['social_login'] = $this->model_account_socl_login->getSoclLoginList();
                
                if($this->config->get('soclall_theme_applied'))
                    $data['social_login_theme'] = $this->config->get('soclall_theme_applied');
                else $data['social_login_theme'] = 'default';
                
                $social_login_themes_resize = array('no5','no6','no7');
                $data['social_login_theme_size'] = (in_array($data['social_login_theme'], $social_login_themes_resize)) ? (($this->config->get('soclall_theme_resize')) ? $this->config->get('soclall_theme_resize') : '100') : '0';
                
                $social_login_themes_customize = array('no4','no7','no8');
                $data['social_login_themes_customize_check'] = (in_array($data['social_login_theme'], $social_login_themes_customize)) ? true : false;
                if(in_array($data['social_login_theme'], $social_login_themes_customize)) {
                    $data['social_login_themes_customize_col'] = ($this->config->get('soclall_theme_custom_col')) ? $this->config->get('soclall_theme_custom_col') : '1';
                    $data['social_login_themes_customize_width'] = ($this->config->get('soclall_theme_custom_width')) ? $this->config->get('soclall_theme_custom_width') : '100';
                    $data['social_login_themes_customize_text'] = ($this->config->get('soclall_theme_custom_text')) ? $this->config->get('soclall_theme_custom_text') : $this->language->get('text_default_theme_button');
                    $data['social_login_themes_customize_align'] = ($this->config->get('soclall_theme_custom_align')) ? $this->config->get('soclall_theme_custom_align') : 'l';
                    $data['social_login_themes_customize_position'] = ($this->config->get('soclall_theme_custom_position')) ? $this->config->get('soclall_theme_custom_position') : 'c';
                }
            }
                        
			


            
            if(!empty($this->request->get['soclerror']))
                $this->error['warning'] = $this->request->get['soclerror'];
                        
			
		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		$data['action'] = $this->url->link('account/login', '', 'SSL');
		$data['register'] = $this->url->link('account/register', '', 'SSL');
		$data['forgotten'] = $this->url->link('account/forgotten', '', 'SSL');

		// Added strpos check to pass McAfee PCI compliance test (http://forum.opencart.com/viewtopic.php?f=10&t=12043&p=151494#p151295)
		if (isset($this->request->post['redirect']) && (strpos($this->request->post['redirect'], $this->config->get('config_url')) !== false || strpos($this->request->post['redirect'], $this->config->get('config_ssl')) !== false)) {
			$data['redirect'] = $this->request->post['redirect'];
		} elseif (isset($this->session->data['redirect'])) {
			$data['redirect'] = $this->session->data['redirect'];

			unset($this->session->data['redirect']);
		} else {
			$data['redirect'] = '';
		}

		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];

			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}

		if (isset($this->request->post['email'])) {
			$data['email'] = $this->request->post['email'];
		} else {
			$data['email'] = '';
		}

		if (isset($this->request->post['password'])) {
			$data['password'] = $this->request->post['password'];
		} else {
			$data['password'] = '';
		}

		$data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/account/login.tpl')) {
			if(IS_MOBILE){
                $this->response->setOutput($this->load->view('wap/login.tpl', $data));
            }else{
            $this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/account/login.tpl', $data));
            }
		} else {
			$this->response->setOutput($this->load->view('default/template/account/login.tpl', $data));
		}
	}

	protected function validate() {
		$this->event->trigger('pre.customer.login');

		// Check how many login attempts have been made.
		$login_info = $this->model_account_customer->getLoginAttempts($this->request->post['email']);

		if ($login_info && ($login_info['total'] >= $this->config->get('config_login_attempts')) && strtotime('-1 hour') < strtotime($login_info['date_modified'])) {
			$this->error['warning'] = $this->language->get('error_attempts');
		}

		// Check if customer has been approved.
		$customer_info = $this->model_account_customer->getCustomerByEmail($this->request->post['email']);

		if ($customer_info && !$customer_info['approved']) {
			$this->error['warning'] = $this->language->get('error_approved');
		}

		if (!$this->error) {
			if (!$this->customer->login($this->request->post['email'], $this->request->post['password'])) {
				$this->error['warning'] = $this->language->get('error_login');

				$this->model_account_customer->addLoginAttempt($this->request->post['email']);
			} else {
				$this->model_account_customer->deleteLoginAttempts($this->request->post['email']);
			}
		}

		return !$this->error;
	}
}
