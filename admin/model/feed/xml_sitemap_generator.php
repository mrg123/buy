<?php
/**
 * XML Sitemap Generator
 * 
 * @author  Cuispi
 * @version 1.0.1
 * @license Commercial License
 * @package admin
 * @subpackage  admin.model.feed
 */

require_once DIR_SYSTEM . 'library/xml_sitemap_generator/multilingual_seo_toolkit.php';

use XmlSitemapGenerator\MultilingualSeoToolkit;

class ModelFeedXmlSitemapGenerator extends Model {

  /**
   * Holds the instance of the MultilingualSeoToolkit class.
   *
   * @var class object
   */  
  protected $multilingual_seo_toolkit;
  
  /**
   * Constructor.
   *
   * @param object $registry
   * @return void
   */
	public function __construct($registry) {
    parent::__construct($registry);
    
    try {
      if (!class_exists('XmlSitemapGenerator\MultilingualSeoToolkit')) {
        throw new Exception('The MultilingualSeoToolkit class cannot be found.'); 
      }
      
      $this->multilingual_seo_toolkit = new MultilingualSeoToolkit($registry);
    }
    catch (Exception $e) {
      exit($e->getMessage());
    }
    
    $this->multilingual_seo_toolkit = new MultilingualSeoToolkit($registry);
	}
  
  /**
   * getSitemapSettings method
   *
   * @param void
   * @return array
   */ 
	public function getSitemapSettings() {
    $sql = "SELECT * FROM " . DB_PREFIX . "xml_sitemap_generator_sitemap_setting ORDER BY sort_order ASC";
    
    $query = $this->db->query($sql);
    
		return $query->rows;
	}

  /**
   * Get the sitemap setting of a given type.
   *
   * @param string $type
   * @return array $query->row
   */  
	public function getSitemapSetting($type) {
    $sql = "SELECT * FROM " . DB_PREFIX . "xml_sitemap_generator_sitemap_setting WHERE type = '" . $this->db->escape($type) . "'";

    $query = $this->db->query($sql);
    
    return $query->row;
	}
  
  /**
   * Update the sitemap setting of a given type.
   *
   * @param string $type
   * @param array $data
   * @return void
   */  
	public function updateSitemapSetting($type, $data) {
    $sql = "UPDATE " . DB_PREFIX . "xml_sitemap_generator_sitemap_setting";
    $sql .= " SET";
    $sql .= "   changefreq = '" . $this->db->escape($data['changefreq']) . "',";
    $sql .= "   priority = '" . $this->db->escape($data['priority']) . "',";
    $sql .= "   url_limit  = '" . $this->db->escape($data['url_limit']) . "',";
    $sql .= "   date_modified = NOW()";
    $sql .= " WHERE type = '" . $this->db->escape($type) . "'";

    $this->db->query("DELETE FROM " . DB_PREFIX . "xml_sitemap_generator_sitemap_setting_to_store WHERE sitemap_setting_type = '" . $this->db->escape($type) . "'");

		if (isset($data['sitemap_setting_store']) && $data['sitemap_setting_store']) {
			foreach ($data['sitemap_setting_store'] as $store_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "xml_sitemap_generator_sitemap_setting_to_store SET sitemap_setting_type = '" . $this->db->escape($type) . "', store_id = '" . (int)$store_id . "'");
			}
		}    
    
