<?php
/**
 * XML Sitemap Generator
 * 
 * @author  Cuispi
 * @version 1.0.1
 * @license Commercial License
 * @package system
 * @subpackage  system.library.xml_sitemap_generator
 */

namespace XmlSitemapGenerator;

require_once DIR_SYSTEM . 'library/xml_sitemap_generator/cli.php';
require_once DIR_SYSTEM . 'library/xml_sitemap_generator/cli_progress_bar/progress.php';
require_once DIR_SYSTEM . 'library/xml_sitemap_generator/multilingual_seo_toolkit.php';

use XmlSitemapGenerator\Cli;
use XmlSitemapGenerator\CliProgressBar\Progress AS CliProgressBar;
use XmlSitemapGenerator\MultilingualSeoToolkit;

final class XmlSitemapGenerator {
  
  /**
   * Holds the current version of the extension.
   *
   * @var string
   */
  protected $version = '1.0.1';
  
  /**
   * Registry
   *
   * @var object
   */     
  private $registry;
   
  /**
   * Holds the class instances in the registry object.
   *
   * @var object
   */  
  private $config, $load, $url, $language;
  
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
   * Holds the absolute path to the root.
   *
   * @var string
   */  
  protected $root_path;
  
  /**
   * The sitemap directory
   *
   * @var string
   */  
  protected $sitemap_dir = 'catalog/view/sitemap';
  
  /**
   * List of validation errors.
   *
   * @var array
   */
	private $errors = array();
  
  /**
   * Holds the instance of the Cli class.
   *
   * @var class object
   */  
  protected $cli;
  
  /**
   * Holds the instance of the MultilingualSeoToolkit class.
   *
   * @var class object
   */  
  protected $multilingual_seo_toolkit;
  
  /**
   * Holds the Logger class instance.
   *
   * @var object
   */
  protected $logger;
  
  /**
   * Constructor
   *
   * @param object $registry
   */
	public function __construct($registry) {
		$this->registry = $registry;
		$this->config = $registry->get('config');
		$this->load = $registry->get('load');
		$this->url = $registry->get('url');
		$this->language = $registry->get('language');
    
    if (($pos = strripos(__CLASS__, '\\')) !== false) { 
      $class = substr(__CLASS__, $pos + 1); 
    }
    
    $code = strtolower(preg_replace('/(?<=\\w)([A-Z])/', '_\\1', $class));
        
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
    
    $this->root_path = rtrim(dirname(DIR_CATALOG), DIRECTORY_SEPARATOR);
    
    $this->sitemap_dir = $this->buildPath(implode(DIRECTORY_SEPARATOR, explode('/', $this->sitemap_dir)));

    try {
      if (!class_exists('XmlSitemapGenerator\MultilingualSeoToolkit')) {
        throw new Exception('The MultilingualSeoToolkit class cannot be found.'); 
      }
      
      $this->multilingual_seo_toolkit = new MultilingualSeoToolkit($registry);
      
      if (!class_exists('XmlSitemapGenerator\Cli')) {
        throw new Exception('The Cli class cannot be found.'); 
      }
      
      $this->cli = new Cli();      
    }
    catch (Exception $e) {
      exit($e->getMessage());
    }
    
    $this->logger = new \Log($this->code . '.log');
  }
  
  /**
   * Destructor
   *
   * @param void
   */  
  public function __destruct() {
    //
  }
   
  /**
   * Generates the XML sitemap files of the given process ID.
   *
   * @param integer $process_id Process ID
   * @return array $data
   */
  public function generateSitemap($process_id) {
    $this->language->load($this->extension_path);
    $this->load->model($this->extension_path);
    
    if ($this->cli->isTerm()) {
      $run_from= 'a terminal';
    } elseif ($this->cli->isCron()) {
      $run_from = 'a cron job';
    } else {
      $run_from = 'a web server';
    }
    
    $this->logger->write('Info: ' . sprintf($this->language->get('text_log_message'), 'The script is being run from ' . $run_from, __METHOD__, __LINE__, __FILE__));

    $process = $this->registry->get($this->model_name)->getProcess($process_id);

    $type = $process['type'];
    $params = json_decode($process['params'], true); 
    
    if ($this->cli->isWebserver()) {
      if (function_exists('ini_set') && (isset($params['max_execution_time']) && is_numeric($params['max_execution_time']))) {
        ini_set('max_execution_time', $params['max_execution_time']);
      }
    }
    
    $this->logger->write(sprintf($this->language->get('text_log_message'), 'Info: max_execution_time: ' . ini_get('max_execution_time'), __METHOD__, __LINE__, __FILE__));

    if (!file_exists($this->getLockDirPath())) {
      mkdir($this->getLockDirPath(), 0777, true);
    }    

    $lock_file_handle = fopen($this->getLockFilePath(), 'c+');
    
    if (!flock($lock_file_handle, LOCK_EX | LOCK_NB)) {
      $this->logger->write(sprintf($this->language->get('text_log_message'), 'Error: Unable to obtain a lock on the file ' . $this->getLockFilePath(), __METHOD__, __LINE__, __FILE__));
    }
      
    $this->makeDir($this->getSitemapDirPath());
    $this->copyFile($this->buildPath($this->getSkeletonDirPath(), 'index.html'), $this->buildPath($this->getSitemapDirPath(), 'index.html'));
    
    $this->load->model('tool/image');

    switch ($type) {
      case 'product':
        $progress = $this->generateProductSitemap($process_id, $params);
        break;
      case 'category':
        $progress = $this->generateCategorySitemap($process_id, $params);
        break;
      case 'manufacturer':
        $progress = $this->generateManufacturerSitemap($process_id, $params);
        break;
      case 'information':
        $progress = $this->generateInformationSitemap($process_id, $params);
        break;
      case 'page':
        $progress = $this->generatePageSitemap($process_id, $params);
        break;
      default:
        $this->logger->write(sprintf($this->language->get('text_log_message'), 'Error: An undefined value was assigned to $type: ' . $type, __METHOD__, __LINE__, __FILE__));
        exit;
    }
    
    $status = $message = $errors = null;

    if (!$this->getErrors($process_id) && (int)$progress === 100) {
      $status = true;
      $message = sprintf($this->language->get('text_sitemap_created'), $this->language->get('text_type_'. $process['type']));
    } else {
      $status = false;
      $message = $this->language->get('error_failed_to_create_sitemaps');

      foreach($this->getErrors($process_id) as $error) {
        $errors[] = sprintf($this->language->get('text_log_message'), $error['message'], $error['method'], $error['line'], $error['file']);
      }
    }

    $lastmod = $this->registry->get($this->model_name)->getSitemapSettingLastmod($type);

    $data = array(
        'status' => $status,
        'message' => $message,
        'data' => array(
            'type' => $type,
            'progress' => $progress,
            'errors' => $errors,
            'prepared' => false,
            'lastmod' => $lastmod ? date($this->language->get('datetime_format'), strtotime($lastmod)) : null,
        ),
    );
   
    if ($this->cli->isCli()) {
      $this->cli->out(gmdate('Y-m-d H:i:s') . ' - ' . ($status === true ?  'Info' : 'Error') . ': ' . $message);
      $this->logger->write(sprintf($this->language->get('text_log_message'), ($status === true ?  'Info' : 'Error') . ': ' . $message, __METHOD__, __LINE__, __FILE__));      
    }
    
    if (!flock($lock_file_handle, LOCK_UN)) {
      $this->logger->write(sprintf($this->language->get('text_log_message'), 'Error: Unable to release the lock on the file ' . $this->getLockFilePath(), __METHOD__, __LINE__, __FILE__));
    }
    
    fclose($lock_file_handle);    

    return $data;    
  }

