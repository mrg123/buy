<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-butopbanner" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
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
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-butopbanner" class="form-horizontal">
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-name"><?php echo $entry_name; ?></label>
            <div class="col-sm-10">
              <input type="text" name="name" value="<?php echo $name; ?>" placeholder="<?php echo $entry_name; ?>" id="input-name" class="form-control" />
              <?php if ($error_name) { ?>
              <div class="text-danger"><?php echo $error_name; ?></div>
              <?php } ?>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-status"><?php echo $entry_status; ?></label>
            <div class="col-sm-10">
                <select name="status" id="input-status" class="form-control">
                    <?php if ($status) { ?>
                    <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                    <option value="0"><?php echo $text_disabled; ?></option>
                    <?php } else { ?>
                    <option value="1"><?php echo $text_enabled; ?></option>
                    <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                    <?php } ?>
                </select>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-2">
              <ul class="nav nav-pills nav-stacked" id="module">
                <?php $module_row = 1; ?>
                <?php foreach ($butopbanner_modules as $butopbanner_module) { ?>
                <li><a href="#tab-module<?php echo $butopbanner_module['key']; ?>" data-toggle="tab"><i class="fa fa-minus-circle" onclick="$('a[href=\'#tab-module<?php echo $butopbanner_module['key']; ?>\']').parent().remove(); $('#tab-module<?php echo $butopbanner_module['key']; ?>').remove(); $('#module a:first').tab('show');"></i> <?php echo $tab_module . ' ' . $module_row; ?></a></li>
                <?php $module_row++; ?>
                <?php } ?>
                <li id="module-add"><a onclick="addModule();"><i class="fa fa-plus-circle"></i> <?php echo $button_module_add; ?></a></li>
              </ul>
            </div>
            <div class="col-sm-10">
              <div class="tab-content">
                <?php foreach ($butopbanner_modules as $butopbanner_module) { ?>
                <div class="tab-pane" id="tab-module<?php echo $butopbanner_module['key']; ?>">
                  <ul class="nav nav-tabs" id="language<?php echo $butopbanner_module['key']; ?>">
                    <?php foreach ($languages as $language) { ?>
                    <li><a href="#tab-module<?php echo $butopbanner_module['key']; ?>-language<?php echo $language['language_id']; ?>" data-toggle="tab"><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" /> <?php echo $language['name']; ?></a></li>
                    <?php } ?>
                  </ul>
                  <div class="tab-content">
                    <?php foreach ($languages as $language) { ?>
                    <div class="tab-pane" id="tab-module<?php echo $butopbanner_module['key']; ?>-language<?php echo $language['language_id']; ?>">
                      <div class="form-group">
                        <label class="col-sm-2 control-label" for="input-heading<?php echo $butopbanner_module['key']; ?>-language<?php echo $language['language_id']; ?>"><?php echo $entry_heading; ?></label>
                        <div class="col-sm-10">
                          <input type="text" name="butopbanner_module[<?php echo $butopbanner_module['key']; ?>][heading][<?php echo $language['language_id']; ?>]" placeholder="<?php echo $entry_heading; ?>" id="input-heading<?php echo $butopbanner_module['key']; ?>-language<?php echo $language['language_id']; ?>" value="<?php echo isset($butopbanner_module['heading'][$language['language_id']]) ? $butopbanner_module['heading'][$language['language_id']] : ''; ?>" class="form-control" />
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="col-sm-2 control-label" for="input-description<?php echo $butopbanner_module['key']; ?>-language<?php echo $language['language_id']; ?>"><?php echo $entry_description; ?></label>
                        <div class="col-sm-10">
                          <textarea name="butopbanner_module[<?php echo $butopbanner_module['key']; ?>][description][<?php echo $language['language_id']; ?>]" placeholder="<?php echo $entry_description; ?>" id="input-description<?php echo $butopbanner_module['key']; ?>-language<?php echo $language['language_id']; ?>" class="form-control"><?php echo isset($butopbanner_module['description'][$language['language_id']]) ? $butopbanner_module['description'][$language['language_id']] : ''; ?></textarea>
                        </div>
                      </div>
                        <div class="form-group">
                                <label class="col-sm-2 control-label" for="input-status"><?php echo $entry_url; ?></label>
                                <div class="col-sm-10">
                                    <input type="text" placeholder="http://" name="butopbanner_module[<?php echo $butopbanner_module['key']; ?>][link][<?php echo $language['language_id']; ?>]" value="<?php if(isset($butopbanner_module['link'][$language['language_id']]) && $butopbanner_module['link'][$language['language_id']] !='') echo $butopbanner_module['link'][$language['language_id']]; else echo ''; ?> " id="input-url" />
                                </div>
                        </div>

						<div class="form-group">
						<label class="col-sm-2 control-label" for="input-image"><?php echo $entry_image; ?></label>
							<div class="col-sm-10">
						<a href="" id="thumb-image_<?php echo $butopbanner_module['key']; ?>_<?php echo $language['language_id']; ?>" data-toggle="image" class="img-thumbnail">
<img width="100" height="100" src="<?php if(isset($butopbanner_module['slider_image'][$language['language_id']]) && trim($butopbanner_module['slider_image'][$language['language_id']]) !='') { echo HTTPS_CATALOG .'image/' . $butopbanner_module['slider_image'][$language['language_id']]; } else { ?><?php echo HTTPS_CATALOG ?>image/cache/no_image-100x100.png <?php } ?>" alt="no image" title="browse image" data-placeholder="browse image" />
						</a>
						<input type="hidden" name="butopbanner_module[<?php echo $butopbanner_module['key']; ?>][slider_image][<?php echo $language['language_id']; ?>]" value="<?php echo isset($butopbanner_module['slider_image'][$language['language_id']]) ? $butopbanner_module['slider_image'][$language['language_id']] : ''; ?>" id="input-image_<?php echo $butopbanner_module['key']; ?>_<?php echo $language['language_id']; ?>" /> 
							</div>
						</div>
						
						<div class="form-group">
						<label class="col-sm-2 control-label" for="input-image2">Toggle <?php echo $entry_image; ?></label>
							<div class="col-sm-10">
						<a href="" id="thumb-image2_<?php echo $butopbanner_module['key']; ?>_<?php echo $language['language_id']; ?>" data-toggle="image" class="img-thumbnail">
<img width="100" height="100" src="<?php if(isset($butopbanner_module['slider_image2'][$language['language_id']]) && trim($butopbanner_module['slider_image2'][$language['language_id']]) !='') { echo HTTPS_CATALOG .'image/' . $butopbanner_module['slider_image2'][$language['language_id']]; } else { ?><?php echo HTTPS_CATALOG ?>image/cache/no_image-100x100.png <?php } ?>" alt="no image" title="browse image" data-placeholder="browse image" />
						</a>
						<input type="hidden" name="butopbanner_module[<?php echo $butopbanner_module['key']; ?>][slider_image2][<?php echo $language['language_id']; ?>]" value="<?php echo isset($butopbanner_module['slider_image2'][$language['language_id']]) ? $butopbanner_module['slider_image2'][$language['language_id']] : ''; ?>" id="input-image2_<?php echo $butopbanner_module['key']; ?>_<?php echo $language['language_id']; ?>" /> 
							</div>
						</div>
						

                    </div>
                    <?php } ?>
                  </div>
                </div>
                <?php } ?>
              </div>
            </div>

          </div>
        </form>
      </div>
    </div>
  </div>
  <script type="text/javascript"><!--
