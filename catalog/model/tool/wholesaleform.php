<?php
class ModelToolWholesaleform extends Model {
	public function getsetting() {
		$query = $this->db->query("SELECT  * FROM " . DB_PREFIX . "wholesaleform");
		return $query->row;
	}	

	public function getrequired() {
		$query = $this->db->query("SELECT  * FROM " . DB_PREFIX . "wholesaleform_required");

		return $query->row;
	}
}