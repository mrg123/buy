<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right"><a href="<?php echo $invoice; ?>" target="_blank" data-toggle="tooltip" title="<?php echo $button_invoice_print; ?>" class="btn btn-info"><i class="fa fa-print"></i></a> <a href="<?php echo $shipping; ?>" target="_blank" data-toggle="tooltip" title="<?php echo $button_shipping_print; ?>" class="btn btn-info"><i class="fa fa-truck"></i></a> <a href="<?php echo $edit; ?>" data-toggle="tooltip" title="<?php echo $button_edit; ?>" class="btn btn-primary"><i class="fa fa-pencil"></i></a> <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a></div>
      <h1><?php echo $heading_title; ?></h1>
      <ul class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
        <?php } ?>
      </ul>
    </div>
  </div>
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="panel panel-default">
          <div class="panel-heading">
            <h3 class="panel-title"><i class="fa fa-shopping-cart"></i> <?php echo $text_order_detail; ?></h3>
          </div>
          <table class="table">
            <tbody>
            <tr>
              <td style="width: 1%;"><button data-toggle="tooltip" title="<?php echo $text_customer; ?>" class="btn btn-info btn-xs"><i class="fa fa-user fa-fw"></i></button></td>
              <td><?php if ($customer) { ?>
                <a href="<?php echo $customer; ?>" target="_blank"><?php echo $firstname; ?> <?php echo $lastname; ?></a>
                <?php } else { ?>
                <?php echo $firstname; ?> <?php echo $lastname; ?>
                <?php } ?>
                
                &nbsp;&nbsp;
                <?php if($coc) { ?>
                  <a href="<?php echo $coc_href; ?>" target="_blank">
                   <i class="fa fa-shopping-cart"></i> 
                   </a>
                   * <?php echo $coc; ?> &nbsp;
                  <?php } ?>  
                  
                  <?php if($img_count) { ?>
                  <a id="img_<?php echo $order_id; ?>" class="order_img_preview" href="<?php echo $preview_url; ?>&order_id=<?php echo $order_id; ?>" target="_blank" >
                  <i class="fa fa-image"></i> * <?php echo $img_count; ?> &nbsp;
                  </a>
                  <?php }else{ ?>
                  
                  <?php } ?>

                   <?php if($ban==1) { ?>
 <img src="view/image/shantou.png" style="vertical-align: initial;"> &nbsp;&nbsp;
                  <?php } ?>

                  <?php if($resolved_count==2) { ?>
 <i class="fa fa-check" style="color:green;font-size:20px"></i> &nbsp;&nbsp;                  
                  <?php }else if($resolved_count==1){ ?>
<i class="fa fa-exclamation-circle" style="color:#f24545;font-size:20px"></i> &nbsp;&nbsp;
                  <?php } ?>  
                
                </td>

                <td style="width: 1%;"><button data-toggle="tooltip" title="<?php echo $text_store; ?>" class="btn btn-info btn-xs"><i class="fa fa-shopping-cart fa-fw"></i></button></td>
                <td><a href="<?php echo $store_url; ?>" target="_blank"><?php echo $store_name; ?></a></td>
            </tr>
             <tr>
                <td><button data-toggle="tooltip" title="<?php echo $text_date_added; ?>" class="btn btn-info btn-xs"><i class="fa fa-calendar fa-fw"></i></button></td>
                <td><?php echo $date_added; ?></td>

                 <td><button data-toggle="tooltip" title="<?php echo $text_customer_group; ?>" class="btn btn-info btn-xs"><i class="fa fa-group fa-fw"></i></button></td>
              <td><?php echo $customer_group; ?></td>

              </tr>
              
              <tr>
                <td>
                <?php if ($shipping_method) { ?>
                <button data-toggle="tooltip" title="<?php echo $text_shipping_method; ?>" class="btn btn-info btn-xs"><i class="fa fa-truck fa-fw"></i></button></td>
                <td><?php echo $shipping_method; ?>
                <?php } ?>
                </td>

                 <td><button data-toggle="tooltip" title="<?php echo $text_payment_method; ?>" class="btn btn-info btn-xs"><i class="fa fa-credit-card fa-fw"></i></button></td>
                <td><?php echo $payment_method; ?></td>
              </tr>
              

              <tr>
              <td><button data-toggle="tooltip" title="<?php echo $text_email; ?>" class="btn btn-info btn-xs"><i class="fa fa-envelope-o fa-fw"></i></button></td>
              <td><a href="mailto:<?php echo $email; ?>"><?php echo $email; ?></a></td>

               <td><button data-toggle="tooltip" title="<?php echo $text_telephone; ?>" class="btn btn-info btn-xs"><i class="fa fa-phone fa-fw"></i></button></td>
              <td><?php echo $telephone; ?></td>
            </tr>

             
             
              <tr>
               
              </tr>
             
            </tbody>
          </table>
        </div>
      </div>
     
      <div class="col-md-4" style="display:none;">
        <div class="panel panel-default">
          <div class="panel-heading">
            <h3 class="panel-title"><i class="fa fa-cog"></i> <?php echo $text_option; ?></h3>
          </div>
          <table class="table">
            <tbody>
              <tr>
                <td><?php echo $text_invoice; ?></td>
                <td id="invoice" class="text-right"><?php echo $invoice_no; ?></td>
                <td style="width: 1%;" class="text-center"><?php if (!$invoice_no) { ?>
                  <button id="button-invoice" data-loading-text="<?php echo $text_loading; ?>" data-toggle="tooltip" title="<?php echo $button_generate; ?>" class="btn btn-success btn-xs"><i class="fa fa-cog"></i></button>
                  <?php } else { ?>
                  <button disabled="disabled" class="btn btn-success btn-xs"><i class="fa fa-refresh"></i></button>
                  <?php } ?></td>
              </tr>
              <tr>
                <td><?php echo $text_reward; ?></td>
                <td class="text-right"><?php echo $reward; ?></td>
                <td class="text-center"><?php if ($customer && $reward) { ?>
                  <?php if (!$reward_total) { ?>
                  <button id="button-reward-add" data-loading-text="<?php echo $text_loading; ?>" data-toggle="tooltip" title="<?php echo $button_reward_add; ?>" class="btn btn-success btn-xs"><i class="fa fa-plus-circle"></i></button>
                  <?php } else { ?>
                  <button id="button-reward-remove" data-loading-text="<?php echo $text_loading; ?>" data-toggle="tooltip" title="<?php echo $button_reward_remove; ?>" class="btn btn-danger btn-xs"><i class="fa fa-minus-circle"></i></button>
                  <?php } ?>
                  <?php } else { ?>
                  <button disabled="disabled" class="btn btn-success btn-xs"><i class="fa fa-plus-circle"></i></button>
                  <?php } ?></td>
              </tr>
              <tr>
                <td><?php echo $text_affiliate; ?>
                  <?php if ($affiliate) { ?>
                  (<a href="<?php echo $affiliate; ?>"><?php echo $affiliate_firstname; ?> <?php echo $affiliate_lastname; ?></a>)
                  <?php } ?></td>
                <td class="text-right"><?php echo $commission; ?></td>
                <td class="text-center"><?php if ($affiliate) { ?>
                  <?php if (!$commission_total) { ?>
                  <button id="button-commission-add" data-loading-text="<?php echo $text_loading; ?>" data-toggle="tooltip" title="<?php echo $button_commission_add; ?>" class="btn btn-success btn-xs"><i class="fa fa-plus-circle"></i></button>
                  <?php } else { ?>
                  <button id="button-commission-remove" data-loading-text="<?php echo $text_loading; ?>" data-toggle="tooltip" title="<?php echo $button_commission_remove; ?>" class="btn btn-danger btn-xs"><i class="fa fa-minus-circle"></i></button>
                  <?php } ?>
                  <?php } else { ?>
                  <button disabled="disabled" class="btn btn-success btn-xs"><i class="fa fa-plus-circle"></i></button>
                  <?php } ?></td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>

      
       <?php if ($comment) { ?>
       <div class="col-md-12">
        <table class="table table-bordered">
          <thead>
            <tr>
              <td><?php echo $text_comment; ?></td>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td><?php echo $comment; ?></td>
            </tr>
          </tbody>
        </table>
        </div>
        <?php } ?>
    </div>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-info-circle"></i> <?php echo $text_order; ?></h3>
      </div>
      <div class="panel-body">
        <table class="table table-bordered">
          <thead>
            <tr>
            <?php if ($shipping_method) { ?>
              <td style="width: 50%;" class="text-left"><?php echo $text_shipping_address; ?>
                <?php } ?></td>

              <td style="width: 50%;" class="text-left"><?php echo $text_payment_address; ?></td>
              
            </tr>
          </thead>
          <tbody>
            <tr>
              <td class="text-left"><?php echo $payment_address; ?></td>
              <?php if ($shipping_method) { ?>
              <td class="text-left"><?php echo $shipping_address; ?></td>
              <?php } ?>
            </tr>
          </tbody>
        </table>
        <table class="table table-bordered">
          <thead>
            <tr>
              <td class="text-left"><?php echo $column_product; ?></td>
              <td class="text-left"><?php echo $column_model; ?></td>
              <td class="text-right"><?php echo $column_quantity; ?></td>
              <td class="text-right"><?php echo $column_price; ?></td>
              <td class="text-right"><?php echo $column_total; ?></td>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($products as $product) { ?>
            <tr>
              <td class="text-left"><a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a>
                <?php foreach ($product['option'] as $option) { ?>
                <br />
                <?php if ($option['type'] != 'file') { ?>
                &nbsp;<small> - <?php echo $option['name']; ?>: <?php echo $option['value']; ?></small>
                <?php } else { ?>
                &nbsp;<small> - <?php echo $option['name']; ?>: <a href="<?php echo $option['href']; ?>"><?php echo $option['value']; ?></a></small>
                <?php } ?>
                <?php } ?></td>
              <td class="text-left"><?php echo $product['model']; ?></td>
              <td class="text-right"><?php echo $product['quantity']; ?></td>
              <td class="text-right"><?php echo $product['price']; ?></td>
              <td class="text-right"><?php echo $product['total']; ?></td>
            </tr>
            <?php } ?>
            <?php foreach ($vouchers as $voucher) { ?>
            <tr>
              <td class="text-left"><a href="<?php echo $voucher['href']; ?>"><?php echo $voucher['description']; ?></a></td>
              <td class="text-left"></td>
              <td class="text-right">1</td>
              <td class="text-right"><?php echo $voucher['amount']; ?></td>
              <td class="text-right"><?php echo $voucher['amount']; ?></td>
            </tr>
            <?php } ?>
            <?php foreach ($totals as $total) { ?>
            <tr>
              <td colspan="4" class="text-right"><?php echo $total['title']; ?></td>
              <td class="text-right"><?php echo $total['text']; ?></td>
            </tr>
            <?php } ?>
          </tbody>
        </table>
       
      </div>
    </div>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-comment-o"></i> <?php echo $text_history; ?></h3>
      </div>
      <div class="panel-body">
        <ul class="nav nav-tabs">
          <li class="active"><a href="#tab-history" data-toggle="tab"><?php echo $tab_history; ?></a></li>
          <li><a href="#tab-additional" data-toggle="tab"><?php echo $tab_additional; ?></a></li>
          <?php foreach ($tabs as $tab) { ?>
          <li><a href="#tab-<?php echo $tab['code']; ?>" data-toggle="tab"><?php echo $tab['title']; ?></a></li>
          <?php } ?>
        </ul>
        <div class="tab-content">
          <div class="tab-pane active" id="tab-history">
            <div id="history"></div>
            <br />
            <fieldset>
              <legend><?php echo $text_history_add; ?></legend>
              <form class="form-horizontal">
                <div class="form-group">
                  <label class="col-sm-2 control-label" for="input-order-status"><?php echo $entry_order_status; ?></label>
                  <div class="col-sm-10">
                    <select name="order_status_id" id="input-order-status" class="form-control">
                      <?php foreach ($order_statuses as $order_statuses) { ?>
                      <?php if ($order_statuses['order_status_id'] == $order_status_id) { ?>
                      <option value="<?php echo $order_statuses['order_status_id']; ?>" selected="selected"><?php echo $order_statuses['name']; ?></option>
                      <?php } else { ?>
                      <option value="<?php echo $order_statuses['order_status_id']; ?>"><?php echo $order_statuses['name']; ?></option>
                      <?php } ?>
                      <?php } ?>
                    </select>
                  </div>
                </div>
                <div class="form-group" style="display:none">
                  <label class="col-sm-2 control-label" for="input-override"><span data-toggle="tooltip" title="<?php echo $help_override; ?>" style="display:none"><?php echo $entry_override; ?></span></label>
                  <div class="col-sm-10">
                   

                     <div class="pull-left">
                      <input type="checkbox" name="override" value="1" id="input-override" style="margin-right:20px;display:none"/>
                     
                   
                     </div>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-2 control-label" for="input-notify"><?php echo $entry_notify; ?></label>
                  <div class="col-sm-10">
                    

                     <div class="pull-left">
                     <input type="checkbox" name="notify" value="1" id="input-notify" style="margin-right:30px" checked/>
                    <a id="button-history" data-loading-text="<?php echo $text_loading; ?>" class="btn btn-primary"><i class="fa fa-plus-circle"></i> <?php echo $button_history_add; ?></a>

  <a href="<?php echo $invoice; ?>" target="_blank" data-toggle="tooltip" title="<?php echo $button_invoice_print; ?>" class="btn btn-info"><i class="fa fa-print"></i></a> <a href="<?php echo $shipping; ?>" target="_blank" data-toggle="tooltip" title="<?php echo $button_shipping_print; ?>" class="btn btn-info"><i class="fa fa-truck"></i></a> <a href="<?php echo $edit; ?>" data-toggle="tooltip" title="<?php echo $button_edit; ?>" class="btn btn-primary"><i class="fa fa-pencil"></i></a> <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a>
                     </div>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-2 control-label" for="input-comment"><?php echo $entry_comment; ?></label>
                  <div class="col-sm-10">
                    <textarea name="comment" rows="8" id="input-comment" class="form-control"></textarea>
                  </div>
                </div>
              </form>
            </fieldset>
            <div class="form-group row">
              <div class="col-sm-2">&nbsp;</div>
              <div class="col-sm-10">
              </div>
            </div>

        <form class="form-horizontal">
        <br/>
        <div class="form-group" style="border-top: 1px solid #ededed;">
          <label class="col-sm-2 control-label" for="input-admin_comment">Admin Remarks</label>
          <div class="col-sm-10" id="comment_box">
            <?php if($remarks) {  foreach($remarks as $key=>$arr){?>
            <?php if($arr['resolved']==1) { ?>
            <div style="background-color:#ddd;">
            <?php }else{ ?>
<div>
            <?php } ?>
            <?php echo $arr['add_time'];?> &nbsp;&nbsp;
             <span>
             <?php if($arr['resolved']==1) { ?>
            <input type="checkbox" name="remark[<?php echo $arr['remark_id']; ?>]" remark_id="<?php echo $arr['remark_id']; ?>" checked />
            <?php }else{ ?>
            <input type="checkbox" name="remark[<?php echo $arr['remark_id']; ?>]" remark_id="<?php echo $arr['remark_id']; ?>"/>
            <?php } ?>
            </span>

            <?php echo html_entity_decode($arr['remark']); ?> 
            </div>
            <?php }} ?>
          </div>
        </div>
            <div class="form-group" style="border-top: 1px solid #ededed;" >
                  <label class="col-sm-2 control-label" for="input-admin_comment"> &nbsp; </label>
                  <div class="col-sm-10">
                    <textarea name="admin_comment" id="input-admin_comment" class="form-control"></textarea>
                  </div>
                  <div class="col-sm-2"> &nbsp; </div>
                 <div class="col-sm-10" >
                 <br/>
              <input type="button" id="admin_comment" data-loading-text="<?php echo $text_loading; ?>" class="btn btn-primary" value="Add Admin Remarks"> 
            </div>
            </div>
          </form>   
             
          </div>
          <div class="tab-pane" id="tab-additional">
            <?php if ($account_custom_fields) { ?>
            <table class="table table-bordered">
              <thead>
                <tr>
                  <td colspan="2"><?php echo $text_account_custom_field; ?></td>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($account_custom_fields as $custom_field) { ?>
                <tr>
                  <td><?php echo $custom_field['name']; ?></td>
                  <td><?php echo $custom_field['value']; ?></td>
                </tr>
                <?php } ?>
              </tbody>
            </table>
            <?php } ?>
            <?php if ($payment_custom_fields) { ?>
            <table class="table table-bordered">
              <thead>
                <tr>
                  <td colspan="2"><?php echo $text_payment_custom_field; ?></td>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($payment_custom_fields as $custom_field) { ?>
                <tr>
                  <td><?php echo $custom_field['name']; ?></td>
                  <td><?php echo $custom_field['value']; ?></td>
                </tr>
                <?php } ?>
              </tbody>
            </table>
            <?php } ?>
            <?php if ($shipping_method && $shipping_custom_fields) { ?>
            <table class="table table-bordered">
              <thead>
                <tr>
                  <td colspan="2"><?php echo $text_shipping_custom_field; ?></td>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($shipping_custom_fields as $custom_field) { ?>
                <tr>
                  <td><?php echo $custom_field['name']; ?></td>
                  <td><?php echo $custom_field['value']; ?></td>
                </tr>
                <?php } ?>
              </tbody>
            </table>
            <?php } ?>
            <table class="table table-bordered">
              <thead>
                <tr>
                  <td colspan="2"><?php echo $text_browser; ?></td>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td><?php echo $text_ip; ?></td>
                  <td><?php echo $ip; ?></td>
                </tr>
                <?php if ($forwarded_ip) { ?>
                <tr>
                  <td><?php echo $text_forwarded_ip; ?></td>
                  <td><?php echo $forwarded_ip; ?></td>
                </tr>
                <?php } ?>
                <tr>
                  <td><?php echo $text_user_agent; ?></td>
                  <td><?php echo $user_agent; ?></td>
                </tr>
                <tr>
                  <td><?php echo $text_accept_language; ?></td>
                  <td><?php echo $accept_language; ?></td>
                </tr>
              </tbody>
            </table>
          </div>
          <?php foreach ($tabs as $tab) { ?>
          <div class="tab-pane" id="tab-<?php echo $tab['code']; ?>"><?php echo $tab['content']; ?></div>
          <?php } ?>
        </div>
      </div>
    </div>
  </div>
  <script type="text/javascript"><!--
