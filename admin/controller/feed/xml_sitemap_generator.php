<?php
/**
 * XML Sitemap Generator
 * 
 * @author  Cuispi
 * @version 1.0.1
 * @license Commercial License
 * @package admin
 * @subpackage  admin.controller.feed
 */

require_once DIR_SYSTEM . 'library/xml_sitemap_generator/xml_sitemap_generator.php';
require_once DIR_SYSTEM . 'library/xml_sitemap_generator/cli.php';

use XmlSitemapGenerator\XmlSitemapGenerator;
use XmlSitemapGenerator\Cli;

class ControllerFeedXmlSitemapGenerator extends Controller {

  /**
   * Development mode
   *
   * @var boolean True or false
   */
  private $dev = false;
  
  /**
   * The list of validation errors.
   *
   * @var array
   */
	private $error = array();

  /**
   * The code of this extension.
   *
   * @var string
   */  
  protected $code;

  /**
   * The short code of this extension.
   *
   * @var string
   */  
  protected $_code;
  
  /**
   * The partial path to the file of this extension.
   *
   * @var string
   */  
  protected $extension_path;
  
  /**
   * The instantiated model class name of this extension.
   *
   * @var string
   */  
  protected $model_name;
  
  /**
   * The key of the user token.
   *
   * @var string
   */  
  protected $user_token_key;
  
  /**
   * The value of the user token. 
   *
   * @var string
   */  
  protected $user_token_value;  
  
  /**
   * Holds the instance of the XmlSitemapGenerator class.
   *
   * @var class object
   */  
  protected $xml_sitemap_generator;
  
  /**
   * Holds the instance of the Cli class.
   *
   * @var class object
   */  
  protected $cli;

  /**
   * Holds error messages regarding the extension core library initialization.
   *
   * @var mixed Array or false  Defaults to false.
   */  
  protected $initialization_errors = false;  
  
  /**
   * Holds the Logger class instance.
   *
   * @var object
   */
  protected $logger;
  
  /**
   * Constructor.
   *
   * @param object $registry
   * @return void
   */
	public function __construct($registry) {
    parent::__construct($registry);
    
    if ($this->dev === true && function_exists('ini_set')) {
      ini_set('display_errors', 1);
    }
    
    try {
      if (!class_exists('XmlSitemapGenerator\XmlSitemapGenerator')) {
        throw new Exception('The XmlSitemapGenerator class cannot be found.'); 
      }
      
      $this->xml_sitemap_generator = new XmlSitemapGenerator($registry);
      
      if (!class_exists('XmlSitemapGenerator\Cli')) {
        throw new Exception('The Cli class cannot be found.'); 
      }
      
      $this->cli = new Cli();
    }
    catch (Exception $e) {
      exit($e->getMessage());
    }

    $class_name = strtolower(preg_replace('/(?<=\\w)([A-Z])/', '_\\1', __CLASS__));

    if (strpos($class_name, '_feed_') !== false) {
      list(, $code) = explode('_feed_', $class_name);
    } else {
      $code = null;
    }
    
    if (version_compare(VERSION, '3.0.0.0', '<')) { // OpenCart 2.3.0.2 or earlier.
      $this->code = $code;
      $this->_code = $code;
    } else { // OpenCart 3.0.0.0 or later.
      $this->code = 'feed_' . $code;
      $this->_code = $code;
    }
    
    if (version_compare(VERSION, '2.3.0.0', '<')) { // for OpenCart 2.2.0.0 or earlier.
      $this->extension_path = 'feed/' . $this->_code;
      $this->model_name = 'model_feed_' . $this->_code;
    } else {
      $this->extension_path = 'extension/feed/' . $this->_code;
      $this->model_name = 'model_extension_feed_' . $this->_code;
    }
    
    if (version_compare(VERSION, '3.0.0.0', '<')) { // OpenCart 2.3.0.2 or earlier.
      $this->user_token_key = 'token';
      $this->user_token_value = $this->session->data['token'];
    } else { // OpenCart 3.0.0.0 or later.
      $this->user_token_key = 'user_token';
      $this->user_token_value = $this->session->data['user_token'];
    }
    
    $this->logger = new Log($this->code . '.log');
	}