  /**
   * Generates the XML sitemaps that include product URLs.
   *
   * @param integer $process_id
   * @param array $params
   * @return integer $progress
   */
  private function generateProductSitemap($process_id, $params) {
    $stores = $this->getStores(); 
    
    $this->cli->out(sprintf($this->language->get('text_progress_message_preparing'), $this->language->get('text_type_'. $params['type'])));
    $this->logger->write('Info: ' . sprintf($this->language->get('text_log_message'), sprintf($this->language->get('text_progress_message_preparing'), $this->language->get('text_type_'. $params['type'])), __METHOD__, __LINE__, __FILE__));
    
    $this->registry->get($this->model_name)->createTemporaryProducts($params['stores']);
    
    $this->cli->out(sprintf($this->language->get('text_progress_message_generating'), $this->language->get('text_type_'. $params['type'])));
    $this->logger->write('Info: ' . sprintf($this->language->get('text_log_message'), sprintf($this->language->get('text_progress_message_generating'), $this->language->get('text_type_'. $params['type'])), __METHOD__, __LINE__, __FILE__));
    
    $total = $count = $progress = $product_count = 0;
    
    $total += $this->registry->get($this->model_name)->getTotalTemporaryProducts($params['stores']);
    
    $this->registry->get($this->model_name)->updateProcessStartTime($process_id, time());
    $this->registry->get($this->model_name)->updateProcessTotal($process_id, $total);
    $this->registry->get($this->model_name)->updateProcessPrepared($process_id, true);

    if ($this->cli->isCli() && !$this->cli->isCron()) {
      $cli_progress_bar = new CliProgressBar();
    }     
    
    foreach ($stores as $store) {

      $url = new \Url($store['url'], $store['ssl']);
      
      $base_url = $store['url'];
      
      $sitemap_product_dir = $this->buildPath($this->getSitemapDirPath(), 'store', $store['store_id'], 'product' . DIRECTORY_SEPARATOR);
      
      $this->makeDir($sitemap_product_dir);
      $this->removeFiles($sitemap_product_dir . '*');
      $this->copyFile($this->buildPath($this->getSkeletonDirPath(), 'index.html'), $this->buildPath($this->getSitemapDirPath(), 'store', 'index.html'));
      $this->copyFile($this->buildPath($this->getSkeletonDirPath(), 'index.html'), $this->buildPath($this->getSitemapDirPath(), 'store', $store['store_id'], 'index.html'));
      $this->copyFile($this->buildPath($this->getSkeletonDirPath(), 'index.html'), $this->buildPath($this->getSitemapDirPath(), 'store', $store['store_id'], 'product', 'index.html'));
      
      $sitemap_index_file = $this->buildPath($this->getSitemapDirPath(), 'store', $store['store_id'], 'product', 'sitemap-index.xml');
      
      if (!$sitemap_index_handle = fopen($sitemap_index_file, 'w')) {
        $this->setError($process_id, sprintf($this->language->get('error_cannot_open_file'), $sitemap_index_file), __METHOD__, __FILE__, __LINE__);
      }

      $sitemap_index = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
      
      if ($params['use_xsl_stylesheets'] === true) {
        $sitemap_index .= '<?xml-stylesheet type="text/xsl" href="./sitemap-index.xsl"?>' . "\n";
      }
      
      $sitemap_index .= '<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";
      
      if (in_array($store['store_id'], $params['stores'])) {
        
        $product_total = $this->registry->get($this->model_name)->getTotalTemporaryProducts((int)$store['store_id']);

        $num_pages = ceil($product_total / (int)$params['url_limit']);

        for ($page = 1; $page <= $num_pages; $page++) {

          $sitemap_file = $this->buildPath($this->getSitemapDirPath(), 'store', $store['store_id'], 'product', 'sitemap_' . $page . '.xml');

          if (!$sitemap_handle = fopen($sitemap_file, 'w')) {
            $this->setError($process_id, sprintf($this->language->get('error_cannot_open_file'), $sitemap_file), __METHOD__, __FILE__, __LINE__);
          }

          $sitemap = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
          
          if ($params['use_xsl_stylesheets'] === true) {
            $sitemap .= '<?xml-stylesheet type="text/xsl" href="./sitemap.xsl"?>' . "\n";
          }
          
          $sitemap .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xhtml="http://www.w3.org/1999/xhtml" xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">' . "\n";

          $products = $this->registry->get($this->model_name)->getTemporaryProducts((int)$store['store_id'], array(
              'start' => ($page - 1) * (int)$params['url_limit'],
              'limit' => (int)$params['url_limit'],
          ));

          $product_count += count($products);

          foreach ($products as $index => $product) {
            
            $timestamp = time();
            
            $sitemap .= '  <url>' . "\n";

            // The <loc> attribute
            $loc = $this->buildProductUrl($url, $base_url, $product, $params);
            $sitemap .= '    <loc>' . $loc . '</loc>' . "\n";
            unset($loc);

            if ($product['lastmod']) {
              $sitemap .= '    <lastmod>' . $this->getLastmod($product['lastmod']) . '</lastmod>' . "\n";
            }          

            // The <changefreq> attribute
            $sitemap .= '    <changefreq>' . $params['changefreq'] . '</changefreq>' . "\n";

            // The <priority> attribute
            $sitemap .= '    <priority>' . $params['priority'] . '</priority>' . "\n";          

            // The <image> attribute
            if ($product['image'] && ($params['image_width'] > 0 && $params['image_height'] > 0)) {
              $sitemap .= '    <image:image>' . "\n";
              $sitemap .= '      <image:loc>' . $this->registry->get('model_tool_image')->resize($product['image'], $params['image_width'], $params['image_height']) . '</image:loc>' . "\n";
              $sitemap .= '      <image:caption>' . $product['name'] . '</image:caption>' . "\n";
              $sitemap .= '      <image:title>' . $product['name'] . '</image:title>' . "\n";
              $sitemap .= '    </image:image>' . "\n";
            }          

            // Alternate languages
            if ($params['use_hreflang'] === true) {
              $alt_lang_products = $this->registry->get($this->model_name)->getAltLangTemporaryProducts((int)$store['store_id'], (int)$product['product_id']);

              foreach ($alt_lang_products as $alt_lang_product) {
                if ($this->multilingual_seo_toolkit->extensionEnabled() === true) {
                  $hreflang = $this->multilingual_seo_toolkit->getLangPrefix($alt_lang_product['language_code']);
                } else {
                  $hreflang = $alt_lang_product['language_code'];
                }
                
                $href = $this->buildProductUrl($url, $base_url, $alt_lang_product, $params);
                $sitemap .= '    <xhtml:link rel="alternate" hreflang="' . $hreflang . '" href="' . $href . '" />' . "\n";
                unset($hreflang, $href);
              }

              unset($alt_lang_products);
            }

            $sitemap .= '  </url>' . "\n";

            $count++;
            
            $errors = $this->getErrors($process_id);
            
            if ($errors) {
              foreach($this->getErrors($process_id) as $error) {
                $this->logger->write(sprintf($this->language->get('text_log_message'), $error['message'], $error['method'], $error['line'], $error['file']));
                $this->cli->out(sprintf($this->language->get('text_log_message'), $error['message'], $error['method'], $error['line'], $error['file']));
              }
              
              exit(-1);
              
            } else {
              $_progress = round(($count / $total) * 100);
              
              if ($progress < $_progress) {
                $progress = $_progress;
                $this->registry->get($this->model_name)->updateProcessProgress($process_id, $progress);
                $this->registry->get($this->model_name)->updateSitemapSettingLastmod('product');
                
                if ($_progress == 100) {
                  $this->registry->get($this->model_name)->updateProcessEndTime($process_id, time());
                }
              }
              
              if ($timestamp < time() || $count == $total) {
                $this->registry->get($this->model_name)->updateProcessCompleted($process_id, $count);
              }
              
              if ($this->cli->isCli() && !$this->cli->isCron()) {
                $cli_progress_bar->update($count, $total);                
              }
            }
            
            unset($errors);
            
          }

          $sitemap .= '</urlset>' . "\n";

          if (fwrite($sitemap_handle, $sitemap) === false) {
            $this->setError($process_id, sprintf($this->language->get('error_cannot_write_to_file'), $sitemap_file), __METHOD__, __FILE__, __LINE__);
          }

          fclose($sitemap_handle);

          $sitemap_index .= '  <sitemap>' . "\n";
          $sitemap_index .= '    <loc>' . $this->buildPath(rtrim($base_url, DIRECTORY_SEPARATOR), $this->sitemap_dir, 'store', $store['store_id'], 'product', 'sitemap_' . $page . '.xml') . '</loc>' . "\n";
          $sitemap_index .= '    <lastmod>' . $this->getLastmod() . '</lastmod>' . "\n";
          $sitemap_index .= '  </sitemap>' . "\n";
        }
      }

      $sitemap_index .= '</sitemapindex>' . "\n";

      if (fwrite($sitemap_index_handle, $sitemap_index) === false) {
        $this->setError($process_id, sprintf($this->language->get('error_cannot_write_to_file'), $sitemap_index_file), __METHOD__, __FILE__, __LINE__);
      }

      fclose($sitemap_index_handle);
      
      $this->addStylingToTypeSitemapIndex($process_id, 'product', $store);
      
      if (in_array($store['store_id'], $params['stores'])) {
        $this->addStylingToTypeSitemap($process_id, 'product', $store);
      }
    }
    
    if ($total <= 0) {
      $progress = 100;
      $this->registry->get($this->model_name)->updateProcessProgress($process_id, $progress);
      $this->registry->get($this->model_name)->updateSitemapSettingLastmod('product');
      $this->registry->get($this->model_name)->updateProcessEndTime($process_id, time());
    }

    $this->generateBaseSitemapIndex($process_id, $params);
    
    $this->generateStoreSitemapIndex($process_id, $params);
    
    return $progress;
  }
  
