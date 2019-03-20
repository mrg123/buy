<?php
/*
 *	location: admin/model
 */

class ModelModuleCustomerToggle extends Model {
	public function getToggleByCustomerId($customer_id){
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "customer_to_toggle WHERE customer_id='" . (int)$customer_id . "'");

		return $query->row;
	}
	
	public function updateToggle($customer_id,$toggle){
		$this->db->query("DELETE FROM " . DB_PREFIX . "customer_to_toggle WHERE customer_id = '" . (int)$customer_id . "'");
		
		$this->db->query("INSERT INTO " . DB_PREFIX . "customer_to_toggle SET customer_id = '" . (int)$customer_id . "', toggle = '" . (int)$toggle . "'");
		
		$customer_id = $this->db->getLastId();
		
		return $customer_id;
	}
	
	public function install(){
		$this->db->query("
CREATE TABLE IF NOT EXISTS `oc_customer_to_toggle` (
  `customer_id` int(11) NOT NULL,
  `toggle` tinyint(1) NOT NULL,
  PRIMARY KEY (`customer_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
		");
	}
}
?>