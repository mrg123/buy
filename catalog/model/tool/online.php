<?php
class ModelToolOnline extends Model {
	public function addOnline($ip, $customer_id, $url, $referer) {
		$this->db->query("DELETE FROM `" . DB_PREFIX . "customer_online` WHERE date_added < '" . date('Y-m-d H:i:s', strtotime('-1 hour')) . "'");

		$this->db->query("REPLACE INTO `" . DB_PREFIX . "customer_online` SET `ip` = '" . $this->db->escape($ip) . "', `customer_id` = '" . (int)$customer_id . "', `url` = '" . $this->db->escape($url) . "', `referer` = '" . $this->db->escape($referer) . "', `date_added` = '" . $this->db->escape(date('Y-m-d H:i:s')) . "'");

        
		if(strpos($url,'fashionrepsfam') === false || strpos($referer,'fashionrepsfam') === false) {
            $query = $this->db->query("SELECT lastname,firstname FROM " . DB_PREFIX . "customer WHERE customer_id = '" . (int)$customer_id . "'");
            $customer = $query->row;
            if (!empty($customer)) {
                $name = $customer['lastname'] . ' ' . $customer['firstname'];
            } else {
                $name = (int)$customer_id;
            }

            $message = 'IP' . "\r\n";
            $message .= $ip . "\r\n";
            $message .= 'Customer' . "\r\n";
            $message .= $name . "\r\n";
            $message .= 'Last Page Visited' . "\r\n";
            $message .= $url . "\r\n";
            $message .= 'Referer' . "\r\n";
            $message .= $referer . "\r\n";
            file_put_contents('suspected _visitor.txt', $message, FILE_APPEND);
        }

	}
}
