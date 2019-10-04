<?php
class ControllerAccountSoclLogin extends Controller
{
    private $error = array();
    
    public function index()
    {
        $this->load->model('account/socl_login');
        
        if (!$this->model_account_socl_login->checkInstalled() || !isset($this->request->get['token'])) {
            if (!$this->customer->isLogged()) {
                $this->session->data['redirect'] = $this->url->link('account/account', '', 'SSL');

                $this->load->language('account/socl_login');
                
                $this->response->redirect($this->url->link('account/login', "soclerror=" . $this->language->get('error_cant_get_token'), 'SSL'));
            }
        }

        $token = $this->request->get['token'];

        $socl_all = new SoclAll($this->config->get('soclall_appid'), $this->config->get('soclall_secretkey'));

        $user = $socl_all->getUser($token);
        
        if(isset($user['error']))
            $this->response->redirect($this->url->link('account/login', "soclerror=" . $user['error'], 'SSL'));
        
        if(isset($user['success'])) {
            $user = $user['result'];
            $soclall_id = ($this->request->get['network'] == 'tumblr') ? $user['profile_url'] : $user['id'];
        }

        if (isset($soclall_id) && !empty($soclall_id) && isset($this->request->get['network'])) { 
            $email = $this->model_account_socl_login->checkSoclCustomerById($soclall_id, $this->request->get['network']);
            if ($email) {
                if($this->loginSocl($email))
                    $this->response->redirect($this->url->link('account/account', '', 'SSL'));
                else
                    $this->response->redirect($this->url->link('account/login', "soclerror=" . $this->error['warning'], 'SSL'));
            }
            
            if(!empty($user['email'])) {
                if($this->model_account_socl_login->checkSoclCustomerByEmail($user['email'])) {
                    $this->model_account_socl_login->insertUpdateNewSoclId($soclall_id, $user['email'], $this->request->get['network']);
                    
                    if($this->loginSocl($user['email']))
                        $this->response->redirect($this->url->link('account/account', '', 'SSL'));
                    else
                        $this->response->redirect($this->url->link('account/login', "soclerror=" . $this->error['warning'], 'SSL'));
                }
            }
            
            $params = "soclid=" . $soclall_id . "&network=" . $this->request->get['network'];
            if(!empty($user['email']))
                $params .= "&email=" . $user['email'];
            if(!empty($user['first_name']))
                $params .= "&firstname=" . $user['first_name'];
            if(!empty($user['last_name']))
                $params .= "&lastname=" . $user['last_name'];
            
            $this->response->redirect($this->url->link('account/login', $params, 'SSL'));
        } else {
            $this->load->language('account/socl_login');
            
            $this->response->redirect($this->url->link('account/login', "soclerror=" . $this->language->get('error_get_user_fail'), 'SSL'));
        }
    }
    
    private function loginSocl($email)
    {
        $this->load->language('account/socl_login');
        
        $this->load->model('account/customer');
        
        // Check how many login attempts have been made.
		$login_info = $this->model_account_customer->getLoginAttempts($email);
				
		if ($login_info && ($login_info['total'] > $this->config->get('config_login_attempts')) && strtotime('-1 hour') < strtotime($login_info['date_modified'])) {
			$this->error['warning'] = $this->language->get('error_attempts');
		}
		
		// Check if customer has been approved.
		$customer_info = $this->model_account_customer->getCustomerByEmail($email);

		if ($customer_info && !$customer_info['approved']) {
			$this->error['warning'] = $this->language->get('error_approved');
		}
		
		if (!$this->error) {
			if (!$this->customer->login($email, '', true)) {
				$this->error['warning'] = $this->language->get('error_login');
			
				$this->model_account_customer->addLoginAttempt($email);
			} else {
				$this->model_account_customer->deleteLoginAttempts($email);
			}			
		}

		if (!$this->error) {
            $this->setAddressInfo();
            
			return true;
		} else {
			return false;
		}
    }
    
