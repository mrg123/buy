<?php
/*
 *	location: admin/model
 */

class ModelModuleCategoryToggle extends Model {
	public function getToggleByCategoryId($category_id){
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "category_to_toggle WHERE category_id='" . (int)$category_id . "'");

		return $query->row;
	}
}
?>