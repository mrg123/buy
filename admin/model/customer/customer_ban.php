<?php
class ModelCustomerCustomerBan extends Model {
	public function add($customer_id) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "customer_ban SET customer_id = '" . (int)$customer_id . "'");

		$ban_id = $this->db->getLastId();
		return $ban_id;
	}

	public function delete($customer_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "customer_ban WHERE customer_id = '" . (int)$customer_id . "'");
		return 1;
	}

	public function get($customer_id) {
		$result = $this->db->query("SELECT * FROM " . DB_PREFIX . "customer_ban WHERE customer_id = '" . (int)$customer_id . "'");
		return $result->row;
	}
}