  /**
   * The index() implementation
   *
   * @param void
   * @return response
   */
	public function index() {    
    $this->language->load($this->extension_path);
    
    try {
      if (!class_exists('XmlSitemapGenerator\XmlSitemapGenerator')) {
        throw new Exception($this->language->get('error_library_not_loaded')); 
      }
    }
    catch (Exception $e) {
      $this->logger->write('The class XmlSitemapGenerator does not exist in ' . __FILE__ . ' line ' . __LINE__ . ': ' . $e->getMessage());
      $this->initialization_errors['error_library_not_loaded'] = $e->getMessage();
    }
    
    $this->load->model($this->extension_path);
    
		$this->document->setTitle($this->language->get('heading_title'));
    
    $data = array();
    
    // Scripts and Styles
    $this->document->addScript('view/javascript/' . $this->_code . '/es6-promise/4.1.1/es6-promise.min.js');
    $this->document->addScript('view/javascript/' . $this->_code . '/es6-promise/4.1.1/es6-promise.auto.min.js');
    
    $this->document->addScript('view/javascript/' . $this->_code . '/jquery.kh-cookie.min.js');
    
    $this->document->addScript('view/javascript/' . $this->_code . '/bootstrap-switch/3.3.2/js/bootstrap-switch.min.js');
    $this->document->addStyle('view/javascript/' . $this->_code . '/bootstrap-switch/3.3.2/css/bootstrap-switch.min.css');
    
    $this->document->addScript('view/javascript/' . $this->_code . '/bootstrap-multiselect/0.9.13/js/bootstrap-multiselect.min.js');
    $this->document->addStyle('view/javascript/' . $this->_code . '/bootstrap-multiselect/0.9.13/css/bootstrap-multiselect.min.css');
    
    // Core CSS and JS files of this extension.
    $this->document->addStyle('view/stylesheet/' . $this->_code . '/' . $this->_code . '.css');
    
    if (is_file(DIR_APPLICATION . 'view/javascript/' . $this->_code . '/' . $this->_code . (!$this->dev ? '.min' : '') . '.js')) {
      $this->document->addScript('view/javascript/' . $this->_code . '/' . $this->_code . (!$this->dev ? '.min' : '') . '.js' . ($this->dev ? '?'.  time() : ''));
    } else {
      $this->initialization_errors['error_admin_js_not_loaded'] = $this->language->get('error_admin_js_not_loaded');
    }    
    
    // Version
    $data['version'] = $this->xml_sitemap_generator->getVersion();
    
    // Heading title
    $data['heading_title'] = $this->language->get('heading_title');    
    
    // Text  
    $data['text_edit'] = $this->language->get('text_edit');
    $data['text_on'] = $this->language->get('text_on');
    $data['text_off'] = $this->language->get('text_off');    
    $data['text_enabled'] = $this->language->get('text_enabled');
    $data['text_disabled'] = $this->language->get('text_disabled');
    $data['text_status'] = $this->language->get('text_status');
    $data['text_general'] = $this->language->get('text_general');
    $data['text_page_stores_all_selected'] = $this->language->get('text_page_stores_all_selected');
    $data['text_page_stores_non_selected'] = $this->language->get('text_page_stores_non_selected');
    $data['text_confirm_remove_page'] = $this->language->get('text_confirm_remove_page');
    $data['text_confirm_delete_pages'] = $this->language->get('text_confirm_delete_pages');
    $data['text_page_search'] = $this->language->get('text_page_search');
    $data['text_page_no_results'] = $this->language->get('text_page_no_results');
    $data['text_page_new'] = $this->language->get('text_page_new');
    
    // Column
    $data['column_name'] = $this->language->get('column_name');
    $data['column_changefreq'] = $this->language->get('column_changefreq');
    $data['column_priority'] = $this->language->get('column_priority');
    $data['column_url_limit'] = $this->language->get('column_url_limit');
    $data['column_lastmod'] = $this->language->get('column_lastmod');
    $data['column_action'] = $this->language->get('column_action');
    $data['column_page_id'] = $this->language->get('column_page_id');
    $data['column_url'] = $this->language->get('column_url');
    $data['column_stores'] = $this->language->get('column_stores');
    $data['column_status'] = $this->language->get('column_status');
    $data['column_date_added'] = $this->language->get('column_date_added');
    
    // Entry
    $data['entry_config_status'] = $this->language->get('entry_config_status');
    $data['entry_config_js_debug'] = $this->language->get('entry_config_js_debug');
    $data['entry_config_use_xsl_stylesheets'] = $this->language->get('entry_config_use_xsl_stylesheets');
    $data['entry_config_append_lang_param'] = $this->language->get('entry_config_append_lang_param');
    $data['entry_config_use_hreflang'] = $this->language->get('entry_config_use_hreflang');
    $data['entry_config_image_width'] = $this->language->get('entry_config_image_width');
    $data['entry_config_image_height'] = $this->language->get('entry_config_image_height');
    $data['entry_config_max_execution_time'] = $this->language->get('entry_config_max_execution_time');
    $data['entry_page_url'] = $this->language->get('entry_page_url');
    $data['entry_page_stores'] = $this->language->get('entry_page_stores');
    $data['entry_page_status'] = $this->language->get('entry_page_status');
    
    // Help
		$data['help_config_status'] = $this->language->get('help_config_status');
    $data['help_config_js_debug'] = $this->language->get('help_config_js_debug');
    $data['help_config_use_xsl_stylesheets'] = $this->language->get('help_config_use_xsl_stylesheets');
    $data['help_config_append_lang_param'] = $this->language->get('help_config_append_lang_param');
    $data['help_config_use_hreflang'] = $this->language->get('help_config_use_hreflang');
    $data['help_config_image_width'] = $this->language->get('help_config_image_width');
    $data['help_config_image_height'] = $this->language->get('help_config_image_height');
    $data['help_config_max_execution_time'] = $this->language->get('help_config_max_execution_time');
    
    // Button
    $data['button_save'] = $this->language->get('button_save');
    $data['button_save_and_close'] = $this->language->get('button_save_and_close');
    $data['button_cancel'] = $this->language->get('button_cancel');
    $data['button_generat_sitemap'] = $this->language->get('button_generat_sitemap');
    $data['button_generat_sitemaps'] = $this->language->get('button_generat_sitemaps');
    $data['button_add'] = $this->language->get('button_add');
    $data['button_edit'] = $this->language->get('button_edit');
    $data['button_delete'] = $this->language->get('button_delete');
    $data['button_remove'] = $this->language->get('button_remove');
    $data['button_apply'] = $this->language->get('button_apply');
    $data['button_discard'] = $this->language->get('button_discard');
    $data['button_save_configuration'] = $this->language->get('button_save_configuration');

    // Tab
    $data['tab_sitemap_settings'] = $this->language->get('tab_sitemap_settings');
    $data['tab_view_sitemap'] = $this->language->get('tab_view_sitemap');
    $data['tab_pages'] = $this->language->get('tab_pages');
    $data['tab_config'] = $this->language->get('tab_config');
    $data['tab_help'] = $this->language->get('tab_help');
    
		// Success
		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];
			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}
    
    // Warning
		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}
    
    // Initialization errors
    if ($this->initialization_errors) {
      $data['initialization_errors'] = $this->initialization_errors;
    } else {
      $data['initialization_errors'] = false;
    }    
    
    // Breadcrumbs
		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
        'text' => $this->language->get('text_home'),
        'href' => $this->url->link('common/dashboard', $this->user_token_key . '=' . $this->user_token_value, true)
		);
    
    if (version_compare(VERSION, '2.3.0.0', '<')) { // OpenCart 2.2.0.0 or earlier.
      $data['breadcrumbs'][] = array(
          'text' => $this->language->get('text_feed'),
          'href' => $this->url->link('extension/feed', $this->user_token_key . '=' . $this->user_token_value, true)
      );
    } elseif (version_compare(VERSION, '3.0.0.0', '<')) { // OpenCart 2.3.0.2 or earlier.
      $data['breadcrumbs'][] = array(
          'text' => $this->language->get('text_extension'),
          'href' => $this->url->link('extension/extension', $this->user_token_key . '=' . $this->user_token_value . '&type=feed', true)
      );    
    } else { // OpenCart 3.0.0.0 or later.
      $data['breadcrumbs'][] = array(
          'text' => $this->language->get('text_extension'),
          'href' => $this->url->link('marketplace/extension', $this->user_token_key . '=' . $this->user_token_value . '&type=feed', true)
      );    
    }     

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link($this->extension_path, $this->user_token_key . '=' . $this->user_token_value, true)
		);

    // Action
		$data['action'] = $this->url->link($this->extension_path, $this->user_token_key . '=' . $this->user_token_value, true);

    // Cancel
    if (version_compare(VERSION, '2.3.0.0', '<')) { // OpenCart 2.2.0.0 or earlier.
      $data['cancel'] = $this->url->link('extension/module', $this->user_token_key . '=' . $this->user_token_value, true);
    } elseif (version_compare(VERSION, '3.0.0.0', '<')) { // OpenCart 2.3.0.2 or earlier.
      $data['cancel'] = $this->url->link('extension/extension', $this->user_token_key . '=' . $this->user_token_value . '&type=feed', true);
    } else { // OpenCart 3.0.0.0 or later.
      $data['cancel'] = $this->url->link('marketplace/extension', $this->user_token_key . '=' . $this->user_token_value . '&type=feed', true);
    }
    
    //
    // Sitemap Settings
    // --------------------------------------------------
    
    $sitemap_settings = $this->{$this->model_name}->getSitemapSettings();
      
    $data['sitemap_settings'] = array();
    
    foreach($sitemap_settings as $sitemap_setting) {
      $sitemap_setting_stores = $this->{$this->model_name}->getSitemapSettingStores($sitemap_setting['type']);
      
      $_sitemap_settings[] = array(
          'name' => $this->language->get('text_type_' . $sitemap_setting['type']),
          'type' => $sitemap_setting['type'],
          'changefreq' => $sitemap_setting['changefreq'],
          'priority' => $sitemap_setting['priority'],
          'lastmod' => $sitemap_setting['lastmod'] ? date($this->language->get('datetime_format'), strtotime($sitemap_setting['lastmod'])) : null,
          'url_limit' => (int)$sitemap_setting['url_limit'],
          'sort_order' => (int)$sitemap_setting['sort_order'],
          'date_added' => $sitemap_setting['date_added'],
          'date_modified' => $sitemap_setting['date_modified'],
          'stores' => $sitemap_setting_stores,
      );
    }
    
    $data['sitemap_settings'] = $_sitemap_settings;    
    
    $data['changefreqs'] = array('always', 'hourly', 'daily', 'weekly', 'monthly', 'yearly', 'never');
    
    $data['priorities'] = array('1.0', '0.9', '0.8', '0.7', '0.6', '0.5', '0.4', '0.3', '0.2', '0.1', '0.0');
    
    // Get stores.
    $this->load->model('setting/store');

    $stores = array_merge(array(array(
        'store_id' => 0,
        'name' => $this->config->get('config_name'),
        'url' => HTTP_CATALOG,
        'ssl' => HTTPS_CATALOG
    )), $this->model_setting_store->getStores());    
    
    $data['stores'] = $stores;    
    
    //
    // Pages
    // --------------------------------------------------

    if ($this->xml_sitemap_generator->isAjax()) {
      return $this->get_pages();
    }
    
    //
    // Config
    // --------------------------------------------------

    $config_data = array(
        $this->code . '_status' => false,
        $this->code . '_config' => array(
            'js_debug' => false,
            'use_xsl_stylesheets' => true,
            'append_lang_param' => false,
            'use_hreflang' => true,
            'image_width' => 500,
            'image_height' => 500,
            'max_execution_time' => 600,
        ),
    );
    
    $extension_status = (bool)$this->config->get($this->code . '_status');
    $config_info = (array)$this->config->get($this->code . '_config');

		if (count($this->request->post)) {
			$config_data = array_merge($config_data, $this->request->post['config']);
      
    } elseif (!empty($config_info)) {
      $config_data = array_replace_recursive($config_data, array_merge(array(
          $this->code . '_status' => $extension_status,
          $this->code . '_config' => $config_info
      )));
    }
       
    $data['config'] = $config_data;
    
    //
    // Misc
    // --------------------------------------------------

		$data['code'] = $this->code;
		$data['_code'] = $this->_code;
    
    $data['dev'] = $this->dev;
    
		$data['extension_path'] = $this->extension_path;
    
		$data['user_token_key'] = $this->user_token_key;
		$data['user_token_value'] = $this->user_token_value;
    
		$data['base_sitemap_index_url'] = $this->xml_sitemap_generator->getBaseSitemapIndexUrl();
    
    
		if (isset($this->request->post['config'][$this->code . '_lic'])) {
			$lic_data = $this->request->post['config'][$this->code . '_lic'];
		} else {
      $lic_data = $this->config->get($this->code . '_lic');
		}
    
    $data['config'][$this->code . '_lic'] = $lic_data;
    
    $data['lic_key'] = $lic_data['key'];
    
    $data['server_name'] = $_SERVER['SERVER_NAME'] ? $_SERVER['SERVER_NAME'] : $_SERVER['HTTP_HOST'];
    $data['admin_language'] = $this->config->get('config_admin_language');
    $data['date_default_timezone'] = date_default_timezone_get();
    $data['server_addr'] = isset($_SERVER['LOCAL_ADDR']) ? $_SERVER['LOCAL_ADDR'] : $_SERVER['SERVER_ADDR'];
    
    $data['copyright_notice_year'] = call_user_func(function($y) {
      $c = date('Y');
      return $y . (($y != $c) ? '-' . $c : '');
    }, 2018);    
    
    //
    // Template
    // --------------------------------------------------       

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
        
    if (version_compare(VERSION, '2.2.0.0', '<')) { // for OpenCart 2.1.0.2 or earlier.
      $this->response->setOutput($this->load->view($this->extension_path . '.tpl', $data));      
    } else {
      $this->response->setOutput($this->load->view($this->extension_path, $data));    
    }  
	}
  
  /**
   * Update the sitemap setting of a given type.
   *
   * @param void
   * @return response
   */
	public function update_sitemap_setting() {
    if (!$this->xml_sitemap_generator->isAjax()) {
      return false;
    }
    
    $data = array(
        'status' => false,
        'message' => '',
        'data' => array(
            'changefreq' => null,
            'priority' => null,
            'url_limit' => null,
            'lastmod' => null,
        ),
    );    
    
    $this->language->load($this->extension_path);
    $this->load->model($this->extension_path);
    
    if (!$this->user->hasPermission('modify', $this->extension_path)) {
      $data['message'] = $this->language->get('error_permission');

    } elseif ($this->xml_sitemap_generator->isProcessLocked()) {
      $data['message'] = $this->language->get('error_process_locked');
      
    } else {
      $this->{$this->model_name}->updateSitemapSetting($this->request->post['type'], $this->request->post['data']);
      
      $data['status'] = true;
      $data['message'] = $this->language->get('text_sitemap_setting_success');
    }
    
    $sitemapSetting = $this->{$this->model_name}->getSitemapSetting($this->request->post['type']);
    $sitemapSettingStore = $this->{$this->model_name}->getSitemapSettingStores($this->request->post['type']);
    
    $data['data']['changefreq'] = $sitemapSetting['changefreq'];
    $data['data']['priority'] = $sitemapSetting['priority'];
    $data['data']['url_limit'] = (int)$sitemapSetting['url_limit'];
    $data['data']['lastmod'] = $sitemapSetting['lastmod'] ? date($this->language->get('datetime_format'), strtotime($sitemapSetting['lastmod'])) : null;
    $data['data']['sitemap_setting_store'] = $sitemapSettingStore;
    
		$this->response->setOutput(json_encode($data));
	}
  
  /**
   * Get a list of pages.
   *
   * @param void
   * @return response
   */
	public function get_pages() {    
    if (!$this->xml_sitemap_generator->isAjax()) {
      return false;
    }
    
    $data = array();
    
		$data['pages'] = array();
    
 		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'name';
		}

		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = 'DESC';
		}

		if (isset($this->request->get['search'])) {
			$search = $this->request->get['search'];
		} else {
			$search = '';
		}

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}
    
    //$limit = $this->config->get('config_limit_admin');
    $limit = 10;    
    
		$url = '';

		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

		if (isset($this->request->get['search'])) {
			$url .= '&search=' . $this->request->get['search'];
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['sort_page_id'] = $this->url->link('extension/feed/xml_sitemap_generator', $this->user_token_key . '=' . $this->user_token_value . '&sort=page_id' . $url, true);
		$data['sort_url'] = $this->url->link('extension/feed/xml_sitemap_generator', $this->user_token_key . '=' . $this->user_token_value . '&sort=url' . $url, true);
		$data['sort_status'] = $this->url->link('extension/feed/xml_sitemap_generator', $this->user_token_key . '=' . $this->user_token_value . '&sort=status' . $url, true);
		$data['sort_date_added'] = $this->url->link('extension/feed/xml_sitemap_generator', $this->user_token_key . '=' . $this->user_token_value . '&sort=date_added' . $url, true);
    
		$filter_data = array(
        'sort'  => $sort,
        'order' => $order,
        'search' => $search,
        'start' => ($page - 1) * $limit,
        'limit' => $limit
		);
    
    $this->load->model($this->extension_path);
    
		$page_total = $this->{$this->model_name}->getTotalPages($filter_data);

		$results = $this->{$this->model_name}->getPages($filter_data);    
    
		foreach ($results as $result) {
      $page_stores = $this->{$this->model_name}->getPageStores($result['page_id']);

			$data['pages'][] = array(
          'page_id' => $result['page_id'],
          'url' => $result['url'],
          'status' => (bool)$result['status'],
          'date_added' => date($this->language->get('date_format_short'), strtotime($result['date_added'])),
          'date_modified' => date($this->language->get('date_format_short'), strtotime($result['date_modified'])),
          'stores' => $page_stores,
			);
		}
    
		$url = '';
    
		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}
    
		if (isset($this->request->get['search'])) {
			$url .= '&search=' . $this->request->get['search'];
		}    
 
		$pagination = new Pagination();
		$pagination->total = $page_total;
		$pagination->page = $page;
		$pagination->limit = $limit;
		$pagination->url = $this->url->link('extension/feed/xml_sitemap_generator', $this->user_token_key . '=' . $this->user_token_value . $url . '&page={page}', true);

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), 
      ($page_total) ? (($page - 1) * $limit) + 1 : 0, 
      ((($page - 1) * $limit) > ($page_total - $limit)) ? $page_total : ((($page - 1) * $limit) + $limit), 
      $page_total, ceil($page_total / $limit)
    );

		$data['sort'] = $sort;
		$data['order'] = $order;
		$data['search'] = $search; 
    
		$this->response->setOutput(json_encode($data));
	}
  
  /**
   * Create a new page or update the page of a given page ID.
   *
   * @param void
   * @return response
   */
	public function save_page() {
    if (!$this->xml_sitemap_generator->isAjax()) {
      return false;
    }
    
    $data = array(
        'status' => false,
        'message' => '',
        'data' => array(
            'page_id' => null,
            'url' => null,
            'status' => null,
            'date_added' => null,
            'date_modified' => null,
            'page_store' => null,
        ),   
    );
    
    $this->language->load($this->extension_path);
    $this->load->model($this->extension_path);
    
    if (!$this->user->hasPermission('modify', $this->extension_path)) {
      $data['message'] = $this->language->get('error_permission');
      
    } elseif ($this->xml_sitemap_generator->isProcessLocked()) {
      $data['message'] = $this->language->get('error_process_locked');
      
    } else {
      if (!(isset($this->request->post['page_id']) && $this->request->post['page_id'])) {
        $page_id = $this->{$this->model_name}->addPage($this->request->post['data']);
      } else {
        $page_id = $this->{$this->model_name}->updatePage($this->request->post['page_id'], $this->request->post['data']);
      }

      $data['status'] = true;
      $data['message'] = $this->language->get('text_page_save_success');
      
      if (isset($page_id) && is_numeric($page_id)) {
        $page = $this->{$this->model_name}->getPage($page_id);
        $pageStore = $this->{$this->model_name}->getPageStores($page_id);

        $data['data']['page_id'] = (int)$page['page_id'];      
        $data['data']['url'] = html_entity_decode($page['url']);      
        $data['data']['status'] = (bool)$page['status']; 
        $data['data']['date_added'] = $page['date_added'] ? date($this->language->get('date_format_short'), strtotime($page['date_added'])) : null;
        $data['data']['date_modified'] = $page['date_modified'] ? date($this->language->get('date_format_short'), strtotime($page['date_modified'])) : null;
        $data['data']['page_store'] = $pageStore;
      }
    }
    
		$this->response->setOutput(json_encode($data));
	}
  
  /**
   * Delete the page of a given page ID.
   *
   * @param void
   * @return response
   */
	public function delete_page() {
    if (!$this->xml_sitemap_generator->isAjax()) {
      return false;
    }
    
    $data = array(
        'status' => false,
        'message' => '',
        'data' => array(
            'page_id' => null,
        ),
    );
    
    $this->language->load($this->extension_path);
    
    if (!$this->user->hasPermission('modify', $this->extension_path)) {
      $data['message'] = $this->language->get('error_permission');
      
    } elseif ($this->xml_sitemap_generator->isProcessLocked()) {
      $data['message'] = $this->language->get('error_process_locked');
      
    } else {
      $this->load->model($this->extension_path);

      $this->{$this->model_name}->deletePage($this->request->post['page_id']);

      $data['status'] = true;
      $data['message'] = $this->language->get('text_page_delete_success');
      $data['data']['page_id'] = (int)$this->request->post['page_id'];
    }
    
		$this->response->setOutput(json_encode($data));
	}
  
  /**
   * Delete selected pages.
   *
   * @param void
   * @return response
   */
	public function delete_pages() {
    if (!$this->xml_sitemap_generator->isAjax()) {
      return false;
    }
    
    $data = array(
        'status' => false,
        'message' => '',
        'data' => array(
            'page_ids' => null,
        ),
    );    
    
    $this->language->load($this->extension_path);
    
    if (!$this->user->hasPermission('modify', $this->extension_path)) {
      $data['message'] = $this->language->get('error_permission');
      
    } elseif ($this->xml_sitemap_generator->isProcessLocked()) {
      $data['message'] = $this->language->get('error_process_locked');
      
    } elseif (!(isset($this->request->post['page_ids']) && $this->request->post['page_ids'])) {
      $data['message'] = $this->language->get('error_no_page_link_selected');
      
    } else {
      $this->load->model($this->extension_path);

      foreach ($this->request->post['page_ids'] as $page_id) {
        $this->{$this->model_name}->deletePage($page_id);
      }

      $data['status'] = true;
      $data['message'] = count($this->request->post['page_ids']) > 1 ? $this->language->get('text_pages_delete_success') : $this->language->get('text_page_delete_success');
      $data['data']['page_ids'] = $this->request->post['page_ids'];      
    }
    
    
		$this->response->setOutput(json_encode($data));
	}
  
  /**
   * Save the configuration.
   *
   * @param void
   * @return response
   */
	public function save_config() {
    if (!$this->xml_sitemap_generator->isAjax()) {
      return false;
    }
    
    $data = array(
        'status' => false,
        'message' => '',
        'data' => array(
            'status' => null,
            'js_debug' => null,
            'use_xsl_stylesheets' => null,
            'append_lang_param' => null,
            'use_hreflang' => null,
            'image_width' => null,
            'image_height' => null,            
            'max_execution_time' => null,
        ),
    );
    
    $this->language->load($this->extension_path);
    
    if (!$this->user->hasPermission('modify', $this->extension_path)) {
      $data['message'] = $this->language->get('error_permission');
      
    } elseif ($this->xml_sitemap_generator->isProcessLocked()) {
      $data['message'] = $this->language->get('error_process_locked');
      
    } elseif (is_numeric($this->request->post['image_width']) && $this->request->post['image_width'] > 1000) {
      $data['message'] = sprintf($this->language->get('error_image_width_max_value'), 1000);
      
    } elseif (is_numeric($this->request->post['image_height']) && $this->request->post['image_height'] > 1000) {
      $data['message'] = sprintf($this->language->get('error_image_height_max_value'), 1000);
      
    } elseif (is_numeric($this->request->post['image_width']) && $this->request->post['image_width'] < 0) {
      $data['message'] = $this->language->get('error_image_width_negative_value');
      
    } elseif (is_numeric($this->request->post['image_height']) && $this->request->post['image_height'] < 0) {
      $data['message'] = $this->language->get('error_image_height_negative_value');
      
    } else {
      $this->language->load($this->extension_path);
      
      $config_data = array(
          $this->code . '_status' => $this->request->post['status'],
          $this->code . '_config' => array(
              'js_debug' => (bool)$this->request->post['js_debug'],
              'use_xsl_stylesheets' => (bool)$this->request->post['use_xsl_stylesheets'],
              'append_lang_param' => (bool)$this->request->post['append_lang_param'],
              'use_hreflang' => (bool)$this->request->post['use_hreflang'],
              'image_width' => (int)$this->request->post['image_width'],
              'image_height' => (int)$this->request->post['image_height'],              
              'max_execution_time' => is_numeric($this->request->post['max_execution_time']) ? (int)$this->request->post['max_execution_time'] : 600,
          ),
          $this->code . '_version' => $this->xml_sitemap_generator->getVersion(),
          $this->code . '_lic' => $this->config->get($this->code . '_lic'),
      );
      
      $this->load->model('setting/setting');
      $this->model_setting_setting->editSetting($this->code, $config_data);


      $sitemap_dir_path = $this->xml_sitemap_generator->getSitemapDirPath();

      if ((bool)$this->request->post['status'] === true) {
        if (is_dir($sitemap_dir_path . '_') && !is_dir($sitemap_dir_path)) {
          rename($sitemap_dir_path . '_', $sitemap_dir_path);
        }   
      } else {
        if (is_dir($sitemap_dir_path) && !is_dir($sitemap_dir_path . '_')) {
          rename($sitemap_dir_path, $sitemap_dir_path . '_');
        }    
      }

      $data['status'] = true;
      $data['message'] = $this->language->get('text_success');
      $data['data'] = array(
          'status' => (bool)$this->request->post['status'],
          'js_debug' => (bool)$this->request->post['js_debug'],
          'use_xsl_stylesheets' => (bool)$this->request->post['use_xsl_stylesheets'],
          'append_lang_param' => (bool)$this->request->post['append_lang_param'],
          'use_hreflang' => (bool)$this->request->post['use_hreflang'],
          'image_width' => $this->request->post['image_width'],
          'image_height' => $this->request->post['image_height'],          
          'max_execution_time' => $this->request->post['max_execution_time'],
      );
    }
    
		$this->response->setOutput(json_encode($data));
	}
  
  /**
   * Create a queue.
   *
   * @param void
   * @return response
   */
	public function create_queue() {
    if (!$this->xml_sitemap_generator->isAjax()) {
      return false;
    }
    
    $data = array(
        'status' => false,
        'message' => '',
        'data' => array(
            'queue_id' => null,
            'params' => null,
        ),
    );

    $this->language->load($this->extension_path);
    
    if (!$this->user->hasPermission('modify', $this->extension_path)) {
      $data['message'] = $this->language->get('error_permission');
      
    } elseif ($this->xml_sitemap_generator->isProcessLocked()) {
      $data['message'] = $this->language->get('error_process_locked');
      
    } elseif (!(isset($this->request->post['tasks']) && $this->request->post['tasks'])) {
      $data['message'] = $this->language->get('error_no_task_selected');
      
    } else {
      $this->load->model($this->extension_path);
      
      $params = array(
          'tasks' => (array)$this->request->post['tasks']
      );
      
      $queue_id = $this->{$this->model_name}->createQueue($params);

      $data['status'] = true;
      $data['data']['queue_id'] = $queue_id;
      $data['data']['params'] = $params;
    }
    
		$this->response->setOutput(json_encode($data));
	}
  
  /**
   * Get the next task in a queue.
   *
   * @param void
   * @return response
   */
	public function get_next_task() {
    if (!$this->xml_sitemap_generator->isAjax()) {
      return false;
    }
    
    $data = array(
        'status' => false,
        'message' => '',
        'data' => array(
            'queue_id' => null,
            'next_task' => null,
        ),
    );

    $this->language->load($this->extension_path);
    
    if (!$this->user->hasPermission('modify', $this->extension_path)) {
      $data['message'] = $this->language->get('error_permission');
      
    } elseif ($this->xml_sitemap_generator->isProcessLocked()) {
      $data['message'] = $this->language->get('error_process_locked');
      
    } else {
      $this->load->model($this->extension_path);
      $next_task = $this->{$this->model_name}->getNextTask($this->request->post['task'], $this->request->post['queue_id']);
      
      $data['status'] = true;
      $data['data']['queue_id'] = $this->request->post['queue_id'];
      $data['data']['next_task'] = $next_task;
    }
    
		$this->response->setOutput(json_encode($data));
	}
  
  /**
   * Create a process.
   *
   * @param void
   * @return response
   */
	public function create_process() {
    if (!$this->xml_sitemap_generator->isAjax()) {
      return false;
    }
    
    $data = array(
        'status' => false,
        'message' => '',
        'has_process' => false,
        'data' => array(
            'process_id' => null,
            'type' => null,
            'params' => null,
            'progress_message' => '',
        ),
    );
    
    $this->language->load($this->extension_path);
    $this->load->model($this->extension_path);
    
    if (!$this->user->hasPermission('modify', $this->extension_path)) {
      $data['message'] = $this->language->get('error_permission');
      
    } elseif ($this->xml_sitemap_generator->isProcessLocked()) {
      $data['message'] = $this->language->get('error_process_locked');
      
    } elseif ($this->{$this->model_name}->hasProcess($this->request->post['queue_id'], $this->request->post['type'])) {
      $data['has_process'] = true;
      $data['data']['type'] = $this->request->post['type'];
      
    } else {
      $sitemap_setting = $this->{$this->model_name}->getSitemapSetting($this->request->post['type']);
      $sitemap_setting_stores = $this->{$this->model_name}->getSitemapSettingStores($this->request->post['type']);
      $config = $this->config->get($this->code . '_config');
      
      if (function_exists('ini_set')) {
        ini_set('max_execution_time', $config['max_execution_time']);
      }
      
      $params = array(
          'type' => $sitemap_setting['type'],
          'changefreq' => $sitemap_setting['changefreq'],
          'priority' => $sitemap_setting['priority'],
          'url_limit' => $sitemap_setting['url_limit'],
          'stores' => $sitemap_setting_stores,
          'use_xsl_stylesheets' => (bool)$config['use_xsl_stylesheets'],
          'append_lang_param' => (bool)$config['append_lang_param'],
          'use_hreflang' => (bool)$config['use_hreflang'],
          'image_width' => (int)$config['image_width'],
          'image_height' => (int)$config['image_height'],
          'max_execution_time' => ini_get('max_execution_time'),
      );

      $process_id = $this->{$this->model_name}->createProcess($this->request->post['type'], $params, $this->request->post['queue_id']);

      $data['status'] = true;
      $data['data']['process_id'] = $process_id;
      $data['data']['type'] = $sitemap_setting['type'];
      $data['data']['params'] = $params;
      $data['data']['progress_message'] = sprintf($this->language->get('text_progress_message_preparing'), $this->language->get('text_type_'. $this->request->post['type']));
    }
    
		$this->response->setOutput(json_encode($data));
	}
  
  /**
   * Generates the XML sitemap files of the given process ID.
   *
   * @param void
   * @return response
   */
	public function generate_sitemap() {
    if (!$this->xml_sitemap_generator->isAjax()) {
      return false;
    }
    
    $data = array(
        'status' => false,
        'message' => '',
        'data' => array(
            'type' => null,
            'progress' => 0,
            'errors' => null,
            'prepared' => null,
            'lastmod' => null,
        ),
    );

    $this->language->load($this->extension_path);
    
    if (!$this->user->hasPermission('modify', $this->extension_path)) {
      $data['message'] = $this->language->get('error_permission');    
      
    } elseif (!(isset($this->request->post['process_id']) && is_numeric($this->request->post['process_id']))) {
      $data['message'] = $this->language->get('error_process_id');  
      
    } else {
      $this->load->model($this->extension_path);
      $result = $this->xml_sitemap_generator->generateSitemap((int)$this->request->post['process_id']);
      
      $data['status'] = $result['status'];
      $data['message'] = $result['message'];
      $data['data']['type'] = $result['data']['type'];
      $data['data']['progress'] = $result['data']['progress'];
      $data['data']['errors'] = $result['data']['errors'];
      $data['data']['prepared'] = (bool)$result['data']['prepared'];
      $data['data']['lastmod'] = $result['data']['lastmod'];
      
      $errors = $this->xml_sitemap_generator->getErrors((int)$this->request->post['process_id']);
      
      if ($errors) {
        foreach($errors as $error) {
          $this->logger->write($error['message'] . ': ' . $error['method'] . ' on ' . $error['line'] . ' in ' . $error['file']);
        }
      }
    }
    
		$this->response->setOutput(json_encode($data));
	}

  /**
   * Check the progress of a given process.
   *
   * @param void
   * @return response
   */
	public function check_progress() {
    if (!$this->xml_sitemap_generator->isAjax()) {
      return false;
    }
    
    $this->language->load($this->extension_path);
    
    $this->load->model($this->extension_path);
    
    $process = $this->{$this->model_name}->getProcess($this->request->post['process_id']);
    
    $status = $message = $errors = null;
    
    $_errors = $this->xml_sitemap_generator->getErrors($process['process_id']);
    
    if ($_errors) {
      foreach($_errors as $error) {
        $errors[] = sprintf($this->language->get('text_log_message'), $error['message'], $error['method'], $error['line'], $error['file']);
      }
    }

    if (!$_errors && (int)$process['progress'] === 100 && (bool)$process['finalized'] === false) {
      
      $this->{$this->model_name}->updateProcessFinalized($process['process_id'], true);
      
      $status = true;
      $message = sprintf($this->language->get('text_sitemap_created'), $this->language->get('text_type_'. $process['type']));
      $this->logger->write(sprintf($this->language->get('text_log_message'), 'Info: ' . $message, __METHOD__, __LINE__, __FILE__));      
      
    } elseif ($_errors) {
      $status = false;
      $message = $this->language->get('error_failed_to_create_sitemaps');
      $this->logger->write(sprintf($this->language->get('text_log_message'), 'Error: ' . $message, __METHOD__, __LINE__, __FILE__));
      
    } else {
      $status = true;
      $message = false;
    }     
    
    if ((bool)$process['prepared'] === true) {
      $progress_message = sprintf($this->language->get('text_progress_message_generating'), $this->language->get('text_type_'. $process['type']));
      $progress_items_completed = sprintf($this->language->get('text_progress_items_completed'), (int)$process['completed'], (int)$process['total']);
      
      $start_time = $process['start_time'];
      $now = time();
      
      if ((int)$process['completed'] > 0) {
        $rate = ($now - $start_time) / (int)$process['completed'];
      } else {
        $rate = $now - $start_time;
      }
      
      $_elapsed = $now - $start_time;
      
      $left = (int)$process['total'] - (int)$process['completed'];
      $_remaining = round($rate * $left, 2);
      
      $elapsed = $this->xml_sitemap_generator->toTime($_elapsed);
      $remaining = $this->xml_sitemap_generator->toTime($_remaining);
      
      $progress_time_reporting = sprintf($this->language->get('text_progress_time_reporting'), $elapsed, $remaining);
      
    } else {
      $progress_message = '';
      $progress_items_completed = '';
      $progress_time_reporting = '';
    }
    
    $lastmod = $this->{$this->model_name}->getSitemapSettingLastmod($process['type']);
    
    $data = array(
        'status' => $status,
        'message' => $message,
        'data' => array(
            'type' => $process['type'],
            'progress' => (int)$process['progress'],
            'errors' => $errors,
            'prepared' => (bool)$process['prepared'],
            'finalized' => (bool)$process['finalized'],
            'end_time' => $process['end_time'],
            'lastmod' => $lastmod ? date($this->language->get('datetime_format'), strtotime($lastmod)) : null,
            'progress_message' => $progress_message,
            'progress_items_completed' => $progress_items_completed,
            'progress_time_reporting' => $progress_time_reporting,
        ),
    );
    
		$this->response->setOutput(json_encode($data));
	}
  
  /**
   * Generate the XML sitemap files for Products through the command line.
   *
   * @param void
   * @return void
   */  
	public function cli_generate_sitemap_product() {
    $this->_cli_generate_sitemap('product');
	}    
  
  /**
   * Generate the XML sitemap files for Categories through the command line.
   *
   * @param void
   * @return void
   */  
	public function cli_generate_sitemap_category() {
    $this->_cli_generate_sitemap('category');
	}    
  
  /**
   * Generate the XML sitemap files for Manufacturers through the command line.
   *
   * @param void
   * @return void
   */  
	public function cli_generate_sitemap_manufacturer() {
    $this->_cli_generate_sitemap('manufacturer');
	}    
  
  /**
   * Generate the XML sitemap files for Information through the command line.
   *
   * @param void
   * @return void
   */  
	public function cli_generate_sitemap_information() {
    $this->_cli_generate_sitemap('information');
	}
  
  /**
   * Generate the XML sitemap files for Pages through the command line.
   *
   * @param void
   * @return void
   */  
	public function cli_generate_sitemap_page() {
    $this->_cli_generate_sitemap('page');
	}
  
  /**
   * Generate the XML sitemap files for Products, Categories, Manufacturers, Information, and Pages through the command line all at one time.
   *
   * @param void
   * @return void
   */
	public function cli_generate_sitemap_all() {
    $start_time = microtime(true);
    
    $this->cli_generate_sitemap_product();
    $this->cli_generate_sitemap_category();
    $this->cli_generate_sitemap_manufacturer();
    $this->cli_generate_sitemap_information();
    $this->cli_generate_sitemap_page();
    
    $end_time = microtime(true);
    $time_diff = $end_time - $start_time;
    
    $this->language->load($this->extension_path);
    
    $this->cli->out(gmdate('Y-m-d H:i:s') . ' - Info: Total time elapsed for all tasks: '. $this->cli->toTime($time_diff) . ' (' . $time_diff . ')');
    $this->logger->write(sprintf($this->language->get('text_log_message'), 'Info: Total time elapsed for all tasks: '. $this->cli->toTime($time_diff) . ' (' . $time_diff . ')', __METHOD__, __LINE__, __FILE__));
	}
  
  /**
   * Generate the XML sitemap files of a given type through the command line.
   *
   * @param string $type
   * @return void
   */  
	private function _cli_generate_sitemap($type) {
    $this->language->load($this->extension_path);

    if ($this->xml_sitemap_generator->isProcessLocked()) {
      $this->cli->out(gmdate('Y-m-d H:i:s') . ' - ' . $this->language->get('error_process_locked'));
      $this->logger->write($this->language->get('error_process_locked') . ': ' . __METHOD__ . ' on ' . __LINE__ . ' in ' . __FILE__);
      exit(-1);
    }
    
    if (php_sapi_name() != 'cli') {
      $this->logger->write(sprintf($this->language->get('text_log_message'), 'Error: Attempted to call method ' . __METHOD__ . ' by non-CLI means.', __METHOD__, __LINE__, __FILE__));
      
      http_response_code(400);
      exit(-1);
    }
    
    if (!$this->config->get($this->code . '_status')) {
      $this->cli->out(gmdate('Y-m-d H:i:s') . ' - Error: The XML Sitemap Generator extension is not enabled.');
      $this->logger->write(sprintf($this->language->get('text_log_message'), 'Error: The XML Sitemap Generator extension is not enabled.', __METHOD__, __LINE__, __FILE__));
      exit(-1);
    }
    
    $start_time = microtime(true);  
    
    $this->load->model($this->extension_path);
    
    $sitemap_setting = $this->{$this->model_name}->getSitemapSetting($type);
    $sitemap_setting_stores = $this->{$this->model_name}->getSitemapSettingStores($type);
    $config = $this->config->get($this->code . '_config');
    
    $params = array(
        'type' => $sitemap_setting['type'],
        'changefreq' => $sitemap_setting['changefreq'],
        'priority' => $sitemap_setting['priority'],
        'url_limit' => $sitemap_setting['url_limit'],
        'stores' => $sitemap_setting_stores,
        'use_xsl_stylesheets' => (bool)$config['use_xsl_stylesheets'],
        'append_lang_param' => (bool)$config['append_lang_param'],
        'use_hreflang' => (bool)$config['use_hreflang'],
        'image_width' => (int)$config['image_width'],
        'image_height' => (int)$config['image_height'],        
        'max_execution_time' => $config['max_execution_time'],
    );

    $process_id = $this->{$this->model_name}->createProcess($type, $params);
    
    $this->xml_sitemap_generator->generateSitemap($process_id);

    $end_time = microtime(true);
    $time_diff = $end_time - $start_time;

    $this->logger->write('Info: Time elapsed for ' . $this->language->get('text_type_' . $type) . ': ' . $this->cli->toTime($time_diff) . ' (' . $time_diff . '): ' . __METHOD__ . ' on ' . __LINE__ . ' in ' . __FILE__);
  }  
  
  /**
   * Get the lic data
   *
   * @param void
   * @return response
   */  
	public function get_lic() {
    if (!(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')) {
      $this->logger->write('Error: Invalid Ajax call: ' . __METHOD__ . ' on ' . __LINE__ . ' in ' . __FILE__);
      $this->logger->write($_SERVER);
      return false;
    }
    
    $data = $this->config->get($this->code . '_lic');
    
    if (!$data) {
      $this->logger->write('Error: Failed to fetch license data: ' . __METHOD__ . ' on ' . __LINE__ . ' in ' . __FILE__);
      $this->logger->write($_SERVER);
    }
    
    return $this->response->setOutput(json_encode($data));
  }
  
  /**
   * Save the lic data
   *
   * @param void
   * @return response
   */  
	public function save_lic() {
    if (!(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')) {
      $this->logger->write('Error: Invalid Ajax call: ' . __METHOD__ . ' on ' . __LINE__ . ' in ' . __FILE__);
      $this->logger->write($_SERVER);
      return false;
    }
    
    $value = array(
        'key' => $this->request->post['key'],
        'licensee' => array(
            'name' => $this->request->post['licensee']['name'],
        ),
        'server' => $this->request->post['server'],
        'purchased_at' => array(
            'raw' => $this->request->post['purchased_at']['raw'],
            'formatted' => $this->request->post['purchased_at']['formatted'],
        ),
        'expires_at' => array(
            'raw' => $this->request->post['expires_at']['raw'],
            'formatted' => $this->request->post['expires_at']['formatted'],
        ),
        'status' => array(
            'id' => $this->request->post['status']['id'],
            'name' => $this->request->post['status']['name'],
            'icon' => array(
                'name' => $this->request->post['status']['icon']['name'],
                'color' => $this->request->post['status']['icon']['color']
            ),
        ),
        'checked_at' => array(
            'raw' => $this->request->post['checked_at']['raw'],
            'formatted' => $this->request->post['checked_at']['formatted'],
        ),
        'urls' => array(
            'list' => $this->request->post['urls']['list'],
            'detail' => $this->request->post['urls']['detail'],
        ),
    );
    
    $this->load->model($this->extension_path); 
    $data = $this->{$this->model_name}->updateSettingValue($this->code, $this->code . '_lic', $value);

    if (!$data) {
      $this->logger->write('Error: Failed to save license data: ' . __METHOD__ . ' on ' . __LINE__ . ' in ' . __FILE__);
      $this->logger->write($_SERVER);
    }
    
    if (! $this->isOC2031orEarlier()) { // for OpenCart 2.1.0.0 or later.
      // Convert an object to an array
      $data = json_decode(json_encode($data), true);
    }  

		$this->response->setOutput(json_encode($data));
	}
  
  /**
   * Checks if OpenCart 2.0.3.1 or earlier
   *
   * @param void
   * @return bool True or false
   */
  protected function isOC2031orEarlier() {
    return version_compare(str_replace('_rc1', '.RC.1', VERSION), '2.1.0.0.RC.1', '<');
  }

  /**
   * The install() implementation
   *
   * @param void
   * @return void
   */
  public function install() {
    $this->load->model($this->extension_path);
    
    $this->{$this->model_name}->install();
    
    $config_data = array(
        $this->code . '_status' => true,
        $this->code . '_config' => array(
            'js_debug' => false,
            'use_xsl_stylesheets' => true,
            'append_lang_param' => false,
            'use_hreflang' => true,
            'image_width' => 500,
            'image_height' => 500,            
            'max_execution_time' => 600,
        ),
        $this->code . '_version' => $this->xml_sitemap_generator->getVersion(),
    );
    
    $this->load->model('setting/setting');
    
    $this->model_setting_setting->editSetting($this->code, $config_data);   
  }

  /**
   * The uninstall() implementation
   *
   * @param void
   * @return void
   */
  public function uninstall() {
    //
  }

  /**
   * The upgrade() implementation
   *
   * @param void
   * @return void
   */
  public function upgrade() {
    //
  }
  
}