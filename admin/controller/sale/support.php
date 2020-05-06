<?php
class ControllerSaleSupport extends Controller {

    public function index(){
        $this->load->language('sale/support');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->getList();
    }

    protected function getList() {
        if (isset($this->request->get['filter_order_id'])) {
            $filter_order_id = $this->request->get['filter_order_id'];
        } else {
            $filter_order_id = null;
        }
        if (isset($this->request->get['filter_customer'])) {
            $filter_customer = $this->request->get['filter_customer'];
        } else {
            $filter_customer = null;
        }
        if (isset($this->request->get['filter_customer_email'])) {
            $filter_customer_email = $this->request->get['filter_customer_email'];
        } else {
            $filter_customer_email = null;
        }
        if (isset($this->request->get['filter_ticket_id'])) {
            $filter_ticket_id = $this->request->get['filter_ticket_id'];
        } else {
            $filter_ticket_id = null;
        }
        if (isset($this->request->get['filter_priority'])) {
            $filter_priority = $this->request->get['filter_priority'];
        } else {
            $filter_priority = '';
        }
        if (isset($this->request->get['filter_status'])) {
            $filter_status = $this->request->get['filter_status'];
        } else {
            $filter_status = 0;
        }

        if (isset($this->request->get['filter_date_added'])) {
            $filter_date_added = $this->request->get['filter_date_added'];
        } else {
            $filter_date_added = null;
        }

        if (isset($this->request->get['filter_date_modified'])) {
            $filter_date_modified = $this->request->get['filter_date_modified'];
        } else {
            $filter_date_modified = null;
        }

        if (isset($this->request->get['sort'])) {
            $sort = $this->request->get['sort'];
        } else {
            $sort = 'id';
        }

        if (isset($this->request->get['order'])) {
            $order = $this->request->get['order'];
        } else {
            $order = 'DESC';
        }

        if (isset($this->request->get['page'])) {
            $page = $this->request->get['page'];
        } else {
            $page = 1;
        }

        $url = '';

        if (isset($this->request->get['filter_order_id'])) {
            $url .= '&filter_order_id=' . $this->request->get['filter_order_id'];
        }

        if (isset($this->request->get['filter_customer'])) {
            $url .= '&filter_customer=' . urlencode(html_entity_decode($this->request->get['filter_customer'], ENT_QUOTES, 'UTF-8'));
        }

        if (isset($this->request->get['filter_customer_email'])) {
            $url .= '&filter_customer_email=' . urlencode(html_entity_decode($this->request->get['filter_customer_email'], ENT_QUOTES, 'UTF-8'));
        }
        if (isset($this->request->get['filter_ticket_id'])) {
            $url .= '&filter_ticket_id=' . urlencode(html_entity_decode($this->request->get['filter_ticket_id'], ENT_QUOTES, 'UTF-8'));
        }
        if (isset($this->request->get['filter_priority'])) {
            $url .= '&filter_priority=' . urlencode(html_entity_decode($this->request->get['filter_priority'], ENT_QUOTES, 'UTF-8'));
        }
        if (isset($this->request->get['filter_status'])) {
            $url .= '&filter_status=' . $this->request->get['filter_status'];
        }

        if (isset($this->request->get['filter_date_added'])) {
            $url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
        }

        if (isset($this->request->get['filter_date_modified'])) {
            $url .= '&filter_date_modified=' . $this->request->get['filter_date_modified'];
        }

        if (isset($this->request->get['sort'])) {
            $url .= '&sort=' . $this->request->get['sort'];
        }

        if (isset($this->request->get['order'])) {
            $url .= '&order=' . $this->request->get['order'];
        }

        if (isset($this->request->get['page'])) {
            $url .= '&page=' . $this->request->get['page'];
        }

        $data['breadcrumbs'] = array();

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL')
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('sale/support', 'token=' . $this->session->data['token'] . $url, 'SSL')
        );

        $data['statuses'] = $this->status();

        $data['priority'] = $this->priority();
        $priority = $this->priority();
        $support_status = $this->status();



        $data['support_list'] = array();


