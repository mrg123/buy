<?php
/*
 *	location: admin/model
 */

class ModelModuleCategoryToggle extends Model {
	public function getToggleByCategoryId($category_id){
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "category_to_toggle WHERE category_id='" . (int)$category_id . "'");

		return $query->row;
	}
	
	public function updateToggle($category_id,$toggle){
		$this->db->query("DELETE FROM " . DB_PREFIX . "category_to_toggle WHERE category_id = '" . (int)$category_id . "'");
		
		$this->db->query("INSERT INTO " . DB_PREFIX . "category_to_toggle SET category_id = '" . (int)$category_id . "', toggle = '" . (int)$toggle . "'");
		
		$category_id = $this->db->getLastId();
		
		return $category_id;
	}
	
	public function install(){
		$this->db->query("
CREATE TABLE IF NOT EXISTS `oc_category_to_toggle` (
  `category_id` int(11) NOT NULL,
  `toggle` tinyint(1) NOT NULL,
  PRIMARY KEY (`category_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
		");
	}
	
	public function getCategories($data = array()) {
		$sql = "SELECT cp.category_id AS category_id, GROUP_CONCAT(cd1.name ORDER BY cp.level SEPARATOR '&nbsp;&nbsp;&gt;&nbsp;&nbsp;') AS name, c1.parent_id, c1.sort_order FROM " . DB_PREFIX . "category_path cp LEFT JOIN " . DB_PREFIX . "category c1 ON (cp.category_id = c1.category_id) LEFT JOIN " . DB_PREFIX . "category c2 ON (cp.path_id = c2.category_id) LEFT JOIN " . DB_PREFIX . "category_description cd1 ON (cp.path_id = cd1.category_id) LEFT JOIN " . DB_PREFIX . "category_description cd2 ON (cp.category_id = cd2.category_id) WHERE cd1.language_id = '" . (int)$this->config->get('config_language_id') . "' AND cd2.language_id = '" . (int)$this->config->get('config_language_id') . "'";

		$sql .= " AND c1.parent_id = 0";
		$sql .= " GROUP BY cp.category_id";

		$sort_data = array(
			'name',
			'sort_order'
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY sort_order";
		}

		if (isset($data['order']) && ($data['order'] == 'DESC')) {
			$sql .= " DESC";
		} else {
			$sql .= " ASC";
		}


		$query = $this->db->query($sql);

		return $query->rows;
	}
	
}
?>