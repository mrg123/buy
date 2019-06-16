<?php
class ModelToolOrderImg extends Model {
	public function add($order_id, $img_url) {

		$this->db->query("INSERT INTO `" . DB_PREFIX . "order_img` SET `order_id` = '" . $order_id . "', `url` = '" . $this->db->escape($img_url) . "'");

		return $this->db->getLastId();
	}

	public function delete($order_id) {

		$this->db->query("DELETE FROM  `" . DB_PREFIX . "order_img` WHERE `order_id` = '" . $order_id . "'");

		return 1;
	}

	public function count($order_id) {

		$query = $this->db->query("SELECT count(*) as total FROM  `" . DB_PREFIX . "order_img` WHERE `order_id` = '" . $order_id . "'");

		return $query->row['total'];
    }
    
    public function getImg($order_id){
        $query = $this->db->query("SELECT * FROM  `" . DB_PREFIX . "order_img` WHERE `order_id` = '" . $order_id . "'");

		return $query->rows;   
    }

	
}