  /**
   * Generates the XML sitemaps that include category/subcategory URLs and the product URLs belonging to them.
   *
   * @param integer $process_id
   * @param array $params
   * @return integer $progress
   */
  private function generateCategorySitemap($process_id, $params) {
    $stores = $this->getStores();
    
    $this->cli->out(sprintf($this->language->get('text_progress_message_preparing'), $this->language->get('text_type_'. $params['type'])));
    $this->logger->write('Info: ' . sprintf($this->language->get('text_log_message'), sprintf($this->language->get('text_progress_message_preparing'), $this->language->get('text_type_'. $params['type'])), __METHOD__, __LINE__, __FILE__));
    
    $this->registry->get($this->model_name)->createTemporaryCategories($params['stores']);
    
    $this->cli->out(sprintf($this->language->get('text_progress_message_generating'), $this->language->get('text_type_'. $params['type'])));
    $this->logger->write('Info: ' . sprintf($this->language->get('text_log_message'), sprintf($this->language->get('text_progress_message_generating'), $this->language->get('text_type_'. $params['type'])), __METHOD__, __LINE__, __FILE__));
    
    $total = $count = $progress = $category_count = 0;
    
    $total += $this->registry->get($this->model_name)->getTotalTemporaryCategories($params['stores']);
    
    $this->registry->get($this->model_name)->updateProcessStartTime($process_id, time());
    $this->registry->get($this->model_name)->updateProcessTotal($process_id, $total);    
    $this->registry->get($this->model_name)->updateProcessPrepared($process_id, true);
    
    if ($this->cli->isCli() && !$this->cli->isCron()) {
      $cli_progress_bar = new CliProgressBar();
    }
    
    foreach ($stores as $store) {
      
      $url = new \Url($store['url'], $store['ssl']);
      
      $base_url = $store['url'];
      
      $sitemap_category_dir = $this->buildPath($this->getSitemapDirPath(), 'store', $store['store_id'], 'category' . DIRECTORY_SEPARATOR);
      
      $this->makeDir($sitemap_category_dir);
      $this->removeFiles($sitemap_category_dir . '*');
      $this->copyFile($this->buildPath($this->getSkeletonDirPath(), 'index.html'), $this->buildPath($this->getSitemapDirPath(), 'store', 'index.html'));
      $this->copyFile($this->buildPath($this->getSkeletonDirPath(), 'index.html'), $this->buildPath($this->getSitemapDirPath(), 'store', $store['store_id'], 'index.html'));
      $this->copyFile($this->buildPath($this->getSkeletonDirPath(), 'index.html'), $this->buildPath($this->getSitemapDirPath(), 'store', $store['store_id'], 'category', 'index.html'));
      
      $sitemap_index_file = $this->buildPath($this->getSitemapDirPath(), 'store', $store['store_id'], 'category', 'sitemap-index.xml');
      
      if (!$sitemap_index_handle = fopen($sitemap_index_file, 'w')) {
        $this->setError($process_id, sprintf($this->language->get('error_cannot_open_file'), $sitemap_index_file), __METHOD__, __FILE__, __LINE__);
      }

      $sitemap_index = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
      
      if ($params['use_xsl_stylesheets'] === true) {
        $sitemap_index .= '<?xml-stylesheet type="text/xsl" href="./sitemap-index.xsl"?>' . "\n";
      }
      
      $sitemap_index .= '<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";
      
      if (in_array($store['store_id'], $params['stores'])) {
        
        $category_total = $this->registry->get($this->model_name)->getTotalTemporaryCategories((int)$store['store_id']);

        $num_pages = ceil($category_total / (int)$params['url_limit']);

        for ($page = 1; $page <= $num_pages; $page++) {

          $sitemap_file = $this->buildPath($this->getSitemapDirPath(), 'store', $store['store_id'], 'category', 'sitemap_' . $page . '.xml');

          if (!$sitemap_handle = fopen($sitemap_file, 'w')) {
            $this->setError($process_id, sprintf($this->language->get('error_cannot_open_file'), $sitemap_file), __METHOD__, __FILE__, __LINE__);
          }

          $sitemap = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
          
          if ($params['use_xsl_stylesheets'] === true) {
            $sitemap .= '<?xml-stylesheet type="text/xsl" href="./sitemap.xsl"?>' . "\n";
          }
          
          $sitemap .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xhtml="http://www.w3.org/1999/xhtml" xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">' . "\n";

          $categories = $this->registry->get($this->model_name)->getTemporaryCategories((int)$store['store_id'], array(
              'start' => ($page - 1) * (int)$params['url_limit'],
              'limit' => (int)$params['url_limit'],
          ));

          $category_count += count($categories);

          foreach ($categories as $index => $category) {

            $timestamp = time();
            
            $sitemap .= '  <url>' . "\n";

            // The <loc> attribute
            $loc = $this->buildCategoryUrl($url, $base_url, $category, $params);
            $sitemap .= '    <loc>' . $loc . '</loc>' . "\n";
            unset($loc);

            if ($category['lastmod']) {
              $sitemap .= '    <lastmod>' . $this->getLastmod($category['lastmod']) . '</lastmod>' . "\n";
            }          

            // The <changefreq> attribute
            $sitemap .= '    <changefreq>' . $params['changefreq'] . '</changefreq>' . "\n";

            // The <priority> attribute
            $sitemap .= '    <priority>' . $params['priority'] . '</priority>' . "\n";

            // The <image> attribute
            if ($category['image'] && ($params['image_width'] > 0 && $params['image_height'] > 0)) {
              $sitemap .= '    <image:image>' . "\n";
              $sitemap .= '      <image:loc>' . $this->registry->get('model_tool_image')->resize($category['image'], $params['image_width'], $params['image_height']) . '</image:loc>' . "\n";
              $sitemap .= '      <image:caption>' . $category['product_name'] . '</image:caption>' . "\n";
              $sitemap .= '      <image:title>' . $category['product_name'] . '</image:title>' . "\n";
              $sitemap .= '    </image:image>' . "\n";
            }

            // Alternate languages
            if ($params['use_hreflang'] === true) {
              $alt_lang_categories = $this->registry->get($this->model_name)->getAltLangTemporaryCategories((int)$store['store_id'], (int)$category['category_id'], (int)$category['product_id']);

              foreach ($alt_lang_categories as $alt_lang_category) {
                if ($this->multilingual_seo_toolkit->extensionEnabled() === true) {
                  $hreflang = $this->multilingual_seo_toolkit->getLangPrefix($alt_lang_category['language_code']);
                } else {
                  $hreflang = $alt_lang_category['language_code'];
                }
                
                $href = $this->buildCategoryUrl($url, $base_url, $alt_lang_category, $params);
                $sitemap .= '    <xhtml:link rel="alternate" hreflang="' . $hreflang . '" href="' . $href . '" />' . "\n";
                unset($hreflang, $href);
              }

              unset($alt_lang_categories);
            }          

            $sitemap .= '  </url>' . "\n";

            $count++;

            $errors = $this->getErrors($process_id);
            
            if ($errors) {
              foreach($this->getErrors($process_id) as $error) {
                $this->logger->write(sprintf($this->language->get('text_log_message'), $error['message'], $error['method'], $error['line'], $error['file']));
                $this->cli->out(sprintf($this->language->get('text_log_message'), $error['message'], $error['method'], $error['line'], $error['file']));
              }
              
              exit(-1);
              
            } else {
              $_progress = round(($count / $total) * 100);
              
              if ($progress < $_progress) {
                $progress = $_progress;
                $this->registry->get($this->model_name)->updateProcessProgress($process_id, $progress);
                $this->registry->get($this->model_name)->updateSitemapSettingLastmod('category');
                
                if ($_progress == 100) {
                  $this->registry->get($this->model_name)->updateProcessEndTime($process_id, time());
                }                
              }
              
              if ($timestamp < time() || $count == $total) {
                $this->registry->get($this->model_name)->updateProcessCompleted($process_id, $count);
              }            
              
              if ($this->cli->isCli() && !$this->cli->isCron()) {
                $cli_progress_bar->update($count, $total);          
              }                
            }
            
            unset($errors);
            
          }

          $sitemap .= '</urlset>' . "\n";

          if (fwrite($sitemap_handle, $sitemap) === false) {
            $this->setError($process_id, sprintf($this->language->get('error_cannot_write_to_file'), $sitemap_file), __METHOD__, __FILE__, __LINE__);
          }

          fclose($sitemap_handle);

          $sitemap_index .= '  <sitemap>' . "\n";
          $sitemap_index .= '    <loc>' . $this->buildPath(rtrim($base_url, DIRECTORY_SEPARATOR), $this->sitemap_dir, 'store', $store['store_id'], 'category', 'sitemap_' . $page . '.xml') . '</loc>' . "\n";
          $sitemap_index .= '    <lastmod>' . $this->getLastmod() . '</lastmod>' . "\n";
          $sitemap_index .= '  </sitemap>' . "\n";
        }
      }

      $sitemap_index .= '</sitemapindex>' . "\n";

      if (fwrite($sitemap_index_handle, $sitemap_index) === false) {
        $this->setError($process_id, sprintf($this->language->get('error_cannot_write_to_file'), $sitemap_index_file), __METHOD__, __FILE__, __LINE__);
      }

      fclose($sitemap_index_handle);
      
      $this->addStylingToTypeSitemapIndex($process_id, 'category', $store);
      
      if (in_array($store['store_id'], $params['stores'])) {
        $this->addStylingToTypeSitemap($process_id, 'category', $store);
      }   
    }
    
    if ($total <= 0) {
      $progress = 100;
      $this->registry->get($this->model_name)->updateProcessProgress($process_id, $progress);
      $this->registry->get($this->model_name)->updateSitemapSettingLastmod('category');
      $this->registry->get($this->model_name)->updateProcessEndTime($process_id, time());
    }

    $this->generateBaseSitemapIndex($process_id, $params);
    
    $this->generateStoreSitemapIndex($process_id, $params);
    
    return $progress;
  }  
  
