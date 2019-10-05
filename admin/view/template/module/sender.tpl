<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-sender" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
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
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-sender" class="form-horizontal">
			<div class="form-group">
            <label class="col-sm-2 control-label" for="input-status"><?php echo $entry_status; ?></label>
            <div class="col-sm-10">
              <select name="sender_status" id="input-status" class="form-control">
                <?php if ($sender_status) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select>
            </div>
          </div>

       	<div class="tab-pane">
            <ul class="nav nav-tabs" id="email">
              <?php foreach ($emails as $val) { ?>
              <li><a href="#email<?php echo $val; ?>" data-toggle="tab">email<?php echo $val; ?></a></li>
              <?php } ?>
            </ul>
            <div class="tab-content">
              <?php foreach ($emails as $val) { ?>
              <div class="tab-pane" id="email<?php echo $val; ?>">
                <div class="form-group">
                  <label class="col-sm-2 control-label" for="input-title<?php echo $val; ?>">
                  SMTP Hostname
                 
                  </label>
                  <div class="col-sm-10">
                    <input type="text" name="sender_email<?php echo $val; ?>[config_mail_smtp_hostname]"  id="input-heading<?php echo $val; ?>" value="<?php echo isset(${'sender_email'.$val}['config_mail_smtp_hostname']) ? ${'sender_email'.$val}['config_mail_smtp_hostname'] : ''; ?>" class="form-control" />
                  </div>
                </div>

                <div class="form-group">
                  <label class="col-sm-2 control-label" for="input-title<?php echo $val; ?>">
                  SMTP Username
                
                  </label>
                  <div class="col-sm-10">
                    <input type="text" name="sender_email<?php echo $val; ?>[config_mail_smtp_username]"  id="input-heading<?php echo $val; ?>" value="<?php echo isset(${'sender_email'.$val}['config_mail_smtp_username']) ? ${'sender_email'.$val}['config_mail_smtp_username'] : ''; ?>" class="form-control" />
                  </div>
                </div>

                <div class="form-group">
                  <label class="col-sm-2 control-label" for="input-title<?php echo $val; ?>">
                  
                  SMTP Password
                  </label>
                  <div class="col-sm-10">
                    <input type="text" name="sender_email<?php echo $val; ?>[config_mail_smtp_password]"  id="input-heading<?php echo $val; ?>" value="<?php echo isset(${'sender_email'.$val}['config_mail_smtp_password']) ? ${'sender_email'.$val}['config_mail_smtp_password'] : ''; ?>" class="form-control" />
                  </div>
                </div>

                <div class="form-group">
                  <label class="col-sm-2 control-label" for="input-title<?php echo $val; ?>">
                  
                  SMTP Port
                  </label>
                  <div class="col-sm-10">
                    <input type="text" name="sender_email<?php echo $val; ?>[config_mail_smtp_port]"  id="input-heading<?php echo $val; ?>" value="<?php echo isset(${'sender_email'.$val}['config_mail_smtp_port']) ? ${'sender_email'.$val}['config_mail_smtp_port'] : ''; ?>" class="form-control" />
                  </div>
                </div>

                <div class="form-group">
            <label class="col-sm-2 control-label" for="input-status<?php echo $val; ?>">  DEFAULT </label>
            <div class="col-sm-10">
              <select name="sender_email<?php echo $val; ?>[default]]" id="input-status<?php echo $val; ?>" class="form-control">
                <?php if (isset(${'sender_email'.$val}['default']) && ${'sender_email'.$val}['default']==1) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select>
            </div>
          </div>
              
              </div>
              <?php } ?>
            </div>
          </div> 
		  
		   
		
          
        </form>
      </div>
    </div>
  </div>
</div>
  <script type="text/javascript"><!--
$('#email a:first').tab('show');
//--></script>
<?php echo $footer; ?>