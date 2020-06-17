<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" id="button-shipping" form="form-order" formaction="<?php echo $shipping; ?>" data-toggle="tooltip" title="<?php echo $button_shipping_print; ?>" class="btn btn-info"><i class="fa fa-truck"></i></button>
        <button type="submit" id="button-invoice" form="form-order" formaction="<?php echo $invoice; ?>" data-toggle="tooltip" title="<?php echo $button_invoice_print; ?>" class="btn btn-info"><i class="fa fa-print"></i></button>
        <a href="<?php echo $add; ?>" data-toggle="tooltip" title="<?php echo $button_add; ?>" class="btn btn-primary"><i class="fa fa-plus"></i></a></div>
      <h1><?php echo $heading_title; ?></h1>
      <ul class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
        <?php } ?>
      </ul>
    </div>
  </div>
  <div class="container-fluid">
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-list"></i> <?php echo $text_list; ?></h3>
      </div>
      <div class="panel-body">
        <div class="well">
          <div class="row">
            <div class="col-sm-4">
              <div class="form-group">
                <label class="control-label" for="input-order-id"><?php echo $entry_order_id; ?></label>
                <input type="text" name="filter_order_id" value="<?php echo $filter_order_id; ?>" placeholder="<?php echo $entry_order_id; ?>" id="input-order-id" class="form-control" />
              </div>
              <div class="form-group">
                <label class="control-label" for="input-customer"><?php echo $entry_customer; ?></label>
                <input type="text" name="filter_customer" value="<?php echo $filter_customer; ?>" placeholder="<?php echo $entry_customer; ?>" id="input-customer" class="form-control" />
              </div>
              <div class="form-group">
                <label class="control-label" for="input-customer_email"><?php echo $entry_customer_email; ?></label>
                <input type="text" name="filter_customer_email" value="<?php echo $filter_customer_email; ?>" placeholder="<?php echo $entry_customer_email; ?>" id="input-customer_email" class="form-control" />
              </div>

                <div class="form-group">
                    <label class="control-label" for="filter_chose_status">
                        Multiple Criteria Search
                    </label>
                    <select name="filter_chose_status" id="filter_chose_status" class="form-control" multiple >
                        <option value="*"></option>
                        <?php foreach ($order_statuses as $order_status) { ?>
                        <?php if (in_array($order_status['order_status_id'],$filter_chose_status)) { ?>
                        <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                        <?php } else { ?>
                        <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                        <?php } ?>
                        <?php } ?>
                    </select>
                </div>


                <div class="form-group">
                    <button type="button" id="button-filter" class="btn btn-primary pull-left"><i class="fa fa-search"></i>  Search  </button>
                    <span class="pull-left" style="display: inline-block;line-height: 35px;margin-left: 5px;"><?php echo $results; ?></span>

                    <div class="pull-left" style="clear:left;display: block;line-height: 35px;margin-top: 15px;"><?php echo $pagination; ?></div>
                </div>


            </div>
            <div class="col-sm-4">
              <div class="form-group">
                <label class="control-label" for="input-order-status"><?php echo $entry_order_status; ?></label>
                <select name="filter_order_status" id="input-order-status" class="form-control">
                  <option value="*"></option>
                  <?php if ($filter_order_status == '0') { ?>
                  <option value="0" selected="selected"><?php echo $text_missing; ?></option>
                  <?php } else { ?>
                  <option value="0"><?php echo $text_missing; ?></option>
                  <?php } ?>
                  <?php foreach ($order_statuses as $order_status) { ?>
                  <?php if ($order_status['order_status_id'] == $filter_order_status) { ?>
                  <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                  <?php } else { ?>
                  <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                  <?php } ?>
                  <?php } ?>
                </select>
              </div>
              <div class="form-group">
                <label class="control-label" for="input-total"><?php echo $entry_total; ?></label>
                <input type="text" name="filter_total" value="<?php echo $filter_total; ?>" placeholder="<?php echo $entry_total; ?>" id="input-total" class="form-control" />
              </div>
              <div class="form-group">
                <label class="control-label" for="input-model"><?php echo $entry_model; ?></label>
                <input type="text" name="filter_model" value="<?php echo $filter_model; ?>" placeholder="<?php echo $entry_model; ?>" id="input-model" class="form-control" />
              </div>


            </div>
            <div class="col-sm-4">
              <div class="form-group">
                <label class="control-label" for="input-date-added"><?php echo $entry_date_added; ?></label>
                <div class="input-group date">
                  <input type="text" name="filter_date_added" value="<?php echo $filter_date_added; ?>" placeholder="<?php echo $entry_date_added; ?>" data-date-format="YYYY-MM-DD" id="input-date-added" class="form-control" />
                  <span class="input-group-btn">
                  <button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
                  </span></div>
              </div>
              <div class="form-group">
                <label class="control-label" for="input-date-modified"><?php echo $entry_date_modified; ?></label>
                <div class="input-group date">
                  <input type="text" name="filter_date_modified" value="<?php echo $filter_date_modified; ?>" placeholder="<?php echo $entry_date_modified; ?>" data-date-format="YYYY-MM-DD" id="input-date-modified" class="form-control" />
                  <span class="input-group-btn">
                  <button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
                  </span></div>
              </div>
              <div class="form-group">
                <label class="control-label" for="input-shipping_method"><?php echo $entry_shipping_method; ?></label>

                <input type="text" name="filter_shipping_method" value="<?php echo $filter_shipping_method; ?>"  id="input-shipping_method" class="form-control" />
              </div>
              <div class="form-group">
                <label class="control-label" for="filter_remark"> Admin Remarks </label>
                <select name="filter_remark" class="form-control" id="filter_remark">
                <option value="">All</option>
                  <?php foreach($remarks as $key => $arr) { ?>
                    <?php if($arr['val'] == $filter_remark) { ?>
                    <option value="<?php echo $arr['val']; ?>" selected><?php echo $arr['name']; ?></option>
                    <?php }else{ ?>
                    <option value="<?php echo $arr['val']; ?>"><?php echo $arr['name']; ?></option>
                    <?php } ?>
                  <?php } ?>
                </select>
              </div>
                <div class="form-group">
                    <button type="button" class="btn btn-primary" id="batchOrder">Order Status Bulk Update</button>
                </div>
              
            </div>
          </div>
        </div>
          <div class="table-responsive">
              <table class="table table-bordered table-hover">
        <form method="post" enctype="multipart/form-data" tar
              <thead>
                <tr>
                  <td style="width: 1px;" class="text-center"><input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" /></td>
                  <td class="text-right" width="350"><?php echo $column_action; ?></td>
                  <td class="text-left">
                  <?php if($sort=='country'){ ?>
                  <a href="<?php echo $sort_country; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_country; ?></a>
                  <?php } else{ ?>
                  <a href="<?php echo $sort_country; ?>"><?php echo $column_country; ?></a>
                  <?php } ?>
                  </td>
                  <td class="text-right"><?php if ($sort == 'o.order_id') { ?>
                    <a href="<?php echo $sort_order; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_order_id; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_order; ?>"><?php echo $column_order_id; ?></a>
                    <?php } ?></td>
                  <td class="text-left"><?php if ($sort == 'status') { ?>
                    <a href="<?php echo $sort_status; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_status; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_status; ?>"><?php echo $column_status; ?></a>
                    <?php } ?></td>
                    <td class="text-right"><?php if ($sort == 'o.total') { ?>
                    <a href="<?php echo $sort_total; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_total; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_total; ?>"><?php echo $column_total; ?></a>
                    <?php } ?></td>
                     <td class="text-left"><?php echo $entry_shipping_method; ?></td>
                      
                  <td class="text-left"><?php if ($sort == 'customer') { ?>
                    <a href="<?php echo $sort_customer; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_customer; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_customer; ?>"><?php echo $column_customer; ?></a>
                    <?php } ?></td>
                  <td class="text-left"><?php echo $entry_model; ?></td>
                  <td class="text-left"><?php echo $entry_customer_email; ?></td>
                  

                  <td class="text-left"><?php if ($sort == 'o.date_added') { ?>
                    <a href="<?php echo $sort_date_added; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_date_added; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_date_added; ?>"><?php echo $column_date_added; ?></a>
                    <?php } ?></td>
                  <td class="text-left"><?php if ($sort == 'o.date_modified') { ?>
                    <a href="<?php echo $sort_date_modified; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_date_modified; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_date_modified; ?>"><?php echo $column_date_modified; ?></a>
                    <?php } ?></td>

                </tr>
              </thead>
              <tbody>
                <?php if ($orders) { ?>
                <?php foreach ($orders as $order) { ?>
                <tr>
                  <td class="text-center"><?php if (in_array($order['order_id'], $selected)) { ?>
                    <input type="checkbox" name="selected[]" value="<?php echo $order['order_id']; ?>" checked="checked" />
                    <?php } else { ?>
                    <input type="checkbox" name="selected[]" value="<?php echo $order['order_id']; ?>" />
                    <?php } ?>
                    <input type="hidden" name="shipping_code[]" value="<?php echo $order['shipping_code']; ?>" /></td>
                    
                    <td class="text-right">

                    <?php if($order['ban']==1) { ?>
 <img src="view/image/shantou.png" style="vertical-align: initial;"> &nbsp;&nbsp;                  
                  <?php } ?>
                  

                  <?php if($order['resolved_count']==2) { ?>
 <i class="fa fa-check" style="color:green;font-size:20px"></i> &nbsp;&nbsp;                  
                  <?php }else if($order['resolved_count']==1){ ?>
<i class="fa fa-exclamation-circle" style="color:#f24545;font-size:20px"></i> &nbsp;&nbsp;
                  <?php } ?>  


                  <?php if($order['coc']) { ?>
                  <a href="<?php echo $order['coc_href']; ?>" target="_blank">
                   <i class="fa fa-shopping-cart"></i> 
                   </a>
                   * <?php echo $order['coc']; ?> &nbsp;
                  <?php } ?>  
                  
                  <?php if($order['img_count']) { ?>
                  <a id="img_<?php echo $order['order_id']; ?>" class="order_img_preview" href="<?php echo $order['num_url']; ?>&order_id=<?php echo $order['order_id']; ?>" target="_blank" >
                  <i class="fa fa-image"></i> * <?php echo $order['img_count']; ?> &nbsp;
                  </a>
                  <?php }else{ ?>
                  <a id="img_<?php echo $order['order_id']; ?>" class="order_img_preview" href="<?php echo $order['num_url']; ?>" target="_blank"></span>
                  <?php } ?>

                  <button type="button" value="<?php echo $order['order_id']; ?>" id="button-delete<?php echo $order['order_id']; ?>" data-loading-text="<?php echo $text_loading; ?>" data-toggle="tooltip" title="<?php echo $button_delete; ?>" class="btn btn-danger"><i class="fa fa-trash-o"></i></button>

                  <a href="<?php echo $order['edit']; ?>" data-toggle="tooltip" title="<?php echo $button_edit; ?>" class="btn btn-primary"><i class="fa fa-pencil"></i></a>

                  <a href="<?php echo $order['view']; ?>" data-toggle="tooltip" title="<?php echo $button_view; ?>" class="btn btn-info"><i class="fa fa-eye"></i></a> 

                  <a target="_blank" data-toggle="tooltip" title="upload image" class="btn btn-info layui-btn" data-method="setTop" order-id="<?php echo $order['order_id']; ?>" done="<?php echo $order['done']; ?>" id="btn_<?php echo $order['order_id']; ?>" ><i class="fa fa-upload"></i></a>    

                  <?php if($order['done']) { ?>
                  <a target="_blank" data-toggle="tooltip" title="delete image" class="btn btn-danger clear-image" data-method="setTop" order-id="<?php echo $order['order_id']; ?>" done="<?php echo $order['done']; ?>" id="btn_<?php echo $order['order_id']; ?>">
<i class="fa fa-power-off"></i>
                  </a>
                  <?php } ?>

                    </td>
                  <td class="text-right"><?php echo $order['country']; ?></td>
                  <td class="text-right"><?php echo $order['order_id']; ?></td>
                  <td class="text-left"><?php echo $order['status']; ?></td>
                  <td class="text-right"><?php echo $order['total']; ?></td>
                  <td class="text-left"><?php echo $order['shipping_method']; ?></td>
                  <td class="text-left"><?php echo $order['customer']; ?></td>
                  <td class="text-left">
                    <?php if(isset($models[$order['order_id']])) { echo $models[$order['order_id']]; } ?>
                  </td>
                  <td class="text-left"><?php echo $order['email']; ?></td>
                  <td class="text-left"><?php echo $order['date_added']; ?></td>
                  <td class="text-left"><?php echo $order['date_modified']; ?></td>
                  
                </tr>
                <?php } ?>
                <?php } else { ?>
                <tr>
                  <td class="text-center" colspan="8"><?php echo $text_no_results; ?></td>
                </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
        </form>
        <div class="row">
          <div class="col-sm-6 text-left"><?php echo $pagination; ?></div>
          <div class="col-sm-6 text-right"><?php echo $results; ?></div>
        </div>
      </div>
    </div>
  </div>

  <!-- 批量处理订单弹窗 -->
  <div class="" id="batch-window">
  <div class="container-fluid">
     <form role="form" id="batch-order">
     <div class="row">
      <div class="col-md-4">
        <div class="form-group">
          <textarea class="form-control" rows="30" name="batch-order-id" id="batch-order-id"></textarea>
        </div>
      </div>
      <div class="col-md-8">
      <div style="position:absolute;right:-2px;top:-2px;">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true" style="font-size:30px">×</button>
			</div>
        <div class="form-group">
          <label class="control-label" for="batch-status">Order Status</label>
           <select name="batch-status" id="batch-status" class="form-control">
                  <option value=""></option>
                  <?php foreach ($order_statuses as $order_status) { ?>
                  <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                  <?php } ?>
                </select>
        </div>
        <div class="form-group">
          <label class="control-label" for="batch-comment">Comment</label>
          <textarea name="batch-comment" class="form-control" id="batch-comment" rows="5"></textarea>
        </div>
        <div class="form-group">
          <label class="control-label" for="batch-notify">Notify Customer</label>
          <input type="checkbox" value="1" name="batch-notify" id="batch-notify" style="vertical-align: top;margin-left:10px;" checked>
        </div>
        <div class="form-group">
          <?php if(!empty($choose_email)) { ?>
<?php foreach($choose_email as $key => $arr) { ?>
<?php if($arr['config_mail_smtp_username']){ ?>
                    <input type="radio" name="choose_email" value="<?php echo $key;?>" id="email_<?php echo $key;?>" <?php if($arr['default']){ echo 'checked';}?>/>
                    <label for="email_<?php echo $key;?>"><?php echo $arr['config_mail_smtp_username'];?></label>
                    &nbsp;&nbsp;
          <?php }}}else{ ?>          
<input type="hidden" name="choose_email" value="" checked />
          <?php } ?>
        </div>
        <div class="form-group">
          <label class="control-label" for="batch-frequency">Email Sending Frequency</label>
          <input type="text" value="10" name="batch-frequency" class="form-control" id="batch-frequency">
        </div>

         <div class="form-group">
         <div id="batch-success" style="text-align: right;color: green;display:none"><i class="fa fa-check-circle"></i> Success !</div>
          <button type="button" class="btn btn-primary pull-right" id="batch-order-check">
          Order Status Bulk Update
          </button>
        </div>
      </div>
     </div>
     </form>
  </div>
  </div>
  <script type="text/javascript"><!--
      $("#filter_chose_status").chosen();
$('#button-filter').on('click', function() {
	url = 'index.php?route=sale/order&token=<?php echo $token; ?>';

	var filter_order_id = $('input[name=\'filter_order_id\']').val();

	if (filter_order_id) {
		url += '&filter_order_id=' + encodeURIComponent(filter_order_id);
	}

	var filter_customer = $('input[name=\'filter_customer\']').val();

	if (filter_customer) {
		url += '&filter_customer=' + encodeURIComponent(filter_customer);
	}

  var filter_customer_email = $('input[name=\'filter_customer_email\']').val();
	if (filter_customer_email) {
		url += '&filter_customer_email=' + encodeURIComponent(filter_customer_email);
	}
  var filter_model = $('input[name=\'filter_model\']').val();
	if (filter_model) {
		url += '&filter_model=' + encodeURIComponent(filter_model);
	}
  var filter_shipping_method = $('input[name=\'filter_shipping_method\']').val();
	if (filter_shipping_method) {
		url += '&filter_shipping_method=' + encodeURIComponent(filter_shipping_method);
	}
   var filter_remark = $('select[name=\'filter_remark\']').val();
	if (filter_remark) {
		url += '&filter_remark=' + encodeURIComponent(filter_remark);
	}
     var filter_black = $('select[name=\'filter_black\']').val();
	if (filter_black) {
		url += '&filter_black=' + encodeURIComponent(filter_black);
	}

	var filter_order_status = $('select[name=\'filter_order_status\']').val();

	if (filter_order_status != '*') {
		url += '&filter_order_status=' + encodeURIComponent(filter_order_status);
	}

	var filter_total = $('input[name=\'filter_total\']').val();

	if (filter_total) {
		url += '&filter_total=' + encodeURIComponent(filter_total);
	}

	var filter_date_added = $('input[name=\'filter_date_added\']').val();

	if (filter_date_added) {
		url += '&filter_date_added=' + encodeURIComponent(filter_date_added);
	}

	var filter_date_modified = $('input[name=\'filter_date_modified\']').val();

	if (filter_date_modified) {
		url += '&filter_date_modified=' + encodeURIComponent(filter_date_modified);
	}


    var filter_chose_status = $("#filter_chose_status").chosen().val();
    if (filter_chose_status) {
        url += '&filter_chose_status=' + encodeURIComponent(filter_chose_status.join('_'));
    }

	location = url;
});
//--></script>
  <script type="text/javascript"><!--
$('input[name=\'filter_customer\']').autocomplete({
	'source': function(request, response) {
		$.ajax({
			url: 'index.php?route=customer/customer/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request),
			dataType: 'json',
			success: function(json) {
				response($.map(json, function(item) {
					return {
						label: item['name'],
						value: item['customer_id']
					}
				}));
			}
		});
	},
	'select': function(item) {
		$('input[name=\'filter_customer\']').val(item['label']);
	}
});
//--></script>
  <script type="text/javascript"><!--
$('input[name^=\'selected\']').on('change', function() {
	$('#button-shipping, #button-invoice').prop('disabled', true);

	var selected = $('input[name^=\'selected\']:checked');

	if (selected.length) {
		$('#button-invoice').prop('disabled', false);
	}

	for (i = 0; i < selected.length; i++) {
		if ($(selected[i]).parent().find('input[name^=\'shipping_code\']').val()) {
			$('#button-shipping').prop('disabled', false);

			break;
		}
	}
});

$('input[name^=\'selected\']:first').trigger('change');

// Login to the API
var token = '';

$.ajax({
	url: '<?php echo $store; ?>index.php?route=api/login',
	type: 'post',
	data: 'key=<?php echo $api_key; ?>',
	dataType: 'json',
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

$('button[id^=\'button-delete\']').on('click', function(e) {
	if (confirm('<?php echo $text_confirm; ?>')) {
		var node = this;

		$.ajax({
			url: '<?php echo $store; ?>index.php?route=api/order/delete&token=' + token + '&order_id=' + $(node).val(),
			dataType: 'json',
			crossDomain: true,
			beforeSend: function() {
				$(node).button('loading');
			},
			complete: function() {
				$(node).button('reset');
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
	}
});
//--></script>
  <script src="view/javascript/jquery/datetimepicker/bootstrap-datetimepicker.min.js" type="text/javascript"></script>
  <link href="view/javascript/jquery/datetimepicker/bootstrap-datetimepicker.min.css" type="text/css" rel="stylesheet" media="screen" />
  <script type="text/javascript"><!--
$('.date').datetimepicker({
	pickTime: false
});
//--></script></div>

<script src="view/javascript/layui/layer.js" type="text/javascript"></script>
 <script type="text/javascript">
        var move = 10;
        //触发事件
        var active = {
          setTop: function(order_id){
            var that = this; 
            var order_id = $(that).attr('order-id');
            
            //多窗口模式，层叠置顶
            layer.open({
              type: 2 //此处以iframe举例
              ,title: '当你选择该窗体时，即会在最顶端'
              ,area: ['700px', '550px']
              ,shade: 0
              ,maxmin: true
              ,offset: [ //为了演示，随机坐标
                (100 + move)
                ,(200 + move)
              ] 
              ,content: ['<?php echo $webupload_url; ?>&order_id='+order_id,'yes']
              ,yes: function(){
                $(that).click(); 
              }
              ,btn2: function(){
                layer.closeAll();
              }
              ,closeBtn:1
              ,zIndex: layer.zIndex //重点1
              ,success: function(layero){
                layer.setTop(layero); //重点2
              }
            });
          }
        
        };
        
        $('.layui-btn').on('click', function(){
          var done = $(this).attr('done');
          var order_id = $(this).attr('order-id');
          var othis = $(this), method = othis.data('method');
         

          active[method] ? active[method].call(this, othis) : '';
          move += 30;
          

        
        });

        $('.clear-image').on('click', function(){
          var done = $(this).attr('done');
          var order_id = $(this).attr('order-id');
          var othis = $(this), method = othis.data('method');
         
          if(done=='1'){
              layer.confirm('清空图片?',{
                btn:['确定','取消']
              },function(index){
                layer.close(index);

                $.ajax({
                                    url:'index.php?route=tool/webupload/restart&token=<?php echo $token; ?>&order_id='+order_id,
                                    type:"post",
                                    data:{'order_id': order_id},
                                    dataType:"json",
                                    cache: false,
                                    success:function(data){
                othis.attr('done',0);
                $('#img_'+order_id).html('');
                layer.alert('操作成功图片已清空');
                                    },
                                    error:function(){
                                        layer.alert('操作失败,请重试!');
                                    }
                                });

                


              },function(){

              });

          }else{
            layer.alert('无图片');
         
          }

        
        });
        
        function open(order_id){
          var othis = $('#btn_'+order_id), method = othis.data('method');
          active[method] ? active[method].call(othis, othis) : '';
          move += 30; 
        }

      $('#batchOrder').click(function(){
        $('#batch-window').addClass('upBg show');
      });
      $('.close').click(function(){
         $('#batch-window').removeClass('upBg show');   
      });
      var validate = 1;
      $('#batch-order-check').click(function(){
          var order_id = $.trim($('#batch-order-id').val());
          var order_status = $('#batch-status').val();
          var order_comment = $('#batch-comment').val();
          var order_frequency = $('#batch-frequency').val();
          if(order_id ==''){
            alert('order id not empty');
            return;
          }
          if(order_frequency <0 || order_frequency >600){
            alert('Frequency have to big 0 less 600');
            return;
          }
          if(order_status == ''){
            alert('order status have to choose');
            return;
          }
          var form = $('#batch-order').serialize();
          
if(validate) {
            $.ajax({
                type: 'post',
                url: 'index.php?route=sale/order/batchorder&token=<?php echo $token; ?>',
                data: form,
                dataType: 'json',
                beforeSend:function(){
                  validate = 0;
                  $('#batch-order-check').attr("disabled",true);
                  $('#batch-order-check').text("Sending");
                },
                success: function (json) {
                  if(json['state']){
                    successRest();
                  }else{
                    alert(json['message']);
                  }
                 

                },
                complete:function(){
                  errorReset();
                },
                error:function(){
                 errorReset();
                }
            });
        }


      });   
      function successRest(){
        validate = 1;
        $('#batch-order-id').val('');
        $('#batch-status').val('');
        $('#batch-comment').val('');
        $('#batch-order-check').attr("disabled",false);
        $('#batch-order-check').text("Order Status Bulk Update");
         $('#batch-success').show().delay(2000).fadeOut();
      }
      function errorReset(){
        validate = 1;
        $('#batch-order-check').attr("disabled",false);
        $('#batch-order-check').text("Order Status Bulk Update");
      }

        
     
      </script>

      <style type="text/css">
      #batch-window{
        display:none;
      }
.upBg{
transform: translateX(-50%) scale(0.8,0.8);
left: 50%;
top: 20%;
border-radius: 3px;
position: fixed;
width: 70%;
height: 600px;
overflow-y: auto;
z-index: 1111;
transition: all .3s;
visibility: hidden;
background: #f2f2f2;
opacity: 0;
padding:10px;
}
.show{
transform: translateX(-50%) scale(1,1);
visibility: visible;
opacity: 1;
box-shadow: 1px 1px 20px 2px #888;
}
</style>

<?php echo $footer; ?>
