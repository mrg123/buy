<?php

class ControllerModuleSoclLogin extends Controller
{
    private $error = array();
    
    public function install()
    {       
        // Create table socl network
        $this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "soclall_network` ( 
                            `network_code` char(10) NOT NULL,
                            `network_name` char(50) NOT NULL,
                            PRIMARY KEY (`network_code`) 
                            )ENGINE=MyISAM DEFAULT CHARSET=utf8;");

        $query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "soclall_network` LIMIT 0,1");
        if ($query->num_rows) {
            $this->db->query("DELETE FROM `" . DB_PREFIX . "soclall_network`");
        }
        
        $this->db->query("INSERT INTO `" . DB_PREFIX . "soclall_network` VALUES 
                        ('facebook','Facebook'),
                        ('twitter','Twitter'),
                        ('google','Google Plus'),
                        ('linkedin','LinkedIn'),
                        ('live','Live'),
                        ('plurk','Plurk'),
                        ('tumblr','Tumblr'),
                        ('mailru','Mail.ru'),
                        ('reddit','Reddit'),
                        ('lastfm','Last.fm'),
                        ('vkontakte','Vkontakte'),
                        ('disqus','Disqus'),
                        ('wordpress','Wordpress'),
                        ('foursquare','Foursquare'),
                        ('github','Github'),
                        ('instagram','Instagram'),
                        ('pinterest','Pinterest'),
                        ('amazon','Amazon'),
                        ('ebay','Ebay'),
                        ('yahoo','Yahoo!'),
                        ('weibo','Weibo'),
                        ('twitch','Twitch'),
                        ('steam','Steam');");
                        
        // Create table soclall id
        $this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "soclall_id` ( 
                            `network_code` char(10) NOT NULL,
                            `customer_id` int(11) NOT NULL,
                            `socl_id` char(255) NOT NULL, 
                            PRIMARY KEY (`network_code`, `customer_id`) 
                            )ENGINE=MyISAM DEFAULT CHARSET=utf8;");
    }
    
    public function index() {
        // drop column logo
        $query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "soclall_network` LIMIT 0, 1");
        if (array_key_exists('logo', $query->row)) {
			$this->db->query("ALTER TABLE `" .DB_PREFIX. "soclall_network` DROP COLUMN `logo`");
		}
        
        // update new networks
        $new_nets = array('instagram', 'pinterest', 'amazon', 'ebay', 'yahoo', 'weibo', 'twitch', 'steam');        
        $query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "soclall_network` WHERE `network_code` IN ('" .implode("','", $new_nets). "')");
        
        if ($query->num_rows) {
            foreach($query->rows as $net) {
                $exist_nets[] = $net['network_code'];
            }
        } else $exist_nets = array();
        
        $new_nets = array_diff($new_nets, $exist_nets);
        
        foreach($new_nets as $net) {
            $this->db->query("INSERT INTO `" . DB_PREFIX . "soclall_network` VALUES ('" .$net. "','" .ucfirst($net). "')");
        }
        // end update
        
        $this->load->language('module/socl_login');
        
        $this->document->setTitle($this->language->get('heading_title'));
        $this->document->addStyle('view/javascript/socl_login/socl_login_theme.css');
        
        $this->load->model('setting/setting');
        
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()){
            $this->model_setting_setting->editSetting('soclall', $this->request->post);
            
            $this->session->data['success'] = $this->language->get('text_success');
            
            $this->response->redirect($this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'));
        }
        
        $data['heading_title'] = $this->language->get('heading_title');
        $data['text_edit'] = $this->language->get('text_edit');
        
        $data['tab_common_settings'] = $this->language->get('tab_common_settings');
        $data['tab_api_settings'] = $this->language->get('tab_api_settings');
        $data['tab_manage_network'] = $this->language->get('tab_manage_network');
        $data['tab_manage_theme'] = $this->language->get('tab_manage_theme');
        
        $data['entry_app_id'] = $this->language->get('entry_app_id');
        $data['entry_secret_key'] = $this->language->get('entry_secret_key');
        $data['entry_user_required'] = $this->language->get('entry_user_required');
        $data['entry_customer_group'] = $this->language->get('entry_customer_group');
        $data['entry_ebay_site'] = $this->language->get('entry_ebay_site');
        //**
        $data['entry_custom_col'] = $this->language->get('entry_custom_col');
        $data['entry_custom_width'] = $this->language->get('entry_custom_width');
        $data['entry_custom_align'] = $this->language->get('entry_custom_align');
        $data['entry_custom_position'] = $this->language->get('entry_custom_position');
        $data['entry_custom_text'] = $this->language->get('entry_custom_text');
        
        $data['help_user_required'] = $this->language->get('help_user_required');
        $data['help_customer_group'] = $this->language->get('help_customer_group');
        $data['help_tab_manage_network'] = $this->language->get('help_tab_manage_network');
        $data['help_ebay_site'] = $this->language->get('help_ebay_site');
        
        $data['button_save_all'] = $this->language->get('button_save_all');
		$data['button_cancel'] = $this->language->get('button_cancel');
        $data['button_apply'] = $this->language->get('button_apply');
        $data['button_custom'] = $this->language->get('button_custom');//**
        $data['button_done'] = $this->language->get('button_done');//**
        
        $data['theme_title_no'] = $this->language->get('theme_title_no');
        $data['text_select_all'] = $this->language->get('text_select_all');
        $data['text_custom_size'] = $this->language->get('text_custom_size');
        $data['text_customize_theme'] = $this->language->get('text_customize_theme');
        $data['text_default_theme_button'] = $this->language->get('text_default_theme_button');//**
        
        if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}
        
        $data['breadcrumbs'] = array();

   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),      		
      		'separator' => false
   		);

   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_module'),
			'href'      => $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);

   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('module/socl_login', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
        
        $data['action'] = $this->url->link('module/socl_login', 'token=' . $this->session->data['token'], 'SSL');

		$data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');
        
        if (isset($this->request->post['soclall_appid'])) {
            $data['soclall_appid'] = $this->request->post['soclall_appid'];
        } elseif ($this->config->get('soclall_appid')) {
            $data['soclall_appid'] = $this->config->get('soclall_appid');
        } else {
            $data['soclall_appid'] = '';
        }
        
        if($data['soclall_appid'])
            $data['text_view_your_dashboard'] = sprintf($this->language->get('text_view_your_dashboard'), $data['soclall_appid']);
        else $data['text_view_your_dashboard'] = $this->language->get('text_no_app_id');
        
        if (isset($this->request->post['soclall_secretkey'])) {
            $data['soclall_secretkey'] = $this->request->post['soclall_secretkey'];
        } elseif ($this->config->get('soclall_secretkey')) {
            $data['soclall_secretkey'] = $this->config->get('soclall_secretkey');
        } else {
            $data['soclall_secretkey'] = '';
        }
        
        if (isset($this->request->post['soclall_customer_group_id'])) {
			$data['soclall_customer_group_id'] = $this->request->post['soclall_customer_group_id'];
		} elseif($this->config->get('soclall_customer_group_id')) {
			$data['soclall_customer_group_id'] = $this->config->get('soclall_customer_group_id');
		} else {
            $data['soclall_customer_group_id'] = $this->config->get('config_customer_group_id');
		}
        
        if (isset($this->request->post['soclall_required_details'])) {
			$data['soclall_required_details'] = $this->request->post['soclall_required_details'];
		} else {
			$data['soclall_required_details'] = $this->config->get('soclall_required_details');
		}
        
        if (isset($this->request->post['soclall_enabled_network'])) {
			$data['soclall_enabled_network'] = $this->request->post['soclall_enabled_network'];
		} else {
			$data['soclall_enabled_network'] = $this->config->get('soclall_enabled_network');
		}
        
        if (isset($this->request->post['soclall_theme_applied'])) {
			$data['soclall_theme_applied'] = $this->request->post['soclall_theme_applied'];
		} elseif($this->config->get('soclall_theme_applied')){
			$data['soclall_theme_applied'] = $this->config->get('soclall_theme_applied');
		} else {
            $data['soclall_theme_applied'] = 'default';
		}
        
        if (isset($this->request->post['soclall_theme_resize'])) {
			$data['soclall_theme_resize'] = $this->request->post['soclall_theme_resize'];
		} elseif($this->config->get('soclall_theme_resize')){
			$data['soclall_theme_resize'] = $this->config->get('soclall_theme_resize');
		} else {
            $data['soclall_theme_resize'] = '100';
		}
        
        if (isset($this->request->post['soclall_ebay_site'])) {
			$data['soclall_ebay_site'] = $this->request->post['soclall_ebay_site'];
		} elseif($this->config->get('soclall_ebay_site')){
			$data['soclall_ebay_site'] = $this->config->get('soclall_ebay_site');
		} else {
            $data['soclall_ebay_site'] = 'US';
		}
        
        //**
        if (isset($this->request->post['soclall_theme_custom_text'])) {
			$data['soclall_theme_custom_text'] = $this->request->post['soclall_theme_custom_text'];
		} elseif($this->config->get('soclall_theme_custom_text')){
			$data['soclall_theme_custom_text'] = $this->config->get('soclall_theme_custom_text');
		} else $data['soclall_theme_custom_text'] = $this->language->get('text_default_theme_button');
        
        if (isset($this->request->post['soclall_theme_custom_col'])) {
			$data['soclall_theme_custom_col'] = $this->request->post['soclall_theme_custom_col'];
		} elseif($this->config->get('soclall_theme_custom_col')){
			$data['soclall_theme_custom_col'] = $this->config->get('soclall_theme_custom_col');
		} else $data['soclall_theme_custom_col'] = '1';
        
        if (isset($this->request->post['soclall_theme_custom_width'])) {
			$data['soclall_theme_custom_width'] = $this->request->post['soclall_theme_custom_width'];
		} elseif($this->config->get('soclall_theme_custom_width')){
			$data['soclall_theme_custom_width'] = $this->config->get('soclall_theme_custom_width');
		} else $data['soclall_theme_custom_width'] = '100';
        
        if (isset($this->request->post['soclall_theme_custom_align'])) {
			$data['soclall_theme_custom_align'] = $this->request->post['soclall_theme_custom_align'];
		} elseif($this->config->get('soclall_theme_custom_align')){
			$data['soclall_theme_custom_align'] = $this->config->get('soclall_theme_custom_align');
		} else $data['soclall_theme_custom_align'] = 'l';
        
        if (isset($this->request->post['soclall_theme_custom_position'])) {
			$data['soclall_theme_custom_position'] = $this->request->post['soclall_theme_custom_position'];
		} elseif($this->config->get('soclall_theme_custom_position')){
			$data['soclall_theme_custom_position'] = $this->config->get('soclall_theme_custom_position');
		} else $data['soclall_theme_custom_position'] = 'c';
        
        // Ebay Sites
        $data['ebay_sites'] = (new ReflectionClass('SoclallEbaySites'))->getConstants();
        
        // Networks
        $this->load->model('tool/image');
        
        $data['networks'] = array();
        
        $query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "soclall_network`");
        
        if($query->num_rows){
            foreach($query->rows as $network){                
                $data['networks'][] = array(
                    'name' => $network['network_name'],
                    'code' => $network['network_code']
                    );
            }
        }
        
        // Theme
        $data['theme'] = array('default','core','no3','no4','no5','no6','no7','no8');
        $data['themes_resize'] = array('no5','no6','no7');
        $data['theme_sizes'] = array('100','75','50');
        $data['themes_custom'] = array('no4','no7','no8');//**
        $data['themes_custom_position'] = array(
            'l' => $this->language->get('text_customize_left'), 
            'c' => $this->language->get('text_customize_center'), 
            'r' => $this->language->get('text_customize_right'));//**

        // New User Required
        $data['new_user_details'] = array(
            array('value' => 'firstname', 'text' => $this->language->get('entry_firstname')),
            array('value' => 'lastname', 'text' => $this->language->get('entry_lastname')),
            array('value' => 'telephone', 'text' => $this->language->get('entry_telephone')),
            array('value' => 'fax', 'text' => $this->language->get('entry_fax')),
            array('value' => 'company', 'text' => $this->language->get('entry_company')),
            array('value' => 'add', 'text' => $this->language->get('entry_address')),
            array('value' => 'city', 'text' => $this->language->get('entry_city')),
            array('value' => 'postcode', 'text' => $this->language->get('entry_post_code')),
            array('value' => 'country', 'text' => $this->language->get('entry_country')),
            array('value' => 'region', 'text' => $this->language->get('entry_region')));
            
        // Customer Group
        $this->load->model('customer/customer_group');
        
        $data['customer_groups'] = array();
        
        $customer_groups = $this->model_customer_customer_group->getCustomerGroups();
        foreach($customer_groups as $gr) {
            if(is_array($this->config->get('config_customer_group_display')) && in_array($gr['customer_group_id'], $this->config->get('config_customer_group_display'))){
                $data['customer_groups'][] = array(
                    'customer_group_id' => $gr['customer_group_id'],
                    'name' => $gr['name']);
            }
        }
        
		$data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');
		
        $this->response->setOutput($this->load->view('module/socl_login.tpl', $data));
    }
    
    private function validate(){
        if (!$this->user->hasPermission('modify', 'module/socl_login')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
        
        if (!$this->error) return true;
		else return false;
    }
}

?>