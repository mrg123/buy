<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-gobaldbill-direct" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
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
      <div class="panel-body">
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-gobaldbill-direct" class="form-horizontal">
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-status"><?php echo $entry_status; ?></label>
            <div class="col-sm-10">
              <select name="gobaldbill_status" id="input-status" class="form-control">
                <?php if ($gobaldbill_status) { ?>
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
            <label class="col-sm-2 control-label" for="input-order-status"><?php echo $entry_order_status; ?></label>
            <div class="col-sm-10">
              <select name="gobaldbill_order_status_id" id="input-order-status" class="form-control">
                <?php foreach ($order_statuses as $order_status) { ?>
                <?php if ($order_status['order_status_id'] == $gobaldbill_order_status_id) { ?>
                <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                <?php } else { ?>
                <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                <?php } ?>
                <?php } ?>
              </select>
            </div>
	  </div>
	  <div class="form-group">
            <label class="col-sm-2 control-label" for="input-order-fail-status"><?php echo $entry_order_fail_status; ?></label>
            <div class="col-sm-10">
              <select name="gobaldbill_order_fail_status_id" id="input-order-fail-status" class="form-control">
                <?php foreach ($order_statuses as $order_status) { ?>
                <?php if ($order_status['order_status_id'] == $gobaldbill_order_fail_status_id) { ?>
                <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                <?php } else { ?>
                <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                <?php } ?>
                <?php } ?>
              </select>
            </div>
	  </div>
	  <div class="form-group">
		<label class="col-sm-2 control-label" for="input-merchantno"><?php echo $entry_merchantno; ?></label>
		<div class="col-sm-10">
		  <input type="text" name="gobaldbill_merchantno" value="<?php echo $gobaldbill_merchantno; ?>" placeholder="<?php echo $entry_merchantno; ?>" id="input-merchantno" class="form-control" />
		</div>
	  </div>
	  <div class="form-group">
            <label class="col-sm-2 control-label" for="input-referer"><?php echo $entry_referer; ?></label>
            <div class="col-sm-10">
              <input type="text" name="gobaldbill_referer" value="<?php echo $gobaldbill_referer; ?>" placeholder="<?php echo $entry_referer; ?>" id="input-referer" class="form-control" />
            </div>
          </div>
	  <div class="form-group">
            <label class="col-sm-2 control-label" for="input-key"><?php echo $entry_key; ?></label>
            <div class="col-sm-10">
              <input type="text" name="gobaldbill_key" value="<?php echo $gobaldbill_key; ?>" placeholder="<?php echo $entry_key; ?>" id="input-key" class="form-control" />
            </div>
          </div>
	  <div class="form-group">
            <label class="col-sm-2 control-label" for="input-gateway"><?php echo $entry_gateway; ?></label>
            <div class="col-sm-10">
              <input type="text" name="gobaldbill_gateway" value="<?php echo $gobaldbill_gateway; ?>" placeholder="<?php echo $entry_gateway; ?>" id="input-gateway" class="form-control" />
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-sort-order"><?php echo $entry_sort_order; ?></label>
            <div class="col-sm-10">
              <input type="text" name="gobaldbill_sort_order" value="<?php echo $gobaldbill_sort_order; ?>" placeholder="<?php echo $entry_sort_order; ?>" id="input-sort-order" class="form-control" />
	      <input type="hidden" name="gobaldbill_imgtype" value="<?php echo $gobaldbill_imgtype; ?>" /> 
	      <input type="hidden" name="gobaldbill_embed" value="<?php echo $gobaldbill_embed; ?>" />
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<?php echo $footer; ?> 
