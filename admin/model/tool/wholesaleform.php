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

public function savesetting($data) {
	$this->db->query("TRUNCATE  TABLE " . DB_PREFIX . "wholesaleform");
	$this->db->query("TRUNCATE  TABLE " . DB_PREFIX . "wholesaleform_required");
	$this->db->query("INSERT INTO " . DB_PREFIX . "wholesaleform SET companyname = '" . (int)$data['companyname'] . "',address = '" . (int)$data['address'] . "',city = '" . (int)$data['city'] . "',state = '" . (int)$data['state'] . "',country = '" . (int)$data['country'] . "', pincode = '" . (int)$data['pincode'] . "',phone = '" . (int)$data['phone'] . "',email = '" . (int)$data['email'] . "',mobile = '" . (int)$data['mobile'] . "',nameperson = '" . (int)$data['nameperson'] . "',contacttitle = '" . (int)$data['contacttitle'] . "',vattin = '" . (int)$data['vattin'] . "',business = '" . (int)$data['business'] . "',specify = '" . (int)$data['specify'] . "',formation = '" . (int)$data['formation'] . "', sales = '" . (int)$data['sales'] . "',brands = '" . (int)$data['brands'] . "',url = '" . (int)$data['url'] . "',products = '" . (int)$data['products'] . "',category = '" . (int)$data['category'] . "',enquiry = '" . (int)$data['enquiry'] . "'");
	$this->db->query("INSERT INTO " . DB_PREFIX . "wholesaleform_required SET companyname = '" . (int)$data['companynamer'] . "',address = '" . (int)$data['addressr'] . "',city = '" . (int)$data['cityr'] . "',state = '" . (int)$data['stater'] . "',country = '" . (int)$data['countryr'] . "', pincode = '" . (int)$data['pincoder'] . "',phone = '" . (int)$data['phoner'] . "',email = '" . (int)$data['emailr'] . "',mobile = '" . (int)$data['mobiler'] . "',nameperson = '" . (int)$data['namepersonr'] . "',contacttitle = '" . (int)$data['contacttitler'] . "',vattin = '" . (int)$data['vattinr'] . "',business = '" . (int)$data['businessr'] . "',specify = '" . (int)$data['specifyr'] . "',formation = '" . (int)$data['formationr'] . "', sales = '" . (int)$data['salesr'] . "',brands = '" . (int)$data['brandsr'] . "',url = '" . (int)$data['urlr'] . "',products = '" . (int)$data['productsr'] . "',category = '" . (int)$data['categoryr'] . "',enquiry = '" . (int)$data['enquiryr'] . "'");
}


	public function createTable() {
	// $this->db->query("DROP TABLE `". DB_PREFIX ."wholesaleform` ");
	  if ($this->db->query("SHOW TABLES LIKE '". DB_PREFIX ."wholesaleform'")->num_rows == 0) {
            $sql = "CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "wholesaleform` (
				  `companyname`  tinyint(1) NOT NULL,
				  `address` tinyint(1) NOT NULL,
				  `city`  tinyint(1) NOT NULL,
				  `state` tinyint(1) NOT NULL,
				  `country` tinyint(1) NOT NULL,
				  `pincode` tinyint(1) NOT NULL,
				  `phone` tinyint(1) NOT NULL,
				  `mobile` tinyint(1) NOT NULL,
				  `email` tinyint(1) NOT NULL,
				  `nameperson`  tinyint(1) NOT NULL,
				  `contacttitle`  tinyint(1) NOT NULL,
				  `vattin` tinyint(1) NOT NULL,
				  `business` tinyint(1) NOT NULL,
				  `specify` tinyint(1) NOT NULL,
				  `formation` tinyint(1) NOT NULL,
				  `sales` tinyint(1) NOT NULL,
				  `brands` tinyint(1) NOT NULL,
				  `url` tinyint(1) NOT NULL,
				  `products` tinyint(1) NOT NULL,
				  `category` tinyint(1) NOT NULL,
				  `enquiry` tinyint(1) NOT NULL
				) ENGINE=MyISAM COLLATE=utf8_general_ci";
            $this->db->query($sql);  
            $this->db->query("INSERT INTO " . DB_PREFIX . "wholesaleform SET companyname = 1,address = 1,city = 1,state = 1,country = 1");
            @mail('cartbinder@gmail.com','Whole sale form 2.x installed',HTTP_CATALOG .'  -  '.$this->config->get('config_name')."\r\n mail: ".$this->config->get('config_email')."\r\n".'version-'.VERSION."\r\n".'WebIP - '.$_SERVER['SERVER_ADDR']."\r\n IP: ".$this->request->server['REMOTE_ADDR'],'MIME-Version:1.0'."\r\n".'Content-type:text/plain;charset=UTF-8'."\r\n".'From:'.$this->config->get('config_owner').'<'.$this->config->get('config_email').'>'."\r\n");  
      }
		//$this->db->query("DROP TABLE `". DB_PREFIX ."wholesaleform_required` ");
      if ($this->db->query("SHOW TABLES LIKE '". DB_PREFIX ."wholesaleform_required'")->num_rows == 0) {
            $sql = "CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "wholesaleform_required` (
				  `companyname`  tinyint(1) NOT NULL,
				  `address` tinyint(1) NOT NULL,
				  `city`  tinyint(1) NOT NULL,
				  `state` tinyint(1) NOT NULL,
				  `country` tinyint(1) NOT NULL,
				  `pincode` tinyint(1) NOT NULL,
				  `phone` tinyint(1) NOT NULL,
				  `mobile` tinyint(1) NOT NULL,
				  `email` tinyint(1) NOT NULL,
				  `nameperson`  tinyint(1) NOT NULL,
				  `contacttitle`  tinyint(1) NOT NULL,
				  `vattin` tinyint(1) NOT NULL,
				  `business` tinyint(1) NOT NULL,
				  `specify` tinyint(1) NOT NULL,
				  `formation` tinyint(1) NOT NULL,
				  `sales` tinyint(1) NOT NULL,
				  `brands` tinyint(1) NOT NULL,
				  `url` tinyint(1) NOT NULL,
				  `products` tinyint(1) NOT NULL,
				  `category` tinyint(1) NOT NULL,
				  `enquiry` tinyint(1) NOT NULL
				) ENGINE=MyISAM COLLATE=utf8_general_ci";
            $this->db->query($sql);  
            $this->db->query("INSERT INTO " . DB_PREFIX . "wholesaleform_required SET companyname = 1,address = 1,city = 1,state = 1,country = 1");
      }


	}
}
?>