$(document).delegate('#button-invoice', 'click', function() {
	$.ajax({
		url: 'index.php?route=sale/order/createinvoiceno&token=<?php echo $token; ?>&order_id=<?php echo $order_id; ?>',
		dataType: 'json',
		beforeSend: function() {
			$('#button-invoice').button('loading');
		},
		complete: function() {
			$('#button-invoice').button('reset');
		},
		success: function(json) {
			$('.alert').remove();

			if (json['error']) {
				$('#content > .container-fluid').prepend('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error'] + '</div>');
			}

			if (json['invoice_no']) {
				$('#invoice').html(json['invoice_no']);

				$('#button-invoice').replaceWith('<button disabled="disabled" class="btn btn-success btn-xs"><i class="fa fa-cog"></i></button>');
			}
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});
});

$(document).delegate('#button-reward-add', 'click', function() {
	$.ajax({
		url: 'index.php?route=sale/order/addreward&token=<?php echo $token; ?>&order_id=<?php echo $order_id; ?>',
		type: 'post',
		dataType: 'json',
		beforeSend: function() {
			$('#button-reward-add').button('loading');
		},
		complete: function() {
			$('#button-reward-add').button('reset');
		},
		success: function(json) {
			$('.alert').remove();

			if (json['error']) {
				$('#content > .container-fluid').prepend('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error'] + '</div>');
			}

			if (json['success']) {
                $('#content > .container-fluid').prepend('<div class="alert alert-success"><i class="fa fa-check-circle"></i> ' + json['success'] + '</div>');

				$('#button-reward-add').replaceWith('<button id="button-reward-remove" data-toggle="tooltip" title="<?php echo $button_reward_remove; ?>" class="btn btn-danger btn-xs"><i class="fa fa-minus-circle"></i></button>');
			}
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});
});

