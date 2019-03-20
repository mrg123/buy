<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-cod" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
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
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_edit; ?></h3>
      </div>
      <div class="panel-body">
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-cod" class="form-horizontal">
	  <div class="form-group">
            <label class="col-sm-2 control-label" for="input-order-status"><?php echo $entry_type; ?></label>
            <div class="col-sm-10">
              <select name="mycheckout_type" id="input-type" class="form-control">
            	  <?php if ($mycheckout_type == '3') { ?>
            		<option value="1">1 - Pay In Next Page</option>
            		<option value="2">2 - Pay In Current Page</option>
            		<option value="3" selected="selected">3 - Pay While Selecting The Payment Method</option>
                            <?php } elseif ($mycheckout_type == '2') { ?>
            		<option value="1">1 - Pay In Next Page</option>
            		<option value="2" selected="selected">2 - Pay In Current Page</option>
            		<option value="3">3 - Pay While Selecting The Payment Method</option>
            		<?php } else { ?>
            		<option value="1" selected="selected">1 - Pay In Next Page</option>
            		<option value="2">2 - Pay In Current Page</option>
            		<option value="3">3 - Pay While Selecting The Payment Method</option>
            		<?php } ?>
              </select>
            </div>
          </div>
	  <div class="form-group">
            <label class="col-sm-2 control-label" for="input-merchantid"><?php echo $entry_merchantid; ?></label>
            <div class="col-sm-10">
              <input type="text" name="mycheckout_merchantid" value="<?php echo $mycheckout_merchantid; ?>" placeholder="<?php echo $entry_merchantid; ?>" id="input-merchantid" class="form-control" />
	      <?php if (isset($error_merchantid)) { ?>
              <div class="text-danger"><?php echo $error_merchantid; ?></div>
              <?php } ?>
            </div>
          </div>
	  <div class="form-group">
            <label class="col-sm-2 control-label" for="input-transno"><?php echo $entry_transno; ?></label>
            <div class="col-sm-10">
              <input type="text" name="mycheckout_transno" value="<?php echo $mycheckout_transno; ?>" placeholder="<?php echo $entry_transno; ?>" id="input-transno" class="form-control" />
	      <?php if (isset($error_transno)) { ?>
              <div class="text-danger"><?php echo $error_transno; ?></div>
              <?php } ?>
            </div>
          </div>
	  <div class="form-group">
            <label class="col-sm-2 control-label" for="input-md5key"><?php echo $entry_md5key; ?></label>
            <div class="col-sm-10">
              <input type="text" name="mycheckout_md5key" value="<?php echo $mycheckout_md5key; ?>" placeholder="<?php echo $entry_md5key; ?>" id="input-md5key" class="form-control" />
	      <?php if (isset($error_md5key)) { ?>
              <div class="text-danger"><?php echo $error_md5key; ?></div>
              <?php } ?>
            </div>
          </div>
	  <div class="form-group">
            <label class="col-sm-2 control-label" for="input-status"><?php echo $entry_status; ?></label>
            <div class="col-sm-10">
              <select name="mycheckout_status" id="input-status" class="form-control">
                <?php if ($mycheckout_status) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select>
            </div>
          </div>
	  <div class="form-group">
            <label class="col-sm-2 control-label" for="input-geo-zone"><?php echo $entry_geo_zone; ?></label>
            <div class="col-sm-10">
              <select name="mycheckout_geo_zone_id" id="input-geo-zone" class="form-control">
                <option value="0"><?php echo $text_all_zones; ?></option>
                <?php foreach ($geo_zones as $geo_zone) { ?>
                <?php if ($geo_zone['geo_zone_id'] == $mycheckout_geo_zone_id) { ?>
                <option value="<?php echo $geo_zone['geo_zone_id']; ?>" selected="selected"><?php echo $geo_zone['name']; ?></option>
                <?php } else { ?>
                <option value="<?php echo $geo_zone['geo_zone_id']; ?>"><?php echo $geo_zone['name']; ?></option>
                <?php } ?>
                <?php } ?>
              </select>
            </div>
          </div>
	  <div class="form-group">
            <label class="col-sm-2 control-label" for="input-sort-order"><?php echo $entry_sort_order; ?></label>
            <div class="col-sm-10">
              <input type="text" name="mycheckout_sort_order" value="<?php echo $mycheckout_sort_order; ?>" placeholder="<?php echo $entry_sort_order; ?>" id="input-sort-order" class="form-control" />
            </div>
          </div>
	  <div class="form-group">
            <label class="col-sm-2 control-label" for="input-order-status"><?php echo $entry_order_status; ?></label>
            <div class="col-sm-10">
              <select name="mycheckout_order_status_id" id="input-order-status" class="form-control">
                <?php foreach ($order_statuses as $order_status) { ?>
                <?php if ($order_status['order_status_id'] == $mycheckout_order_status_id) { ?>
                <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                <?php } else { ?>
                <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                <?php } ?>
                <?php } ?>
              </select>
            </div>
          </div>
	  <div class="form-group">
            <label class="col-sm-2 control-label" for="input-success-order-status"><?php echo $entry_pay_success_order_status; ?></label>
            <div class="col-sm-10">
              <select name="mycheckout_pay_success_order_status_id" id="input-success-order-status" class="form-control">
                <?php foreach ($order_statuses as $order_status) { ?>
                <?php if ($order_status['order_status_id'] == $mycheckout_pay_success_order_status_id) { ?>
                <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                <?php } else { ?>
                <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                <?php } ?>
                <?php } ?>
              </select>
            </div>
          </div>
	  <div class="form-group">
            <label class="col-sm-2 control-label" for="input-fail-order-status"><?php echo $entry_pay_fail_order_status; ?></label>
            <div class="col-sm-10">
              <select name="mycheckout_pay_fail_order_status_id" id="input-fail-order-status" class="form-control">
                <?php foreach ($order_statuses as $order_status) { ?>
                <?php if ($order_status['order_status_id'] == $mycheckout_pay_fail_order_status_id) { ?>
                <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                <?php } else { ?>
                <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                <?php } ?>
                <?php } ?>
              </select>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<?php echo $footer; ?>