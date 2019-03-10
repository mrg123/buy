<?php 
class ControllerInformationToggleBan extends Controller{

    public function index(){

        $status = $this->config->get('ban_chinese_status');

        $description = '';
        $title = '';
        
        if($status){

        $ban_chinese_description = $this->config->get('ban_chinese_description');
        
		$language_id = $this->config->get('config_language_id');

		$title = $ban_chinese_description[$language_id]['title'];

		$description .= html_entity_decode($ban_chinese_description[$language_id]['description'], ENT_QUOTES, 'UTF-8') . "\n";
        

    }
        $data['title'] = $title;
        
        $data['description'] = $description;

        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/information/toggle_ban.tpl')) {
			$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/information/toggle_ban.tpl', $data));
		} else {
			$this->response->setOutput($this->load->view('default/template/information/contact.tpl', $data));
		}

    }
}

?>