    $this->db->query($sql);
	}  
  
  /**
   * Get the sitemap setting stores of a given type.
   *
   * @param string $type
   * @return $sitemap_setting_store_data
   */ 
	public function getSitemapSettingStores($type) {
		$sitemap_setting_store_data = array();

    $sql = "SELECT s2s.store_id AS s2s_store_id , s.store_id AS s_store_id  FROM " . DB_PREFIX . "xml_sitemap_generator_sitemap_setting_to_store s2s";
    $sql .= " LEFT JOIN " . DB_PREFIX . "store s ON (s2s.store_id = s.store_id) ";
    $sql .= " WHERE sitemap_setting_type = '" . $this->db->escape($type) . "'";
    
    $query = $this->db->query($sql);    
    
		foreach ($query->rows as $result) {
      if ($result['s2s_store_id'] == 0 || $result['s2s_store_id'] == $result['s_store_id']) {
        $sitemap_setting_store_data[] = (int)$result['s2s_store_id'];
      }
		}

		return $sitemap_setting_store_data;
	}
  
  /**
   * Get the value of the "lastmod" column in the sitemap setting of a given type.
   *
   * @param string $type
   * @return void
   */ 
	public function getSitemapSettingLastmod($type) {
    $query = $this->db->query("SELECT lastmod FROM " . DB_PREFIX . "xml_sitemap_generator_sitemap_setting WHERE type = '" . $this->db->escape($type) . "'");
    
		return $query->row['lastmod'];    
	}
  
  /**
   * Update the value of the "lastmod" column in the sitemap setting of a given type.
   *
   * @param string $type
   * @return void
   */ 
	public function updateSitemapSettingLastmod($type) {
    $this->db->query("UPDATE " . DB_PREFIX . "xml_sitemap_generator_sitemap_setting SET lastmod = NOW() WHERE type = '" . $this->db->escape($type) . "'");
	}
  
  /**
   * Get the queue of a given queue ID.
   *
   * @param integer $queue_id
   * @return array
   */ 
	public function getQueue($queue_id) {
    $sql = "SELECT * FROM " . DB_PREFIX . "xml_sitemap_generator_queue";
    $sql .= " WHERE queue_id = '" . (int)$queue_id . "'";
    
    $query = $this->db->query($sql);

		return $query->row;
	}
  
  /**
   * Creates a queue with given parameters.
   *
   * @param array $data
   * @return integer $queue_id
   */ 
	public function createQueue($data = array()) {
    $sql = "INSERT INTO " . DB_PREFIX . "xml_sitemap_generator_queue";
    $sql .= " SET";
    $sql .= "   params = '" . $this->db->escape(json_encode($data)) . "',";
    $sql .= "   date_added = NOW(),";
    $sql .= "   date_modified = NOW()";
    
    $this->db->query($sql);
    
    $queue_id = $this->db->getLastId();

		return $queue_id;
	}
  
  /**
   * Get the process of a given process ID.
   *
   * @param integer $process_id
   * @return array
   */ 
	public function getProcess($process_id) {
    $sql = "SELECT * FROM " . DB_PREFIX . "xml_sitemap_generator_process";
    $sql .= " WHERE process_id = '" . (int)$process_id . "'";
    
    $query = $this->db->query($sql);

		return $query->row;
	}
  
  /**
   * Create a process of a given type with given parameters.
   *
   * @param string $type
   * @param array $params
   * @param integer $queue_id
   * @return integer $process_id
   */ 
	public function createProcess($type, $params = array(), $queue_id = null) {
    $sql = "INSERT INTO " . DB_PREFIX . "xml_sitemap_generator_process";
    $sql .= " SET";
    
    if (is_numeric($queue_id)) {
      $sql .= "   queue_id = '" . (int)$queue_id. "',";
    }
    
    $sql .= "   type = '" . $this->db->escape($type) . "',";
    $sql .= "   progress = 0,";
    $sql .= "   params = '" . $this->db->escape(json_encode($params)) . "',";
    $sql .= "   errors = '" . $this->db->escape(json_encode(array())) . "',";
    $sql .= "   date_added = NOW(),";
    $sql .= "   date_modified = NOW()";
    
    $this->db->query($sql);
    
    $process_id = $this->db->getLastId();

		return $process_id;
	}
  
  /**
   * Checks if a process that meets given queue ID and type exists. 
   *
   * @param integer $queue_id
   * @param string $type
   * @return boolean Returns true if a record that meets given queue ID and type exists, false otherwise.
   */ 
	public function hasProcess($queue_id, $type) {
    $sql = "SELECT COUNT(*) AS total FROM " . DB_PREFIX . "xml_sitemap_generator_process";
    $sql .= " WHERE";
    $sql .= "   queue_id = '" . (int)$queue_id . "'";
    $sql .= "   AND type = '" . $this->db->escape($type) . "'";
    
    $query = $this->db->query($sql);

		return $query->row['total'] > 0 ? true : false;
	}  
  
  /**
   * Update the progress field of a given process.
   *
   * @param integer $process_id
   * @param integer $value
   * @return void
   */ 
	public function updateProcessProgress($process_id, $value) {
    $sql = "UPDATE " . DB_PREFIX . "xml_sitemap_generator_process";
    $sql .= " SET";
    $sql .= "   progress = '" . (int)$value . "',";
    $sql .= "   date_modified = NOW()";
    $sql .= " WHERE process_id = '" . (int)$process_id . "'";

    $this->db->query($sql);
	}
  
  /**
   * Update the completed field of a given process.
   *
   * @param integer $process_id
   * @param integer $value
   * @return void
   */ 
	public function updateProcessCompleted($process_id, $value) {
    $sql = "UPDATE " . DB_PREFIX . "xml_sitemap_generator_process";
    $sql .= " SET";
    $sql .= "   completed = '" . (int)$value . "',";
    $sql .= "   date_modified = NOW()";
    $sql .= " WHERE process_id = '" . (int)$process_id . "'";

    $this->db->query($sql);
	}
  
  /**
   * Update the total field of a given process.
   *
   * @param integer $process_id
   * @param integer $value
   * @return void
   */ 
	public function updateProcessTotal($process_id, $value) {
    $sql = "UPDATE " . DB_PREFIX . "xml_sitemap_generator_process";
    $sql .= " SET";
    $sql .= "   total = '" . (int)$value . "',";
    $sql .= "   date_modified = NOW()";
    $sql .= " WHERE process_id = '" . (int)$process_id . "'";

    $this->db->query($sql);
	}
  
  /**
   * Update the start_time field of a given process.
   *
   * @param integer $process_id
   * @param integer $value
   * @return void
   */ 
	public function updateProcessStartTime($process_id, $value) {
    $sql = "UPDATE " . DB_PREFIX . "xml_sitemap_generator_process";
    $sql .= " SET";
    $sql .= "   start_time = '" . (int)$value . "',";
    $sql .= "   date_modified = NOW()";
    $sql .= " WHERE process_id = '" . (int)$process_id . "'";

    $this->db->query($sql);
	}
  
  /**
   * Update the end_time field of a given process.
   *
   * @param integer $process_id
   * @param integer $value
   * @return void
   */ 
	public function updateProcessEndTime($process_id, $value) {
    $sql = "UPDATE " . DB_PREFIX . "xml_sitemap_generator_process";
    $sql .= " SET";
    $sql .= "   end_time = '" . (int)$value . "',";
    $sql .= "   date_modified = NOW()";
    $sql .= " WHERE process_id = '" . (int)$process_id . "'";

    $this->db->query($sql);
	}
  
  /**
   * Update the "prepared" column in the process table.
   *
   * @param integer $process_id
   * @param string $value True or false
   * @return void
   */ 
	public function updateProcessPrepared($process_id, $value) {
    $sql = "UPDATE " . DB_PREFIX . "xml_sitemap_generator_process";
    $sql .= " SET";
    $sql .= "   prepared = '" . $this->db->escape((bool)$value) . "'";
    $sql .= " WHERE process_id = '" . (int)$process_id . "'";

    $this->db->query($sql);
	}
  
  /**
   * Update the "finalized" column in the process table.
   *
   * @param integer $process_id
   * @param string $value True or false
   * @return void
   */ 
	public function updateProcessFinalized($process_id, $value) {
    $sql = "UPDATE " . DB_PREFIX . "xml_sitemap_generator_process";
    $sql .= " SET";
    $sql .= "   finalized = '" . $this->db->escape((bool)$value) . "'";
    $sql .= " WHERE process_id = '" . (int)$process_id . "'";

    $this->db->query($sql);
	}
  
  /**
   * Save a given process error to the database.
   *
   * @param integer $process_id
   * @param string $error
   * @return void
   */ 
	public function setErrorToProcess($process_id, $error) {
    $data = $this->getProcess($process_id);
    $errors = json_decode($data['errors'], true);
    $errors[] = $error;
    
    $sql = "UPDATE " . DB_PREFIX . "xml_sitemap_generator_process";
    $sql .= " SET";
    $sql .= "   errors = '" . $this->db->escape(json_encode($errors)) . "'";
    $sql .= " WHERE process_id = '" . (int)$process_id . "'";

    $this->db->query($sql);
	}
  
  /**
   * Retrieve the process errors that have been stored in the database, if any.
   *
   * @param integer $process_id
   * @return array $errors
   */ 
	public function getProcessErrors($process_id) {
    $data = $this->getProcess($process_id);
    $errors = json_decode($data['errors'], true);
    return $errors;
	}
  
  /**
   * Get the next task in a queue..
   *
   * @param string $current_task The current task
   * @param integer $queue_id The queue ID
   * @return Returns the next task as a string, null if no process left, or false if there is no task in a queue.
   */
  public function getNextTask($current_task, $queue_id = null) {
    if (!$queue_id) {
      return false;
    }
    
    $queue = $this->getQueue($queue_id);
    
    $params = json_decode($queue['params'], true);

    if (!$params['tasks']) {
      return false;
    }
    
    $key = array_search($current_task, $params['tasks']);
    
    if (!is_numeric($key)) {
      return false;
    }
  
    $current = key($params['tasks']);
    
    while ($current !== null && $current != $key) {
      next($params['tasks']);
      $current = key($params['tasks']);
    }
    
    $next_task = next($params['tasks']);
    
    return $next_task;
  }  
  
  /**
   * Get the stores other than the default.
   *
   * @param void
   * @return array
   */  
	public function getStores() {
    $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "store ORDER BY url");
		return $query->rows;
	}
  
  /**
   * Creates temporary data for Products.
   *
   * @param integer or array $store_id
   * @return void
   */  
	public function createTemporaryProducts($store_id) {
    $this->db->query("TRUNCATE TABLE " . DB_PREFIX . "xml_sitemap_generator_temporary_product");
    
    if (!$store_id) {
      return;
    }
    
    $sql = "INSERT INTO " . DB_PREFIX . "xml_sitemap_generator_temporary_product (";
    $sql .= "   product_id,";
    $sql .= "   store_id,";
    $sql .= "   language_id,";
    $sql .= "   language_code,";
    $sql .= "   seo_url,";
    $sql .= "   name,";
    $sql .= "   image,";
    $sql .= "   lastmod,";
    $sql .= "   date_added,";
    $sql .= "   date_modified";
    $sql .= " )";
    $sql .= " SELECT";
    $sql .= "   p.product_id,";
    $sql .= "   p2s.store_id,";
    $sql .= "   pd.language_id,";
    $sql .= "   l.code AS language_code,";
    
    if (version_compare(VERSION, '3.0.0.0', '<') && $this->multilingual_seo_toolkit->extensionEnabled() === false) { // OpenCart 2.3.0.2 or earlier.
      $sql .= "   (SELECT keyword FROM " . DB_PREFIX . "url_alias WHERE query = CONCAT('product_id=', p.product_id)) AS keyword,";
    } else { // OpenCart 3.0.0.0 or later.
      $sql .= "   (SELECT keyword FROM " . DB_PREFIX . "seo_url WHERE query = CONCAT('product_id=', p.product_id) AND store_id = p2s.store_id AND language_id = pd.language_id) AS keyword,";
    }
    
    $sql .= "   pd.name,";
    $sql .= "   p.image,";
    $sql .= "   p.date_modified,";
    $sql .= "   NOW(),";
    $sql .= "   NOW()";
    $sql .= " FROM " . DB_PREFIX . "product p";
    $sql .= " LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id)";
    $sql .= " LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id)";
    $sql .= " RIGHT JOIN " . DB_PREFIX . "language l ON (pd.language_id = l.language_id)";
    $sql .= " WHERE";
    $sql .= "   p.status = '1'";
    $sql .= "   AND p.date_available <= NOW()";
    $sql .= "   AND l.status = '1'";
    
    if (is_numeric($store_id)) {
      $sql .= " AND p2s.store_id = '" . (int)$store_id . "'";
      
    } elseif (is_array($store_id)) {
      $sql .= " AND p2s.store_id IN (" . implode(',', $store_id) . ")";
    }      
    
    if ((bool)$this->config->get('config_seo_url') === false) {
      $sql .= "   AND l.language_id = (SELECT language_id FROM " . DB_PREFIX . "language ORDER BY sort_order ASC LIMIT 1)";
    }
    
    $sql .= " ORDER BY";
    $sql .= "   p.sort_order ASC,";
    $sql .= "   p.product_id ASC,";
    $sql .= "   p2s.store_id ASC,";
    $sql .= "   l.sort_order ASC,";
    $sql .= "   LCASE(pd.name) ASC";    
    
    $this->db->query($sql);
  }
  
  /**
   * Get the total number of the rows in the temporary data set for Products.
   *
   * @param integer or array $store_id
   * @return void
   */  
  public function getTotalTemporaryProducts($store_id) {
    if (is_array($store_id) && empty($store_id)) {
      return 0;
    }
    
    $sql = "SELECT COUNT(product_id) AS total FROM " . DB_PREFIX . "xml_sitemap_generator_temporary_product";
    
    if (is_numeric($store_id)) {
      $sql .= " WHERE store_id = '" . (int)$store_id . "'";
      
    } elseif (is_array($store_id)) {
      $sql .= " WHERE store_id IN (" . implode(',', $store_id) . ")";
    }	
    
    $query = $this->db->query($sql);
    
    return (int)$query->row['total'];
  }
  
  /**
   * Get the products in the temporary data set.
   *
   * @param integer $store_id
   * @param array $data
   * @return array
   */  
	public function getTemporaryProducts($store_id, $data = array()) {
    $data = array_merge(array(
        'start' => null,
        'limit' => null,
    ), $data);
    
    $sql = "SELECT";
    $sql .= "   *";
    $sql .= " FROM " . DB_PREFIX . "xml_sitemap_generator_temporary_product";
    $sql .= " WHERE store_id = '" . (int)$store_id . "'";
    
    if (isset($data['start']) || isset($data['limit'])) {
      if ($data['start'] < 0) {
        $data['start'] = 0;
      }

      if ($data['limit'] < 1) {
        $data['limit'] = 20;
      }

      $sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
    }   

    $query = $this->db->query($sql);
    
    $product_data = $query->rows;

    return $product_data;
	}   
  
  /**
   * Retrieves the alternate language products in the temporary data set.
   *
   * @param integer $store_id
   * @param integer $product_id
   * @return array
   */  
	public function getAltLangTemporaryProducts($store_id, $product_id) {
    $sql = "SELECT";
    $sql .= "   tp.product_id,";
    $sql .= "   tp.store_id,";
    $sql .= "   tp.language_id,";
    $sql .= "   tp.language_code,";
    $sql .= "   tp.seo_url,";
    $sql .= "   tp.name";
    $sql .= " FROM " . DB_PREFIX . "xml_sitemap_generator_temporary_product tp";
    $sql .= " RIGHT JOIN " . DB_PREFIX . "language l ON (tp.language_id = l.language_id)";
    $sql .= " WHERE";
    $sql .= "   tp.store_id = '" . (int)$store_id . "'";
    $sql .= "   AND tp.product_id = '". (int)$product_id . "'";
    $sql .= " ORDER BY";   
    $sql .= "   l.sort_order";

    $query = $this->db->query($sql);
    
    $product_data = $query->rows;

    return $product_data;
  }
  
  /**
   * Creates temporary data for Categories.
   *
   * @param integer or array $store_id
   * @return void
   */  
	public function createTemporaryCategories($store_id) {
    $this->db->query("TRUNCATE TABLE " . DB_PREFIX . "xml_sitemap_generator_temporary_category");
    
    if (!$store_id) {
      return;
    }
    
    // Get stores.
    $this->load->model('setting/store');

    $stores = array_merge(array(array(
        'store_id' => 0,
        'name' => $this->config->get('config_name'),
        'url' => HTTP_CATALOG,
        'ssl' => HTTPS_CATALOG
    )), $this->model_setting_store->getStores());      
    
    // Get languages.
    $this->load->model('localisation/language');
    
    $languages = $this->model_localisation_language->getLanguages();     
    
    
    $sql = "INSERT INTO " . DB_PREFIX . "xml_sitemap_generator_temporary_category (";
    $sql .= "   category_id,"; 
    $sql .= "   store_id,";
    $sql .= "   language_id,";
    $sql .= "   language_code,";
    $sql .= "   category_seo_url,";
    $sql .= "   category_name,";
    $sql .= "   image,";
    $sql .= "   lastmod,";
    $sql .= "   date_added,";
    $sql .= "   date_modified";
    $sql .= " )";
    $sql .= " SELECT";
    $sql .= "   c.category_id,"; 
    $sql .= "   c2s.store_id,"; 
    $sql .= "   cd.language_id,"; 
    $sql .= "   l.code AS language_code,"; 
    //$sql .= "   (SELECT keyword FROM " . DB_PREFIX . "seo_url WHERE query = CONCAT('category_id=', c.category_id) AND store_id = c2s.store_id AND language_id = cd.language_id) AS keyword,"; 
    $sql .= "   NULL,"; 
    $sql .= "   cd.name,"; 
    $sql .= "   NULL,"; 
    $sql .= "   c.date_modified,"; 
    $sql .= "    NOW(),"; 
    $sql .= "    NOW()"; 
    $sql .= " FROM " . DB_PREFIX . "category c";
    $sql .= " LEFT JOIN " . DB_PREFIX . "category_description cd ON (c.category_id = cd.category_id)";
    $sql .= " LEFT JOIN " . DB_PREFIX . "category_to_store c2s ON (c.category_id = c2s.category_id)";
    $sql .= " RIGHT JOIN " . DB_PREFIX . "language l ON (cd.language_id = l.language_id)";
    $sql .= " WHERE";
    $sql .= "   c.status = '1'";
    $sql .= "   AND l.status = '1'";
    
    if (is_numeric($store_id)) {
      $sql .= " AND c2s.store_id = '" . (int)$store_id . "'";
      
    } elseif (is_array($store_id)) {
      $sql .= " AND c2s.store_id IN (" . implode(',', $store_id) . ")";
    } 
    
    if ((bool)$this->config->get('config_seo_url') === false) {
      $sql .= "   AND l.language_id = (SELECT language_id FROM " . DB_PREFIX . "language ORDER BY sort_order ASC LIMIT 1)";
    }
    
    $sql .= " ORDER BY";
    $sql .= "   c.sort_order ASC,";
    $sql .= "   c.category_id ASC,";
    $sql .= "   c2s.store_id ASC,";
    $sql .= "   l.sort_order ASC,";
    $sql .= "   LCASE(cd.name) ASC";
    
    $this->db->query($sql);
    
    unset($sql);
    
    
    $query = $this->db->query("SELECT category_id FROM " . DB_PREFIX . "category ORDER BY category_id");
    
    $categories = $query->rows;

    $this->db->query("SET SQL_SAFE_UPDATES = 0");
    
    foreach($categories as $category) {
      
      $sql = "SELECT";
      //$sql .= "	CONCAT(REPEAT('    ', level  - 1), category_id) AS tree_item,";
      //$sql .= "	level,";
      $sql .= "	@path := (IF (@path <> '0', CONCAT_WS('_', @path, category_id), category_id)) AS path";
      $sql .= " FROM (";
      $sql .= "   SELECT";
      $sql .= "     _category_id AS category_id,";
      $sql .= "     parent_id,";
      $sql .= "     @cl := @cl + 1 AS level,";
      $sql .= "     @path := @r";
      $sql .= "   FROM (";
      $sql .= "			SELECT";
      $sql .= "				@r AS _category_id,";
      $sql .= "				(";
      $sql .= "					SELECT";
      $sql .= "						@r := parent_id";
      $sql .= "					FROM " . DB_PREFIX . "category";
      $sql .= "					WHERE category_id = _category_id";
      $sql .= "				) AS parent_id,";
      $sql .= "				@l := @l + 1 AS level";
      $sql .= "			FROM (";
      $sql .= "				SELECT @r := " . (int)$category['category_id'] . ", @l := 0, @cl := 0";
      $sql .= "			) vars,";
      $sql .= "			" . DB_PREFIX . "category c";
      $sql .= "			WHERE";
      $sql .= "				@r <> 0";
      $sql .= "			ORDER BY level DESC";
      $sql .= "		) qi";
      $sql .= " ) qo";
      $sql .= " ORDER BY path DESC";
      $sql .= " LIMIT 1";
      
      $query = $this->db->query($sql);  
      
      $category_path = $query->row['path'];
      
      unset($sql, $query);

      
      $sql = "UPDATE " . DB_PREFIX . "xml_sitemap_generator_temporary_category SET";
      $sql .= " category_path = '". $category_path . "',";
      $sql .= " date_modified = NOW()";
      $sql .= " WHERE category_id = '". (int)$category['category_id'] . "'";

      $this->db->query($sql);
      
      unset($sql);

      
      foreach($stores as $store) {
        foreach($languages as $language) {
          
          $sql = "SELECT";
          $sql .= "  CONCAT(REPEAT('    ', level  - 1), category_id) AS tree_item,";
          $sql .= "  level,";
          $sql .= "  keyword,";
          //$sql .= "  @seo_url := CONCAT_WS('/', @seo_url, keyword) AS seo_url";
          $sql .= "  IF (keyword IS NULL,";
          $sql .= "     NULL,";
          $sql .= "     @seo_url := (TRIM(LEADING '/' FROM CONCAT_WS('/', @seo_url, keyword)))";
          $sql .= "  ) AS seo_url";
          $sql .= " FROM (";
          $sql .= "  SELECT";
          $sql .= "    _category_id AS category_id,";
          $sql .= "    parent_id,";
          $sql .= "    @cl := @cl + 1 AS level,";
          $sql .= "    @seo_url := '',";
          
          if (version_compare(VERSION, '3.0.0.0', '<') && $this->multilingual_seo_toolkit->extensionEnabled() === false) { // OpenCart 2.3.0.2 or earlier.
            $sql .= "    (";
            $sql .= "      SELECT keyword FROM " . DB_PREFIX . "url_alias";
            $sql .= "      WHERE query = CONCAT('category_id=', _category_id)";
            $sql .= "    ) AS keyword";            
          } else { // OpenCart 3.0.0.0 or later.
            $sql .= "    (";
            $sql .= "      SELECT keyword FROM " . DB_PREFIX . "seo_url";
            $sql .= "      WHERE query = CONCAT('category_id=', _category_id) AND store_id = c2s.store_id AND language_id = cd.language_id";
            $sql .= "    ) AS keyword";
          }    
          
          $sql .= "  FROM (";
          $sql .= "      SELECT";
          $sql .= "        @r AS _category_id,";
          $sql .= "        (";
          $sql .= "          SELECT";
          $sql .= "            @r := parent_id";
          $sql .= "          FROM " . DB_PREFIX . "category";
          $sql .= "          WHERE category_id = _category_id";
          $sql .= "        ) AS parent_id,";
          $sql .= "        @l := @l + 1 AS level";
          $sql .= "      FROM (";
          $sql .= "        SELECT @r := " . (int)$category['category_id'] . ", @l := 0, @cl := 0";
          $sql .= "      ) vars,";
          $sql .= "      " . DB_PREFIX . "category c";
          $sql .= "      WHERE";
          $sql .= "        @r <> 0";
          $sql .= "      ORDER BY level DESC";
          $sql .= "    ) qi";
          $sql .= "    LEFT JOIN " . DB_PREFIX . "category_description cd ON (_category_id = cd.category_id)";
          $sql .= "    LEFT JOIN " . DB_PREFIX . "category_to_store c2s ON (_category_id = c2s.category_id)";
          $sql .= "    RIGHT JOIN " . DB_PREFIX . "language l ON (cd.language_id = l.language_id)";
          $sql .= "    WHERE";
          $sql .= "      cd.language_id = '" . (int)$language['language_id'] . "'";
          $sql .= "      AND c2s.store_id = '" . (int)$store['store_id'] . "'";
          $sql .= " ) qo";
          $sql .= " ORDER BY level ASC";

          $query = $this->db->query($sql);
          
          $row = end($query->rows);
          $seo_url = $row['seo_url'];

          unset($sql, $query);
          
          if ($seo_url) {
            $sql = "UPDATE " . DB_PREFIX . "xml_sitemap_generator_temporary_category SET";
            $sql .= " category_seo_url = '". $seo_url . "',";
            $sql .= " date_modified = NOW()";
            $sql .= " WHERE";
            $sql .= "   category_id = '". (int)$category['category_id'] . "'";
            $sql .= "   AND store_id = '". (int)$store['store_id'] . "'";
            $sql .= "   AND language_id = '". (int)$language['language_id'] . "'";

            $this->db->query($sql);

            unset($sql);          
          }
          
          unset($seo_url);
        }    
      }
    }

    $sql = "INSERT INTO " . DB_PREFIX . "xml_sitemap_generator_temporary_category (";
    $sql .= "   category_id,";
    $sql .= "   store_id, ";
    $sql .= "   language_id,";
    $sql .= "   language_code,";
    $sql .= "   product_id,";
    $sql .= "   category_path,";
    $sql .= "   category_seo_url ,";
    $sql .= "   product_seo_url ,";
    $sql .= "   category_name,";
    $sql .= "   product_name,";
    $sql .= "   image,";
    $sql .= "   lastmod,";
    $sql .= "   date_added,";
    $sql .= "   date_modified ";
    $sql .= " )";
    $sql .= " SELECT";
    $sql .= "   p2c.category_id,";
    $sql .= "   p2s.store_id, ";
    $sql .= "   pd.language_id,";
    $sql .= "   l.code AS language_code,";
    $sql .= "   p.product_id,";
    $sql .= "   tc.category_path,";
    $sql .= "   tc.category_seo_url,";
    
    #========== Custom Settings: BEGIN ==========
    
    if (version_compare(VERSION, '3.0.0.0', '<') && $this->multilingual_seo_toolkit->extensionEnabled() === false) { // OpenCart 2.3.0.2 or earlier.
      $sql .= "   (SELECT keyword FROM " . DB_PREFIX . "url_alias WHERE query = CONCAT('product_id=', p.product_id)) AS product_seo_url,";
    } else { // OpenCart 3.0.0.0 or later.
      $sql .= "   (SELECT keyword FROM " . DB_PREFIX . "seo_url WHERE query = CONCAT('product_id=', p.product_id) AND store_id = p2s.store_id AND language_id = pd.language_id) AS product_seo_url,";
    }    
    
    #========== Custom Settings: END ============      
    
    //$sql .= "   IF (";
		//$sql .= "     (SELECT COUNT(seo_url_id) FROM " . DB_PREFIX . "seo_url WHERE query = CONCAT('product_id=', p.product_id) AND store_id = p2s.store_id AND language_id = pd.language_id),";
    //$sql .= "     CONCAT_WS(";
    //$sql .= "       '/',";
    //$sql .= "       tc.seo_url,";
    //$sql .= "       (SELECT keyword FROM " . DB_PREFIX . "seo_url WHERE query = CONCAT('product_id=', p.product_id) AND store_id = p2s.store_id AND language_id = pd.language_id)";
		//$sql .= "     ),";
    //$sql .= "     NULL";
    //$sql .= "   ) seo_url,";
    $sql .= "   tc.category_name,";
    $sql .= "   pd.name,";
    $sql .= "   p.image,";
    $sql .= "   p.date_modified,";
    $sql .= "   NOW(),";
    $sql .= "   NOW() ";
    $sql .= " FROM " . DB_PREFIX . "product p";
    $sql .= " LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id)";
    $sql .= " LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id)";
    $sql .= " RIGHT JOIN " . DB_PREFIX . "language l ON (pd.language_id = l.language_id) ";
    $sql .= " RIGHT JOIN " . DB_PREFIX . "product_to_category p2c ON (p.product_id = p2c.product_id)";
    $sql .= " LEFT JOIN " . DB_PREFIX . "xml_sitemap_generator_temporary_category tc ";
    $sql .= "   ON (";
    $sql .= "     p2c.category_id = tc.category_id ";
    $sql .= "     AND p2s.store_id = tc.store_id";
    $sql .= "     AND pd.language_id = tc.language_id";
    $sql .= "   )";
    $sql .= " WHERE";
    $sql .= "   p.status = '1'";
    $sql .= "   AND p.date_available <= NOW()";
    $sql .= "   AND l.status = '1'";
    
    if (is_numeric($store_id)) {
      $sql .= " AND p2s.store_id = '" . (int)$store_id . "'";
      
    } elseif (is_array($store_id)) {
      $sql .= " AND p2s.store_id IN (" . implode(',', $store_id) . ")";
    }    
    
    if ((bool)$this->config->get('config_seo_url') === false) {
      $sql .= "   AND l.language_id = (SELECT language_id FROM " . DB_PREFIX . "language ORDER BY sort_order ASC LIMIT 1)";
    }
    
    $sql .= " ORDER BY ";
    $sql .= "   p.sort_order ASC,";
    $sql .= "   p.product_id ASC,";
    $sql .= "   p2s.store_id ASC,";
    $sql .= "   l.sort_order ASC, 	";
    $sql .= "   LCASE(pd.name) ASC";

    $this->db->query($sql);

    unset($sql);
	}
  
  /**
   * Get the total number of the rows in the temporary data set for Categories.
   *
   * @param integer or null $store_id
   * @return void
   */  
  public function getTotalTemporaryCategories($store_id = null) {
    if (is_array($store_id) && empty($store_id)) {
      return 0;
    }
    
    $sql = "SELECT COUNT(category_id) AS total FROM " . DB_PREFIX . "xml_sitemap_generator_temporary_category";
    
    if (is_numeric($store_id)) {
      $sql .= " WHERE store_id = '" . (int)$store_id . "'";
      
    } elseif (is_array($store_id)) {
      $sql .= " WHERE store_id IN (" . implode(',', $store_id) . ")";
    }	
    
    $query = $this->db->query($sql);
    
    return (int)$query->row['total'];
  }

  /**
   * Get the categories in the temporary data set.
   *
   * @param integer $store_id
   * @param array $data
   * @return array
   */  
	public function getTemporaryCategories($store_id, $data = array()) {
    $data = array_merge(array(
        'start' => null,
        'limit' => null,
    ), $data);
    
    $sql = "SELECT";
    $sql .= "   *";
    $sql .= " FROM " . DB_PREFIX . "xml_sitemap_generator_temporary_category";
    $sql .= " WHERE store_id = '" . (int)$store_id . "'";
    
    if (isset($data['start']) || isset($data['limit'])) {
      if ($data['start'] < 0) {
        $data['start'] = 0;
      }

      if ($data['limit'] < 1) {
        $data['limit'] = 20;
      }

      $sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
    }   

    $query = $this->db->query($sql);
    
    $category_data = $query->rows;

    return $category_data;
  }  
  
  /**
   * Retrieves the alternate language categories in the temporary data set.
   *
   * @param integer $store_id
   * @param integer $category_id
   * @param integer $product_id
   * @return array
   */  
	public function getAltLangTemporaryCategories($store_id, $category_id, $product_id) {
    $sql = "SELECT";
    $sql .= "   tm.category_id,";
    $sql .= "   tm.store_id,";
    $sql .= "   tm.language_id,";
    $sql .= "   tm.language_code,";
    $sql .= "   tm.product_id,";
    $sql .= "   tm.category_path,";
    $sql .= "   tm.category_seo_url,";
    $sql .= "   tm.product_seo_url,";
    $sql .= "   tm.category_name,";
    $sql .= "   tm.product_name";
    $sql .= " FROM " . DB_PREFIX . "xml_sitemap_generator_temporary_category tm";
    $sql .= " RIGHT JOIN " . DB_PREFIX . "language l ON (tm.language_id = l.language_id)";
    $sql .= " WHERE";
    $sql .= "   tm.store_id = '" . (int)$store_id . "'";
    $sql .= "   AND tm.category_id = '". (int)$category_id . "'";
    $sql .= "   AND tm.product_id = '". (int)$product_id . "'";
    $sql .= " ORDER BY";   
    $sql .= "   l.sort_order";

    $query = $this->db->query($sql);
    
    $category_data = $query->rows;

    return $category_data;
	}  
  
  /**
   * Creates temporary data for Manufacturers.
   *
   * @param integer or array $store_id
   * @return void
   */  
	public function createTemporaryManufacturers($store_id) {
    $this->db->query("TRUNCATE TABLE " . DB_PREFIX . "xml_sitemap_generator_temporary_manufacturer");
    
    if (!$store_id) {
      return;
    }    
    
    $sql = "INSERT INTO " . DB_PREFIX . "xml_sitemap_generator_temporary_manufacturer (";
    $sql .= "   manufacturer_id,";
    $sql .= "   store_id,";
    $sql .= "   language_id,";
    $sql .= "   language_code,";
    $sql .= "   manufacturer_seo_url,";
    $sql .= "   manufacturer_name,";
    $sql .= "   image,";
    $sql .= "   lastmod,";
    $sql .= "   date_added,";
    $sql .= "   date_modified";
    $sql .= " )";
    $sql .= " SELECT";
    $sql .= "   m.manufacturer_id,";
    $sql .= "   m2s.store_id,";
    $sql .= "   l.language_id,";
    $sql .= "   l.code AS language_code,";
    
    if (version_compare(VERSION, '3.0.0.0', '<') && $this->multilingual_seo_toolkit->extensionEnabled() === false) { // OpenCart 2.3.0.2 or earlier.
      $sql .= "   (SELECT keyword FROM " . DB_PREFIX . "url_alias WHERE query = CONCAT('manufacturer_id=', m.manufacturer_id)) AS keyword,";
    } else { // OpenCart 3.0.0.0 or later.
      $sql .= "   (SELECT keyword FROM " . DB_PREFIX . "seo_url WHERE query = CONCAT('manufacturer_id=', m.manufacturer_id) AND store_id = m2s.store_id AND language_id = l.language_id) AS keyword,";
    }      
    
    $sql .= "   m.name,";
    $sql .= "   NULL,";
    $sql .= "   NULL,";
    $sql .= "   NOW(),";
    $sql .= "   NOW()";
    $sql .= " FROM " . DB_PREFIX . "manufacturer m";
    $sql .= " LEFT JOIN " . DB_PREFIX . "manufacturer_to_store m2s ON (m.manufacturer_id = m2s.manufacturer_id)";
    $sql .= " RIGHT JOIN " . DB_PREFIX . "language l ON (1 = 1)";
    $sql .= " WHERE 1 = 1";
    $sql .= "   AND l.status = '1'";
    
    if (is_numeric($store_id)) {
      $sql .= " AND m2s.store_id = '" . (int)$store_id . "'";
      
    } elseif (is_array($store_id)) {
      $sql .= " AND m2s.store_id IN (" . implode(',', $store_id) . ")";
    }
    
    if ((bool)$this->config->get('config_seo_url') === false) {
      $sql .= "   AND l.language_id = (SELECT language_id FROM " . DB_PREFIX . "language ORDER BY sort_order ASC LIMIT 1)";
    }
    
    $sql .= " ORDER BY";
    $sql .= "   m.sort_order ASC,";
    $sql .= "   m.manufacturer_id ASC,";
    $sql .= "   m2s.store_id ASC,";
    $sql .= "   l.sort_order ASC,";
    $sql .= "   LCASE(m.name) ASC";
    
    $this->db->query($sql);
    
    unset($sql);

    $sql = "INSERT INTO " . DB_PREFIX . "xml_sitemap_generator_temporary_manufacturer (";
    $sql .= "   manufacturer_id,";
    $sql .= "   store_id,";
    $sql .= "   language_id,";
    $sql .= "   language_code,";
    $sql .= "   product_id,";
    $sql .= "   manufacturer_seo_url,";
    $sql .= "   product_seo_url,";
    $sql .= "   manufacturer_name,";
    $sql .= "   product_name,";
    $sql .= "   image,";
    $sql .= "   lastmod,";
    $sql .= "   date_added,";
    $sql .= "   date_modified";
    $sql .= " )";
    $sql .= " SELECT";
    $sql .= "   p.manufacturer_id,";
    $sql .= "   p2s.store_id,";
    $sql .= "   pd.language_id,";
    $sql .= "   l.code AS language_code,";
    $sql .= "   p.product_id,";
    //$sql .= "   IF (";
		//$sql .= "     (SELECT COUNT(seo_url_id) FROM " . DB_PREFIX . "seo_url WHERE query = CONCAT('product_id=', p.product_id) AND store_id = p2s.store_id AND language_id = pd.language_id),";
    //$sql .= "     CONCAT_WS(";
    //$sql .= "       '/',";
    //$sql .= "       tm.seo_url,";
    //$sql .= "       (SELECT keyword FROM " . DB_PREFIX . "seo_url WHERE query = CONCAT('product_id=', p.product_id) AND store_id = p2s.store_id AND language_id = pd.language_id)";
		//$sql .= "     ),";
    //$sql .= "     CONCAT(tm.seo_url, '?product_id=', p.product_id)";
    //$sql .= "   ) seo_url,";
    $sql .= "   tm.manufacturer_seo_url,";
    
    if (version_compare(VERSION, '3.0.0.0', '<') && $this->multilingual_seo_toolkit->extensionEnabled() === false) { // OpenCart 2.3.0.2 or earlier.
      $sql .= "   (SELECT keyword FROM " . DB_PREFIX . "url_alias WHERE query = CONCAT('product_id=', p.product_id)) AS keyword,";
    } else { // OpenCart 3.0.0.0 or later.
      $sql .= "   (SELECT keyword FROM " . DB_PREFIX . "seo_url WHERE query = CONCAT('product_id=', p.product_id) AND store_id = p2s.store_id AND language_id = pd.language_id) AS keyword,";
    }       
    
    $sql .= "   tm.manufacturer_name,";
    $sql .= "   pd.name,";
    $sql .= "   p.image,";
    $sql .= "   p.date_modified,";
    $sql .= "   NOW(),";
    $sql .= "   NOW()";
    $sql .= " FROM " . DB_PREFIX . "product p";
    $sql .= " LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id)";
    $sql .= " LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id)";
    $sql .= " RIGHT JOIN " . DB_PREFIX . "language l ON (pd.language_id = l.language_id)";
    $sql .= " RIGHT JOIN " . DB_PREFIX . "xml_sitemap_generator_temporary_manufacturer tm";
    $sql .= "   ON (";
    $sql .= "     p.manufacturer_id = tm.manufacturer_id";
    $sql .= "     AND p2s.store_id = tm.store_id";
    $sql .= "     AND pd.language_id = tm.language_id";
    $sql .= "   )";
    $sql .= " WHERE";
    $sql .= "   p.status = '1'";
    $sql .= "   AND p.date_available <= NOW()";
    $sql .= "   AND l.status = '1'";
    
    if (is_numeric($store_id)) {
      $sql .= " AND p2s.store_id = '" . (int)$store_id . "'";
      
    } elseif (is_array($store_id)) {
      $sql .= " AND p2s.store_id IN (" . implode(',', $store_id) . ")";
    }    
    
    if ((bool)$this->config->get('config_seo_url') === false) {
      $sql .= "   AND l.language_id = (SELECT language_id FROM " . DB_PREFIX . "language ORDER BY sort_order ASC LIMIT 1)";
    }
    
    $sql .= " ORDER BY";
    $sql .= "   p.sort_order ASC,";
    $sql .= "   p.product_id ASC,";
    $sql .= "   p2s.store_id ASC,";
    $sql .= "   l.sort_order ASC,";
    $sql .= "   LCASE(pd.name) ASC";
    
    $this->db->query($sql);
  }
  
  /**
   * Get the total number of the rows in the temporary data set for Manufacturers.
   *
   * @param integer or array $store_id
   * @return void
   */  
  public function getTotalTemporaryManufacturers($store_id) {
    if (is_array($store_id) && empty($store_id)) {
      return 0;
    }
    
    $sql = "SELECT COUNT(manufacturer_id) AS total FROM " . DB_PREFIX . "xml_sitemap_generator_temporary_manufacturer";
    
    if (is_numeric($store_id)) {
      $sql .= " WHERE store_id = '" . (int)$store_id . "'";
      
    } elseif (is_array($store_id)) {
      $sql .= " WHERE store_id IN (" . implode(',', $store_id) . ")";
    }
    
    $query = $this->db->query($sql);
    
    return (int)$query->row['total'];
  }

  /**
   * Get the manufacturers in the temporary data set.
   *
   * @param integer $store_id
   * @param array $data
   * @return array
   */  
	public function getTemporaryManufacturers($store_id, $data = array()) {
    $data = array_merge(array(
        'start' => null,
        'limit' => null,
    ), $data);
    
    $sql = "SELECT";
    $sql .= "   *";
    $sql .= " FROM " . DB_PREFIX . "xml_sitemap_generator_temporary_manufacturer";
    $sql .= " WHERE store_id = '" . (int)$store_id . "'";
    
    if (isset($data['start']) || isset($data['limit'])) {
      if ($data['start'] < 0) {
        $data['start'] = 0;
      }

      if ($data['limit'] < 1) {
        $data['limit'] = 20;
      }

      $sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
    }   

    $query = $this->db->query($sql);
    
    $manufacturer_data = $query->rows;

    return $manufacturer_data;
	}  
  
  /**
   * Retrieves the alternate language manufacturers in the temporary data set.
   *
   * @param integer $store_id
   * @param integer $manufacturer_id
   * @param integer $product_id
   * @return array
   */  
	public function getAltLangTemporaryManufacturers($store_id, $manufacturer_id, $product_id) {
    $sql = "SELECT";
    $sql .= "   tm.manufacturer_id,";
    $sql .= "   tm.store_id,";
    $sql .= "   tm.language_id,";
    $sql .= "   tm.language_code,";
    $sql .= "   tm.product_id,";
    $sql .= "   tm.manufacturer_seo_url,";
    $sql .= "   tm.product_seo_url,";
    $sql .= "   tm.manufacturer_name,";
    $sql .= "   tm.product_name";
    $sql .= " FROM " . DB_PREFIX . "xml_sitemap_generator_temporary_manufacturer tm";
    $sql .= " RIGHT JOIN " . DB_PREFIX . "language l ON (tm.language_id = l.language_id)";
    $sql .= " WHERE";
    $sql .= "   tm.store_id = '" . (int)$store_id . "'";
    $sql .= "   AND tm.manufacturer_id = '". (int)$manufacturer_id . "'";
    $sql .= "   AND tm.product_id = '". (int)$product_id . "'";
    $sql .= " ORDER BY";   
    $sql .= "   l.sort_order";

    $query = $this->db->query($sql);
    
    $manufacturer_data = $query->rows;

    return $manufacturer_data;
	}
  
  /**
   * Creates temporary data for Information.
   *
   * @param integer or array $store_id
   * @return void
   */  
	public function createTemporaryInformations($store_id) {
    $this->db->query("TRUNCATE TABLE " . DB_PREFIX . "xml_sitemap_generator_temporary_information");
    
    if (!$store_id) {
      return;
    }
    
    $sql = "INSERT INTO " . DB_PREFIX . "xml_sitemap_generator_temporary_information (";
    $sql .= "   information_id,";
    $sql .= "   store_id,";
    $sql .= "   language_id,";
    $sql .= "   language_code,";
    $sql .= "   seo_url,";
    $sql .= "   title,";
    $sql .= "   date_added,";
    $sql .= "   date_modified";
    $sql .= " )";
    $sql .= " SELECT ";
    $sql .= "   i.information_id,";
    $sql .= "   i2s.store_id,";
    $sql .= "   id.language_id,";
    $sql .= "   l.code AS language_code,";
    
    if (version_compare(VERSION, '3.0.0.0', '<') && $this->multilingual_seo_toolkit->extensionEnabled() === false) { // OpenCart 2.3.0.2 or earlier.
      $sql .= "   (SELECT keyword FROM " . DB_PREFIX . "url_alias WHERE query = CONCAT('information_id=', i.information_id)) AS keyword,";
    } else { // OpenCart 3.0.0.0 or later.
      $sql .= "   (SELECT keyword FROM " . DB_PREFIX . "seo_url WHERE query = CONCAT('information_id=', i.information_id) AND store_id = i2s.store_id AND language_id = id.language_id) AS keyword,";
    }    
    
    $sql .= "   id.title,";
    $sql .= "   NOW(),";
    $sql .= "   NOW()";
    $sql .= " FROM " . DB_PREFIX . "information i";
    $sql .= " LEFT JOIN " . DB_PREFIX . "information_description id ON (i.information_id = id.information_id)";
    $sql .= " LEFT JOIN " . DB_PREFIX . "information_to_store i2s ON (i.information_id = i2s.information_id)";
    $sql .= " RIGHT JOIN " . DB_PREFIX . "language l ON (id.language_id = l.language_id)";
    $sql .= " WHERE";
    $sql .= "   i.status = '1'";
    $sql .= "   AND l.status = '1'";
    
    if (is_numeric($store_id)) {
      $sql .= " AND i2s.store_id = '" . (int)$store_id . "'";
      
    } elseif (is_array($store_id)) {
      $sql .= " AND i2s.store_id IN (" . implode(',', $store_id) . ")";
    }    
    
    if ((bool)$this->config->get('config_seo_url') === false) {
      $sql .= "   AND l.language_id = (SELECT language_id FROM " . DB_PREFIX . "language ORDER BY sort_order ASC LIMIT 1)";
    }
    
    $sql .= " ORDER BY";
    $sql .= "   i.sort_order ASC,";
    $sql .= "   i.information_id ASC,";
    $sql .= "   i2s.store_id ASC,";
    $sql .= "   l.sort_order ASC,";
    $sql .= "   LCASE(id.title) ASC";
    
    $this->db->query($sql);
  }  
 
  /**
   * Get the total number of the rows in the temporary data set for Information.
   *
   * @param integer or array $store_id
   * @return void
   */  
  public function getTotalTemporaryInformations($store_id) {
    if (is_array($store_id) && empty($store_id)) {
      return 0;
    }
    
    $sql = "SELECT COUNT(information_id) AS total FROM " . DB_PREFIX . "xml_sitemap_generator_temporary_information";
    
    if (is_numeric($store_id)) {
      $sql .= " WHERE store_id = '" . (int)$store_id . "'";
      
    } elseif (is_array($store_id)) {
      $sql .= " WHERE store_id IN (" . implode(',', $store_id) . ")";
    }

    $query = $this->db->query($sql);
    
    return (int)$query->row['total'];
  }

  /**
   * Get the informations in the temporary data set.
   *
   * @param integer $store_id
   * @param array $data
   * @return array
   */  
	public function getTemporaryInformations($store_id, $data = array()) {
    $data = array_merge(array(
        'start' => null,
        'limit' => null,
    ), $data);
    
    $sql = "SELECT";
    $sql .= "   *";
    $sql .= " FROM " . DB_PREFIX . "xml_sitemap_generator_temporary_information";
    $sql .= " WHERE store_id = '" . (int)$store_id . "'";
    
    if (isset($data['start']) || isset($data['limit'])) {
      if ($data['start'] < 0) {
        $data['start'] = 0;
      }

      if ($data['limit'] < 1) {
        $data['limit'] = 20;
      }

      $sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
    }   

    $query = $this->db->query($sql);
    
    $information_data = $query->rows;

    return $information_data;
	}  
  
  /**
   * Retrieves the alternate language informations in the temporary data set.
   *
   * @param integer $store_id
   * @param integer $information_id
   * @return array
   */  
	public function getAltLangTemporaryInformations($store_id, $information_id) {
    $sql = "SELECT";
    $sql .= "   ti.information_id,";
    $sql .= "   ti.store_id,";
    $sql .= "   ti.language_id,";
    $sql .= "   ti.language_code,";
    $sql .= "   ti.seo_url,";
    $sql .= "   ti.title";
    $sql .= " FROM " . DB_PREFIX . "xml_sitemap_generator_temporary_information ti";
    $sql .= " RIGHT JOIN " . DB_PREFIX . "language l ON (ti.language_id = l.language_id)";
    $sql .= " WHERE";
    $sql .= "   ti.store_id = '" . (int)$store_id . "'";
    $sql .= "   AND ti.information_id = '". (int)$information_id . "'";
    $sql .= " ORDER BY";   
    $sql .= "   l.sort_order";

    $query = $this->db->query($sql);
    
    $information_data = $query->rows;

    return $information_data;
	}

  /**
   * Creates temporary data for Pages.
   *
   * @param integer or array $store_id
   * @return void
   */  
	public function createTemporaryPages($store_id) {
    $this->db->query("TRUNCATE TABLE " . DB_PREFIX . "xml_sitemap_generator_temporary_page");
    
    if (!$store_id) {
      return;
    }
    
    $sql = "INSERT INTO " . DB_PREFIX . "xml_sitemap_generator_temporary_page (";
    $sql .= "   page_id,";
    $sql .= "   store_id,";
    $sql .= "   url,";
    $sql .= "   date_added,";
    $sql .= "   date_modified";
    $sql .= " )";
    $sql .= " SELECT ";
    $sql .= "   p.page_id,";
    $sql .= "   p2s.store_id,";
    $sql .= "   p.url,";
    $sql .= "   NOW(),";
    $sql .= "   NOW()";
    $sql .= " FROM " . DB_PREFIX . "xml_sitemap_generator_page p";
    $sql .= " LEFT JOIN " . DB_PREFIX . "xml_sitemap_generator_page_to_store p2s ON (p.page_id = p2s.page_id)";
    $sql .= " WHERE";
    $sql .= "   p.status = '1'";
    
    if (is_numeric($store_id)) {
      $sql .= " AND p2s.store_id = '" . (int)$store_id . "'";
      
    } elseif (is_array($store_id)) {
      $sql .= " AND p2s.store_id IN (" . implode(',', $store_id) . ")";
    }    
    
    $sql .= " ORDER BY";
    $sql .= "   p.page_id ASC,";
    $sql .= "   p2s.store_id ASC";
    
    $this->db->query($sql);
  }  
  
  /**
   * Get the total number of the rows in the temporary data set for Pages.
   *
   * @param integer or array $store_id
   * @return void
   */  
  public function getTotalTemporaryPages($store_id) {
    if (is_array($store_id) && empty($store_id)) {
      return 0;
    }
    
    $sql = "SELECT COUNT(page_id) AS total FROM " . DB_PREFIX . "xml_sitemap_generator_temporary_page";
    
    if (is_numeric($store_id)) {
      $sql .= " WHERE store_id = '" . (int)$store_id . "'";
      
    } elseif (is_array($store_id)) {
      $sql .= " WHERE store_id IN (" . implode(',', $store_id) . ")";
    }
    
    $query = $this->db->query($sql);
    
    return (int)$query->row['total'];
  }
  
  /**
   * Get the pages in the temporary data set.
   *
   * @param integer $store_id
   * @param array $data
   * @return array
   */  
	public function getTemporaryPages($store_id, $data = array()) {
    $data = array_merge(array(
        'start' => null,
        'limit' => null,
    ), $data);
    
    $sql = "SELECT";
    $sql .= "   *";
    $sql .= " FROM " . DB_PREFIX . "xml_sitemap_generator_temporary_page";
    $sql .= " WHERE store_id = '" . (int)$store_id . "'";
    
    if (isset($data['start']) || isset($data['limit'])) {
      if ($data['start'] < 0) {
        $data['start'] = 0;
      }

      if ($data['limit'] < 1) {
        $data['limit'] = 20;
      }

      $sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
    }   

    $query = $this->db->query($sql);
    
    $page_data = $query->rows;

    return $page_data;
	}  
  
  /**
   * Get the total number of the pages.
   *
   * @param array $data
   * @return integer
   */
	public function getTotalPages($data = array()) {
    $sql = "SELECT COUNT(*) AS total FROM " . DB_PREFIX . "xml_sitemap_generator_page";

    $sql .= " WHERE 1 = 1";
    
    if (isset($data['search']) && $data['search']) {
      $sql .= " AND (";
      $sql .= "   url LIKE '%" . $this->db->escape($data['search']) . "%'";
      $sql .= "   OR page_id = '" . $this->db->escape($data['search']) . "'";
      $sql .= " )";
    }
    
		$query = $this->db->query($sql);
    
		return $query->row['total'];
	}

  /**
   * Get pages.
   *
   * @param array $data
   * @return array $query->rows
   */
	public function getPages($data = array()) {
    $sql = "SELECT * FROM " . DB_PREFIX . "xml_sitemap_generator_page";

		$sort_data = array(
			'page_id',
			'url',
			'status',
			'date_added',
			'date_modified ',
		);

    $sql .= " WHERE 1 = 1";
    
    if (isset($data['search']) && $data['search']) {
      $sql .= " AND (";
      $sql .= "   url LIKE '%" . $this->db->escape($data['search']) . "%'";
      $sql .= "   OR page_id = '" . $this->db->escape($data['search']) . "'";
      $sql .= " )";
    }
    
		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY page_id";
		}
    
		if (isset($data['order']) && ($data['order'] == 'DESC')) {
			$sql .= " DESC";
		} else {
			$sql .= " ASC";
		}

		if (isset($data['start']) || isset($data['limit'])) {
			if ($data['start'] < 0) {
				$data['start'] = 0;
			}

			if ($data['limit'] < 1) {
				$data['limit'] = 20;
			}

			$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		}

		$query = $this->db->query($sql);

		return $query->rows;
	}
  
  /**
   * Create a page.
   *
   * @param array $data
   * @return integer $page_id
   */  
	public function addPage($data) {
    $sql = "INSERT " . DB_PREFIX . "xml_sitemap_generator_page";
    $sql .= " SET";
    $sql .= "   url = '" . $this->db->escape($data['url']) . "',";
    $sql .= "   status = '" . $this->db->escape($data['status']) . "',";
    $sql .= "   date_added = NOW(),";
    $sql .= "   date_modified = NOW()";
    
    $this->db->query($sql);
    
    $page_id = $this->db->getLastId();
    
    $this->db->query("DELETE FROM " . DB_PREFIX . "xml_sitemap_generator_page_to_store WHERE page_id = '" . (int)$page_id . "'");

		if (isset($data['page_store']) && $data['page_store']) {
			foreach ($data['page_store'] as $store_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "xml_sitemap_generator_page_to_store SET page_id = '" . (int)$page_id . "', store_id = '" . (int)$store_id . "'");
			}
		}
    
    return $page_id;
	}
  
  /**
   * Update the page of a given page ID.
   *
   * @param integer $page_id
   * @param array $data
   * @return integer $page_id
   */  
	public function updatePage($page_id, $data) {
    $sql = "UPDATE " . DB_PREFIX . "xml_sitemap_generator_page";
    $sql .= " SET";
    $sql .= "   url = '" . $this->db->escape($data['url']) . "',";
    $sql .= "   status = '" . $this->db->escape($data['status']) . "',";
    $sql .= "   date_modified = NOW()";
    $sql .= " WHERE page_id = '" . (int)$page_id . "'";
    
    $this->db->query($sql);
    
    $this->db->query("DELETE FROM " . DB_PREFIX . "xml_sitemap_generator_page_to_store WHERE page_id = '" . (int)$page_id . "'");

		if (isset($data['page_store']) && $data['page_store']) {
			foreach ($data['page_store'] as $store_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "xml_sitemap_generator_page_to_store SET page_id = '" . (int)$page_id . "', store_id = '" . (int)$store_id . "'");
			}
		}
    
    return (int)$page_id;
	}
  
  /**
   * Delete the page of a given page ID.
   *
   * @param integer $page_id
   * @return void
   */  
	public function deletePage($page_id) {
    $this->db->query("DELETE FROM " . DB_PREFIX . "xml_sitemap_generator_page WHERE page_id = '" . (int)$page_id . "'");
    $this->db->query("DELETE FROM " . DB_PREFIX . "xml_sitemap_generator_page_to_store WHERE page_id = '" . (int)$page_id . "'");
	}
  
  /**
   * Get the page of a given page ID.
   *
   * @param integer $page_id The page ID
   * @return $query->row
   */  
	public function getPage($page_id) {
    $sql = "SELECT * FROM " . DB_PREFIX . "xml_sitemap_generator_page WHERE page_id = '" . (int)$page_id . "'";

    $query = $this->db->query($sql);
    
    return $query->row;
	}  
  
  /**
   * Get the page stores of a given page ID.
   *
   * @param integer $page_id The page ID
   * @return $page_store_data
   */ 
	public function getPageStores($page_id) {
		$page_store_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "xml_sitemap_generator_page_to_store WHERE page_id = '" . (int)$page_id . "'");

		foreach ($query->rows as $result) {
			$page_store_data[] = (int)$result['store_id'];
		}

		return $page_store_data;
	}
  
  /**
   * Updates the single setting value in the OpenCart setting table.
   *
   * @param string $code
   * @param string $key
   * @param mixed $value
   * @param integer $store_id
   * @return void
   */ 
	public function updateSettingValue($code, $key, $value, $store_id = 0) {
		$this->db->query("DELETE FROM `" . DB_PREFIX . "setting` WHERE store_id = '" . (int)$store_id . "' AND `code` = '" . $this->db->escape($code) . "' AND `key` = '" . $this->db->escape($key) . "'");

    if (substr($key, 0, strlen($code)) == $code) {
      if (!is_array($value)) {
        $this->db->query("INSERT INTO " . DB_PREFIX . "setting SET store_id = '" . (int)$store_id . "', `code` = '" . $this->db->escape($code) . "', `key` = '" . $this->db->escape($key) . "', `value` = '" . $this->db->escape($value) . "'");
      } else {
        if ($this->isOC2031orEarlier()) { // for OpenCart 2.0.3.1 or earlier.
          $this->db->query("INSERT INTO " . DB_PREFIX . "setting SET store_id = '" . (int)$store_id . "', `code` = '" . $this->db->escape($code) . "', `key` = '" . $this->db->escape($key) . "', `value` = '" . $this->db->escape(serialize($value)) . "', serialized = '1'");
        } else { // for OpenCart 2.1.0.0 or later.
          $this->db->query("INSERT INTO " . DB_PREFIX . "setting SET store_id = '" . (int)$store_id . "', `code` = '" . $this->db->escape($code) . "', `key` = '" . $this->db->escape($key) . "', `value` = '" . $this->db->escape(json_encode($value)) . "', serialized = '1'");
        }
      }
      
      $query = $this->db->query("SELECT value, serialized FROM `" . DB_PREFIX . "setting` WHERE `code` = '" . $this->db->escape($code) . "' AND `key` = '" . $this->db->escape($key) . "' AND store_id = '0'");

      if ($query->row) {
        if (!$query->row['serialized']) {
          $value = $query->row['value'];
        } else {
          if ($this->isOC2031orEarlier()) { // for OpenCart 2.0.3.1 or earlier.
            $value = unserialize($query->row['value']);
          } else { // for OpenCart 2.1.0.0 or later.
            $value = json_decode($query->row['value']);
          }
        }
        return $value;
      }
    }
    
    return null;
	}  

  /**
   * Checks if OpenCart 2.0.3.1 or earlier
   *
   * @param void
   * @return bool True or false
   */
  public function isOC2031orEarlier() {
    return version_compare(str_replace('_rc1', '.RC.1', VERSION), '2.1.0.0.RC.1', '<');
  }  
  
  /**
   * The install() implementation
   *
   * @param void
   * @return void
   */
  public function install() {
    $this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "xml_sitemap_generator_page` ("
      . "`page_id` int(11) NOT NULL AUTO_INCREMENT,"
      . "`url` varchar(2083) NOT NULL,"
      . "`status` tinyint(1) NOT NULL DEFAULT '1',"
      . "`date_added` datetime NOT NULL,"
      . "`date_modified` datetime NOT NULL,"
      . "PRIMARY KEY (`page_id`)"
    . ") ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8");
    
    $this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "xml_sitemap_generator_page_to_store` ("
      . "`page_id` int(11) NOT NULL,"
      . "`store_id` int(11) NOT NULL DEFAULT '0',"
      . "PRIMARY KEY (`page_id`,`store_id`) USING BTREE"
    . ") ENGINE=MyISAM DEFAULT CHARSET=utf8");
   
    $this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "xml_sitemap_generator_process` ("
      . "`process_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,"
      . "`queue_id` bigint(20) UNSIGNED DEFAULT NULL,"
      . "`type` varchar(32) NOT NULL,"
      . "`progress` tinyint(3) UNSIGNED NOT NULL DEFAULT '0',"
      . "`completed` int(11) NOT NULL DEFAULT '0',"
      . "`total` int(11) NOT NULL DEFAULT '0',"
      . "`params` mediumtext NOT NULL,"
      . "`errors` mediumtext NOT NULL,"
      . "`prepared` tinyint(1) NOT NULL DEFAULT '0',"
      . "`finalized` tinyint(1) NOT NULL DEFAULT '0',"
      . "`start_time` int(10) UNSIGNED DEFAULT NULL,"
      . "`end_time` int(10) UNSIGNED DEFAULT NULL,"
      . "`date_added` datetime NOT NULL,"
      . "`date_modified` datetime NOT NULL,"
      . "PRIMARY KEY (`process_id`)"
    . ") ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8");
   
    $this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "xml_sitemap_generator_queue` ("
      . "`queue_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,"
      . "`params` mediumtext NOT NULL,"
      . "`date_added` datetime NOT NULL,"
      . "`date_modified` datetime NOT NULL,"
      . "PRIMARY KEY (`queue_id`)"
    . ") ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8");
    
    $this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "xml_sitemap_generator_sitemap_setting` ("
      . "`type` varchar(32) NOT NULL,"
      . "`changefreq` varchar(7) NOT NULL,"
      . "`priority` decimal(2,1) NOT NULL DEFAULT '0.0',"
      . "`lastmod` datetime DEFAULT NULL,"
      . "`url_limit` smallint(5) UNSIGNED NOT NULL,"
      . "`sort_order` int(11) NOT NULL DEFAULT '0',"
      . "`date_added` datetime NOT NULL,"
      . "`date_modified` datetime NOT NULL,"
      . "PRIMARY KEY (`type`) USING BTREE"
    . ") ENGINE=MyISAM DEFAULT CHARSET=utf8");
    
    $this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "xml_sitemap_generator_sitemap_setting_to_store` ("
      . "`sitemap_setting_type` varchar(32) NOT NULL,"
      . "`store_id` int(11) NOT NULL DEFAULT '0',"
      . "PRIMARY KEY (`sitemap_setting_type`,`store_id`) USING BTREE"
    . ") ENGINE=MyISAM DEFAULT CHARSET=utf8");  
    
    $this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "xml_sitemap_generator_temporary_category` ("
      . "`category_id` int(11) NOT NULL,"
      . "`store_id` int(11) NOT NULL,"
      . "`language_id` int(11) NOT NULL,"
      . "`language_code` varchar(5) NOT NULL,"
      . "`product_id` int(11) NOT NULL DEFAULT '0',"
      . "`category_path` varchar(255) DEFAULT NULL,"
      . "`category_seo_url` varchar(2083) DEFAULT NULL,"
      . "`product_seo_url` varchar(255) DEFAULT NULL,"
      . "`category_name` varchar(255) DEFAULT NULL,"
      . "`product_name` varchar(255) DEFAULT NULL,"
      . "`image` varchar(255) DEFAULT NULL,"
      . "`lastmod` datetime DEFAULT NULL,"
      . "`date_added` datetime NOT NULL,"
      . "`date_modified` datetime NOT NULL,"
      . "PRIMARY KEY (`category_id`,`store_id`,`language_id`,`product_id`)"
    . ") ENGINE=MyISAM DEFAULT CHARSET=utf8");   

    $this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "xml_sitemap_generator_temporary_information` ("
      . "`information_id` int(11) NOT NULL,"
      . "`store_id` int(11) NOT NULL,"
      . "`language_id` int(11) NOT NULL,"
      . "`language_code` varchar(5) NOT NULL,"
      . "`seo_url` varchar(2083) DEFAULT NULL,"
      . "`title` varchar(255) DEFAULT NULL,"
      . "`date_added` datetime NOT NULL,"
      . "`date_modified` datetime NOT NULL,"
      . "PRIMARY KEY (`information_id`,`store_id`,`language_id`)"
    . ") ENGINE=MyISAM DEFAULT CHARSET=utf8");

    $this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "xml_sitemap_generator_temporary_manufacturer` ("
      . "`manufacturer_id` int(11) NOT NULL,"
      . "`store_id` int(11) NOT NULL,"
      . "`language_id` int(11) NOT NULL,"
      . "`language_code` varchar(5) NOT NULL,"
      . "`product_id` int(11) NOT NULL DEFAULT '0',"
      . "`manufacturer_seo_url` varchar(255) DEFAULT NULL,"
      . "`product_seo_url` varchar(255) DEFAULT NULL,"
      . "`manufacturer_name` varchar(255) DEFAULT NULL,"
      . "`product_name` varchar(255) DEFAULT NULL,"
      . "`image` varchar(255) DEFAULT NULL,"
      . "`lastmod` datetime DEFAULT NULL,"
      . "`date_added` datetime NOT NULL,"
      . "`date_modified` datetime NOT NULL,"
      . "PRIMARY KEY (`manufacturer_id`,`store_id`,`language_id`,`product_id`)"
    . ") ENGINE=MyISAM DEFAULT CHARSET=utf8");
    
    $this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "xml_sitemap_generator_temporary_page` ("
      . "`page_id` int(11) NOT NULL,"
      . "`store_id` int(11) NOT NULL,"
      . "`url` varchar(2083) DEFAULT NULL,"
      . "`date_added` datetime NOT NULL,"
      . "`date_modified` datetime NOT NULL,"
      . "PRIMARY KEY (`page_id`,`store_id`)"
    . ") ENGINE=MyISAM DEFAULT CHARSET=utf8");
    
    $this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "xml_sitemap_generator_temporary_product` ("
      . "`product_id` int(11) NOT NULL,"
      . "`store_id` int(11) NOT NULL,"
      . "`language_id` int(11) NOT NULL,"
      . "`language_code` varchar(5) NOT NULL,"
      . "`seo_url` varchar(2083) DEFAULT NULL,"
      . "`name` varchar(255) DEFAULT NULL,"
      . "`image` varchar(255) DEFAULT NULL,"
      . "`lastmod` datetime DEFAULT NULL,"
      . "`date_added` datetime NOT NULL,"
      . "`date_modified` datetime NOT NULL,"
      . "PRIMARY KEY (`product_id`,`store_id`,`language_id`) USING BTREE"
    . ") ENGINE=MyISAM DEFAULT CHARSET=utf8");

    
    // Get stores.
    $this->load->model('setting/store');

    $stores = array_merge(array(array(
        'store_id' => 0,
        'name' => $this->config->get('config_name'),
        'url' => HTTP_CATALOG,
        'ssl' => HTTPS_CATALOG
    )), $this->model_setting_store->getStores());    
    
    $sitemap_setting_total_query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "xml_sitemap_generator_sitemap_setting");
    
    if ((int)$sitemap_setting_total_query->row['total'] <= 0) {
      $this->db->query("INSERT INTO `" . DB_PREFIX . "xml_sitemap_generator_sitemap_setting` (`type`, `changefreq`, `priority`, `lastmod`, `url_limit`, `sort_order`, `date_added`, `date_modified`) VALUES"
        . "('product', 'weekly', '1.0', NULL, 1000, 1, NOW(), NOW()),"
        . "('category', 'weekly', '0.7', NULL, 1000, 2, NOW(), NOW()),"
        . "('manufacturer', 'weekly', '0.7', NULL, 1000, 3, NOW(), NOW()),"
        . "('information', 'monthly', '0.5', NULL, 1000, 4, NOW(), NOW()),"
        . "('page', 'weekly', '0.5', NULL, 1000, 5, NOW(), NOW())"
      . "");
      
      $sitemap_setting_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "xml_sitemap_generator_sitemap_setting");
      
      if ($sitemap_setting_query->num_rows > 0) {
        foreach($sitemap_setting_query->rows as $sitemap_setting) {
          foreach($stores as $store) {
            $this->db->query("INSERT INTO `" . DB_PREFIX . "xml_sitemap_generator_sitemap_setting_to_store` (`sitemap_setting_type`, `store_id`) VALUES ('" . $this->db->escape($sitemap_setting['type']) . "', " . (int)$store['store_id'] . ")");
          }
        }
      }
    }
    
    $page_query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "xml_sitemap_generator_page");
    
    if ((int)$page_query->row['total'] <= 0) {
      $this->db->query("INSERT INTO `" . DB_PREFIX . "xml_sitemap_generator_page` (`page_id`, `url`, `status`, `date_added`, `date_modified`) VALUES"
        . "(NULL, 'index.php?route=information/contact', 1, NOW(), NOW()),"
        . "(NULL, 'index.php?route=account/return/add', 1, NOW(), NOW()),"
        . "(NULL, 'index.php?route=product/manufacturer', 1, NOW(), NOW()),"
        . "(NULL, 'index.php?route=account/voucher', 1, NOW(), NOW()),"
        . "(NULL, 'index.php?route=product/special', 1, NOW(), NOW())"
      . "");
    }
  }
  
}