        $filter_data = array(
            'filter_order_id'      => $filter_order_id,
            'filter_ticket_id'      => $filter_ticket_id,
            'filter_customer'	   => $filter_customer,
            'filter_customer_email'	   => $filter_customer_email,
            'filter_priority'	   => $filter_priority,
            'filter_status'  => $filter_status,
            'filter_date_added'    => $filter_date_added,
            'filter_date_modified' => $filter_date_modified,
            'sort'                 => $sort,
            'order'                => $order,
            'start'                => ($page - 1) * $this->config->get('config_limit_admin'),
            'limit'                => $this->config->get('config_limit_admin')
        );

        $support_total = $this->getSupportList($filter_data,'count');
        $results = $this->getSupportList($filter_data);

        foreach ($results as $result) {
            $data['support_list'][] = [
                'id' => $result['id'],
                'ticket_id' => $result['ticket_id'],
                'order_id' => $result['order_id'],
                'customer' => $result['lastname'] . ' ' . $result['firstname'],
                'subject' => $result['subject'],
                'priority' => $priority[$result['priority']],
                'add_time' => $result['add_time'],
                'update_time' => $result['update_time'],
                'email' => $result['email'],
                'status' => $support_status[$result['status']],
                'url' => $this->url->link('sale/support/detail', 'token=' . $this->session->data['token'] . '&ticket_id=' . $result['ticket_id'], 'SSL')
            ];
        }




        $data['heading_title'] = $this->language->get('heading_title');

        $data['text_list'] = $this->language->get('text_list');
        $data['text_no_results'] = $this->language->get('text_no_results');
        $data['text_confirm'] = $this->language->get('text_confirm');
        $data['text_missing'] = $this->language->get('text_missing');
        $data['text_loading'] = $this->language->get('text_loading');

        $data['column_order_id'] = $this->language->get('column_order_id');
        $data['column_customer'] = $this->language->get('column_customer');
        $data['column_status'] = $this->language->get('column_status');
        $data['column_total'] = $this->language->get('column_total');
        $data['column_date_added'] = $this->language->get('column_date_added');
        $data['column_date_modified'] = $this->language->get('column_date_modified');
        $data['column_action'] = $this->language->get('column_action');

        $data['entry_return_id'] = $this->language->get('entry_return_id');
        $data['entry_order_id'] = $this->language->get('entry_order_id');
        $data['entry_customer'] = $this->language->get('entry_customer');
        $data['entry_order_status'] = $this->language->get('entry_order_status');
        $data['entry_total'] = $this->language->get('entry_total');
        $data['entry_date_added'] = $this->language->get('entry_date_added');
        $data['entry_date_modified'] = $this->language->get('entry_date_modified');
        $data['entry_order_id'] = $this->language->get('entry_order_id');

        $data['button_invoice_print'] = $this->language->get('button_invoice_print');
        $data['button_shipping_print'] = $this->language->get('button_shipping_print');
        $data['button_add'] = $this->language->get('button_add');
        $data['button_edit'] = $this->language->get('button_edit');
        $data['button_delete'] = $this->language->get('button_delete');
        $data['button_filter'] = $this->language->get('button_filter');
        $data['button_view'] = $this->language->get('button_view');
        $data['button_ip_add'] = $this->language->get('button_ip_add');


        $data['entry_customer_email'] = $this->language->get('entry_customer_email');
        $data['entry_model'] = $this->language->get('entry_model');
        $data['entry_shipping_method'] = $this->language->get('entry_shipping_method');
        $data['column_country'] = $this->language->get('column_country');


        $data['token'] = $this->session->data['token'];


        $url = '';

        if (isset($this->request->get['filter_order_id'])) {
            $url .= '&filter_order_id=' . $this->request->get['filter_order_id'];
        }
        if (isset($this->request->get['filter_ticket_id'])) {
            $url .= '&filter_ticket_id=' . $this->request->get['filter_ticket_id'];
        }
        if (isset($this->request->get['filter_customer'])) {
            $url .= '&filter_customer=' . urlencode(html_entity_decode($this->request->get['filter_customer'], ENT_QUOTES, 'UTF-8'));
        }
        if (isset($this->request->get['filter_customer_email'])) {
            $url .= '&filter_customer_email=' . urlencode(html_entity_decode($this->request->get['filter_customer_email'], ENT_QUOTES, 'UTF-8'));
        }
        if (isset($this->request->get['filter_priority'])) {
            $url .= '&filter_priority=' . urlencode(html_entity_decode($this->request->get['filter_priority'], ENT_QUOTES, 'UTF-8'));
        }
        if (isset($this->request->get['filter_status'])) {
            $url .= '&filter_status=' . $this->request->get['filter_status'];
        }

