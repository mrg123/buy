<?php

class ModelAccountSoclLogin extends Model
{
    public function getSoclLoginList()
    {
        $socl_login = array();
        
        if($this->config->get('soclall_appid') && $this->config->get('soclall_secretkey')) {
            $this->load->model('tool/image');
            
            $socl_all = new SoclAll($this->config->get('soclall_appid'), $this->config->get('soclall_secretkey'));
            
            $query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "soclall_network`");
            
            if($query->num_rows){
                $enabled_net = $this->config->get('soclall_enabled_network');
                $ebay_site = ($this->config->get('soclall_ebay_site')) ? $this->config->get('soclall_ebay_site') : 'US';
                foreach($query->rows as $network){
                    if(is_array($enabled_net) && in_array($network['network_code'], $enabled_net)) {
                        $socl_login[] = array(
                            'href' => $socl_all->getLoginUrl($network['network_code'], $this->url->link('account/socl_login' , '', 'SSL'), ($network['network_code'] == 'ebay') ? $ebay_site : ''),
                            'code' => $network['network_code'], 'name' => $network['network_name']);
                    }
                }
            }
        }

        return $socl_login;
    }
    
    public function checkSoclCustomerById($soclId, $network) {
        $query = $this->db->query("SELECT c.`email` FROM `" . DB_PREFIX . "customer` c LEFT JOIN `" . DB_PREFIX . "soclall_id` s ON (c.`customer_id` = s.`customer_id`) WHERE s.`socl_id` = '" . $soclId . "' AND s.`network_code` = '" . $network . "'");
        if($query->num_rows)
            return $query->row['email'];
        else return 0;
    }
    
    public function checkSoclCustomerByEmail($email) {
        $query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "customer` WHERE LOWER(`email`) = '" . $this->db->escape(utf8_strtolower($email)) . "'");
        if($query->num_rows)
            return true;
        else return false;
    }
    
    public function insertUpdateNewSoclId($id, $email, $network) {
        if($id) {
            $query = $this->db->query("SELECT `customer_id` FROM `" . DB_PREFIX . "customer` WHERE LOWER(`email`) = '" . $this->db->escape(utf8_strtolower($email)) . "'");
            if($query->num_rows) {
                // 2015-07-03: fix bug duplicate primary key
                $checkExisted = $this->db->query("SELECT * FROM `" . DB_PREFIX . "soclall_id` WHERE `network_code` = '" . $network . "' AND `customer_id` = '" . $query->row['customer_id'] . "'");
                if($checkExisted->num_rows)
                    $this->db->query("UPDATE `" . DB_PREFIX . "soclall_id` SET `socl_id` = '" . $id . "' WHERE `network_code` = '" . $network . "' AND `customer_id` = '" . $query->row['customer_id'] . "'");
                else
                    $this->db->query("INSERT INTO `" . DB_PREFIX . "soclall_id` VALUES ('" . $network . "','" . $query->row['customer_id'] . "','" . $id . "')");   
            }
        }
    }
    
    public function checkInstalled() {
        $query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "extension` WHERE `type`='module' AND `code`='socl_login'");
        if($query->num_rows)
            return true;
        else return false;
    }
}

?>