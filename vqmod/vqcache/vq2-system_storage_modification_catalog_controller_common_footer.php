<?php
class ControllerCommonFooter extends Controller {

public function addTrack(){
	
	/*
	是否记录访客的会话
	*/	
	$add = 0;
	$sign = $this->config->get('track_sign');
	if (isset($this->session->data['track_id'])) {
		$track_id = $this->session->data['track_id'];
	} elseif (isset($this->request->cookie['track_id'])) {
		$track_id = $this->request->cookie['track_id'];	
		$this->session->data['track_id'] = $track_id;
	} elseif (isset($this->request->get[$sign])) {
		$track_id = 1;	
		$add = 1;
		$visitor = $this->request->get[$sign];
	} else {
		$track_id = 0;	
	}
	
	/* 开始记录访客的会话信息 */
		if($add){
		
		/* 新增访客信息,或者是*/
		if (isset($this->request->server['REMOTE_ADDR'])) {
			$ip = $this->request->server['REMOTE_ADDR'];
		} else {
			$ip = '';
		}

		if (isset($this->request->server['HTTP_HOST']) && isset($this->request->server['REQUEST_URI'])) {
			$url = 'http://' . $this->request->server['HTTP_HOST'] . $this->request->server['REQUEST_URI'];
		} else {
			$url = '';
		}

		if (isset($this->request->server['HTTP_REFERER'])) {
			$referer = $this->request->server['HTTP_REFERER'];
		} else {
			$referer = '';
		}
			
		$session_id = $this->session->getId();
		
		
		
		$nation = '';
		
		$tracks = array(
			'session_id' => $session_id,
			'visitor' => $visitor,
			'ip' => $ip,
			'nation' => $nation,
			'referer' => $referer,
			'landing_url' => $url
		);
		
		/* add track */
		$this->db->query("INSERT INTO " . DB_PREFIX . "track SET session_id = '" . $this->db->escape($tracks['session_id']) . "', visitor = '" . $this->db->escape($tracks['visitor']) . "', ip = '" . $this->db->escape($tracks['ip']) . "', nation = '" . $this->db->escape($tracks['nation']) . "', referer = '" . $this->db->escape($tracks['referer']) . "', landing_url = '" . $this->db->escape($tracks['landing_url']) . "', date_added = date_add(NOW(),interval 8 hour)");
	
		$track_id = $this->db->getLastId();
		
		/* add track url*/
		$this->db->query("INSERT INTO " . DB_PREFIX . "track_url SET track_id = '" . (int)$track_id . "', url = '" . $this->db->escape($tracks['landing_url']) . "', date = date_add(NOW(),interval 8 hour)");
	
		$this->session->data['track_id'] = $track_id;
		setcookie('track_id', $track_id, time() + 60 * 60 * 24 * 30, '/', $this->request->server['HTTP_HOST']);
		
		}elseif($track_id){
			/*记录访问的页面*/
			if (isset($this->request->server['HTTP_HOST']) && isset($this->request->server['REQUEST_URI'])) {
			$url = 'http://' . $this->request->server['HTTP_HOST'] . $this->request->server['REQUEST_URI'];
			} else {
				$url = '';
			}
			/* add track url*/
		$this->db->query("INSERT INTO " . DB_PREFIX . "track_url SET track_id = '" . (int)$track_id . "', url = '" . $this->db->escape($url) . "', date = date_add(NOW(),interval 8 hour)");
		}
	
	
	
	}
			
