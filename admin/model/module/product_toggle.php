<?php
/*
 *	location: admin/model
 */

class ModelModuleProductToggle extends Model {
	public function getToggleByProductId($product_id){
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "product_to_toggle WHERE product_id='" . (int)$product_id . "'");

		return $query->row;
	}
	
	public function updateToggle($product_id,$toggle,$related_id){
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_to_toggle WHERE product_id = '" . (int)$product_id . "'");
		
		$this->db->query("INSERT INTO " . DB_PREFIX . "product_to_toggle SET product_id = '" . (int)$product_id . "', toggle = '" . (int)$toggle . "', related_id = '" . (int)$related_id . "'");
		
		$product_id = $this->db->getLastId();
		
		return $product_id;
	}
	
	public function install(){
		$this->db->query("
CREATE TABLE IF NOT EXISTS `oc_product_to_toggle` (
  `product_id` int(11) NOT NULL,
  `toggle` tinyint(1) NOT NULL,
  `related_id` int(11) NOT NULL,
  PRIMARY KEY (`product_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
		");
	}
}
?>