$(document).delegate('#button-reward-remove', 'click', function() {
	$.ajax({
		url: 'index.php?route=sale/order/removereward&token=<?php echo $token; ?>&order_id=<?php echo $order_id; ?>',
		type: 'post',
		dataType: 'json',
		beforeSend: function() {
			$('#button-reward-remove').button('loading');
		},
		complete: function() {
			$('#button-reward-remove').button('reset');
		},
		success: function(json) {
			$('.alert').remove();

			if (json['error']) {
				$('#content > .container-fluid').prepend('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error'] + '</div>');
			}

			if (json['success']) {
                $('#content > .container-fluid').prepend('<div class="alert alert-success"><i class="fa fa-check-circle"></i> ' + json['success'] + '</div>');

				$('#button-reward-remove').replaceWith('<button id="button-reward-add" data-toggle="tooltip" title="<?php echo $button_reward_add; ?>" class="btn btn-success btn-xs"><i class="fa fa-plus-circle"></i></button>');
			}
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});
});

$(document).delegate('#button-commission-add', 'click', function() {
	$.ajax({
		url: 'index.php?route=sale/order/addcommission&token=<?php echo $token; ?>&order_id=<?php echo $order_id; ?>',
		type: 'post',
		dataType: 'json',
		beforeSend: function() {
			$('#button-commission-add').button('loading');
		},
		complete: function() {
			$('#button-commission-add').button('reset');
		},
		success: function(json) {
			$('.alert').remove();

			if (json['error']) {
				$('#content > .container-fluid').prepend('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error'] + '</div>');
			}

			if (json['success']) {
                $('#content > .container-fluid').prepend('<div class="alert alert-success"><i class="fa fa-check-circle"></i> ' + json['success'] + '</div>');

				$('#button-commission-add').replaceWith('<button id="button-commission-remove" data-toggle="tooltip" title="<?php echo $button_commission_remove; ?>" class="btn btn-danger btn-xs"><i class="fa fa-minus-circle"></i></button>');
			}
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});
});

