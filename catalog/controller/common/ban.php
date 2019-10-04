<?php
class ControllerCommonBan extends Controller {
	public function index() {
		
		
		$json = explode("\r\n",$this->config->get('ban_json'));



		if (isset($this->request->cookie['ban_code']) && ($this->request->cookie['ban_code']!='') && in_array($this->request->cookie['ban_code'],$json)) {
			$data['ban'] =  false;
		}else{
			$data['ban'] = true;
		}
		$data['ban_url'] = $this->url->link('common/ban/validate', '', 'SSL');

		if(!$this->config->get('ban_status')){
			$data['ban'] = false;
		}

		return $this->load->view('default/template/common/ban.tpl', $data);
		
	}

	public function validate(){
		$code = $this->request->post['invitation_code'];

		if($code==''){
			$result = false;	
		}else{
			$json = explode("\r\n",$this->config->get('ban_json'));
		$result = false;
		if(in_array($code,$json)){
			$_COOKIE['ban_code'] = $code;

			setcookie('ban_code', $code , time() + 60 * 60 * 24 * 3600, '/' ,$this->request->server['HTTP_HOST']);
			
			$result = true;
		}else{
			$result = false;
		}
	}
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($result));
	}
}