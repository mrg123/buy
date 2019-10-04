<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-module" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
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
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-module" class="form-horizontal">
		  <ul class="nav nav-tabs">
            <li class="active"><a href="#tab-general" data-toggle="tab"><?php echo $tab_general; ?></a></li>
             
          </ul>
		  <div class="tab-content">
            <div class="tab-pane active" id="tab-general">
			  <div class="form-group">
				<label class="col-sm-2 control-label" for="input-status"><?php echo $entry_status; ?></label>
				<div class="col-sm-10">
				  <select name="fblogin_status" id="input-status" class="form-control">
					<option value="1"<?php echo $fblogin_status ? ' selected="selected"' : ''; ?>><?php echo $text_enabled; ?></option>
					<option value="0"<?php echo $fblogin_status ? '' : ' selected="selected"'; ?>><?php echo $text_disabled; ?></option>
				  </select>
				</div>
			  </div>
			  <div class="form-group required">
                <label class="col-sm-2 control-label" for="input-app-id"><span data-toggle="tooltip" title="<?php echo $help_app_id; ?>"><?php echo $entry_app_id; ?></span></label>
                <div class="col-sm-10">
				  <?php foreach ($stores as $store) { ?>
					<input type="text" name="fblogin_app_id[<?php echo $store['store_id']; ?>]" value="<?php echo !empty($fblogin_app_id[$store['store_id']]) ? $fblogin_app_id[$store['store_id']] : ''; ?>" class="form-control" /> (<?php echo $store['name']; ?>)<br />
			      <?php } ?>
                </div>
              </div>
			  <div class="form-group">
				<label class="col-sm-2 control-label" for="input-customer-group"><?php echo $entry_customer_group; ?></label>
				<div class="col-sm-10">
				  <select name="fblogin_customer_group_id" id="input-customer-group" class="form-control"><?php foreach ($customer_groups as $customer_group) { ?>
					<?php if ($customer_group['customer_group_id'] == $fblogin_customer_group_id) { ?>
					<option value="<?php echo $customer_group['customer_group_id']; ?>" selected="selected"><?php echo $customer_group['name']; ?></option>
					<?php } else { ?>
					<option value="<?php echo $customer_group['customer_group_id']; ?>"><?php echo $customer_group['name']; ?></option>
					<?php } ?>
			      <?php } ?></select>
				</div>
			  </div>
			  <div class="form-group required">
                <label class="col-sm-2 control-label" for="input-heaidng"><?php echo $entry_heading; ?></label>
                <div class="col-sm-10">
				  <?php foreach ($languages as $language) { ?>
					<div class="input-group"><span class="input-group-addon"><img src="<?php echo version_compare(VERSION, '2.2.0.0', '<') ? 'view/image/flags/' . $language['image'] : 'language/' . $language['code'] . '/' . $language['code'] . '.png'; ?>" title="<?php echo $language['name']; ?>" /></span>
					<input type="text" name="fblogin_heading[<?php echo $language['language_id']; ?>]" value="<?php echo !empty($fblogin_heading[$language['language_id']]) ? $fblogin_heading[$language['language_id']] : ''; ?>" class="form-control" />
					</div>
				  <?php } ?>
                </div>
              </div>
			  <div class="form-group required">
                <label class="col-sm-2 control-label" for="input-text"><?php echo $entry_text; ?></label>
                <div class="col-sm-10">
				  <?php foreach ($languages as $language) { ?>
					<div class="input-group"><span class="input-group-addon"><img src="<?php echo version_compare(VERSION, '2.2.0.0', '<') ? 'view/image/flags/' . $language['image'] : 'language/' . $language['code'] . '/' . $language['code'] . '.png'; ?>" title="<?php echo $language['name']; ?>" /></span>
					<input type="text" name="fblogin_text[<?php echo $language['language_id']; ?>]" value="<?php echo !empty($fblogin_text[$language['language_id']]) ? $fblogin_text[$language['language_id']] : ''; ?>" class="form-control" />
					</div>
				  <?php } ?>
                </div>
              </div>
			  <div class="form-group required">
                <label class="col-sm-2 control-label" for="input-text"><?php echo $entry_button_text; ?></label>
                <div class="col-sm-10">
				  <?php foreach ($languages as $language) { ?>
					<div class="input-group"><span class="input-group-addon"><img src="<?php echo version_compare(VERSION, '2.2.0.0', '<') ? 'view/image/flags/' . $language['image'] : 'language/' . $language['code'] . '/' . $language['code'] . '.png'; ?>" title="<?php echo $language['name']; ?>" /></span>
					<input type="text" name="fblogin_button_text[<?php echo $language['language_id']; ?>]" value="<?php echo !empty($fblogin_button_text[$language['language_id']]) ? $fblogin_button_text[$language['language_id']] : ''; ?>" class="form-control" />
					</div>
				  <?php } ?>
                </div>
              </div>
			  <div class="form-group">
				<label class="col-sm-2 control-label" for="input-box"><?php echo $entry_box; ?></label>
				<div class="col-sm-10">
				  <select name="fblogin_box" id="input-box" class="form-control">
					<option value="1"<?php echo $fblogin_box ? ' selected="selected"' : ''; ?>><?php echo $text_enabled; ?></option>
					<option value="0"<?php echo $fblogin_box ? '' : ' selected="selected"'; ?>><?php echo $text_disabled; ?></option>
				  </select>
				</div>
			  </div>
			  <div class="form-group">
				<label class="col-sm-2 control-label" for="input-align"><?php echo $entry_align; ?></label>
				<div class="col-sm-10">
				  <select name="fblogin_align" id="input-align" class="form-control">
					<?php if ($fblogin_align == 'LEFT') { ?>
					<option value="LEFT" selected="selected">LEFT</option>
					<option value="CENTER">CENTER</option>
					<option value="RIGHT">RIGHT</option>
					<?php } elseif ($fblogin_align == 'CENTER') { ?>
					<option value="LEFT">LEFT</option>
					<option value="CENTER" selected="selected">CENTER</option>
					<option value="RIGHT">RIGHT</option>
					<?php } else { ?>
					<option value="LEFT">LEFT</option>
					<option value="CENTER">CENTER</option>
					<option value="RIGHT" selected="selected">RIGHT</option>
					<?php } ?>
				  </select>
				</div>
			  </div>
			</div>
			
		  </div>
		</form>
      </div>
    </div>
  </div>
</div>
<?php echo $footer; ?>