$(document).delegate('#button-commission-remove', 'click', function() {
	$.ajax({
		url: 'index.php?route=sale/order/removecommission&token=<?php echo $token; ?>&order_id=<?php echo $order_id; ?>',
		type: 'post',
		dataType: 'json',
		beforeSend: function() {
			$('#button-commission-remove').button('loading');
		},
		complete: function() {
			$('#button-commission-remove').button('reset');
		},
		success: function(json) {
			$('.alert').remove();

			if (json['error']) {
				$('#content > .container-fluid').prepend('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error'] + '</div>');
			}

			if (json['success']) {
                $('#content > .container-fluid').prepend('<div class="alert alert-success"><i class="fa fa-check-circle"></i> ' + json['success'] + '</div>');

				$('#button-commission-remove').replaceWith('<button id="button-commission-add" data-toggle="tooltip" title="<?php echo $button_commission_add; ?>" class="btn btn-success btn-xs"><i class="fa fa-plus-circle"></i></button>');
			}
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});
});

var token = '';

// Login to the API
$.ajax({
	url: '<?php echo $store_url; ?>index.php?route=api/login',
	type: 'post',
	dataType: 'json',
	data: 'key=<?php echo $api_key; ?>',
	crossDomain: true,
	success: function(json) {
		$('.alert').remove();

        if (json['error']) {
    		if (json['error']['key']) {
    			$('#content > .container-fluid').prepend('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error']['key'] + ' <button type="button" class="close" data-dismiss="alert">&times;</button></div>');
    		}

            if (json['error']['ip']) {
    			$('#content > .container-fluid').prepend('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error']['ip'] + ' <button type="button" id="button-ip-add" data-loading-text="<?php echo $text_loading; ?>" class="btn btn-danger btn-xs pull-right"><i class="fa fa-plus"></i> <?php echo $button_ip_add; ?></button></div>');
    		}
        }

        if (json['token']) {
			token = json['token'];
		}
	},
	error: function(xhr, ajaxOptions, thrownError) {
		alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
	}
});