  /**
   * Generates the XML sitemaps that include manufacturer URLs and the product URLs belonging to them.
   *
   * @param integer $process_id
   * @param array $params
   * @return integer $progress
   */
  private function generateManufacturerSitemap($process_id, $params) {
    $stores = $this->getStores();

    $this->cli->out(sprintf($this->language->get('text_progress_message_preparing'), $this->language->get('text_type_'. $params['type'])));
    $this->logger->write('Info: ' . sprintf($this->language->get('text_log_message'), sprintf($this->language->get('text_progress_message_preparing'), $this->language->get('text_type_'. $params['type'])), __METHOD__, __LINE__, __FILE__));
    
    $this->registry->get($this->model_name)->createTemporaryManufacturers($params['stores']);
    
    $this->cli->out(sprintf($this->language->get('text_progress_message_generating'), $this->language->get('text_type_'. $params['type'])));
    $this->logger->write('Info: ' . sprintf($this->language->get('text_log_message'), sprintf($this->language->get('text_progress_message_generating'), $this->language->get('text_type_'. $params['type'])), __METHOD__, __LINE__, __FILE__));
    
    $total = $count = $progress = $manufacturer_count = 0;
    
    $total += $this->registry->get($this->model_name)->getTotalTemporaryManufacturers($params['stores']);
    
    $this->registry->get($this->model_name)->updateProcessStartTime($process_id, time());
    $this->registry->get($this->model_name)->updateProcessTotal($process_id, $total);    
    $this->registry->get($this->model_name)->updateProcessPrepared($process_id, true);
    
    if ($this->cli->isCli() && !$this->cli->isCron()) {
      $cli_progress_bar = new CliProgressBar();
    }
    
    foreach ($stores as $store) {
      
      $url = new \Url($store['url'], $store['ssl']);
      
      $base_url = $store['url'];
      
      $sitemap_manufacturer_dir = $this->buildPath($this->getSitemapDirPath(), 'store', $store['store_id'], 'manufacturer' . DIRECTORY_SEPARATOR);
      
      $this->makeDir($sitemap_manufacturer_dir);
      $this->removeFiles($sitemap_manufacturer_dir . '*');
      $this->copyFile($this->buildPath($this->getSkeletonDirPath(), 'index.html'), $this->buildPath($this->getSitemapDirPath(), 'store', 'index.html'));
      $this->copyFile($this->buildPath($this->getSkeletonDirPath(), 'index.html'), $this->buildPath($this->getSitemapDirPath(), 'store', $store['store_id'], 'index.html'));
      $this->copyFile($this->buildPath($this->getSkeletonDirPath(), 'index.html'), $this->buildPath($this->getSitemapDirPath(), 'store', $store['store_id'], 'manufacturer', 'index.html'));
      
      $sitemap_index_file = $this->buildPath($this->getSitemapDirPath(), 'store', $store['store_id'], 'manufacturer', 'sitemap-index.xml');
      
      if (!$sitemap_index_handle = fopen($sitemap_index_file, 'w')) {
        $this->setError($process_id, sprintf($this->language->get('error_cannot_open_file'), $sitemap_index_file), __METHOD__, __FILE__, __LINE__);
      }

      $sitemap_index = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
      
      if ($params['use_xsl_stylesheets'] === true) {
        $sitemap_index .= '<?xml-stylesheet type="text/xsl" href="./sitemap-index.xsl"?>' . "\n";
      }
      
      $sitemap_index .= '<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";
      
      if (in_array($store['store_id'], $params['stores'])) {
        
        $manufacturer_total = $this->registry->get($this->model_name)->getTotalTemporaryManufacturers((int)$store['store_id']);

        $num_pages = ceil($manufacturer_total / (int)$params['url_limit']);

        for ($page = 1; $page <= $num_pages; $page++) {

          $sitemap_file = $this->buildPath($this->getSitemapDirPath(), 'store', $store['store_id'], 'manufacturer', 'sitemap_' . $page . '.xml');

          if (!$sitemap_handle = fopen($sitemap_file, 'w')) {
            $this->setError($process_id, sprintf($this->language->get('error_cannot_open_file'), $sitemap_file), __METHOD__, __FILE__, __LINE__);
          }

          $sitemap = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
          
          if ($params['use_xsl_stylesheets'] === true) {
            $sitemap .= '<?xml-stylesheet type="text/xsl" href="./sitemap.xsl"?>' . "\n";
          }
          
          $sitemap .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xhtml="http://www.w3.org/1999/xhtml" xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">' . "\n";

          $manufacturers = $this->registry->get($this->model_name)->getTemporaryManufacturers((int)$store['store_id'], array(
              'start' => ($page - 1) * (int)$params['url_limit'],
              'limit' => (int)$params['url_limit'],
          ));

          $manufacturer_count += count($manufacturers);

          foreach ($manufacturers as $index => $manufacturer) {
            
            $timestamp = time();
            
            $sitemap .= '  <url>' . "\n";

            // The <loc> attribute
            $loc = $this->buildManufacturerUrl($url, $base_url, $manufacturer, $params);
            $sitemap .= '    <loc>' . $loc . '</loc>' . "\n";
            unset($loc);

            if ($manufacturer['lastmod']) {
              $sitemap .= '    <lastmod>' . $this->getLastmod($manufacturer['lastmod']) . '</lastmod>' . "\n";
            }          

            // The <changefreq> attribute
            $sitemap .= '    <changefreq>' . $params['changefreq'] . '</changefreq>' . "\n";

            // The <priority> attribute
            $sitemap .= '    <priority>' . $params['priority'] . '</priority>' . "\n";

            // The <image> attribute
            if ($manufacturer['image'] && ($params['image_width'] > 0 && $params['image_height'] > 0)) {
              $sitemap .= '    <image:image>' . "\n";
              $sitemap .= '      <image:loc>' . $this->registry->get('model_tool_image')->resize($manufacturer['image'], $params['image_width'], $params['image_height']) . '</image:loc>' . "\n";
              $sitemap .= '      <image:caption>' . $manufacturer['product_name'] . '</image:caption>' . "\n";
              $sitemap .= '      <image:title>' . $manufacturer['product_name'] . '</image:title>' . "\n";
              $sitemap .= '    </image:image>' . "\n";
            }

            // Alternate languages
            if ($params['use_hreflang'] === true) {
              $alt_lang_manufacturers = $this->registry->get($this->model_name)->getAltLangTemporaryManufacturers((int)$store['store_id'], (int)$manufacturer['manufacturer_id'], (int)$manufacturer['product_id']);

              foreach ($alt_lang_manufacturers as $alt_lang_manufacturer) {
                if ($this->multilingual_seo_toolkit->extensionEnabled() === true) {
                  $hreflang = $this->multilingual_seo_toolkit->getLangPrefix($alt_lang_manufacturer['language_code']);
                } else {
                  $hreflang = $alt_lang_manufacturer['language_code'];
                }
                
                $href = $this->buildManufacturerUrl($url, $base_url, $alt_lang_manufacturer, $params);
                $sitemap .= '    <xhtml:link rel="alternate" hreflang="' . $hreflang . '" href="' . $href . '" />' . "\n";
                unset($hreflang, $href);                
              }

              unset($alt_lang_manufacturers);
            }          

            $sitemap .= '  </url>' . "\n";

            $count++;

            $errors = $this->getErrors($process_id);
            
            if ($errors) {
              foreach($this->getErrors($process_id) as $error) {
                $this->logger->write(sprintf($this->language->get('text_log_message'), $error['message'], $error['method'], $error['line'], $error['file']));
                $this->cli->out(sprintf($this->language->get('text_log_message'), $error['message'], $error['method'], $error['line'], $error['file']));
              }
              
              exit(-1);
              
            } else {
              $_progress = round(($count / $total) * 100);
              
              if ($progress < $_progress) {
                $progress = $_progress;
                $this->registry->get($this->model_name)->updateProcessProgress($process_id, $progress);
                $this->registry->get($this->model_name)->updateSitemapSettingLastmod('manufacturer');
                
                if ($_progress == 100) {
                  $this->registry->get($this->model_name)->updateProcessEndTime($process_id, time());
                }                
              }
              
              if ($timestamp < time() || $count == $total) {
                $this->registry->get($this->model_name)->updateProcessCompleted($process_id, $count);
              }             
              
              if ($this->cli->isCli() && !$this->cli->isCron()) {
                $cli_progress_bar->update($count, $total);          
              }               
            }
            
            unset($errors);
         
          }

          $sitemap .= '</urlset>' . "\n";

          if (fwrite($sitemap_handle, $sitemap) === false) {
            $this->setError($process_id, sprintf($this->language->get('error_cannot_write_to_file'), $sitemap_file), __METHOD__, __FILE__, __LINE__);
          }

          fclose($sitemap_handle);

          $sitemap_index .= '  <sitemap>' . "\n";
          $sitemap_index .= '    <loc>' . $this->buildPath(rtrim($base_url, DIRECTORY_SEPARATOR), $this->sitemap_dir, 'store', $store['store_id'], 'manufacturer', 'sitemap_' . $page . '.xml') . '</loc>' . "\n";
          $sitemap_index .= '    <lastmod>' . $this->getLastmod() . '</lastmod>' . "\n";
          $sitemap_index .= '  </sitemap>' . "\n";
        }
      }

      $sitemap_index .= '</sitemapindex>' . "\n";

      if (fwrite($sitemap_index_handle, $sitemap_index) === false) {
        $this->setError($process_id, sprintf($this->language->get('error_cannot_write_to_file'), $sitemap_index_file), __METHOD__, __FILE__, __LINE__);
      }

      fclose($sitemap_index_handle);
      
      $this->addStylingToTypeSitemapIndex($process_id, 'manufacturer', $store);
      
      if (in_array($store['store_id'], $params['stores'])) {
        $this->addStylingToTypeSitemap($process_id, 'manufacturer', $store);
      }      
    }
    
    if ($total <= 0) {
      $progress = 100;
      $this->registry->get($this->model_name)->updateProcessProgress($process_id, $progress);
      $this->registry->get($this->model_name)->updateSitemapSettingLastmod('manufacturer');
      $this->registry->get($this->model_name)->updateProcessEndTime($process_id, time());
    }

    $this->generateBaseSitemapIndex($process_id, $params);
    
    $this->generateStoreSitemapIndex($process_id, $params);
    
    return $progress;
  }  
  
