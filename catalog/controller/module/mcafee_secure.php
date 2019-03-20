<?php
class ControllerModuleMcafeeSecure extends Controller {
    public function index() {
        $this->load->language('module/mcafee_secure');

        $data['heading_title'] = $this->language->get('heading_title');

        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/mcafee_secure.tpl')) {
            return $this->load->view($this->config->get('config_template') . '/template/module/mcafee_secure.tpl', $data);
        }

        return $this->load->view('default/template/module/mcafee_secure.tpl', $data);
    }
}