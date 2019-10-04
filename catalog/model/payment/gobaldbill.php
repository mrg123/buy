<?php 
class ModelPaymentGobaldbill extends Model {
  	public function getMethod($address) {
		$this->load->language('payment/gobaldbill');
		
		if ($this->config->get('gobaldbill_status')) {
        	$status = TRUE;
      	} else {
			$status = FALSE;
		}
		
		$method_data = array();
	
		if ($status) {		
			$img = HTTP_SERVER.'catalog/view/theme/default/template/image/gobaldbill.gif';
      		$method_data = array( 
        		'code'       => 'gobaldbill',
        		'title'      =>  '<img src="'.$img.'"/>'.$this->language->get('text_title'),
				'terms'      => '',
				'sort_order' => $this->config->get('gobaldbill_sort_order')
      		);
    	}
   
    	return $method_data;
  	}
}
?>