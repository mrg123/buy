<?php
class ControllerToolWebupload extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('tool/upload');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('tool/upload');

		$this->getList();
	}

	protected function getList() {

		$data['heading_title'] = $this->language->get('heading_title');
		
		$data['text_list'] = $this->language->get('text_list');
		$data['text_no_results'] = $this->language->get('text_no_results');
		$data['text_confirm'] = $this->language->get('text_confirm');

		$data['column_name'] = $this->language->get('column_name');
		$data['column_filename'] = $this->language->get('column_filename');
		$data['column_date_added'] = $this->language->get('column_date_added');
		$data['column_action'] = $this->language->get('column_action');

		$data['entry_name'] = $this->language->get('entry_name');
		$data['entry_date_added'] = $this->language->get('entry_date_added');

		$data['button_download'] = $this->language->get('button_download');
		$data['button_delete'] = $this->language->get('button_delete');
		$data['button_filter'] = $this->language->get('button_filter');


		$order_id = $this->request->get['order_id'];

		$this->load->model('tool/order_img');
		$num = $this->model_tool_order_img->nowNum($order_id);
		$data['order_id'] = $order_id;
		$data['num'] = $num;
		$data['token'] = $this->session->data['token'];
		$data['catalog_url'] = HTTPS_CATALOG;
		$data['upload_status_id'] = $this->config->get('qc_photo_upload_status_id');

		$sign = md5(md5('9876'));
		$preview_url = HTTPS_CATALOG . 'index.php?route=information/qc_photo&sign='.$sign;
		$data['message'] = "Please click this link to view your QC photo " . $preview_url;
		$data['catalog_preview_url'] = $preview_url;	
		
		
		// API login
		$this->session->data['api_id'] = 1;

		$this->response->setOutput($this->load->view('tool/webupload.tpl', $data));
	}

	public function upload(){
		$order_id = $this->request->get['order_id'];	
		$num = $this->request->get['num'];	

		$this->init();

		$targetDir = DIR_IMAGE . 'order_upload_tmp' . DIRECTORY_SEPARATOR . $order_id;
		$uploadDir = DIR_IMAGE . 'order_upload' . DIRECTORY_SEPARATOR . $order_id;
		// Create target dir
		if (!file_exists($targetDir)) {
		@mkdir($targetDir);
		}

		// Create target dir
		if (!file_exists($uploadDir)) {
		@mkdir($uploadDir);
		}
		$date = date('Y-m-d_H-i-s');
		// Get a file name
		if (isset($_REQUEST["name"])) {
			$fileName = uniqid($date  . "_") .'.'. pathinfo($_REQUEST["name"])['extension'];
		} elseif (!empty($_FILES)) {
			$fileName = $_FILES["file"]["name"];
		} else {
			$fileName = uniqid("file_");
		}
		$img_url = 'image'.DIRECTORY_SEPARATOR.'order_upload' . DIRECTORY_SEPARATOR . $order_id . DIRECTORY_SEPARATOR . $fileName;
		

		$filePath = $targetDir . DIRECTORY_SEPARATOR . $fileName;
		$uploadPath = $uploadDir . DIRECTORY_SEPARATOR . $fileName;

				// Chunking might be enabled
		$chunk = isset($_REQUEST["chunk"]) ? intval($_REQUEST["chunk"]) : 0;
		$chunks = isset($_REQUEST["chunks"]) ? intval($_REQUEST["chunks"]) : 1;

				// Open temp file
		if (!$out = @fopen("{$filePath}_{$chunk}.parttmp", "wb")) {
			die('{"jsonrpc" : "2.0", "error" : {"code": 102, "message": "Failed to open output stream."}, "id" : "id"}');
		}

		if (!empty($_FILES)) {
			if ($_FILES["file"]["error"] || !is_uploaded_file($_FILES["file"]["tmp_name"])) {
				die('{"jsonrpc" : "2.0", "error" : {"code": 103, "message": "Failed to move uploaded file."}, "id" : "id"}');
			}

			// Read binary input stream and append it to temp file
			if (!$in = @fopen($_FILES["file"]["tmp_name"], "rb")) {
				die('{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "Failed to open input stream."}, "id" : "id"}');
			}
		} else {
			if (!$in = @fopen("php://input", "rb")) {
				die('{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "Failed to open input stream."}, "id" : "id"}');
			}
		}

		while ($buff = fread($in, 4096)) {
			fwrite($out, $buff);
		}

		@fclose($out);
		@fclose($in);

		rename("{$filePath}_{$chunk}.parttmp", "{$filePath}_{$chunk}.part");

		$index = 0;
		$done = true;
		for( $index = 0; $index < $chunks; $index++ ) {
			if ( !file_exists("{$filePath}_{$index}.part") ) {
				$done = false;
				break;
			}
		}
		if ( $done ) {
			if (!$out = @fopen($uploadPath, "wb")) {
				die('{"jsonrpc" : "2.0", "error" : {"code": 102, "message": "Failed to open output stream."}, "id" : "id"}');
			}

			if ( flock($out, LOCK_EX) ) {
				for( $index = 0; $index < $chunks; $index++ ) {
					if (!$in = @fopen("{$filePath}_{$index}.part", "rb")) {
						break;
					}

					while ($buff = fread($in, 4096)) {
						fwrite($out, $buff);
					}

					@fclose($in);
					@unlink("{$filePath}_{$index}.part");
				}

				flock($out, LOCK_UN);
			}
			@fclose($out);
		}

		// 图片上传成功,写入到订单图片表中
		$this->load->model('tool/order_img');
		$this->model_tool_order_img->add($order_id,$img_url,$num);	

		// Return Success JSON-RPC response
		die('{"jsonrpc" : "2.0", "result" : null, "id" : "id"}');
	}

	public function preview(){
		$order_id = $this->request->get('order_id');

	}

	private function init(){
		$targetDir = DIR_IMAGE . 'order_upload_tmp';
		$uploadDir = DIR_IMAGE . 'order_upload';
		// Create target dir
		if (!file_exists($targetDir)) {
			@mkdir($targetDir);
		}

		// Create target dir
		if (!file_exists($uploadDir)) {
			@mkdir($uploadDir);
		}	
	}

	public function restart(){
		$order_id = $this->request->get['order_id'];
		$json = [
			'state' => 0,
			'message' => ''
		];
		$this->load->model('tool/order_img');
		$result = $this->model_tool_order_img->delete($order_id);
		if($result){
			$json['state'] = 1;
		}else{
			$json['message'] = '删除失败';
		}


		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}


}