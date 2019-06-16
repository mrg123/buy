<?php
class ControllerInformationQcPhoto extends Controller {
	public function index() {
		

		$this->load->model('tool/order_img');

		
		if (isset($this->request->get['order_id'])) {
			$order_id = (int)$this->request->get['order_id'];
		} else {
			$order_id = 0;
		}

		if (isset($this->request->get['sign'])) {
			$sign = $this->request->get['sign'];
		} else {
			$sign = '';
		}

		$check_sign = md5(md5('9876'));
		if($check_sign != $sign){
			$order_id = 0;
		}

		$data['action'] = $this->url->link('information/qc_photo/check','','SSL');
		$data['order_id'] = $order_id;

		$data['welcome'] = $this->config->get('qc_photo_welcome');

		$information_info = $this->model_tool_order_img->getImg($order_id);

		if ($information_info) {

			$data['img_arr'] = $information_info;

			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/information/information.tpl')) {
				$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/information/qc_photo.tpl', $data));
			} else {
				$this->response->setOutput($this->load->view('default/template/information/qc_photo.tpl', $data));
			}
		}
	}

	public function check(){
		
		$json = [
			'state' => 0,
			'message' => 'Error Rquest',
			'request' => [],
			'data' => []
		];

		if($this->request->server['REQUEST_METHOD'] == 'POST'){
			$order_id = $this->request->post['order_id'];
			$choose = $this->request->post['choose'];	
			$message = $this->request->post['message'];	

			
			$qc_photo_status = $this->config->get('qc_photo_status');

			$json['request'] = [
				'order_id' => $order_id,
				'choose' => $choose,
				'message' => $message,
				'status' => $qc_photo_status,
			];

			if(!empty($order_id) && $qc_photo_status){
				$this->load->model('account/order');
				$order_info = $this->model_account_order->getOrderToQcPhoto($order_id);

				$json['data']['order_info'] = $order_info;

				if(!empty($order_info)){
					$gl_order_id = $this->config->get('qc_photo_gl_status_id');
					$rl_order_id = $this->config->get('qc_photo_rl_status_id');
					
					if($choose == 'rl'){
						$choose_order_id = $rl_order_id;
					}else{
						// 默认gl
						$choose_order_id = $gl_order_id;
					}

					if($order_info['order_status_id']== $choose_order_id){
						$json['state'] = 1;
						$json['message'] = 'Qc Photo Request has been processed';
					}else{
						// 修改订单状态,并通知客户
                        try {
                            $this->load->model('checkout/order');
                            $this->model_checkout_order->addOrderHistory($order_id, $choose_order_id, $message, 1, 0);
                            $json['state'] = 1;
                        }catch(Exception $e){
							$json['exception'] = $e;
						}

					}

				}
				

			}


		}

		if($json['state']){
			$this->response->redirect($this->url->link('information/qc_photo/success'));
		}else{
			//$this->response->addHeader('Content-Type: application/json');
			//$this->response->setOutput(json_encode($json));

		}
	}

	public function success() {
		$this->load->language('information/qc_photo');

		$this->document->setTitle($this->language->get('heading_title'));

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/home')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('information/contact')
		);

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_message'] = $this->language->get('text_success');

		$data['button_continue'] = $this->language->get('button_continue');

		$data['continue'] = $this->url->link('common/home');

		$data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/common/success.tpl')) {
			$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/common/success.tpl', $data));
		} else {
			$this->response->setOutput($this->load->view('default/template/common/success.tpl', $data));
		}
	}


}