    public function register()
    {           
        $this->load->language('account/socl_login');
        
        $data['heading_title'] = $this->language->get('heading_title');
        
        $data['entry_email'] = $this->language->get('entry_email');
        $data['entry_firstname'] = $this->language->get('entry_firstname');
        $data['entry_lastname'] = $this->language->get('entry_lastname');
        $data['entry_telephone'] = $this->language->get('entry_telephone');
		$data['entry_fax'] = $this->language->get('entry_fax');
		$data['entry_company'] = $this->language->get('entry_company');
		$data['entry_address'] = $this->language->get('entry_address');
        $data['entry_postcode'] = $this->language->get('entry_postcode');
		$data['entry_city'] = $this->language->get('entry_city');
		$data['entry_country'] = $this->language->get('entry_country');
		$data['entry_zone'] = $this->language->get('entry_zone');
        
        $data['text_select'] = $this->language->get('text_select');
        $data['text_fill_all'] = $this->language->get('text_fill_all');        
        $data['text_loading'] = $this->language->get('text_loading');
        
        $data['button_save'] = $this->language->get('button_save');
        $data['button_upload'] = $this->language->get('button_upload');
        
        if (isset($this->request->get['socl_id'])) {
			$data['socl_id'] = $this->request->get['socl_id'];
		} else {
            $data['socl_id'] = '';
		}
        
        if (isset($this->request->get['network'])) {
			$data['network'] = $this->request->get['network'];
		} else {
            $data['network'] = '';
		}
        
        if (isset($this->request->get['firstname'])) {
			$data['firstname'] = $this->request->get['firstname'];
		} else {
			$data['firstname'] = '';
		}

		if (isset($this->request->get['lastname'])) {
			$data['lastname'] = $this->request->get['lastname'];
		} else {
			$data['lastname'] = '';
		}

		if (isset($this->request->get['email'])) {
			$data['email'] = $this->request->get['email'];
		} else {
			$data['email'] = '';
		}
        
        if ($this->config->get('soclall_customer_group_id')) {
            $data['customer_group_id'] = $this->config->get('soclall_customer_group_id');
		} else {
            $data['customer_group_id'] = $this->config->get('config_customer_group_id');
		}
        
        if (isset($this->session->data['shipping_postcode'])) {
			$data['postcode'] = $this->session->data['shipping_postcode'];		
		} else {
			$data['postcode'] = '';
		}

		if (isset($this->session->data['shipping_country_id'])) {
			$data['country_id'] = $this->session->data['shipping_country_id'];		
		} else {	
			$data['country_id'] = $this->config->get('config_country_id');
		}

		if (isset($this->session->data['shipping_zone_id'])) {
			$data['zone_id'] = $this->session->data['shipping_zone_id'];			
		} else {
			$data['zone_id'] = '';
		}
        
        $soclall_required_details = $this->config->get('soclall_required_details');
        
        // Get Country List
        if(is_array($soclall_required_details) && in_array('country', $soclall_required_details)) {
            $this->load->model('localisation/country');
            $data['countries'] = $this->model_localisation_country->getCountries();
        } else $data['countries'] = array();
        
        // Custom Fields
		$this->load->model('account/custom_field');

		$data['custom_fields'] = $this->model_account_custom_field->getCustomFields($data['customer_group_id']);
        
        // check email
        if(empty($data['email']))
            $data['display_email'] = 1;
        else $data['display_email'] = 0;
        
        // check required entry
        if(is_array($soclall_required_details)) {
            if(empty($data['firstname']) && in_array('firstname', $soclall_required_details))
                $data['display_firstname'] = 1;
            else $data['display_firstname'] = 0;
            
            if(empty($data['lastname']) && in_array('lastname', $soclall_required_details))
                $data['display_lastname'] = 1;
            else $data['display_lastname'] = 0;
            
            if(in_array('telephone', $soclall_required_details))
                $data['display_telephone'] = 1;
            else $data['display_telephone'] = 0;
            
            if(in_array('fax', $soclall_required_details))
                $data['display_fax'] = 1;
            else $data['display_fax'] = 0;
            
            if(in_array('company', $soclall_required_details))
                $data['display_company'] = 1;
            else $data['display_company'] = 0;
            
            if(in_array('add', $soclall_required_details))
                $data['display_address'] = 1;
            else $data['display_address'] = 0;
            
            if(in_array('city', $soclall_required_details))
                $data['display_city'] = 1;
            else $data['display_city'] = 0;
            
            if(in_array('postcode', $soclall_required_details))
                $data['display_postcode'] = 1;
            else $data['display_postcode'] = 0;
            
            if(in_array('country', $soclall_required_details))
                $data['display_country'] = 1;
            else $data['display_country'] = 0;
            
            if(in_array('region', $soclall_required_details))
                $data['display_region'] = 1;
            else $data['display_region'] = 0;
        }
        
        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/account/socl_new_user_form.tpl')) {
            $this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/account/socl_new_user_form.tpl', $data));            
		} else {
			$this->response->setOutput($this->load->view('default/template/account/socl_new_user_form.tpl', $data));
		}
    }
    
    public function validate()
    {
        $this->load->language('account/socl_login');
        
        $this->load->model('account/customer');
        
        $json = array();
        
        if(!empty($this->request->post['validate_email'])) {
            if ((utf8_strlen($this->request->post['email']) > 96) || !preg_match('/^[^\@]+@.*.[a-z]{2,15}$/i', $this->request->post['email'])) {
				$json['error']['email'] = $this->language->get('error_email');
			}

			if ($this->model_account_customer->getTotalCustomersByEmail($this->request->post['email'])) {
				$json['error']['existed_email'] = 1;
			}
        }
        
        if(is_array($this->config->get('soclall_required_details'))) {
            $config_required = $this->config->get('soclall_required_details');
            
            if(in_array('firstname', $config_required) && !empty($this->request->post['validate_firstname'])) {
                if ((utf8_strlen(trim($this->request->post['firstname'])) < 1) || (utf8_strlen(trim($this->request->post['firstname'])) > 32)) {
    				$json['error']['firstname'] = $this->language->get('error_firstname');
    			}
            }
            
            if(in_array('lastname', $config_required) && !empty($this->request->post['validate_lastname'])) {
                if ((utf8_strlen(trim($this->request->post['lastname'])) < 1) || (utf8_strlen(trim($this->request->post['lastname'])) > 32)) {
    				$json['error']['lastname'] = $this->language->get('error_lastname');
    			}
            }
            
            if(in_array('telephone', $config_required)) {
                if ((utf8_strlen($this->request->post['telephone']) < 3) || (utf8_strlen($this->request->post['telephone']) > 32)) {
    				$json['error']['telephone'] = $this->language->get('error_telephone');
    			}
            }
            
            if(in_array('add', $config_required)) {
                if ((utf8_strlen(trim($this->request->post['address_1'])) < 3) || (utf8_strlen(trim($this->request->post['address_1'])) > 128)) {
    				$json['error']['address'] = $this->language->get('error_address');
    			}
            }
            
            if(in_array('city', $config_required)) {
                if ((utf8_strlen(trim($this->request->post['city'])) < 2) || (utf8_strlen(trim($this->request->post['city'])) > 128)) {
    				$json['error']['city'] = $this->language->get('error_city');
    			}
            }
            
            if(in_array('country', $config_required)) {
                if ($this->request->post['country_id'] == '') {
    				$json['error']['country'] = $this->language->get('error_country');
    			}
        
                $this->load->model('localisation/country');

                $country_info = $this->model_localisation_country->getCountry($this->request->post['country_id']);
                
                if ($country_info) {
                    if(in_array('postcode', $config_required)) {
            			if ($country_info && $country_info['postcode_required'] && (utf8_strlen(trim($this->request->post['postcode'])) < 2 || utf8_strlen(trim($this->request->post['postcode'])) > 10)) {
            				$json['error']['postcode'] = $this->language->get('error_postcode');
            			}
                    }
        		}
                
                if(in_array('region', $config_required)) {
            		if (!isset($this->request->post['zone_id']) || $this->request->post['zone_id'] == '') {
            			$json['error']['zone'] = $this->language->get('error_zone');
            		}
                }
            }
        }
        
        // Customer Group
        if (isset($this->request->post['customer_group_id']) && is_array($this->config->get('config_customer_group_display')) && in_array($this->request->post['customer_group_id'], $this->config->get('config_customer_group_display'))) {
			$customer_group_id = $this->request->post['customer_group_id'];
		} elseif ($this->config->get('soclall_customer_group_id')) {
			$customer_group_id = $this->config->get('soclall_customer_group_id');
		} else {
            $customer_group_id = $this->config->get('config_customer_group_id');
		}
        
		// Custom field validation
		$this->load->model('account/custom_field');

        $custom_fields = $this->model_account_custom_field->getCustomFields($customer_group_id);

        foreach ($custom_fields as $custom_field) {
            if ($custom_field['required'] && empty($this->request->post['custom_field'][$custom_field['location']][$custom_field['custom_field_id']])) {
                $json['error']['custom_field' . $custom_field['custom_field_id']] = sprintf($this->language->get('error_custom_field'), $custom_field['name']);
            }
        }
        
        if (!$json) {            
            $this->load->model('account/socl_login');
            
            $this->model_account_customer->addCustomer($this->request->post);
            
            $this->model_account_socl_login->insertUpdateNewSoclId($this->request->post['socl_id'], $this->request->post['email'], $this->request->post['network']);
            
            // Clear any previous login attempts for unregistered accounts.
			$this->model_account_customer->deleteLoginAttempts($this->request->post['email']);
            
            $customer_info = $this->model_account_customer->getCustomerByEmail($this->request->post['email']);

            if ($customer_info && !$customer_info['approved']) {
                $json['redirect'] = $this->url->link('account/success');
                $not_approved = true;
            } else $not_approved = false;
            
            if(!$not_approved) {
                $this->customer->login($this->request->post['email'], '', true);
    
    			unset($this->session->data['guest']);
    
    			// Add to activity log
    			$this->load->model('account/activity');
    
    			$activity_data = array(
    				'customer_id' => $this->customer->getId(),
    				'name'        => $this->request->post['firstname'] . ' ' . $this->request->post['lastname']
    			);
    
    			$this->model_account_activity->addActivity('register', $activity_data);
                
                $json['redirect'] = $this->url->link('account/account', '', 'SSL');
            }
		}
        
        $this->response->setOutput(json_encode($json));
    }
    
    public function existed()
    {
        $this->load->language('account/socl_login');

        $data['heading_title'] = $this->language->get('confirm_heading_title');

        $data['text_confirm_pass'] = $this->language->get('text_confirm_pass');
        $data['entry_confirm_pass'] = $this->language->get('entry_confirm_pass');

        $data['button_confirm'] = $this->language->get('button_confirm');
        $data['button_cancel'] = $this->language->get('button_cancel');

        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/account/socl_confirm_password.tpl')) {
            $this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/account/socl_confirm_password.tpl', $data));            
		} else {
			$this->response->setOutput($this->load->view('default/template/account/socl_confirm_password.tpl', $data));
		}
    }

    public function confirm()
    {
        $this->load->language('account/socl_login');

        $json = array();

        if ($this->request->post['socl_id'] && $this->request->post['email'] && $this->request->post['network'] && $this->request->post['confirm_pass']) {

            if (!$this->customer->login($this->request->post['email'], $this->request->post['confirm_pass'])) {
                $json['error'] = $this->language->get('error_wrong_pass');
            }

            $this->load->model('account/customer');

            $customer_info = $this->model_account_customer->getCustomerByEmail($this->request->post['email']);

            if ($customer_info && !$customer_info['approved']) {
                $json['error'] = $this->language->get('error_approved');
            }

            if (!isset($json['error'])) {
                $this->load->model('account/socl_login');

                $this->model_account_socl_login->insertUpdateNewSoclId($this->request->post['socl_id'], $this->request->post['email'], $this->request->post['network']);

                $this->setAddressInfo();

                $json['redirect'] = $this->url->link('account/account', '', 'SSL');
            }

        } else {
            $json['error'] = $this->language->get('error_confirm_fail');
        }

        $this->response->setOutput(json_encode($json));
    }
    
    private function setAddressInfo()
    {
        unset($this->session->data['guest']);

        // Default Shipping Address
        $this->load->model('account/address');
        
        if ($this->config->get('config_tax_customer') == 'payment') {
            $this->session->data['payment_address'] = $this->model_account_address->getAddress($this->customer->getAddressId());
        }
        
        if ($this->config->get('config_tax_customer') == 'shipping') {
            $this->session->data['shipping_address'] = $this->model_account_address->getAddress($this->customer->getAddressId());
        }
        
        // Add to activity log
        $this->load->model('account/activity');
        
        $activity_data = array(
            'customer_id' => $this->customer->getId(),
            'name'        => $this->customer->getFirstName() . ' ' . $this->customer->getLastName()
        );
        
        $this->model_account_activity->addActivity('login', $activity_data);
    }
}

?>