        if (isset($this->request->get['filter_date_added'])) {
            $url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
        }

        if (isset($this->request->get['filter_date_modified'])) {
            $url .= '&filter_date_modified=' . $this->request->get['filter_date_modified'];
        }

        if ($order == 'ASC') {
            $url .= '&order=DESC';
        } else {
            $url .= '&order=ASC';
        }

        if (isset($this->request->get['page'])) {
            $url .= '&page=' . $this->request->get['page'];
        }

        /* 排序保留 */
        $data['sort_order'] = $this->url->link('sale/support', 'token=' . $this->session->data['token'] . '&sort=o.order_id' . $url, 'SSL');
        $data['sort_customer'] = $this->url->link('sale/support', 'token=' . $this->session->data['token'] . '&sort=customer' . $url, 'SSL');
        $data['sort_status'] = $this->url->link('sale/support', 'token=' . $this->session->data['token'] . '&sort=status' . $url, 'SSL');
        $data['sort_total'] = $this->url->link('sale/support', 'token=' . $this->session->data['token'] . '&sort=o.total' . $url, 'SSL');
        $data['sort_date_added'] = $this->url->link('sale/support', 'token=' . $this->session->data['token'] . '&sort=o.date_added' . $url, 'SSL');
        $data['sort_date_modified'] = $this->url->link('sale/support', 'token=' . $this->session->data['token'] . '&sort=o.date_modified' . $url, 'SSL');
        $data['sort_country'] = $this->url->link('sale/support', 'token=' . $this->session->data['token'] . '&sort=country' . $url, 'SSL');

        $url = '';

        if (isset($this->request->get['filter_order_id'])) {
            $url .= '&filter_order_id=' . $this->request->get['filter_order_id'];
        }

        if (isset($this->request->get['filter_customer'])) {
            $url .= '&filter_customer=' . urlencode(html_entity_decode($this->request->get['filter_customer'], ENT_QUOTES, 'UTF-8'));
        }

        if (isset($this->request->get['filter_customer_email'])) {
            $url .= '&filter_customer_email=' . urlencode(html_entity_decode($this->request->get['filter_customer_email'], ENT_QUOTES, 'UTF-8'));
        }
        if (isset($this->request->get['filter_ticket_id'])) {
            $url .= '&filter_ticket_id=' . urlencode(html_entity_decode($this->request->get['filter_ticket_id'], ENT_QUOTES, 'UTF-8'));
        }
        if (isset($this->request->get['filter_priority'])) {
            $url .= '&filter_priority=' . urlencode(html_entity_decode($this->request->get['filter_priority'], ENT_QUOTES, 'UTF-8'));
        }

        if (isset($this->request->get['filter_status'])) {
            $url .= '&filter_status=' . $this->request->get['filter_status'];
        }

        if (isset($this->request->get['filter_date_added'])) {
            $url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
        }

        if (isset($this->request->get['filter_date_modified'])) {
            $url .= '&filter_date_modified=' . $this->request->get['filter_date_modified'];
        }

        if (isset($this->request->get['sort'])) {
            $url .= '&sort=' . $this->request->get['sort'];
        }

        if (isset($this->request->get['order'])) {
            $url .= '&order=' . $this->request->get['order'];
        }