  /**
   * Generates the XML sitemaps that include information URLs.
   *
   * @param integer $process_id
   * @param array $params
   * @return integer $progress
   */
  private function generateInformationSitemap($process_id, $params) {
    $stores = $this->getStores();
    
    $this->cli->out(sprintf($this->language->get('text_progress_message_preparing'), $this->language->get('text_type_'. $params['type'])));
    $this->logger->write('Info: ' . sprintf($this->language->get('text_log_message'), sprintf($this->language->get('text_progress_message_preparing'), $this->language->get('text_type_'. $params['type'])), __METHOD__, __LINE__, __FILE__));    
    
    $this->registry->get($this->model_name)->createTemporaryInformations($params['stores']);
    
    $this->cli->out(sprintf($this->language->get('text_progress_message_generating'), $this->language->get('text_type_'. $params['type'])));
    $this->logger->write('Info: ' . sprintf($this->language->get('text_log_message'), sprintf($this->language->get('text_progress_message_generating'), $this->language->get('text_type_'. $params['type'])), __METHOD__, __LINE__, __FILE__));
    
    $total = $count = $progress = $information_count = 0;
    
    $total += $this->registry->get($this->model_name)->getTotalTemporaryInformations($params['stores']);      
    
    $this->registry->get($this->model_name)->updateProcessStartTime($process_id, time());
    $this->registry->get($this->model_name)->updateProcessTotal($process_id, $total);    
    $this->registry->get($this->model_name)->updateProcessPrepared($process_id, true);
    
    if ($this->cli->isCli() && !$this->cli->isCron()) {
      $cli_progress_bar = new CliProgressBar();
    }
    
    foreach ($stores as $store) {
      
      $url = new \Url($store['url'], $store['ssl']);
      
      $base_url = $store['url'];
      
      $sitemap_information_dir = $this->buildPath($this->getSitemapDirPath(), 'store', $store['store_id'], 'information' . DIRECTORY_SEPARATOR);
      
      $this->makeDir($sitemap_information_dir);
      $this->removeFiles($sitemap_information_dir . '*');
      $this->copyFile($this->buildPath($this->getSkeletonDirPath(), 'index.html'), $this->buildPath($this->getSitemapDirPath(), 'store', 'index.html'));
      $this->copyFile($this->buildPath($this->getSkeletonDirPath(), 'index.html'), $this->buildPath($this->getSitemapDirPath(), 'store', $store['store_id'], 'index.html'));
      $this->copyFile($this->buildPath($this->getSkeletonDirPath(), 'index.html'), $this->buildPath($this->getSitemapDirPath(), 'store', $store['store_id'], 'information', 'index.html'));
      
      $sitemap_index_file = $this->buildPath($this->getSitemapDirPath(), 'store', $store['store_id'], 'information', 'sitemap-index.xml');
      
      if (!$sitemap_index_handle = fopen($sitemap_index_file, 'w')) {
        $this->setError($process_id, sprintf($this->language->get('error_cannot_open_file'), $sitemap_index_file), __METHOD__, __FILE__, __LINE__);
      }

      $sitemap_index = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
      
      if ($params['use_xsl_stylesheets'] === true) {
        $sitemap_index .= '<?xml-stylesheet type="text/xsl" href="./sitemap-index.xsl"?>' . "\n";
      }
      
      $sitemap_index .= '<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";
      
      if (in_array($store['store_id'], $params['stores'])) {

        $information_total = $this->registry->get($this->model_name)->getTotalTemporaryInformations((int)$store['store_id']);

        $num_pages = ceil($information_total / (int)$params['url_limit']);

        for ($page = 1; $page <= $num_pages; $page++) {

          $sitemap_file = $this->buildPath($this->getSitemapDirPath(), 'store', $store['store_id'], 'information', 'sitemap_' . $page . '.xml');

          if (!$sitemap_handle = fopen($sitemap_file, 'w')) {
            $this->setError($process_id, sprintf($this->language->get('error_cannot_open_file'), $sitemap_file), __METHOD__, __FILE__, __LINE__);
          }

          $sitemap = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
          
          if ($params['use_xsl_stylesheets'] === true) {
            $sitemap .= '<?xml-stylesheet type="text/xsl" href="./sitemap.xsl"?>' . "\n";
          }
          
          $sitemap .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xhtml="http://www.w3.org/1999/xhtml" xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">' . "\n";

          $informations = $this->registry->get($this->model_name)->getTemporaryInformations((int)$store['store_id'], array(
              'start' => ($page - 1) * (int)$params['url_limit'],
              'limit' => (int)$params['url_limit'],
          ));

          $information_count += count($informations);

          foreach ($informations as $index => $information) {

            $timestamp = time();
            
            $sitemap .= '  <url>' . "\n";

            // The <loc> attribute
            $loc = $this->buildInformationUrl($url, $base_url, $information, $params);
            $sitemap .= '    <loc>' . $loc . '</loc>' . "\n";
            unset($loc);

            // The <changefreq> attribute
            $sitemap .= '    <changefreq>' . $params['changefreq'] . '</changefreq>' . "\n";

            // The <priority> attribute
            $sitemap .= '    <priority>' . $params['priority'] . '</priority>' . "\n";          

            // Alternate languages
            if ($params['use_hreflang'] === true) {
              $alt_lang_informations = $this->registry->get($this->model_name)->getAltLangTemporaryInformations((int)$store['store_id'], (int)$information['information_id']);

              foreach ($alt_lang_informations as $alt_lang_information) {
                if ($this->multilingual_seo_toolkit->extensionEnabled() === true) {
                  $hreflang = $this->multilingual_seo_toolkit->getLangPrefix($alt_lang_information['language_code']);
                } else {
                  $hreflang = $alt_lang_information['language_code'];
                }
                
                $href = $this->buildInformationUrl($url, $base_url, $alt_lang_information, $params);
                $sitemap .= '    <xhtml:link rel="alternate" hreflang="' . $hreflang . '" href="' . $href . '" />' . "\n";
                unset($hreflang, $href);	
              }

              unset($alt_lang_informations);
            }

            $sitemap .= '  </url>' . "\n";

            $count++;

            $errors = $this->getErrors($process_id);
            
            if ($errors) {
              foreach($this->getErrors($process_id) as $error) {
                $this->logger->write(sprintf($this->language->get('text_log_message'), $error['message'], $error['method'], $error['line'], $error['file']));
                $this->cli->out(sprintf($this->language->get('text_log_message'), $error['message'], $error['method'], $error['line'], $error['file']));
              }
              
              exit(-1);
              
            } else {
              $_progress = round(($count / $total) * 100);
              
              if ($progress < $_progress) {
                $progress = $_progress;
                $this->registry->get($this->model_name)->updateProcessProgress($process_id, $progress);
                $this->registry->get($this->model_name)->updateSitemapSettingLastmod('information');
                
                if ($_progress == 100) {
                  $this->registry->get($this->model_name)->updateProcessEndTime($process_id, time());
                }                
              }
              
              if ($timestamp < time() || $count == $total) {
                $this->registry->get($this->model_name)->updateProcessCompleted($process_id, $count);
              }              
              
              if ($this->cli->isCli() && !$this->cli->isCron()) {
                $cli_progress_bar->update($count, $total);          
              }               
            }
            
            unset($errors);            
           
          }

          $sitemap .= '</urlset>' . "\n";

          if (fwrite($sitemap_handle, $sitemap) === false) {
            $this->setError($process_id, sprintf($this->language->get('error_cannot_write_to_file'), $sitemap_file), __METHOD__, __FILE__, __LINE__);
          }

          fclose($sitemap_handle);

          $sitemap_index .= '  <sitemap>' . "\n";
          $sitemap_index .= '    <loc>' . $this->buildPath(rtrim($base_url, DIRECTORY_SEPARATOR), $this->sitemap_dir, 'store', $store['store_id'], 'information', 'sitemap_' . $page . '.xml') . '</loc>' . "\n";
          $sitemap_index .= '    <lastmod>' . $this->getLastmod() . '</lastmod>' . "\n";
          $sitemap_index .= '  </sitemap>' . "\n";
        }
      }

      $sitemap_index .= '</sitemapindex>' . "\n";

      if (fwrite($sitemap_index_handle, $sitemap_index) === false) {
        $this->setError($process_id, sprintf($this->language->get('error_cannot_write_to_file'), $sitemap_index_file), __METHOD__, __FILE__, __LINE__);
      }

      fclose($sitemap_index_handle);
      
      $this->addStylingToTypeSitemapIndex($process_id, 'information', $store);
      
      if (in_array($store['store_id'], $params['stores'])) {
        $this->addStylingToTypeSitemap($process_id, 'information', $store);
      }      
    }
    
    if ($total <= 0) {
      $progress = 100;
      $this->registry->get($this->model_name)->updateProcessProgress($process_id, $progress);
      $this->registry->get($this->model_name)->updateSitemapSettingLastmod('information');
      $this->registry->get($this->model_name)->updateProcessEndTime($process_id, time());
    }

    $this->generateBaseSitemapIndex($process_id, $params);
    
    $this->generateStoreSitemapIndex($process_id, $params);
    
    return $progress;
  }
  