<?php foreach ($butopbanner_modules as $butopbanner_module) { ?>
<?php foreach ($languages as $language) { ?>
$('#input-description<?php echo $butopbanner_module['key']; ?>-language<?php echo $language['language_id']; ?>').summernote({
	height: 300
});
<?php } ?>
<?php } ?>
//--></script> 
  <script type="text/javascript"><!--
  var module_row = <?php echo $module_row; ?>;
  
function addModule() {
	var token = Math.random().toString(36).substr(2);
	
	butopbanner  = '<div class="tab-pane" id="tab-module' + token + '">';
	butopbanner += '  <ul class="nav nav-tabs" id="language' + token + '">';
    <?php foreach ($languages as $language) { ?>
    butopbanner += '    <li><a href="#tab-module' + token + '-language<?php echo $language['language_id']; ?>" data-toggle="tab"><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" /> <?php echo $language['name']; ?></a></li>';
    <?php } ?>
	butopbanner += '  </ul>';

	butopbanner += '  <div class="tab-content">';

	<?php foreach ($languages as $language) { ?>
	butopbanner += '    <div class="tab-pane" id="tab-module' + token + '-language<?php echo $language['language_id']; ?>">';
	butopbanner += '      <div class="form-group">';
	butopbanner += '        <label class="col-sm-2 control-label" for="input-heading' + token + '-language<?php echo $language['language_id']; ?>"><?php echo $entry_heading; ?></label>';
	butopbanner += '        <div class="col-sm-10"><input type="text" name="butopbanner_module[' + token + '][heading][<?php echo $language['language_id']; ?>]" placeholder="<?php echo $entry_heading; ?>" id="input-heading' + token + '-language<?php echo $language['language_id']; ?>" value="" class="form-control"/></div>';
	butopbanner += '      </div>';
	butopbanner += '      <div class="form-group">';
	butopbanner += '        <label class="col-sm-2 control-label" for="input-description' + token + '-language<?php echo $language['language_id']; ?>"><?php echo $entry_description; ?></label>';
	butopbanner += '        <div class="col-sm-10"><textarea name="butopbanner_module[' + token + '][description][<?php echo $language['language_id']; ?>]" placeholder="<?php echo $entry_description; ?>" id="input-description' + token + '-language<?php echo $language['language_id']; ?>"></textarea></div>';
	butopbanner += '      </div>';
        butopbanner += '      <div class="form-group">';
        butopbanner += '        <label class="col-sm-2 control-label" for="input-link' + token + '-language<?php echo $language['language_id']; ?>"><?php echo $entry_url; ?></label>';
        butopbanner += '        <div class="col-sm-10"><input placeholder="http://" type="text" name="butopbanner_module[' + token + '][link][<?php echo $language['language_id']; ?>]" value="" id="input-url" /></div>';
        butopbanner += '      </div>';
        butopbanner += '      <div class="form-group">';
        butopbanner += '        <label class="col-sm-2 control-label" for="input-image' + token + '-language<?php echo $language['language_id']; ?>"><?php echo $entry_image; ?></label>';
        butopbanner += '        <div class="col-sm-10"><a href="" id="thumb-image_' + token + '_<?php echo $language['language_id']; ?>" data-toggle="image" class="img-thumbnail"><img width="100" height="100" src="<?php echo HTTPS_CATALOG ?>image/cache/no_image-100x100.png" alt="no image" title="browse image" data-placeholder="browse image" /></a><input type="hidden" name="butopbanner_module[' + token + '][slider_image][<?php echo $language['language_id']; ?>]" value="" id="input-image_' + token + '_<?php echo $language['language_id']; ?>" /></div>';
        butopbanner += '      </div>';
		
		butopbanner += '      <div class="form-group">';
        butopbanner += '        <label class="col-sm-2 control-label" for="input-image2' + token + '-language<?php echo $language['language_id']; ?>">Toggle <?php echo $entry_image; ?></label>';
        butopbanner += '        <div class="col-sm-10"><a href="" id="thumb-image2_' + token + '_<?php echo $language['language_id']; ?>" data-toggle="image" class="img-thumbnail"><img width="100" height="100" src="<?php echo HTTPS_CATALOG ?>image/cache/no_image-100x100.png" alt="no image" title="browse image" data-placeholder="browse image" /></a><input type="hidden" name="butopbanner_module[' + token + '][slider_image2][<?php echo $language['language_id']; ?>]" value="" id="input-image2_' + token + '_<?php echo $language['language_id']; ?>" /></div>';
        butopbanner += '      </div>';
        
	butopbanner += '    </div>';
	<?php } ?>

	butopbanner += '  </div>';
	butopbanner += '</div>';

	//$('.tab-content:first-child').prepend(butopbanner);
	$('.tab-content:first-child').append(butopbanner);

	<?php foreach ($languages as $language) { ?>
	$('#input-description' + token + '-language<?php echo $language['language_id']; ?>').summernote({
		height: 300
	});
	<?php } ?>

	$('#module-add').before('<li><a href="#tab-module' + token + '" data-toggle="tab"><i class="fa fa-minus-circle" onclick="$(\'a[href=\\\'#tab-module' + token + '\\\']\').parent().remove(); $(\'#tab-module' + token + '\').remove(); $(\'#module a:first\').tab(\'show\');"></i> <?php echo $tab_module; ?> ' + module_row + '</a></li>');

	$('#module a[href=\'#tab-module' + token + '\']').tab('show');

	$('#language' + token + ' li:first-child a').tab('show');

	module_row++;
}
//--></script> 
  <script type="text/javascript"><!--
$('#module li:first-child a').tab('show');
<?php foreach ($butopbanner_modules as $butopbanner_module) { ?>
$('#language<?php echo $butopbanner_module['key']; ?> li:first-child a').tab('show');
<?php } ?>
//--></script></div>
<?php echo $footer; ?>