<?php
/*
 *	location: admin/model
 */

class ModelModuleProductToggle extends Model {
	public function getToggleByProductId($product_id){
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "product_to_toggle WHERE product_id='" . (int)$product_id . "'");

		return $query->row;
	}
	

}
?>