$(document).delegate('#button-ip-add', 'click', function() {
	$.ajax({
		url: 'index.php?route=user/api/addip&token=<?php echo $token; ?>&api_id=<?php echo $api_id; ?>',
		type: 'post',
		data: 'ip=<?php echo $api_ip; ?>',
		dataType: 'json',
		beforeSend: function() {
			$('#button-ip-add').button('loading');
		},
		complete: function() {
			$('#button-ip-add').button('reset');
		},
		success: function(json) {
			$('.alert').remove();

			if (json['error']) {
				$('#content > .container-fluid').prepend('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error'] + ' <button type="button" class="close" data-dismiss="alert">&times;</button></div>');
			}

			if (json['success']) {
				$('#content > .container-fluid').prepend('<div class="alert alert-success"><i class="fa fa-check-circle"></i> ' + json['success'] + ' <button type="button" class="close" data-dismiss="alert">&times;</button></div>');
			}
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});
});

$('#history').delegate('.pagination a', 'click', function(e) {
	e.preventDefault();

	$('#history').load(this.href);
});

$('#history').load('index.php?route=sale/order/history&token=<?php echo $token; ?>&order_id=<?php echo $order_id; ?>');

$('#button-history').on('click', function() {
	if (typeof verifyStatusChange == 'function'){
		if (verifyStatusChange() == false){
			return false;
		} else{
			addOrderInfo();
		}
	} else{
		addOrderInfo();
	}

	$.ajax({
		url: '<?php echo $store_url; ?>index.php?route=api/order/history&token=' + token + '&order_id=<?php echo $order_id; ?>',
		type: 'post',
		dataType: 'json',
		data: 'order_status_id=' + encodeURIComponent($('select[name=\'order_status_id\']').val()) + '&notify=' + ($('input[name=\'notify\']').prop('checked') ? 1 : 0) + '&override=' + ($('input[name=\'override\']').prop('checked') ? 1 : 0) + '&append=' + ($('input[name=\'append\']').prop('checked') ? 1 : 0) + '&comment=' + encodeURIComponent($('textarea[name=\'comment\']').val()),
		beforeSend: function() {
			$('#button-history').button('loading');
		},
		complete: function() {
			$('#button-history').button('reset');
		},
		success: function(json) {
			$('.alert').remove();

			if (json['error']) {
				$('#history').before('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error'] + ' <button type="button" class="close" data-dismiss="alert">&times;</button></div>');
			}

			if (json['success']) {
				$('#history').load('index.php?route=sale/order/history&token=<?php echo $token; ?>&order_id=<?php echo $order_id; ?>');

				$('#history').before('<div class="alert alert-success"><i class="fa fa-check-circle"></i> ' + json['success'] + ' <button type="button" class="close" data-dismiss="alert">&times;</button></div>');

				$('textarea[name=\'comment\']').val('');
			}
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});
});

