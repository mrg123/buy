<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
          <button type="button" data-toggle="tooltip" title="" class="btn btn-danger" onclick="confirm('Are you sure?') ? deleteSupport() : false;" data-original-title="Delete"><i class="fa fa-trash-o"></i></button>
      </div>
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
              <div class="col-sm-3">
                <div class="form-group">
                    <label class="control-label" for="input-ticket-id">Ticket ID</label>
                    <input type="text" name="filter_ticket_id" value="<?php echo $filter_ticket_id; ?>" placeholder="Ticket ID" id="input-ticket-id" class="form-control" />
                </div>
                <div class="form-group">
                    <label class="control-label" for="input-order-id"><?php echo $entry_order_id; ?></label>
                    <input type="text" name="filter_order_id" value="<?php echo $filter_order_id; ?>" placeholder="<?php echo $entry_order_id; ?>" id="input-order-id" class="form-control" />
                </div>
            </div>

              <div class="col-sm-3">
                <div class="form-group">
                    <label class="control-label" for="input-status">
                        Ticket Status
                    </label>
                    <select name="filter_status" id="input-status" class="form-control">

                        <?php foreach ($statuses as $key => $status) { ?>

                        <?php if ($key == $filter_status) { ?>
                        <option value="<?php echo $key; ?>" selected="selected"><?php echo $status; ?></option>
                        <?php } else { ?>
                        <option value="<?php echo $key; ?>"><?php echo $status; ?></option>
                        <?php } ?>

                        <?php } ?>
                    </select>
                </div>

                  <div class="form-group">
                      <label class="control-label" for="input-customer"><?php echo $entry_customer; ?></label>
                      <input type="text" name="filter_customer" value="<?php echo $filter_customer; ?>" placeholder="<?php echo $entry_customer; ?>" id="input-customer" class="form-control" />
                  </div>
              </div>

              <div class="col-sm-3">
                <div class="form-group">
                    <label class="control-label" for="input-priority">
                        Priority
                    </label>
                    <select name="filter_priority" id="input-priority" class="form-control">
                        <option value=""></option>
                        <?php foreach ($priority as $key => $status) { ?>
                        <?php if ($key == $filter_priority) { ?>
                        <option value="<?php echo $key; ?>" selected="selected"><?php echo $status; ?></option>
                        <?php } else { ?>
                        <option value="<?php echo $key; ?>"><?php echo $status; ?></option>
                        <?php } ?>
                        <?php } ?>
                    </select>
                </div>

                  <div class="form-group">
                      <label class="control-label" for="input-customer_email"><?php echo $entry_customer_email; ?></label>
                      <input type="text" name="filter_customer_email" value="<?php echo $filter_customer_email; ?>" placeholder="<?php echo $entry_customer_email; ?>" id="input-customer_email" class="form-control" />
                  </div>

              </div>

              <div class="col-sm-3">
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
                      <button type="button" id="button-filter" class="btn btn-primary pull-right"><i class="fa fa-search"></i> <?php echo $button_filter; ?></button>
                      <span class="pull-right" style="display: inline-block;line-height: 35px;margin-right: 5px;"><?php echo $results; ?></span>
                      <span class="pull-right" style="display: inline-block;line-height: 35px;margin-right: 5px;"><?php echo $pagination; ?></span>
                  </div>
            </div>

          </div>
        </div>
        <form method="post" enctype="multipart/form-data" target="_blank" id="form-order">
          <div class="table-responsive">
            <table class="table table-bordered table-hover">
              <thead>
                <tr>
                  <td class="text-center"><input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" /></td>
                  <td class="text-right" ><?php echo $column_action; ?></td>
                  <td class="text-left">Ticket ID</td>
                  <td class="text-right">
                   Order ID  </td>
                  <td class="text-left">
                    Customer
                    </td>
                    <td class="text-right" width="350"> Ticket Subject</td>
                    <td class="text-right"> Ticket Status</td>
                     <td class="text-left">Priority</td>

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
                <?php if ($support_list) { ?>
                <?php foreach ($support_list as $support) { ?>
                <tr>
                    <td class="text-center">
                        <input type="checkbox" name="selected[]" value="<?php echo $support['id']; ?>" />

                      </td>
                  <td class="text-right">
                      <a href="<?php echo $support['url'];?>" data-toggle="tooltip" title="" class="btn btn-primary" data-original-title="Edit"><i class="fa fa-pencil"></i></a>
                  </td>
                  <td class="text-right"><?php echo $support['ticket_id']; ?></td>
                  <td class="text-right"><?php echo $support['order_id']; ?></td>
                  <td class="text-left"><?php echo $support['customer']; ?> <br/>
                      <?php echo $support['email']; ?>
                  </td>
                  <td class="text-right"><?php echo $support['subject']; ?></td>
                  <td class="text-left"><?php echo $support['status']; ?></td>
                  <td class="text-left"><?php echo $support['priority']; ?></td>
                  <td class="text-left"><?php echo $support['add_time']; ?></td>
                  <td class="text-left"><?php echo $support['update_time']; ?></td>
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

 
  <script type="text/javascript"><!--
$('#button-filter').on('click', function() {
	url = 'index.php?route=sale/support&token=<?php echo $token; ?>';

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

  var filter_ticket_id = $('input[name=\'filter_ticket_id\']').val();
	if (filter_ticket_id) {
		url += '&filter_ticket_id=' + encodeURIComponent(filter_ticket_id);
	}

   var filter_priority = $('select[name=\'filter_priority\']').val();
	if (filter_priority) {
		url += '&filter_priority=' + encodeURIComponent(filter_priority);
	}

	var filter_status = $('select[name=\'filter_status\']').val();

	if (filter_status != '*') {
		url += '&filter_status=' + encodeURIComponent(filter_status);
	}


	var filter_date_added = $('input[name=\'filter_date_added\']').val();

	if (filter_date_added) {
		url += '&filter_date_added=' + encodeURIComponent(filter_date_added);
	}

	var filter_date_modified = $('input[name=\'filter_date_modified\']').val();

	if (filter_date_modified) {
		url += '&filter_date_modified=' + encodeURIComponent(filter_date_modified);
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

function deleteSupport(){
    var id = [];

    $('input[name="selected[]"]:checked').each(function(){
        id.push($(this).val());
    });
    console.log(id);
    if(id.length === 0){
        return false;
    }


    $.ajax({
        url: 'index.php?route=sale/support/deletesupport&token=<?php echo $token; ?>',
        dataType: 'json',
        data:{'id_arr[]':id},
        type: 'post',
        crossDomain: true,
        success: function(json) {
           $('#button-filter').trigger('click');
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        }
    });
}


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

<?php echo $footer; ?>
