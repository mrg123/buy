<?php

class ControllerModuleMcafeeSecure extends Controller
{

    private $error = array();

    public function index()
    {
        $this->language->load('module/mcafee_secure');

        $this->load->model('setting/setting');
        $this->load->model('design/layout');

        $this->document->setTitle($this->language->get('heading_title'));

        $data['endpoint'] = "https://www.mcafeesecure.com/";

        $config_url = $this->config->get('config_url');

        if ($config_url != null) {
            $data['host'] = $config_url;
        } else if (defined('HTTPS_CATALOG')) {
            $data['host'] = HTTPS_CATALOG;
        } else if (defined('HTTP_CATALOG')) {
            $data['host'] = HTTP_CATALOG;
        }

        $data['email'] = $this->config->get('config_email');
        $data['affiliate'] = 236024;
        $data['partner'] = 'opencart';
        $data['source'] = 'opencart';

        $data['heading_title'] = $this->language->get('heading_title');
        $data['section_title'] = $this->language->get('section_title');

        $data['entry_email'] = $this->language->get('entry_email');
        $data['entry_url'] = $this->language->get('entry_url');

        $data['button_save'] = $this->language->get('button_save');
        $data['button_cancel'] = $this->language->get('button_cancel');
        $data['button_module_add'] = $this->language->get('button_module_add');
        $data['button_remove'] = $this->language->get('button_remove');

        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }

        $data['breadcrumbs'] = array();

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL'),
            'separator' => false
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_module'),
            'href' => $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'),
            'separator' => ' :: '
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('module/mcafee_secure', 'token=' . $this->session->data['token'], 'SSL'),
            'separator' => ' :: '
        );

        if (isset($this->request->post['mcafee_secure'])) {
            $data['mcafee_secure'] = $this->request->post['mcafee_secure'];
        } else {
            $data['mcafee_secure'] = $this->config->get('mcafee_secure');
        }

        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('module/mcafee_secure.tpl', $data));
    }

    public function install()
    {
        $this->load->model('setting/setting');
        $this->model_setting_setting->editSetting('mcafee_secure', array("mcafee_secure_status" => 1));

        $mcafee_secure_module_query = $this->db->query("SELECT extension_id FROM " . DB_PREFIX . "extension WHERE type = 'module' AND code= 'mcafee_secure'");

        if ($mcafee_secure_module_query->num_rows) {
            $module_row = $mcafee_secure_module_query->row;

            $extension_id = $module_row['extension_id'];

            $this->log->write("Extension ID: " . $extension_id);

            $all_layouts_query = $this->db->query("SELECT layout_id FROM " . DB_PREFIX . "layout");

            foreach ($all_layouts_query->rows as $row) {
                $layout_id = $row['layout_id'];

                $this->log->write($layout_id);

                $exists_query = $this->db->query("SELECT layout_module_id FROM " . DB_PREFIX . "layout_module WHERE layout_id = '" . (int)$layout_id . "' AND code = 'mcafee_secure'");

                if ($exists_query->num_rows == 0) {
                    $this->db->query("INSERT INTO " . DB_PREFIX . "layout_module SET layout_id = '" . (int)$layout_id . "', code = 'mcafee_secure', position = 'content_bottom', sort_order = 0");
                }
            }
        }
    }

    public function uninstall()
    {
        $this->load->model('setting/setting');
        $this->model_setting_setting->editSetting('mcafee_secure', array("mcafee_secure_status" => 0));
    }
}