<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-customer-toggle" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
        <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a></div>
      <h1><?php echo $heading_title; ?></h1>
      <ul class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
        <?php } ?>
      </ul>
    </div>
  </div>
  <div class="container-fluid">
    <?php if ($error_warning) { ?>
    <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
	<?php if ($success) { ?>
    <div class="alert alert-success"><i class="fa fa-check-circle"></i> <?php echo $success; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_edit; ?></h3>
      </div>
      <div class="panel-body">
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-customer-toggle" class="form-horizontal">
			
		  <div class="form-group">
            <label class="col-sm-2 control-label" for="input-track_sign"><?php echo $entry_track_sign; ?></label>
            <div class="col-sm-10">
              <input name="track_sign" type="text" value="<?php echo $track_sign; ?>" class="form-control"/>
            </div>
          </div>
		  
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-track_status"><?php echo $entry_status; ?></label>
            <div class="col-sm-10">
              <select name="track_status" id="input-track_status" class="form-control">
                <?php if ($track_status) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select>
            </div>
          </div>
        </form>
		
		<div class="well">
          <div class="row">
            <div class="col-sm-3">
              <div class="form-group">
                <label class="control-label" for="input-filter_visitor"><?php echo $entry_name; ?></label>
                <input type="text" name="filter_visitor" value="<?php echo $filter_visitor; ?>" placeholder="<?php echo $entry_name; ?>" id="input-filter_visitor" class="form-control" />
              </div>
              <div class="form-group">
                <label class="control-label" for="input-filter_nation"><?php echo $entry_nation; ?></label>
                <input type="text" name="filter_nation" value="<?php echo $filter_nation; ?>" placeholder="<?php echo $entry_nation; ?>" id="input-filter_nation" class="form-control" />
              </div>
            </div>
            <div class="col-sm-3">
              <div class="form-group">
                <label class="control-label" for="input-filter_referer"><?php echo $entry_referer; ?></label>
                <input type="text" name="filter_referer" value="<?php echo $filter_referer; ?>" placeholder="<?php echo $entry_referer; ?>" id="input-filter_referer" class="form-control" />
              </div>
			  <div class="form-group">
                <label class="control-label" for="input-filter_ip"><?php echo $entry_ip; ?></label>
                <input type="text" name="filter_ip" value="<?php echo $filter_ip; ?>" placeholder="<?php echo $entry_ip; ?>" id="input-filter_ip" class="form-control" />
              </div>
            </div>
            <div class="col-sm-3">
              <div class="form-group">
                <label class="control-label" for="input-filter_landing_url"><?php echo $entry_landing_url; ?></label>
                <input type="text" name="filter_landing_url" value="<?php echo $filter_landing_url; ?>" placeholder="<?php echo $entry_landing_url; ?>" id="input-filter_landing_url" class="form-control" />
              </div>
              
            </div>
            <div class="col-sm-3">
              <div class="form-group">
                <label class="control-label" for="input-filter_date_added"><?php echo $entry_date_added; ?></label>
                <div class="input-group date">
                  <input type="text" name="filter_date_added" value="<?php echo $filter_date_added; ?>" placeholder="<?php echo $entry_date_added; ?>" data-date-format="YYYY-MM-DD" id="input-filter_date_added" class="form-control" />
                  <span class="input-group-btn">
                  <button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
                  </span></div>
              </div>
              <button type="button" id="button-filter" class="btn btn-primary pull-right"><i class="fa fa-search"></i> <?php echo $button_filter; ?></button>
            </div>
          </div>
        </div>
		
		
		
<ul class="nav nav-tabs">
  <li class="active"><a data-toggle="tab" href="#track">Track </a></li>
  <li><a data-toggle="tab" href="#track_cart">Track Cart</a></li>
  <li><a data-toggle="tab" href="#track_url">Track Url</a></li>
</ul>

<div class="tab-content">
  <div id="track" class="tab-pane fade in active">
  <div class="well">
			<?php echo $entry_total_visitor; ?>: <?php echo $total_visitor; ?>  &nbsp;&nbsp;
			<?php echo $entry_total_order_id; ?>: <?php echo $total_order_id; ?>
		</div>
    <div class="table-responsive">
            <table class="table table-bordered table-hover">
              <thead>
                <tr>
                  <td class="text-left"><?php if ($sort == 'track_id') { ?>
                    <a href="<?php echo $sort_track_id; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_name; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_track_id; ?>"><?php echo $column_name; ?></a>
                    <?php } ?></td>
				  <td class="text-left">
				   <?php if ($sort == 'visitor') { ?>
                    <a href="<?php echo $sort_visitor; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_visitor; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_visitor; ?>"><?php echo $column_visitor; ?></a>
                    <?php } ?>
				  </td>
                  <td class="text-left"><?php if ($sort == 'referer') { ?>
                    <a href="<?php echo $sort_referer; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_referer; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_referer; ?>"><?php echo $column_referer; ?></a>
                    <?php } ?></td>
                  <td class="text-left"><?php if ($sort == 'landing_url') { ?>
                    <a href="<?php echo $sort_landing_url; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_landing_url; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_landing_url; ?>"><?php echo $column_landing_url; ?></a>
                    <?php } ?></td>
                  <td class="text-left"><?php if ($sort == 'ip') { ?>
                    <a href="<?php echo $sort_ip; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_ip; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_ip; ?>"><?php echo $column_ip; ?></a>
                    <?php } ?></td>
                  <td class="text-left"><?php if ($sort == 'date_added') { ?>
                    <a href="<?php echo $sort_date_added; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_date_added; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_date_added; ?>"><?php echo $column_date_added; ?></a>
                    <?php } ?></td>
					<td class="text-left"><?php if ($sort == 'order_id') { ?>
                    <a href="<?php echo $sort_order_id; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_order_id; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_order_id; ?>"><?php echo $column_order_id; ?></a>
                    <?php } ?></td>
					<td class="text-left"><?php if ($sort == 'nation') { ?>
                    <a href="<?php echo $sort_nation; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_nation; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_nation; ?>"><?php echo $column_nation; ?></a>
                    <?php } ?></td>
                  <td class="text-right"><?php echo $column_action; ?></td>
                </tr>
              </thead>
              <tbody>
                <?php if ($tracks) { ?>
                <?php foreach ($tracks as $track) { ?>
                <tr>
                  <td class="text-left"><?php echo $track['track_id']; ?></td>
                  <td class="text-left"><?php echo $track['visitor']; ?></td>
                  <td class="text-left"><?php echo $track['referer']; ?></td>
                  <td class="text-left"><?php echo $track['landing_url']; ?></td>
                  <td class="text-left"><?php echo $track['ip']; ?></td>
                  <td class="text-left"><?php echo $track['date_added']; ?></td>
                  <td class="text-left"><?php echo $track['order_id']; ?></td>
				  <td class="text-left">
				  <?php if($track['nation']){ ?>
				  <?php echo $track['nation']; ?>
				  <?php }else { ?>
				  <button type="button" class="btn btn-default track_nation" data-ip="<?php echo $track['ip']; ?>">Get Nation</button>
				  <?php } ?>
				  </td>
                  <td class="text-right">
                    <button type="button" class="btn btn-primary track" data-track_id="<?php echo $track['track_id']; ?>">Track</button> 
					<button type="button" class="btn btn-default track_close">Close</button>
				  </td>
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
		  
		  <div class="row">
          <div class="col-sm-6 text-left"><?php echo $pagination; ?></div>
          <div class="col-sm-6 text-right"><?php echo $results; ?></div>
		  </div>
  </div>
  <div id="track_cart" class="tab-pane fade">
    <div class="table-responsive">
		<table class="table table-bordered table-hover">
			<thead>
			<tr>
				<td class="text-left">Image</td>
				<td class="text-left">Product Name</td>
				<td class="text-left">Model</td>
				<td class="text-left">Quantity</td>
				<td class="text-left">Price</td>
				<td class="text-left">Total</td>
				
				<td class="text-left">Visitor</td>
				<td class="text-left">Date</td>
			</tr>
			</thead>
			<tbody>
			<?php foreach($products as $arr){ ?>
			<tr>
				<td class="text-center">
				<img src="<?php echo $arr['thumb']; ?>" />
				</td>
				<td class="text-left"><?php echo $arr['name']; ?>
				<?php if ($arr['option']) { ?>
                  <?php foreach ($arr['option'] as $option) { ?>
                  <br />
                  <small><?php echo $option['name']; ?>: <?php echo $option['value']; ?></small>
                  <?php } ?>
                  <?php } ?>
				</td>
				<td class="text-left"><?php echo $arr['model']; ?></td>
				<td class="text-left"><?php echo $arr['quantity']; ?></td>
				<td class="text-left"><?php echo $arr['price']; ?></td>
				<td class="text-left"><?php echo $arr['total']; ?></td>
				
				<td class="text-left"><?php echo $arr['visitor']; ?></td>
				<td class="text-left"><?php echo $arr['date_added']; ?></td>
			</tr>
			<?php } ?>
			</tbody>
		</table>
	</div>
  </div>
  <div id="track_url" class="tab-pane fade">
    <div class="table-responsive">
		<table class="table table-bordered table-hover">
			<thead>
			<tr>
				<td class="text-left">url</td>
				<td class="text-left">count</td>
			</tr>
			</thead>
			<tbody>
			<?php foreach($track_urls as $arr){ ?>
			<tr>
				<td class="text-left"><?php echo $arr['url']; ?></td>
				<td class="text-left"><?php echo $arr['count']; ?></td>
			</tr>
			<?php } ?>
			</tbody>
		</table>
	</div>
  </div>
</div>
		
		
      </div>
    </div>
  </div>
</div>

<script type="text/javascript"><!--
$('#button-filter').on('click', function() {
	url = 'index.php?route=module/track&token=<?php echo $token; ?>';
	
	var filter_visitor = $('input[name=\'filter_visitor\']').val();
	
	if (filter_visitor) {
		url += '&filter_visitor=' + encodeURIComponent(filter_visitor);
	}
	
	var filter_nation = $('input[name=\'filter_nation\']').val();
	
	if (filter_nation) {
		url += '&filter_nation=' + encodeURIComponent(filter_nation);
	}
	
	var filter_referer = $('input[name=\'filter_referer\']').val();
	
	if (filter_referer) {
		url += '&filter_referer=' + encodeURIComponent(filter_referer);
	}	
	
	var filter_landing_url = $('input[name=\'filter_landing_url\']').val();
	
	if (filter_landing_url) {
		url += '&filter_landing_url=' + encodeURIComponent(filter_landing_url);
	}	
	
	var filter_ip = $('input[name=\'filter_ip\']').val();
	
	if (filter_ip) {
		url += '&filter_ip=' + encodeURIComponent(filter_ip);
	}
		
	var filter_date_added = $('input[name=\'filter_date_added\']').val();
	
	if (filter_date_added) {
		url += '&filter_date_added=' + encodeURIComponent(filter_date_added);
	}
	
	location = url;
});

$('.track').on('click', function() {
	//alert($(this).val());
	var track_id = $(this).attr('data-track_id');
	var that = $(this);
	if($('#track_tr'+track_id).length>0){
	$('#track_tr'+track_id).show();
		
	}else{
	$.ajax({
type:'post',
data:'track_id='+track_id,
		url: 'index.php?route=module/track/track&token=<?php echo $token; ?>',
		dataType:'json',
	beforeSend:function(){
	that.text('Tracking...');	
	},
	complete:function(){
	that.text('Track');	
	},
		success:function(json){
			if(json['error']){
				alert(json['error']);
			}else{
			var html = '<tr class="track_tr" id="track_tr'+track_id+'" style="background-color: #f5f5f5;"><td colspan="9">';	
			$.each(json['data'], function (n, data) {
				html += '<p>'+ n + '&nbsp;&nbsp;&nbsp;&nbsp;' + data.date + '&nbsp;&nbsp;&nbsp;&nbsp;' + data.url + '</p>';
			});
			html += '</td></tr>';
			that.parents('tr').after(html);	
			}
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});	
	} 
	
});
		$('.track_nation').on('click',function(){
			var ip = $(this).attr('data-ip');
	        var that = $(this);	
			
			$.ajax({
			type:'post',
			data:'ip='+ip,
			url: 'index.php?route=module/track/trackNation&token=<?php echo $token; ?>',
			dataType:'json',
			beforeSend:function(){
			that.text('Geting...');	
			},
			complete:function(){
				that.text('Get Nation');	
			},	
			success:function(json){
			if(json['error']){
				that.text('Get Nation');
				alert(json['error']);
			}else{
			that.parent().html(json['data']); 
			}
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});	
		});

		$('.track_close').on('click', function() {
			$('.track_tr').hide();
		});
//--></script> 
<script type="text/javascript"><!--
	/*
$('input[name=\'filter_visitor\']').autocomplete({
	'source': function(request, response) {
		$.ajax({
			url: 'index.php?route=module/track/autocomplete&token=<?php echo $token; ?>&filter_visitor=' +  encodeURIComponent(request),
			dataType: 'json',			
			success: function(json) {
				response($.map(json, function(item) {
					return {
						label: item['visitor'],
						value: item['track_id']
					}
				}));
			}
		});
	},
	'select': function(item) {
		$('input[name=\'filter_visitor\']').val(item['label']);
	}	
});

$('input[name=\'filter_nation\']').autocomplete({
	'source': function(request, response) {
		$.ajax({
			url: 'index.php?route=module/track/autocomplete&token=<?php echo $token; ?>&filter_nation=' +  encodeURIComponent(request),
			dataType: 'json',			
			success: function(json) {
				response($.map(json, function(item) {
					return {
						label: item['nation'],
						value: item['track_id']
					}
				}));
			}
		});
	},
	'select': function(item) {
		$('input[name=\'filter_nation\']').val(item['label']);
	}	
});
*/
//--></script> 
  <script type="text/javascript"><!--
$('.date').datetimepicker({
	pickTime: false
});
//--></script>
<?php echo $footer; ?>