        $pagination = new Pagination();
        $pagination->total = $support_total;
        $pagination->page = $page;
        $pagination->limit = $this->config->get('config_limit_admin');
        $pagination->url = $this->url->link('sale/support', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');

        $data['pagination'] = $pagination->render();

        $data['results'] = sprintf($this->language->get('text_pagination'), ($support_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($support_total - $this->config->get('config_limit_admin'))) ? $support_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $support_total, ceil($support_total / $this->config->get('config_limit_admin')));

        $data['filter_order_id'] = $filter_order_id;
        $data['filter_customer'] = $filter_customer;
        $data['filter_status'] = $filter_status;

        $data['filter_date_added'] = $filter_date_added;
        $data['filter_date_modified'] = $filter_date_modified;

        $data['filter_customer_email'] = $filter_customer_email;
        $data['filter_ticket_id'] = $filter_ticket_id;
        $data['filter_priority'] = $filter_priority;
        $data['token'] =  $this->session->data['token'];


        $data['sort'] = $sort;
        $data['order'] = $order;


        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('sale/support_list.tpl', $data));
    }

    public function getSupportList($filter_data,$count = ''){
        if(!empty($count)){
            $sql = "select count(*) from ".DB_PREFIX."support s left join ".DB_PREFIX."customer c on s.customer_id = c.customer_id";
        }else{
            $sql = "select s.*,c.firstname,c.lastname,c.email from ".DB_PREFIX."support s left join ".DB_PREFIX."customer c on s.customer_id = c.customer_id";
        }

        $sql .= " WHERE 1=1";
        if(!empty($filter_data['filter_order_id'])){
            $sql .= " AND s.order_id = {$filter_data['filter_order_id']}";
        }
        if(!empty($filter_data['filter_ticket_id'])){
            $sql .= " AND s.ticket_id = '{$filter_data['filter_ticket_id']}'";
        }
        if(!empty($filter_data['filter_customer'])){
            $sql .= " AND c.firstname LIKE '%{$filter_data['filter_customer']}%' OR c.lastname LIKE '%{$filter_data['filter_customer']}%'";
        }
        if(!empty($filter_data['filter_customer_email'])){
            $sql .= " AND c.email = '%{$filter_data['filter_customer_email']}%'";
        }
        if(!empty($filter_data['filter_priority'])){
            $sql .= " AND s.priority = {$filter_data['filter_priority']}";
        }
        if($filter_data['filter_status']!=100){
            $sql .= " AND s.status = {$filter_data['filter_status']}";
        }
        if(!empty($filter_data['filter_date_added'])){
            $sql .= " AND s.add_time >= '{$filter_data['filter_date_added']}'";
        }
        if(!empty($filter_data['filter_date_modified'])){
            $sql .= " AND s.update_time >= '{$filter_data['filter_date_modified']}'";
        }

        if($filter_data['sort'] == 'o.date_modified'){
            $filter_data['sort'] = 's.update_time';
        }
        if($filter_data['sort'] == 'o.date_added'){
            $filter_data['sort'] = 's.add_time';
        }

        $sort_data = array(
            's.add_time',
            's.update_time',
        );
        if (isset($filter_data['sort']) && in_array($filter_data['sort'], $sort_data)) {
            $sql .= " ORDER BY " . $filter_data['sort'];
        } else {
            $sql .= " ORDER BY s.id";
        }

        if (isset($filter_data['order']) && ($filter_data['order'] == 'DESC')) {
            $sql .= " DESC";
        } else {
            $sql .= " ASC";
        }


        if (isset($filter_data['start']) || isset($filter_data['limit'])) {
            if ($filter_data['start'] < 0) {
                $filter_data['start'] = 0;
            }

            if ($filter_data['limit'] < 1) {
                $filter_data['limit'] = 20;
            }

            $sql .= " LIMIT " . (int)$filter_data['start'] . "," . (int)$filter_data['limit'];
        }

        if(!empty($count)){
            $query = $this->db->query($sql);
            return $query->row['count(*)'];
        }else {
            $query = $this->db->query($sql);
            return $query->rows;
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
            100 => 'ALL',
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

        $this->load->language('sale/support');

        $this->document->addScript('view/javascript/jquery/magnific/jquery.magnific-popup.min.js');
        $this->document->addStyle('view/javascript/jquery/magnific/magnific-popup.css');

        $this->document->setTitle($ticket_id);


        $data['breadcrumbs'] = array();

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/home','token=' . $this->session->data['token'],'SSL')
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_support'),
            'href' => $this->url->link('sale/support', 'token=' . $this->session->data['token'], 'SSL')
        );
        $data['breadcrumbs'][] = array(
            'text' => $ticket_id,
            'href' => $this->url->link('sale/support/detail', 'token=' . $this->session->data['token'] . '&ticket_id='.$ticket_id, 'SSL')
        );

        if (isset($this->session->data['success'])) {
            $data['success'] = $this->session->data['success'];

            unset($this->session->data['success']);
        } else {
            $data['success'] = '';
        }

        $data['heading_title'] = $this->language->get('heading_title');
        $data['ticket_id'] = $ticket_id;
        $data['text_add_support'] = $this->language->get('text_add_support');
        $data['text_history'] = $this->language->get('text_history');
        $data['history'] = $this->url->link('account/support/history', '', 'SSL');
        $data['add_support'] = $this->url->link('account/support/add', '', 'SSL');
        $data['support'] = $this->url->link('account/support', '', 'SSL');




        $sql = "SELECT * FROM `".DB_PREFIX."support` WHERE ticket_id = '{$ticket_id}'";
        $support_main = $this->db->query($sql)->row;
        $customer_id = $support_main['customer_id'];
        $sql = "SELECT * FROM `".DB_PREFIX."support_img` WHERE ticket_id = '{$ticket_id}' ORDER BY time ASC,id ASC";
        $img_rows = $this->db->query($sql)->rows;
        $support_img = [];
        $upload_file = HTTP_CATALOG . 'image/support/';
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
        $sql = "SELECT * FROM `".DB_PREFIX."customer` WHERE customer_id = '{$customer_id}'";
        $customer = $this->db->query($sql)->row;
        $data['name'] = $customer['lastname'] . ' ' . $customer['firstname'];
        $data['store_name'] = $this->config->get('config_name');

        $data['support_main'] = $support_main;
        $data['support_img'] = $support_img;
        $data['status'] = $this->status();
        $data['priority'] = $this->priority();
        $data['ticket_id'] = $ticket_id;
        $data['token'] =  $this->session->data['token'];



        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');


        $this->response->setOutput($this->load->view('sale/support_detail.tpl', $data));

    }
    public function deleteSupport() {
        $json = [
            'state' => 1,
            'message' => 'Success'
        ];
        try {
            $id_arr = $this->request->post['id_arr'];
            $json['request'] = $id_arr;


            foreach($id_arr as $id) {
                $sql = "delete from " . DB_PREFIX . "support where id = {$id}";
                $this->db->query($sql);
            }

        }catch (Exception $e){
            $json['message'] = $e->getMessage();
        }

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
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
            $status = trim($this->request->post['status']);
            $notify = trim($this->request->post['notify']);
            $message = trim($this->request->post['message']);
            $time = (int)trim($this->request->post['time']) + 1;
            $client = 0;

            $ticket_id = $this->db->escape($this->request->post['ticket_id']);
            $date = date('Y-m-d H:i:s', time());
            $add_time = $date;
            $update_time = $date;

            $sql = "SELECT * FROM `".DB_PREFIX."support` WHERE ticket_id = '{$ticket_id}'";
            $support_main = $this->db->query($sql)->row;
            $customer_id = $support_main['customer_id'];

            $sql = "SELECT * FROM `".DB_PREFIX."customer` WHERE customer_id = '{$customer_id}'";
            $customer = $this->db->query($sql)->row;
            $support_main['email'] = $customer['email'];
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
                    $sql .= "('" . $ticket_id . "','" . $url . "','" . $message . "','" . $add_time . "','" . $time . "','" . $client . "'),";
                }
                $sql = rtrim($sql, ',');
                $insert_img_sql = "INSERT INTO `" . DB_PREFIX . "support_img`(`ticket_id`, `img_url`, `message`, `add_time`, `time`,`client`) VALUES " . $sql;
            }else{
                $sql .= "('" . $ticket_id . "','','" . $message . "','" . $add_time . "','" . $time . "','" . $client . "'),";
                $sql = rtrim($sql, ',');
                $insert_img_sql = "INSERT INTO `" . DB_PREFIX . "support_img`(`ticket_id`, `img_url`, `message`, `add_time`,`time`,`client`) VALUES " . $sql;
            }

            $this->db->query($insert_img_sql);

            if($notify){

                $this->sendEmail($support_main);
            }

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
            $subject = '[Ticket ID:' . $data['ticket_id'] . ' UPDATED'. ']' . $data['subject'];

            $email = $data['email'];

            $message = 'Thank you for using customer support ticket system!' . "\n\n";
            $message .= 'We have replied to your ticket!'. "\n\n";
            $message .= 'Ticket ID: ' . $data['ticket_id']. "\n\n";
            $message .= 'Ticket Subject: ' . $data['subject']. "\n\n" . "\n\n";
            $message .= 'Please note that this is an automated notification and replying to this email will receive no feedback from us. If you have any further questions, please post them in your ticket by
following the below steps.'. "\n\n";
            $message .= '1, Login your account using email and password you previously registered on our website.'. "\n\n";
            $message .= '2, Go to "View My History Support Ticket"'. "\n\n";
            $message .= '3, Click on the ticket which you want to post your further comments.'. "\n\n";

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