	public function index() {
		$this->load->language('common/footer');

		$data['scripts'] = $this->document->getScripts('footer');

		$data['text_information'] = $this->language->get('text_information');
    
				$data['wholesaleform_showlinkfooter'] = $this->config->get('wholesaleform_showlinkfooter');
				$data['wholesalelink'] = $this->url->link('information/wholesaleform');
				$data['text_wholesale'] = $this->language->get('text_wholesale');
				
		$data['text_service'] = $this->language->get('text_service');
		$data['text_extra'] = $this->language->get('text_extra');
		$data['text_contact'] = $this->language->get('text_contact');

		$data['text_contacts'] = $this->language->get('text_contacts');
			
		$data['text_return'] = $this->language->get('text_return');
		$data['text_sitemap'] = $this->language->get('text_sitemap');
		$data['text_manufacturer'] = $this->language->get('text_manufacturer');
		$data['text_voucher'] = $this->language->get('text_voucher');
		$data['text_affiliate'] = $this->language->get('text_affiliate');
		$data['text_special'] = $this->language->get('text_special');
		$data['text_account'] = $this->language->get('text_account');
		$data['text_order'] = $this->language->get('text_order');
		$data['text_wishlist'] = $this->language->get('text_wishlist');
		$data['text_newsletter'] = $this->language->get('text_newsletter');

		$data['config_telephone'] = $this->config->get('config_telephone');
		$data['config_address'] = $this->config->get('config_address');
		$data['config_email'] = $this->config->get('config_email');
		$data['config_open'] = $this->config->get('config_open');
		$data['config_comment'] = $this->config->get('config_comment');
		$data['config_twitter'] = $this->config->get('config_twitter');
		$data['config_google'] = $this->config->get('config_google');
		$data['config_facebook'] = $this->config->get('config_facebook');
		$data['config_instagram'] = $this->config->get('config_instagram');
		$data['config_vk'] = $this->config->get('config_vk');
		$data['config_odnoklassniki'] = $this->config->get('config_odnoklassniki');
		$data['config_url'] = $this->config->get('config_url');
		$data['config_card'] = $this->config->get('config_card');
		$data['config_html'] = $this->config->get('config_html');
		


			if($this->config->get('track_status')){
				$this->addTrack();
			}
			
		$this->load->model('catalog/information');

		$data['informations'] = array();

		foreach ($this->model_catalog_information->getInformations() as $result) {
			if ($result['bottom']) {
				$data['informations'][] = array(
					'title' => $result['title'],
					'href'  => $this->url->link('information/information', 'information_id=' . $result['information_id'])
				);
			}
		}

		$data['contact'] = $this->url->link('information/contact');
		$data['return'] = $this->url->link('account/return/add', '', 'SSL');
		$data['sitemap'] = $this->url->link('information/sitemap');
		$data['manufacturer'] = $this->url->link('product/manufacturer');
		$data['voucher'] = $this->url->link('account/voucher', '', 'SSL');
		$data['affiliate'] = $this->url->link('affiliate/account', '', 'SSL');
		$data['special'] = $this->url->link('product/special');
		$data['account'] = $this->url->link('account/account', '', 'SSL');
		$data['order'] = $this->url->link('account/order', '', 'SSL');
		$data['wishlist'] = $this->url->link('account/wishlist', '', 'SSL');
		$data['newsletter'] = $this->url->link('account/newsletter', '', 'SSL');

		$data['powered'] = sprintf($this->language->get('text_powered'), $this->config->get('config_name'), date('Y', time()));

		// Whos Online
		if ($this->config->get('config_customer_online')) {
			$this->load->model('tool/online');

			if (isset($this->request->server['REMOTE_ADDR'])) {
				$ip = $this->request->server['REMOTE_ADDR'];
			} else {
				$ip = '';
			}

			if (isset($this->request->server['HTTP_HOST']) && isset($this->request->server['REQUEST_URI'])) {
				$url = 'http://' . $this->request->server['HTTP_HOST'] . $this->request->server['REQUEST_URI'];
			} else {
				$url = '';
			}

			if (isset($this->request->server['HTTP_REFERER'])) {
				$referer = $this->request->server['HTTP_REFERER'];
			} else {
				$referer = '';
			}

			$this->model_tool_online->addOnline($ip, $this->customer->getId(), $url, $referer);
		}

if(IS_MOBILE){
                return $this->load->view('wap/footer.tpl', $data);
            }
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/common/footer.tpl')) {
			return $this->load->view($this->config->get('config_template') . '/template/common/footer.tpl', $data);
		} else {
			return $this->load->view('default/template/common/footer.tpl', $data);
		}
	}
}