$('#admin_comment').on('click',function(){

var admin_comment = $.trim($('textarea[name=\'admin_comment\']').code());
if($.trim(admin_comment) == ''){
  alert("Remark can't null!");
}else{

$.ajax({
		url: 'index.php?route=sale/order/remark&token=<?php echo $token; ?>&order_id=<?php echo $order_id; ?>',
		type: 'post',
		dataType: 'json',
		data: 'remark=' + encodeURIComponent($('textarea[name=\'admin_comment\']').code()),
		beforeSend: function() {
			$('#button-admin_comment').button('loading');
		},
		complete: function() {
			$('#button-admin_comment').button('reset');
		},
		success: function(json) {

			if (json['state']==1) {
        
$('textarea[name=\'admin_comment\']').code('');
        var _html = '<div><span>'+json['add_time']+' &nbsp;&nbsp; <input type="checkbox" name="remark['+json['remark_id']+']" remark_id="'+json['remark_id']+'"/></span>';

        $('#comment_box').append(_html + unescape(json['remark']) + '</div>');

			}else{
        alert('Try Again!');
      }

			
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});
  
}

});

function unescape(str) {
    var elem = document.createElement('div')
    elem.innerHTML = str
    return elem.innerText || elem.textContent
}

$('body').on('click','#comment_box input',function(){
  var check = $(this).is(':checked');
  var remark_id = $(this).attr('remark_id');
  var resolved = 0;
  var that = $(this);
  if(check== true){
    resolved = 1;
  }

  $.ajax({
		url: 'index.php?route=sale/order/remarkResolved&token=<?php echo $token; ?>&order_id=<?php echo $order_id; ?>',
		type: 'post',
		dataType: 'json',
		data: 'resolved=' + resolved + '&remark_id=' + remark_id,
		success: function(json) {

			if (json['state']==1) {
        if(resolved){
      that.parent().parent().css({
        'background-color':'#ddd'
      });  
        }else{
          that.parent().parent().css({
        'background-color':'#fff'
      }); 
        }
			}else{
        alert('Try Again!');
      }

			
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});

});


function changeStatus(){
	var status_id = $('select[name="order_status_id"]').val();

	$('#openbay-info').remove();

	$.ajax({
		url: 'index.php?route=extension/openbay/getorderinfo&token=<?php echo $token; ?>&order_id=<?php echo $order_id; ?>&status_id=' + status_id,
		dataType: 'html',
		success: function(html) {
			$('#history').after(html);
		}
	});
}

function addOrderInfo(){
	var status_id = $('select[name="order_status_id"]').val();

	$.ajax({
		url: 'index.php?route=extension/openbay/addorderinfo&token=<?php echo $token; ?>&order_id=<?php echo $order_id; ?>&status_id=' + status_id,
		type: 'post',
		dataType: 'html',
		data: $(".openbay-data").serialize()
	});
}

$(document).ready(function() {
	changeStatus();
});

$('select[name="order_status_id"]').change(function(){
	changeStatus();
});


$('#input-admin_comment').summernote({height: 300});

//--></script>
</div>
<?php echo $footer; ?>