  /**
   * Generates the XML sitemaps that include any other page URLs.
   *
   * @param integer $process_id
   * @param array $params
   * @return integer $progress
   */
  private function generatePageSitemap($process_id, $params) {
    $stores = $this->getStores();  
    
    $this->cli->out(sprintf($this->language->get('text_progress_message_preparing'), $this->language->get('text_type_'. $params['type'])));
    $this->logger->write('Info: ' . sprintf($this->language->get('text_log_message'), sprintf($this->language->get('text_progress_message_preparing'), $this->language->get('text_type_'. $params['type'])), __METHOD__, __LINE__, __FILE__));    
    
    $this->registry->get($this->model_name)->createTemporaryPages($params['stores']);
    
    $this->cli->out(sprintf($this->language->get('text_progress_message_generating'), $this->language->get('text_type_'. $params['type'])));
    $this->logger->write('Info: ' . sprintf($this->language->get('text_log_message'), sprintf($this->language->get('text_progress_message_generating'), $this->language->get('text_type_'. $params['type'])), __METHOD__, __LINE__, __FILE__));
    
    $total = $count = $progress = $page_count = 0;
    
    $total += $this->registry->get($this->model_name)->getTotalTemporaryPages($params['stores']);      

    $this->registry->get($this->model_name)->updateProcessStartTime($process_id, time());
    $this->registry->get($this->model_name)->updateProcessTotal($process_id, $total);    
    $this->registry->get($this->model_name)->updateProcessPrepared($process_id, true);
    
    if ($this->cli->isCli() && !$this->cli->isCron()) {
      $cli_progress_bar = new CliProgressBar();
    }
    
    foreach ($stores as $store) {
      
      $base_url = $store['url'];
      
      $sitemap_page_dir = $this->buildPath($this->getSitemapDirPath(), 'store', $store['store_id'], 'page' . DIRECTORY_SEPARATOR);
      
      $this->makeDir($sitemap_page_dir);
      $this->removeFiles($sitemap_page_dir . '*');
      $this->copyFile($this->buildPath($this->getSkeletonDirPath(), 'index.html'), $this->buildPath($this->getSitemapDirPath(), 'store', 'index.html'));
      $this->copyFile($this->buildPath($this->getSkeletonDirPath(), 'index.html'), $this->buildPath($this->getSitemapDirPath(), 'store', $store['store_id'], 'index.html'));
      $this->copyFile($this->buildPath($this->getSkeletonDirPath(), 'index.html'), $this->buildPath($this->getSitemapDirPath(), 'store', $store['store_id'], 'page', 'index.html'));
      
      $sitemap_index_file = $this->buildPath($this->getSitemapDirPath(), 'store', $store['store_id'], 'page', 'sitemap-index.xml');
      
      if (!$sitemap_index_handle = fopen($sitemap_index_file, 'w')) {
        $this->setError($process_id, sprintf($this->language->get('error_cannot_open_file'), $sitemap_index_file), __METHOD__, __FILE__, __LINE__);
      }

      $sitemap_index = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
      
      if ($params['use_xsl_stylesheets'] === true) {
        $sitemap_index .= '<?xml-stylesheet type="text/xsl" href="./sitemap-index.xsl"?>' . "\n";
      }
      
      $sitemap_index .= '<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";
      
      if (in_array($store['store_id'], $params['stores'])) {

        $page_total = $this->registry->get($this->model_name)->getTotalTemporaryPages((int)$store['store_id']);

        $num_pages = ceil($page_total / (int)$params['url_limit']);

        for ($page = 1; $page <= $num_pages; $page++) {

          $sitemap_file = $this->buildPath($this->getSitemapDirPath(), 'store', $store['store_id'], 'page', 'sitemap_' . $page . '.xml');

          if (!$sitemap_handle = fopen($sitemap_file, 'w')) {
            $this->setError($process_id, sprintf($this->language->get('error_cannot_open_file'), $sitemap_file), __METHOD__, __FILE__, __LINE__);
          }

          $sitemap = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
          
          if ($params['use_xsl_stylesheets'] === true) {
            $sitemap .= '<?xml-stylesheet type="text/xsl" href="./sitemap.xsl"?>' . "\n";
          }
          
          $sitemap .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xhtml="http://www.w3.org/1999/xhtml" xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">' . "\n";

          $custom_pages = $this->registry->get($this->model_name)->getTemporaryPages((int)$store['store_id'], array(
              'start' => ($page - 1) * (int)$params['url_limit'],
              'limit' => (int)$params['url_limit'],
          ));

          $page_count += count($custom_pages);

          foreach ($custom_pages as $index => $custom_page) {

            $timestamp = time();
            
            $sitemap .= '  <url>' . "\n";

            // The <loc> attribute
            $loc = $base_url . $custom_page['url'];
            $sitemap .= '    <loc>' . $loc . '</loc>' . "\n";
            unset($loc);

            // The <changefreq> attribute
            $sitemap .= '    <changefreq>' . $params['changefreq'] . '</changefreq>' . "\n";

            // The <priority> attribute
            $sitemap .= '    <priority>' . $params['priority'] . '</priority>' . "\n";          

            $sitemap .= '  </url>' . "\n";

            $count++;

            $errors = $this->getErrors($process_id);
            
            if ($errors) {
              foreach($this->getErrors($process_id) as $error) {
                $this->logger->write(sprintf($this->language->get('text_log_message'), $error['message'], $error['method'], $error['line'], $error['file']));
                $this->cli->out(sprintf($this->language->get('text_log_message'), $error['message'], $error['method'], $error['line'], $error['file']));
              }
              
              exit(-1);
              
            } else {
              $_progress = round(($count / $total) * 100);
              
              if ($progress < $_progress) {
                $progress = $_progress;
                $this->registry->get($this->model_name)->updateProcessProgress($process_id, $progress);
                $this->registry->get($this->model_name)->updateSitemapSettingLastmod('page');
                
                if ($_progress == 100) {
                  $this->registry->get($this->model_name)->updateProcessEndTime($process_id, time());
                }                
              }
              
              if ($timestamp < time() || $count == $total) {
                $this->registry->get($this->model_name)->updateProcessCompleted($process_id, $count);
              }              
              
              if ($this->cli->isCli() && !$this->cli->isCron()) {
                $cli_progress_bar->update($count, $total);
              }             
            }
            
            unset($errors); 
           
          }

          $sitemap .= '</urlset>' . "\n";

          if (fwrite($sitemap_handle, $sitemap) === false) {
            $this->setError($process_id, sprintf($this->language->get('error_cannot_write_to_file'), $sitemap_file), __METHOD__, __FILE__, __LINE__);
          }

          fclose($sitemap_handle);

          $sitemap_index .= '  <sitemap>' . "\n";
          $sitemap_index .= '    <loc>' . $this->buildPath(rtrim($base_url, DIRECTORY_SEPARATOR), $this->sitemap_dir, 'store', $store['store_id'], 'page', 'sitemap_' . $page . '.xml') . '</loc>' . "\n";
          $sitemap_index .= '    <lastmod>' . $this->getLastmod() . '</lastmod>' . "\n";
          $sitemap_index .= '  </sitemap>' . "\n";
        }
      }      

      $sitemap_index .= '</sitemapindex>' . "\n";

      if (fwrite($sitemap_index_handle, $sitemap_index) === false) {
        $this->setError($process_id, sprintf($this->language->get('error_cannot_write_to_file'), $sitemap_index_file), __METHOD__, __FILE__, __LINE__);
      }

      fclose($sitemap_index_handle);
      
      $this->addStylingToTypeSitemapIndex($process_id, 'page', $store);
      
      if (in_array($store['store_id'], $params['stores'])) {
        $this->addStylingToTypeSitemap($process_id, 'page', $store);
      }
    }
    
    if ($total <= 0) {
      $progress = 100;
      $this->registry->get($this->model_name)->updateProcessProgress($process_id, $progress);
      $this->registry->get($this->model_name)->updateSitemapSettingLastmod('page');
      $this->registry->get($this->model_name)->updateProcessEndTime($process_id, time());
    }

    $this->generateBaseSitemapIndex($process_id, $params);
    
    $this->generateStoreSitemapIndex($process_id, $params);
    
    return $progress;
  }
  
  /**
   * Add styling to a given XML sitemap index file.
   *
   * @param integer $process_id
   * @param string $type
   * @param array $store
   * @return void
   */  
  private function addStylingToTypeSitemapIndex($process_id, $type, $store) {
    $file = $this->buildPath($this->getSitemapDirPath(), 'store', (int)$store['store_id'], $type, 'sitemap-index.xsl');

    if (!$handle = fopen($file, 'w')) {
      $this->setError($process_id, sprintf($this->language->get('error_cannot_open_file'), $file), __METHOD__, __FILE__, __LINE__);
    }    

    $skeleton = file_get_contents($this->buildPath($this->getSkeletonDirPath(), 'sitemap-index.xsl'));

    $content = strtr($skeleton, array(
        '{{ title }}' => ucfirst($type) . ' XML Sitemap Index for "' . $store['name'] . '"',
    ));

    if (fwrite($handle, $content) === false) {
      $this->setError($process_id, sprintf($this->language->get('error_cannot_write_to_file'), $file), __METHOD__, __FILE__, __LINE__);
    }

    fclose($handle);
  }  
  
  /**
   * Add styling to a given XML sitemap file.
   *
   * @param integer $process_id
   * @param string $type
   * @param array $store
   * @return void
   */  
  private function addStylingToTypeSitemap($process_id, $type, $store) {
    $file = $this->buildPath($this->getSitemapDirPath(), 'store', (int)$store['store_id'], $type, 'sitemap.xsl');
    
    if (!$handle = fopen($file, 'w')) {
      $this->setError($process_id, sprintf($this->language->get('error_cannot_open_file'), $file), __METHOD__, __FILE__, __LINE__);
    }    
    
    $skeleton = file_get_contents($this->buildPath($this->getSkeletonDirPath(), 'sitemap.xsl'));
    
    $content = strtr($skeleton, array(
        '{{ title }}' => ucfirst($type) . ' XML Sitemap for "' . $store['name'] . '"',
    ));

    if (fwrite($handle, $content) === false) {
      $this->setError($process_id, sprintf($this->language->get('error_cannot_write_to_file'), $file), __METHOD__, __FILE__, __LINE__);
    }
    
    fclose($handle);
  }  

