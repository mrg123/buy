<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-category_toggle" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
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
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-category_toggle" class="form-horizontal">
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-status"><?php echo $entry_status; ?></label>
            <div class="col-sm-10">
              <select name="category_toggle_status" id="input-status" class="form-control">
                <?php if ($category_toggle_status) { ?>
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
		
		<div class="table-responsive">
            <table class="table table-bordered table-hover">
              <thead>
                <tr>
                  <td class="text-left"><?php echo $column_name; ?></td>
				  <td class="text-left"><?php echo $column_category_id; ?></td>
                  <td class="text-right"><?php echo $column_sort_order; ?></td>
                  <td class="text-right"><?php echo $column_action; ?></td>
                </tr>
              </thead>
              <tbody>
                <?php if ($categories) { ?>
                <?php foreach ($categories as $category) { ?>
                <tr>
                  <td class="text-left"><?php echo $category['name']; ?></td>
				  <td class="text-left"><?php echo $category['category_id']; ?></td>
                  <td class="text-right"><?php echo $category['sort_order']; ?></td>
                  <td class="text-right toggle">
                    <?php if($category['toggle']){ ?>
					<label>
					<input type="radio" name="toggle_<?php echo $category['category_id']; ?>" id="toggle_<?php echo $category['category_id']; ?>" value="1" checked="checked" data-category-id = "<?php echo $category['category_id']; ?>"/>
					<?php echo $text_enabled; ?>
					</label>
					<label>
					<input type="radio" name="toggle_<?php echo $category['category_id']; ?>" id="toggle_<?php echo $category['category_id']; ?>" value="0" data-category-id = "<?php echo $category['category_id']; ?>"/>
					<?php echo $text_disabled; ?>
					</label>
					<?php }else{ ?>
					<label>
					<input type="radio" name="toggle_<?php echo $category['category_id']; ?>" id="toggle_<?php echo $category['category_id']; ?>" value="1" data-category-id = "<?php echo $category['category_id']; ?>"/>
					<?php echo $text_enabled; ?>
					</label>
					<label>
					<input type="radio" name="toggle_<?php echo $category['category_id']; ?>" id="toggle_<?php echo $category['category_id']; ?>" value="0" checked="checked" data-category-id = "<?php echo $category['category_id']; ?>"/>
					<?php echo $text_disabled; ?>
					</label>
					<?php } ?>
				  </td>
                </tr>
                <?php } ?>
                <?php } else { ?>
                <tr>
                  <td class="text-center" colspan="4"><?php echo $text_no_results; ?></td>
                </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
		
      </div>
    </div>
  </div>
</div>
  <script type="text/javascript"><!--
$('.toggle input').on('click', function() {
	//alert($(this).val());
	$.ajax({
		url: 'index.php?route=module/category_toggle/updateToggle&token=<?php echo $token; ?>&toggle=' + this.value + '&category_id=' + $(this).data('category-id'),
		dataType:'json',
		success:function(json){
			if(json['success']){
				alert(json['success']);
			}else{
				alert(json['error']);
			}
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});
});
//--></script> 
<?php echo $footer; ?>