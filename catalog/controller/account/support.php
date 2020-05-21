<?php
class ControllerAccountSupport extends Controller {
    /**
     * Function
     * 客户工单首页
     * @author zt7672
     * @version
     * @date 2020/3/14 21:47
     */
	public function index() {
		if (!$this->customer->isLogged()) {
			$this->session->data['redirect'] = $this->url->link('account/account', '', 'SSL');

			$this->response->redirect($this->url->link('account/login', '', 'SSL'));
		}

		$this->load->language('account/support');

		$this->document->setTitle($this->language->get('heading_title'));

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/home')
		);

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_account'),
            'href' => $this->url->link('account/account', '', 'SSL')
        );

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_support'),
			'href' => $this->url->link('account/support', '', 'SSL')
		);

		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];

			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}

		$data['heading_title'] = $this->language->get('heading_title');
		$data['text_add_support'] = $this->language->get('text_add_support');
		$data['text_history'] = $this->language->get('text_history');
		$data['history'] = $this->url->link('account/support/history', '', 'SSL');
		$data['add_support'] = $this->url->link('account/support/add', '', 'SSL');

	

		if ($this->config->get('reward_status')) {
			$data['reward'] = $this->url->link('account/reward', '', 'SSL');
		} else {
			$data['reward'] = '';
		}

		$data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/account/support_list.tpl')) {
			$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/account/support_list.tpl', $data));
		} else {
			$this->response->setOutput($this->load->view('default/template/account/support_list.tpl', $data));
		}
	}

    /**
     * Function
     * 客户工单历史列表页面
     * @author zt7672
     * @version
     * @date 2020/3/14 21:48
     */
	public function history() {
		if (!$this->customer->isLogged()) {
			$this->session->data['redirect'] = $this->url->link('account/account', '', 'SSL');

			$this->response->redirect($this->url->link('account/login', '', 'SSL'));
		}

		$this->load->language('account/support');

		$this->document->setTitle($this->language->get('heading_title'));

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/home')
		);
        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_account'),
            'href' => $this->url->link('account/account', '', 'SSL')
        );
        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_support'),
            'href' => $this->url->link('account/support', '', 'SSL')
        );
		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_history'),
			'href' => $this->url->link('account/support/history', '', 'SSL')
		);

		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];

			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}
		$customer_id = $this->customer->getId();

		$sql = "SELECT * FROM `".DB_PREFIX."support` where customer_id = {$customer_id}";
		$support_rows = $this->db->query($sql)->rows;

		$support_status = $this->status();
        $data['support_rows'] = [];
        if(!empty($support_rows)){
            foreach($support_rows as $key => $item){
                $data['support_rows'][] = [
                    'ticket_id' => $item['ticket_id'],
                    'subject' => $item['subject'],
                    'status' => $support_status[$item['status']],
                    'update_time' => date('l, d, F, Y (H:m:s)',strtotime($item['update_time'])),
                    'url' => $this->url->link('account/support/detail', 'ticket_id='.$item['ticket_id'], 'SSL')
                ];
            }

        }




		$data['heading_title'] = $this->language->get('heading_title');
		$data['text_add_support'] = $this->language->get('text_add_support');
		$data['text_history'] = $this->language->get('text_history');
		$data['history'] = $this->url->link('account/support/history', '', 'SSL');
		$data['add_support'] = $this->url->link('account/support/add', '', 'SSL');

	

		if ($this->config->get('reward_status')) {
			$data['reward'] = $this->url->link('account/reward', '', 'SSL');
		} else {
			$data['reward'] = '';
		}

		$data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/account/support_history.tpl')) {
			$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/account/support_history.tpl', $data));
		} else {
			$this->response->setOutput($this->load->view('default/template/account/support_history.tpl', $data));
		}
	}

    /**
     * Function
     * 客户工单的状态
     * @author zt7672
     * @version
     * @date 2020/3/14 21:48
     * @return array
     */
	public function status(){
        $support_status = [
            0 => 'In Progress',
            1 => 'Answered',
            2 => 'Resolved'
        ];
        return $support_status;
    }

    /**
     * Function 客户工单处理等级
     * @author zt7672
     * @version
     * @date 2020/3/14 21:48
     * @return array
     */
    public function priority(){
        $support_status = [
            1 => 'Low',
            2 => 'Medium',
            3 => 'High'
        ];
        return $support_status;
    }

    /**
     * Function 添加工单,并发送邮件给客户
     * @author zt7672
     * @version
     * @date 2020/3/14 21:48
     */
	public function add() {
		if (!$this->customer->isLogged()) {
			$this->session->data['redirect'] = $this->url->link('account/account', '', 'SSL');

			$this->response->redirect($this->url->link('account/login', '', 'SSL'));
		}

		$this->load->language('account/support');

		$this->document->setTitle($this->language->get('heading_title'));

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/home')
		);

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_account'),
            'href' => $this->url->link('account/account', '', 'SSL')
        );

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_support'),
			'href' => $this->url->link('account/support', '', 'SSL')
		);

		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];

			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}

		$data['heading_title'] = $this->language->get('heading_title');
		$data['text_add_support'] = $this->language->get('text_add_support');
		$data['text_history'] = $this->language->get('text_history');
		$data['history'] = $this->url->link('account/support/history', '', 'SSL');
		$data['add_support'] = $this->url->link('account/support/add', '', 'SSL');
		$data['support'] = $this->url->link('account/support', '', 'SSL');

        $customer_id = $this->customer->getId();

        $sql = "SELECT order_id FROM `".DB_PREFIX."order` where customer_id = {$customer_id}";
        $orders = $this->db->query($sql)->rows;
        $data['orders'] = $orders;

		if ($this->config->get('reward_status')) {
			$data['reward'] = $this->url->link('account/reward', '', 'SSL');
		} else {
			$data['reward'] = '';
		}

		$data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/account/support_add.tpl')) {
			$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/account/support_add.tpl', $data));
		} else {
			$this->response->setOutput($this->load->view('default/template/account/support_add.tpl', $data));
		}
	}

    /**
     * Function 客户工单详情页
     * 可以继续添加留言并上传图片
     * @author zt7672
     * @version
     * @date 2020/3/14 21:48
     */
    public function detail() {
	    $ticket_id = $this->db->escape($this->request->get['ticket_id']);
        if (!$this->customer->isLogged()) {
            $this->session->data['redirect'] = $this->url->link('account/account', '', 'SSL');
            $this->response->redirect($this->url->link('account/login', '', 'SSL'));
        }

        if(!$ticket_id){
            $this->session->data['redirect'] = $this->url->link('account/account', '', 'SSL');
            $this->response->redirect($this->url->link('account/login', '', 'SSL'));
        }


        $this->load->language('account/support');

        $this->document->setTitle($ticket_id);

        $data['breadcrumbs'] = array();

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/home')
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_support'),
            'href' => $this->url->link('account/support', '', 'SSL')
        );
        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_history'),
            'href' => $this->url->link('account/support/history', '', 'SSL')
        );
        $data['breadcrumbs'][] = array(
            'text' => $ticket_id,
            'href' => $this->url->link('account/support/detail', 'ticket_id='.$ticket_id, 'SSL')
        );

        if (isset($this->session->data['success'])) {
            $data['success'] = $this->session->data['success'];

            unset($this->session->data['success']);
        } else {
            $data['success'] = '';
        }

        $data['heading_title'] = $this->language->get('heading_title');
        $data['text_add_support'] = $this->language->get('text_add_support');
        $data['text_history'] = $this->language->get('text_history');
        $data['history'] = $this->url->link('account/support/history', '', 'SSL');
        $data['add_support'] = $this->url->link('account/support/add', '', 'SSL');
        $data['support'] = $this->url->link('account/support', '', 'SSL');

        $customer_id = $this->customer->getId();


        $sql = "SELECT * FROM `".DB_PREFIX."support` WHERE ticket_id = '{$ticket_id}' AND customer_id = {$customer_id}";
        $support_main = $this->db->query($sql)->row;
        $sql = "SELECT * FROM `".DB_PREFIX."support_img` WHERE ticket_id = '{$ticket_id}' ORDER BY time ASC,id ASC";
        $img_rows = $this->db->query($sql)->rows;
        $support_img = [];
        $upload_file = HTTP_SERVER . 'image/support/';
        foreach($img_rows as $key => $item){
            if(isset($support_img[$item['time']])){
                if(!empty($item['img_url'])){
                    $support_img[$item['time']]['img_url'][] = $upload_file . $item['img_url'];
                }

            }else{
                $support_img[$item['time']] = [
                    'add_time' => $item['add_time'],
                    'message'  => $item['message'],
                    'client'   => $item['client'],
                    'img_url' => !empty($item['img_url'])? [$upload_file . $item['img_url']]:[]
                ];
            }
        }
        $data['name'] = $this->customer->getLastName() . ' ' . $this->customer->getFirstName();
        $data['store_name'] = $this->config->get('config_name');

        $data['support_main'] = $support_main;
        $data['support_img'] = $support_img;
        $data['status'] = $this->status();
        $data['priority'] = $this->priority();
        $data['ticket_id'] = $ticket_id;



        $data['column_left'] = $this->load->controller('common/column_left');
        $data['column_right'] = $this->load->controller('common/column_right');
        $data['content_top'] = $this->load->controller('common/content_top');
        $data['content_bottom'] = $this->load->controller('common/content_bottom');
        $data['footer'] = $this->load->controller('common/footer');
        $data['header'] = $this->load->controller('common/header');

        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/account/support_detail.tpl')) {
            $this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/account/support_detail.tpl', $data));
        } else {
            $this->response->setOutput($this->load->view('default/template/account/support_detail.tpl', $data));
        }
    }


    /**
     * Function 新增工单
     * @author zt7672
     * @version
     * @date 2020/3/14 16:43
     */
	public function addSupport() {
		$json = [
		    'state' => 1,
            'message' => 'Success'
        ];
		try {
            $subject = trim($this->request->post['subject']);
            $order_id = trim($this->request->post['order-id']);
            $priority = trim($this->request->post['priority']);
            $message = trim($this->request->post['message']);
            $status = 0;
            $date = date('Y-m-d H:i:s', time());
            $add_time = $date;
            $update_time = $date;
            $customer_id = $this->customer->getId();
            if (!$customer_id) {
                throw new Exception('param error');
            }
            //print_r($_FILES);die;
            $files = [];
            $upload_file = DIR_IMAGE . 'support/' . $customer_id . '/';
            $this->mkdirs($upload_file);
            for ($i = 1; $i < 11; $i++) {
                if (isset($_FILES["file" . $i]["name"]) && $_FILES["file" . $i]["size"] > 0) {
                    $file_name =  $this->getGuidv4() .'-' . $_FILES["file". $i]["name"];

                    move_uploaded_file($_FILES["file" . $i]["tmp_name"],$upload_file . $file_name);
                    $files[] =  $customer_id . '/'. $file_name;
                }
            }

            $sql = "select support_count from " . DB_PREFIX . "support where customer_id = {$customer_id} ORDER BY id DESC LIMIT 1";
            $count = $this->db->query($sql)->row;

            if(!empty($count)){
                $count = $count['support_count'] + 1;
            }else{
                $count = 1;
            }
            $ticket_id = 'CST' . str_pad($count, 3, "0", STR_PAD_LEFT) . $order_id;
            $support_add = [
                'customer_id' => (int)$customer_id,
                'order_id' => (int)$order_id,
                'support_count' => (int)$count,
                'ticket_id' => $this->db->escape($ticket_id),
                'subject' => $this->db->escape($subject),
                'status' => (int)$status,
                'add_time' => $this->db->escape($add_time),
                'update_time' => $this->db->escape($update_time),
                'priority' => (int)$priority,
                'message' => $message,
            ];
            $insert_sql = "INSERT INTO `" . DB_PREFIX . "support`(`customer_id`, `order_id`, `support_count`, `ticket_id`, `subject`, `status`, `update_time`, `add_time`, `priority`) VALUES ({$support_add['customer_id']}, {$support_add['order_id']}, {$support_add['support_count']}, '{$support_add['ticket_id']}', '{$support_add['subject']}', {$support_add['status']}, '{$support_add['update_time']}', '{$support_add['add_time']}', {$support_add['priority']})";

            $this->db->query($insert_sql);



            /* 批量写入数据 */
            $sql = '';
            if(!empty($files)) {
                foreach ($files as $url) {
                    $sql .= "('" . $support_add['ticket_id'] . "','" . $url . "','" . $message . "','" . $add_time . "'),";
                }
                $sql = rtrim($sql, ',');
                $insert_img_sql = "INSERT INTO `" . DB_PREFIX . "support_img`(`ticket_id`, `img_url`, `message`, `add_time`) VALUES " . $sql;
            }else{
                $sql .= "('" . $support_add['ticket_id'] . "','','" . $message . "','" . $add_time . "'),";
                $sql = rtrim($sql, ',');
                $insert_img_sql = "INSERT INTO `" . DB_PREFIX . "support_img`(`ticket_id`, `img_url`, `message`, `add_time`) VALUES " . $sql;
            }

            $this->db->query($insert_img_sql);


            $this->session->data['success'] = 'Submit Ticket Success';

        }catch (Exception $e){
		    $json['message'] = $e->getMessage();
        }

        $this->sendEmail($support_add);

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

    /**
     * Function 增加留言
     * @author zt7672
     * @version
     * @date 2020/3/14 22:25
     */
    public function editSupport() {
        $json = [
            'state' => 1,
            'message' => 'Success'
        ];
        try {

            $message = trim($this->request->post['message']);
            $time = (int)trim($this->request->post['time']) + 1;
            $status = 0;
            $ticket_id = $this->db->escape($this->request->post['ticket_id']);
            $date = date('Y-m-d H:i:s', time());
            $add_time = $date;
            $update_time = $date;
            $customer_id = $this->customer->getId();
            if (!$customer_id) {
                throw new Exception('param error');
            }
            //print_r($_FILES);die;
            $files = [];
            $upload_file = DIR_IMAGE . 'support/' . $customer_id . '/';
            $this->mkdirs($upload_file);
            for ($i = 1; $i < 11; $i++) {
                if (isset($_FILES["file" . $i]["name"]) && $_FILES["file" . $i]["size"] > 0) {
                    $file_name =  $this->getGuidv4() .'-' . $_FILES["file". $i]["name"];

                    move_uploaded_file($_FILES["file" . $i]["tmp_name"],$upload_file . $file_name);
                    $files[] =  $customer_id . '/'. $file_name;
                }
            }

            $update_sql = "UPDATE " . DB_PREFIX . "support SET update_time = '{$update_time}',status = {$status} WHERE ticket_id = '{$ticket_id}' AND customer_id = {$customer_id}";
            $this->db->query($update_sql);


            /* 批量写入留言数据 */
            $sql = '';
            if(!empty($files)) {
                foreach ($files as $url) {
                    $sql .= "('" . $ticket_id . "','" . $url . "','" . $message . "','" . $add_time . "','" . $time . "'),";
                }
                $sql = rtrim($sql, ',');
                $insert_img_sql = "INSERT INTO `" . DB_PREFIX . "support_img`(`ticket_id`, `img_url`, `message`, `add_time`, `time`) VALUES " . $sql;
            }else{
                $sql .= "('" . $ticket_id . "','','" . $message . "','" . $add_time . "','" . $time . "'),";
                $sql = rtrim($sql, ',');
                $insert_img_sql = "INSERT INTO `" . DB_PREFIX . "support_img`(`ticket_id`, `img_url`, `message`, `add_time`,`time`) VALUES " . $sql;
            }

            $this->db->query($insert_img_sql);


            $this->session->data['success'] = 'Edit Ticket Success';

        }catch (Exception $e){
            $json['message'] = $e->getMessage();
        }



        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }

    /**
     * Function 发送工单邮件给客户
     * @author
     * @version
     * @date 2020/3/14 20:30
     * @array $subject = []
     */
	public function sendEmail($data){
        set_time_limit(60);
        try{
            $subject = '[Ticket ID:' . $data['ticket_id'] . ']' . $data['subject'];
            $this->load->model('account/customer');
            $customer = $this->model_account_customer->getCustomer($data['customer_id']);
            $email = $customer['email'];

            $message = 'Thank you for using customer support ticket system!' . "\n\n";
            $message .= 'Your customer support ticket was successfully submitted and we will work on it right away.'. "\n\n";
            $message .= 'Ticket ID: ' . $data['ticket_id']. "\n\n";
            $message .= 'Ticket Subject: ' . $data['subject']. "\n\n" . "\n\n";
            $message .= 'Please note that this is an automated notification and replying to this email will receive no feedback from us. If you have any further questions, please post them in your ticket by
following the below steps.'. "\n\n";
            $message .= '1, Login your account using email and password you previously registered on our website.'. "\n\n";
            $message .= '2, Go to "View My History Support Ticket"'. "\n\n";
            $message .= '3, Click on the ticket which you want to post your further comments.'. "\n\n";
            $message .= '4, Submit your comments.'. "\n\n";
            $message .= 'Best regards,'. "\n\n";
            $message .= 'Customer Support Center'. "\n\n";

            $mail = new Mail();
            $mail->protocol = $this->config->get('config_mail_protocol');
            $mail->parameter = $this->config->get('config_mail_parameter');
            $mail->smtp_hostname = $this->config->get('config_mail_smtp_hostname');
            $mail->smtp_username = $this->config->get('config_mail_smtp_username');
            $mail->smtp_password = html_entity_decode($this->config->get('config_mail_smtp_password'), ENT_QUOTES, 'UTF-8');
            $mail->smtp_port = $this->config->get('config_mail_smtp_port');
            $mail->smtp_timeout = $this->config->get('config_mail_smtp_timeout');

            $mail->setTo($email);
            $mail->setFrom($this->config->get('config_email'));
            $mail->setSender(html_entity_decode($this->config->get('config_name'), ENT_QUOTES, 'UTF-8'));
            $mail->setSubject(html_entity_decode($subject, ENT_QUOTES, 'UTF-8'));
            //$mail->setHtml($html);
            $mail->setText($message);
            $mail->send();



        }catch(Exception $e){

        }
    }

    /* 生产目录 */
    public function  mkdirs($path){
        if (!file_exists($path)) {
            self::mkdirs(dirname($path));
            mkdir($path, 0777);
            chmod($path, 0777);
        }
    }

    /* 生成唯一id */
    public function getGuidv4($trim = true)
    {
        // Windows
        if (function_exists('com_create_guid') === true) {
            if ($trim === true)
                return strtoupper(trim(com_create_guid(), '{}'));
            else
                return strtoupper(com_create_guid());
        }

        // OSX/Linux
        if (function_exists('openssl_random_pseudo_bytes') === true) {
            $data = openssl_random_pseudo_bytes(16);
            $data[6] = chr(ord($data[6]) & 0x0f | 0x40);    // set version to 0100
            $data[8] = chr(ord($data[8]) & 0x3f | 0x80);    // set bits 6-7 to 10
            return strtoupper(vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4)));
        }

        // Fallback (PHP 4.2+)
        mt_srand((double)microtime() * 10000);
        $charid = strtolower(md5(uniqid(rand(), true)));
        $hyphen = chr(45);                  // "-"
        $lbrace = $trim ? "" : chr(123);    // "{"
        $rbrace = $trim ? "" : chr(125);    // "}"
        $guidv4 = $lbrace.
            substr($charid,  0,  8).$hyphen.
            substr($charid,  8,  4).$hyphen.
            substr($charid, 12,  4).$hyphen.
            substr($charid, 16,  4).$hyphen.
            substr($charid, 20, 12).
            $rbrace;
        return strtoupper($guidv4);
    }
}
