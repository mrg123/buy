<?php
class ModelToolOrderImg extends Model {
	public function add($order_id, $img_url,$num) {
	
		$this->db->query("INSERT INTO `" . DB_PREFIX . "order_img` SET `order_id` = '" . $order_id . "', `url` = '" . $this->db->escape($img_url) . "',`num` = '" . (int)$num . "'");

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

	public function lastNum($order_id) {

		$query = $this->db->query("SELECT num FROM  `" . DB_PREFIX . "order_img` WHERE `order_id` = '" . $order_id . "' order by om_id desc");

		if(empty($query->row)){
			return -1;
		}else{
			return $query->row['num'];
		}
		
	}

	public function nowNum($order_id){
		return $this->lastNum($order_id) + 1;
	}

	
}