  /**
   * Generates a base sitemap index file.
   *
   * @param integer $process_id
   * @param array $params
   * @return void
   */
  private function generateBaseSitemapIndex($process_id, $params) {
    $file = $this->buildPath($this->getSitemapDirPath(), 'sitemap-index.xsl');
    
    $this->removeFiles($file);
    
    if (!$handle = fopen($file, 'w')) {
      $this->setError($process_id, sprintf($this->language->get('error_cannot_open_file'), $file), __METHOD__, __FILE__, __LINE__);
    }    
    
    $skeleton = file_get_contents($this->buildPath($this->getSkeletonDirPath(), 'sitemap-index.xsl'));
    
    $content = strtr($skeleton, array(
        '{{ title }}' => 'Base XML Sitemap Index',
    ));

    if (fwrite($handle, $content) === false) {
      $this->setError($process_id, sprintf($this->language->get('error_cannot_write_to_file'), $file), __METHOD__, __FILE__, __LINE__);
    }    
    
    fclose($handle);
    
    unset($file, $handle, $skeleton, $content);
    
    
    $file = $this->buildPath($this->getSitemapDirPath(), 'sitemap-index.xml');
    
    $this->removeFiles($file);
    
    if (!$handle = fopen($file, 'w')) {
      $this->setError($process_id, sprintf($this->language->get('error_cannot_open_file'), $file), __METHOD__, __FILE__, __LINE__);
    }
    
    $content = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
    
    if ($params['use_xsl_stylesheets'] === true) {
      $content .= '<?xml-stylesheet type="text/xsl" href="./sitemap-index.xsl"?>' . "\n";
    }
    
    $content .= '<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";
    
    $stores = $this->getStores();
    
    foreach ($stores as $store) {
      $base_url = rtrim($store['url'], DIRECTORY_SEPARATOR);

      $content .= '  <sitemap>' . "\n";
      $content .= '    <loc>' . $this->buildPath($base_url, $this->sitemap_dir, 'store', $store['store_id'], 'sitemap-index.xml') . '</loc>' . "\n";
      $content .= '    <lastmod>' . $this->getLastmod() . '</lastmod>' . "\n";
      $content .= '  </sitemap>' . "\n";
    }
    
    $content .= '</sitemapindex>' . "\n";
    
    if (fwrite($handle, $content) === false) {
      $this->setError($process_id, sprintf($this->language->get('error_cannot_write_to_file'), $file), __METHOD__, __FILE__, __LINE__);
    }

    fclose($handle);
  }
  
  /**
   * Generates second level sitemap index files for stores.
   *
   * @param integer $process_id
   * @param array $params
   * @return void
   */
  private function generateStoreSitemapIndex($process_id, $params) {
    $sitemap_settings = $this->registry->get($this->model_name)->getSitemapSettings();
    
    if (!$sitemap_settings) {
      return false;
    }
    
    $stores = $this->getStores();
    
    foreach ($stores as $store) {
      $file = $this->buildPath($this->getSitemapDirPath(), 'store', (int)$store['store_id'], 'sitemap-index.xsl');

      $this->removeFiles($file);

      if (!$handle = fopen($file, 'w')) {
        $this->setError($process_id, sprintf($this->language->get('error_cannot_open_file'), $file), __METHOD__, __FILE__, __LINE__);
      }    

      $skeleton = file_get_contents($this->buildPath($this->getSkeletonDirPath(), 'sitemap-index.xsl'));

      $content = strtr($skeleton, array(
          '{{ title }}' => 'XML Sitemap Index for "' . $store['name'] . '"',
      ));

      fwrite($handle, $content);      

      fclose($handle);

      unset($file, $handle, $skeleton, $content);


      $file = $this->buildPath($this->getSitemapDirPath(), 'store', (int)$store['store_id'], 'sitemap-index.xml');

      $this->removeFiles($file);

      if (!$handle = fopen($file, 'w')) {
        $this->setError($process_id, sprintf($this->language->get('error_cannot_open_file'), $file), __METHOD__, __FILE__, __LINE__);
      }

      $content = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
      
      if ($params['use_xsl_stylesheets'] === true) {
        $content .= '<?xml-stylesheet type="text/xsl" href="./sitemap-index.xsl"?>' . "\n";
      }

      $content .= '<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

      foreach ($sitemap_settings as $sitemap_setting) {
        $base_url = rtrim($store['url'], DIRECTORY_SEPARATOR);

        if (is_file($this->buildPath($this->getSitemapDirPath(), 'store', (int)$store['store_id'], $sitemap_setting['type'], 'sitemap-index.xml'))) {
          $content .= '  <sitemap>' . "\n";
          $content .= '    <loc>' . $this->buildPath($base_url, $this->sitemap_dir, 'store', (int)$store['store_id'], $sitemap_setting['type'], 'sitemap-index.xml') . '</loc>' . "\n";
          $content .= '    <lastmod>' . $this->getLastmod($sitemap_setting['date_modified']) . '</lastmod>' . "\n";
          $content .= '  </sitemap>' . "\n";
        }
      }

      $content .= '</sitemapindex>' . "\n";

      if (fwrite($handle, $content) === false) {
        $this->setError($process_id, sprintf($this->language->get('error_cannot_write_to_file'), $file), __METHOD__, __FILE__, __LINE__);
      }

      fclose($handle);
    }
  }
  
  /**
   * Build an product URL.
   *
   * @param Url class instance $url
   * @param string $base_url
   * @param array $product
   * @param array $params
   * @return string The product URL
   */
  private function buildProductUrl($url, $base_url, $product, $params) {
    $return = null;
    
    if ((bool)$this->config->get('config_seo_url') === true) {
      
      if ($product['seo_url']) {
        $path = $product['seo_url'];

      }	else {
        $path = null;
      }
      
      if ($path) {
        if ($this->multilingual_seo_toolkit->extensionEnabled() === true && $this->multilingual_seo_toolkit->isMultilingualSeoUrlEnabled() === true && $this->multilingual_seo_toolkit->isLanguagePrefixInUrlEnabled() === true) {
          $lang_prefix = $this->multilingual_seo_toolkit->getLangPrefix($product['language_code']);
          
          if ($lang_prefix) {
            $return = $base_url . $this->buildUrl($lang_prefix, $path);
          } else {  
            $return = $base_url . $path;
          }
        } else {
          $return = $base_url . $path;
        }
      }
      
      unset($path);
    }
    
    if (!$return) {
      $args = '';

      if ($product['product_id']) {
        $args = 'product_id=' . $product['product_id'];
      }

      if ((bool)$params['append_lang_param'] === true) {
        $args .= '&language=' . $product['language_code'];
      }

      $return = $url->link('product/product', $args);
      unset($args);
    }

    return $return;    
  }  
  
  /**
   * Build an category URL.
   *
   * @param Url class instance $url
   * @param string $base_url
   * @param array $category
   * @param array $params
   * @return string The category URL
   */
  private function buildCategoryUrl($url, $base_url, $category, $params) {
    $return = null;
    
    if ((bool)$this->config->get('config_seo_url') === true) {
      
      if ($category['category_seo_url'] && $category['product_seo_url']) {
        $path = $this->buildUrl($category['category_seo_url'], $category['product_seo_url']);

      } elseif ($category['category_seo_url'] && (!$category['product_seo_url'] && $category['product_id'])) {
        $path = $category['category_seo_url'] . '?product_id=' . $category['product_id'];

      } elseif ($category['category_seo_url'] && (!$category['product_seo_url'] && !$category['product_id'])) {	
        $path = $category['category_seo_url'];
        
      }	else {
        $path = null;
      }
      
      if ($path) {
        if ($this->multilingual_seo_toolkit->extensionEnabled() === true && $this->multilingual_seo_toolkit->isMultilingualSeoUrlEnabled() === true && $this->multilingual_seo_toolkit->isLanguagePrefixInUrlEnabled() === true) {
          $lang_prefix = $this->multilingual_seo_toolkit->getLangPrefix($category['language_code']);
          
          if ($lang_prefix) {
            $return = $base_url . $this->buildUrl($lang_prefix, $path);
          } else {  
            $return = $base_url . $path;
          }          
        } else {
          $return = $base_url . $path;
        }
      }
      
      unset($path);
    }
    
    if (!$return) {
      $args = '';

      if ($category['category_path'] && !$category['product_id']) {
        $args = 'path=' . $category['category_path'];
      } elseif ($category['category_path'] && $category['product_id']) {
        $args = 'path=' . $category['category_path'] . '&product_id=' . $category['product_id'];
      }

      if ((bool)$params['append_lang_param'] === true) {
        $args .= '&language=' . $category['language_code'];
      }

      $return = $url->link('product/category', $args);
      unset($args);
    }

    return $return;    
  }
  
  /**
   * Build an manufacturer URL.
   *
   * @param Url class instance $url
   * @param string $base_url
   * @param array $manufacturer
   * @param array $params
   * @return string The manufacturer URL
   */
  private function buildManufacturerUrl($url, $base_url, $manufacturer, $params) {
    $return = null;
    
    if ((bool)$this->config->get('config_seo_url') === true) {
      
      if ($manufacturer['manufacturer_seo_url'] && $manufacturer['product_seo_url']) {
        $path = $this->buildUrl($manufacturer['manufacturer_seo_url'], $manufacturer['product_seo_url']);

      } elseif ($manufacturer['manufacturer_seo_url'] && (!$manufacturer['product_seo_url'] && $manufacturer['product_id'])) {
        $path = $manufacturer['manufacturer_seo_url'] . '?product_id=' . $manufacturer['product_id'];

      } elseif ($manufacturer['manufacturer_seo_url'] && (!$manufacturer['product_seo_url'] && !$manufacturer['product_id'])) {	
        $path = $manufacturer['manufacturer_seo_url'];
        
      }	else {
        $path = null;
      }
      
      if ($path) {
        if ($this->multilingual_seo_toolkit->extensionEnabled() === true && $this->multilingual_seo_toolkit->isMultilingualSeoUrlEnabled() === true && $this->multilingual_seo_toolkit->isLanguagePrefixInUrlEnabled() === true) {
          $lang_prefix = $this->multilingual_seo_toolkit->getLangPrefix($manufacturer['language_code']);
          
          if ($lang_prefix) {
            $return = $base_url . $this->buildUrl($lang_prefix, $path);
          } else {  
            $return = $base_url . $path;
          }           
        } else {
          $return = $base_url . $path;
        }
      }
      
      unset($path);
    }
    
    if (!$return) {
      $args = '';

      if ($manufacturer['manufacturer_id'] && !$manufacturer['product_id']) {
        $args = 'path=' . $manufacturer['manufacturer_id'];
      } elseif ($manufacturer['manufacturer_id'] && $manufacturer['product_id']) {
        $args = 'path=' . $manufacturer['manufacturer_id'] . '&product_id=' . $manufacturer['product_id'];
      }

      if ((bool)$params['append_lang_param'] === true) {
        $args .= '&language=' . $manufacturer['language_code'];
      }

      $return = $url->link('product/manufacturer/info', $args);
      unset($args);
    }

    return $return;    
  }  
  
  /**
   * Build an information URL.
   *
   * @param Url class instance $url
   * @param string $base_url
   * @param array $information
   * @param array $params
   * @return string The information URL
   */
  private function buildInformationUrl($url, $base_url, $information, $params) {
    $return = null;
    
    if ((bool)$this->config->get('config_seo_url') === true) {
      
      if ($information['seo_url']) {
        $path = $information['seo_url'];

      }	else {
        $path = null;
      }
      
      if ($path) {
        if ($this->multilingual_seo_toolkit->extensionEnabled() === true && $this->multilingual_seo_toolkit->isMultilingualSeoUrlEnabled() === true && $this->multilingual_seo_toolkit->isLanguagePrefixInUrlEnabled() === true) {
          $lang_prefix = $this->multilingual_seo_toolkit->getLangPrefix($information['language_code']);
          
          if ($lang_prefix) {
            $return = $base_url . $this->buildUrl($lang_prefix, $path);
          } else {  
            $return = $base_url . $path;
          }            
        } else {
          $return = $base_url . $path;
        }
      }
      
      unset($path);
    }
    
    if (!$return) {
      $args = '';

      if ($information['information_id']) {
        $args = 'information_id=' . $information['information_id'];
      }

      if ((bool)$params['append_lang_param'] === true) {
        $args .= '&language=' . $information['language_code'];
      }

      $return = $url->link('information/information', $args);
      unset($args);
    }

    return $return;    
  }  
  
  /**
   * Get the stores that are currently enabled on the OpenCart installation.
   *
   * @param void
   * @return array $stores
   */
  private function getStores() {
    $this->load->model('setting/store');

    $stores = array_merge(array(array(
        'store_id' => 0,
        'name' => $this->config->get('config_name'),
        'url' => HTTP_CATALOG,
        'ssl' => HTTPS_CATALOG
    )), $this->registry->get('model_setting_store')->getStores()); 
    
    return $stores;
  }
  
  /**
   * Returns the datetime value for the lastmod tag.
   *
   * @param string $string Datetime string 
   * @return string Datetime string in W3C Datetime format
   */
  private function getLastmod($string = null) {
    $dateTime = new \DateTime($string);
    
    return $dateTime->format(\DateTime::W3C);
  }
  
  /**
   * Save a given process error to the database.
   *
   * @param integer $process_id
   * @param string $message
   * @param string $method
   * @param string $file
   * @param string $line
   * @return void
   */
  private function setError($process_id, $message, $method = '', $file = '', $line = '') {
    $errors = compact('message', 'method', 'file', 'line');
    $this->registry->get($this->model_name)->setErrorToProcess($process_id, $errors);
  }
  
  /**
   * Retrieve the process errors that have been stored in the database, if any.
   *
   * @param integer $process_id
   * @return array $errors
   */
  public function getErrors($process_id) {
    $errors = $this->registry->get($this->model_name)->getProcessErrors($process_id);
    return $errors;
  }
  
  /**
   * Build a file path with the appropriate directory separator.
   * 
   * @param string $segments  Unlimited number of path segments.
   * @return string Path
   */
  private function buildPath($segments) {
    return join(DIRECTORY_SEPARATOR, func_get_args($segments));
  }
  
  /**
   * Build a URL with slashes.
   * 
   * @param string $segments  Unlimited number of path segments.
   * @return string Path
   */
  private function buildUrl($segments) {
    return join('/', func_get_args($segments));
  }  
  
  /**
   * Makes a directory
   *
   * @param string $path The directory path. 
   * @return Returns true on success, false on failure, or null if $path exists. 
   */
  private function makeDir($path) {
    if (!file_exists($path)) {
      return mkdir($path, 0777, true);
    }
    
    return null; 
  }
  
  /**
   * Makes a copy of the file source to dest. 
   *
   * @param string $src Path to the source file. 
   * @param string $dest The destination path.
   * @return Returns true on success, false on failure, or null if $dest exists. 
   */
  private function copyFile($src, $dest) {
    if (!file_exists($dest)) {
      return copy($src, $dest);
    }
    
    return null; 
  }

  /**
   * Remove a single file or all files in  a directory.
   *
   * @param string $path Path to a file or directory.
   * @return void
   */
  private function removeFiles($path) {
    $files = glob($path);
    
    foreach ($files as $file) {
      if (is_file($file)) {
        unlink($file);
      }
    }
  }

  /**
   * [NOT BEING USED]
   * Remove a single file or all files in a directory.
   *
   * @param string $path The directory path.
   * @param string $search The value being searched for,
   * @return void
   */
  private function searchFileRecursive($path, $search) {
    $files = new \RecursiveIteratorIterator(
        new \RecursiveDirectoryIterator($path,
              FilesystemIterator::CURRENT_AS_FILEINFO |
              FilesystemIterator::KEY_AS_PATHNAME |
              FilesystemIterator::SKIP_DOTS
        ),
        \RecursiveIteratorIterator::SELF_FIRST
    );
    
    $files = new RegexIterator($files, '/^.+\/' . $search . '$/i', \RecursiveRegexIterator::MATCH);
      
    $paths = array();
    
    foreach($files as $path => $info) {
      $paths[] = $path;
    }
    
    return $paths;
  }
  
  /**
   * Get the partial path to the sitemap directory.
   *
   * @param void
   * @return string
   */
  public function getSitemapDir() {
    return $this->sitemap_dir;
  }
  
  /**
   * Get the URL for the base sitemap index xml file.
   *
   * @param void
   * @return string
   */
  public function getBaseSitemapIndexUrl() {
    return $this->buildPath(rtrim(HTTP_CATALOG, '/'),  $this->getSitemapDir() , 'sitemap-index.xml');
  }  
  
  /**
   * Get the full path to the sitemap directory.
   *
   * @param void
   * @return string Path to the sitemap directory.
   */
  public function getSitemapDirPath() {
    return $this->buildPath($this->root_path, $this->sitemap_dir);
  }  
  
  /**
   * Get the full path to the skeleton directory.
   *
   * @param void
   * @return string Path to the skeleton directory.
   */
  public function getSkeletonDirPath() {
    return $this->buildPath(rtrim(DIR_SYSTEM, DIRECTORY_SEPARATOR), 'library', $this->_code, 'skeleton');
  }  
  
  /**
   * Get the full path to the lock directory.
   *
   * @param void
   * @return string Path to the lock directory.
   */
  public function getLockDirPath() {
    if (version_compare(VERSION, '3.0.1.0', '<')) { // OpenCart 3.0.0.2 or earlier.
      $path = $this->buildPath(DIR_SYSTEM . 'storage', $this->_code);
    } else { // OpenCart 3.0.1.0 or later.
      $path = $this->buildPath(rtrim(DIR_STORAGE, DIRECTORY_SEPARATOR), $this->_code);
    }    
    
    return $path;
  }
  
  /**
   * Get the full path to the lock file.
   *
   * @param void
   * @return string Path to the lock file.
   */
  public function getLockFilePath() {
    return $this->buildPath($this->getLockDirPath(), 'lock.txt');
  }
  
  /**
   * Checks if a process is running.
   *
   * @param void
   * @return boolean True or false
   */
  public function isProcessLocked() {
    $return = false;
    
    if (is_file($this->getLockFilePath())) {
      $file_handle = fopen($this->getLockFilePath(), 'r+');

      if (!flock($file_handle, LOCK_EX | LOCK_NB)) {
        $return = true;
      }

      fclose($file_handle);
    }
    
    return $return;
  }
  
  /**
   * Passes in the number of seconds elapsed to get "hours:minutes:seconds" returned.
   * 
   * @param integer $seconds Seconds
   * @return string Time in hh:mm:ss format
   */
  public function toTime($seconds) {
    $t = round($seconds);
    return sprintf('%02d:%02d:%02d', ($t/3600),($t/60%60), $t%60);
  }
  
  /**
   * Detects an AJAX request.
   *
   * @param void
   * @return boolean True or false
   */
  public function isAjax() {
    if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
      return true;
    }
    
    return false;
  }
  
  /**
   * Checks if a given PHP function is enabled.
   *
   * @param string $name The PHP function name
   * @return boolean True or false
   */ 
  public function functionEnabled($name) {
    $disabled = explode(',', ini_get('disable_functions'));
    return !in_array($name, $disabled);
  }
  
  /**
   * Get the version of this extension.
   *
   * @param void
   * @return string The version of this extension.
   */
  public function getVersion() {
    return $this->version;
  }

}
