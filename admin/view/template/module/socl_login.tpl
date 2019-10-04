<?php echo $header; ?>

<style type="text/css">
    .network_name {
        display: inline;
        margin-left: 10px;
    }
    
    .required_hide {
        color: #999;
    }
    
    .theme_block {
        margin: 10px 0;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 3px;
        height: 165px;
        overflow: auto;
    }
    
    .theme_block .theme_title {
        font-size: 20px;
        float: left;
    }
    
    .theme_block .btn_apply {
        float: right;
    }
    
    .theme_block .sa_frame {
        float: left;
        width: 100%;
        margin: 15px 0;
        padding: 0 3px;
    }
    
    .theme_block.active {
        border: 3px solid #1872a2;
    }
    
    .fieldset_right {
        float: right;
        font-size: 14px;
        font-weight: bold;
    }
    
    .fieldset_right input {
        margin-right: 5px;
    }
    
    .theme_block .check_theme_applied {
        float: right;
        font-size: 30px;
        color: #009900;
        line-height: 20px;
        margin-left: 15px;
    }
    
    .theme_block .theme_size {
        display: inline-block;
        margin-left: 35px;
        margin-top: 5px;
        font-size: 14px;
    }
    
    .theme_block .btn_custom {
        float: right;
        margin-right: 3px;
        background-color: #aaa;
        color: #FFF;
        border-color: #999;
    }
    
    .theme_block .btn_custom:hover {
        background-color: #999;
    }
</style>

<?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-socl-login" data-toggle="tooltip" title="<?php echo $button_save_all; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
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
            <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-socl-login" class="form-horizontal">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#tab-commonsettings" data-toggle="tab"><?php echo $tab_common_settings; ?></a></li>
                    <li><a href="#tab-apisettings" data-toggle="tab"><?php echo $tab_api_settings; ?></a></li>
                    <li><a href="#tab-managenetwork" data-toggle="tab"><?php echo $tab_manage_network; ?></a></li>
                    <li><a href="#tab-managetheme" data-toggle="tab"><?php echo $tab_manage_theme; ?></a></li>
                </ul>
                
                <div class="tab-content">
                    <div class="tab-pane active" id="tab-commonsettings">
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="input-group"><span data-toggle="tooltip" data-container="#tab-commonsettings" title="<?php echo $help_customer_group; ?>"><?php echo $entry_customer_group; ?></span></label>
                                <div class="col-sm-10">
                                    <select name="soclall_customer_group_id" id="input-group" class="form-control">
                                        <?php foreach($customer_groups as $group){ ?>
                                            <?php if($soclall_customer_group_id == $group['customer_group_id']) { ?>
                                                <option value="<?php echo $group['customer_group_id']; ?>" selected="selected"><?php echo $group['name']; ?></option>
                                            <?php } else { ?>
                                                <option value="<?php echo $group['customer_group_id']; ?>"><?php echo $group['name']; ?></option>
                                        <?php }} ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="input-required"><span data-toggle="tooltip" data-container="#tab-commonsettings" title="<?php echo $help_user_required; ?>"><?php echo $entry_user_required; ?></span></label>
                                <div class="col-sm-10">
                                    <div class="well well-sm" style="height: 315px; overflow: auto;">
                                        <?php foreach($new_user_details as $detail){ ?>
                                            <div class="checkbox">
                                                <label>
                                                    <?php if (is_array($soclall_required_details) && in_array($detail['value'], $soclall_required_details)) { ?>
                                                        <input type="checkbox" name="soclall_required_details[]" value="<?php echo $detail['value']; ?>" checked="checked" />
                                                    <?php } else { ?>
                                                        <input type="checkbox" name="soclall_required_details[]" value="<?php echo $detail['value']; ?>" />
                                                    <?php } ?>
                                                    <?php echo $detail['text']; ?>
                                                </label>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                    </div>
                    
                    <div class="tab-pane" id="tab-apisettings">                    
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="input-apiid"><?php echo $entry_app_id; ?></label>
                                <div class="col-sm-10"><input id="input-apiid" type="text" name="soclall_appid" value="<?php echo $soclall_appid; ?>" class="form-control" /></div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="input-secretkey"><?php echo $entry_secret_key; ?></label>
                                <div class="col-sm-10"><input id="input-secretkey" type="text" name="soclall_secretkey" value="<?php echo $soclall_secretkey; ?>" class="form-control" /></div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">&nbsp;</label>
                                <div class="col-sm-10"><?php echo $text_view_your_dashboard; ?></div>
                            </div> 
                            <div class="form-group">
                                <label class="col-sm-2 control-label"><span data-toggle="tooltip" data-container="#tab-apisettings" title="<?php echo $help_ebay_site; ?>"><?php echo $entry_ebay_site; ?></span></label>
                                <div class="col-sm-10">
                                    <select name="soclall_ebay_site" class="form-control">
                                        <?php foreach($ebay_sites as $key => $value) { ?>
                                            <option value="<?php echo $key; ?>" <?php if($key == $soclall_ebay_site) { ?>selected="selected"<?php } ?>><?php echo $value; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>                       
                    </div>
                    
                    <div class="tab-pane" id="tab-managenetwork">
                        <fieldset>
                            <legend><?php echo $help_tab_manage_network; ?>
                                <div class="fieldset_right">
                                    <input type="checkbox" onchange="soclLoginSelectAll(this)" /><?php echo $text_select_all; ?>
                                </div>
                            </legend>
                            <?php if(count($networks)) { foreach($networks as $network) { ?>
                            <div class="form-group sa-default">
                                <label class="col-sm-2" for="input-name" style="margin-bottom: 0;">
                                    <span class="sa sa-<?php echo $network['code']; ?>"></span>
                                    <div class="network_name"><?php echo $network['name']; ?></div>
                                </label>
                                <div class="col-sm-10" style="line-height: 32px;">
                                    <?php if (is_array($soclall_enabled_network) && in_array($network['code'], $soclall_enabled_network)) { ?>
                                    <input type="checkbox" name="soclall_enabled_network[]" value="<?php echo $network['code']; ?>" checked="checked" />
                                    <?php } else { ?>
                                    <input type="checkbox" name="soclall_enabled_network[]" value="<?php echo $network['code']; ?>" />
                                    <?php } ?>
                                </div>
                            </div>
                            <?php }} ?>
                        </fieldset>
                    </div>
                    
                    <div class="tab-pane" id="tab-managetheme">
                        <input type="hidden" name="soclall_theme_applied" value="<?php echo $soclall_theme_applied; ?>" />
                        <input type="hidden" name="soclall_theme_resize" value="<?php echo $soclall_theme_resize; ?>" />
                        <input type="hidden" name="soclall_theme_custom_col" value="<?php echo $soclall_theme_custom_col; ?>" />
                        <input type="hidden" name="soclall_theme_custom_width" value="<?php echo $soclall_theme_custom_width; ?>" />
                        <input type="hidden" name="soclall_theme_custom_text" value="<?php echo $soclall_theme_custom_text; ?>" />
                        <input type="hidden" name="soclall_theme_custom_align" value="<?php echo $soclall_theme_custom_align; ?>" />
                        <input type="hidden" name="soclall_theme_custom_position" value="<?php echo $soclall_theme_custom_position; ?>" />
                        
                        <div id="soclall_manage_theme">
                        <?php $theme_no = 1; foreach($theme as $item) { ?>
                            <div class="col-xs-6">
                                <div class="theme_block <?php if($item == $soclall_theme_applied) { ?>active<?php } ?>">
                                    <span class="theme_title"><?php echo $theme_title_no . $theme_no; ?></span>
                                    <?php if(in_array($item, $themes_resize) && $item != 'no7') { ?>
                                        <div class="theme_size">
                                            <span><?php echo $text_custom_size; ?></span>
                                            <select onchange="soclLoginResizeTheme( this, '<?php echo $item; ?>' )">
                                                <?php foreach($theme_sizes as $size) { ?>
                                                    <option value="<?php echo $size; ?>" <?php if( $item == $soclall_theme_applied && $size == $soclall_theme_resize ) { ?>selected="selected"<?php } ?>><?php echo $size . "%"; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    <?php } ?>
                                    <button type="button" class="btn btn-primary btn_apply" onclick="soclLoginApplyTheme(this, '<?php echo $item; ?>')" <?php if($item == $soclall_theme_applied) { ?>style="display: none;"<?php } ?> ><?php echo $button_apply; ?></button>
                                    <span class="fa fa-check check_theme_applied" <?php if($item != $soclall_theme_applied) { ?>style="display: none;"<?php } ?>></span>
                                    <?php if(in_array($item, $themes_custom)) { ?>
                                        <button type="button" class="btn btn_custom" onclick="soclLoginCustomTheme(this, '<?php echo $item; ?>')"><?php echo $button_custom; ?></button>
                                    <?php } ?>
                                    <div class="sa_frame">
                                        <div class="sa-<?php echo $item; ?>">
                                            <?php if(count($networks)) { foreach($networks as $network) { ?>
                                                <?php if(in_array($item, $themes_custom)) { ?>
                                                    <div class="col col<?php echo ($item == $soclall_theme_applied) ? $soclall_theme_custom_col : '1'; ?> pos-<?php echo ($item == $soclall_theme_applied) ? $soclall_theme_custom_position : 'c'; ?>">
                                                        <span class="sa <?php if(in_array($item, $themes_resize)) { ?>sa-<?php echo ($item == $soclall_theme_applied) ? $soclall_theme_resize : $theme_sizes[0]; } ?> sa-<?php echo $network['code']; ?> txt-<?php echo ($item == $soclall_theme_applied) ? $soclall_theme_custom_align : 'l'; ?>" style="width: <?php echo ($item == $soclall_theme_applied) ? $soclall_theme_custom_width : '100'; ?>%">
                                                            <?php echo ($item == $soclall_theme_applied) ? $soclall_theme_custom_text : $text_default_theme_button; ?><span>&nbsp;<?php echo $network['name']; ?></span>
                                                        </span>
                                                    </div>
                                                <?php } else { ?>
                                                    <span class="sa <?php if(in_array($item, $themes_resize)) { ?>sa-<?php echo ($item == $soclall_theme_applied) ? $soclall_theme_resize : $theme_sizes[0]; } ?> sa-<?php echo $network['code']; ?>"></span>
                                            <?php }}} ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php $theme_no++; } ?>
                        </div>
                    
                        <div id="soclall_customize_theme" style="display: none;">
                            <div style="margin-bottom: 15px;"><span style="font-size: 18px;"><?php echo $text_customize_theme; ?></span>
                                <div class="fieldset_right">
                                    <button type="button" class="btn btn-primary" onclick="soclLoginDoneCustomize()"><?php echo $button_done; ?></button>
                                    <button type="button" class="btn btn-default" onclick="soclLoginCancelCustomize()"><?php echo $button_cancel; ?></button>
                                </div>
                            </div>
                            <div class="form-group" style="display: none;">
                                <label class="col-sm-2 control-label" for="input-cussize"><?php echo $text_custom_size; ?></label>
                                <div class="col-sm-10">
                                    <select id="input-cussize" class="form-control">
                                        <?php foreach($theme_sizes as $size) { ?>
                                            <option value="<?php echo $size; ?>"><?php echo $size . "%"; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="input-cuscol"><?php echo $entry_custom_col; ?></label>
                                <div class="col-sm-10">
                                    <select id="input-cuscol" class="form-control">
                                        <?php for($i = 1; $i <= 5; $i++) { ?>
                                            <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="input-cuswidth"><?php echo $entry_custom_width; ?></label>
                                <div class="col-sm-10"><input id="input-cuswidth" type="text" value="" class="form-control" /></div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="input-custext"><?php echo $entry_custom_text; ?></label>
                                <div class="col-sm-10"><input id="input-custext" type="text" value="" class="form-control" /></div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="input-cusalign"><?php echo $entry_custom_align; ?></label>
                                <div class="col-sm-10">
                                    <select id="input-cusalign" class="form-control">
                                        <?php foreach($themes_custom_position as $key => $value) { ?>
                                            <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="input-cusposition"><?php echo $entry_custom_position; ?></label>
                                <div class="col-sm-10">
                                    <select id="input-cusposition" class="form-control">
                                        <?php foreach($themes_custom_position as $key => $value) { ?>
                                            <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div id="soclall_customize_theme_review" class="form-group" style="padding: 20px 15px;"></div>
                        </div>
                    </div>
                    
                </div>
            </form>
        </div>
    </div>
  </div>
</div>	

<script type="text/javascript"> 
//**
    var soclall_customize_theme = '';
    var soclall_customize_theme_history = {};
    
    $(document).ready(function() {
        $('#tab-commonsettings input[type=checkbox]').each( function() {
            if(!$(this).is(':checked')) {
                $(this).parent().addClass('required_hide');
            }
        });
            
        $('#tab-commonsettings input[type=checkbox]').change(function() {
            if($(this).val() == 'country' && !$(this).is(':checked')) {
                $('#tab-commonsettings input[type=checkbox][value=\'postcode\']').removeAttr('checked').parent().addClass('required_hide');
                $('#tab-commonsettings input[type=checkbox][value=\'region\']').removeAttr('checked').parent().addClass('required_hide');
            }
            
            if($(this).is(':checked')) {
                $(this).parent().removeClass('required_hide');
            } else {
                $(this).parent().addClass('required_hide');
            }
        });  
        
        //**
        $('#soclall_customize_theme select#input-cuscol').change(function() {
            var col = $(this).val();
            var review = $('#soclall_customize_theme_review div.col');
            for( i = 1; i <= 5; i++ ) {
                if( review.hasClass('col' + i) ) {
                    review.removeClass( 'col' + i );
                    break;
                }
            }
            
            review.addClass('col' + col);
        });
        
        $('#soclall_customize_theme select#input-cusposition').change(function() {
            var pos = $(this).val();
            var review = $('#soclall_customize_theme_review div.col');
            
            var position = ['l','c','r'];
            for( i = 0; i < position.length; i++ ) {
                if( review.hasClass('pos-' + position[i]) ) {
                    review.removeClass( 'pos-' + position[i] );
                    break;
                }
            }
            
            review.addClass('pos-' + pos);
        });
        
        $('#soclall_customize_theme select#input-cusalign').change(function() {
            var align = $(this).val();
            var review = $('#soclall_customize_theme_review span.sa');
            
            var position = ['l','c','r'];
            for( i = 0; i < position.length; i++ ) {
                if( review.hasClass('txt-' + position[i]) ) {
                    review.removeClass( 'txt-' + position[i] );
                    break;
                }
            }
            
            review.addClass('txt-' + align);
        });
        
        $('#soclall_customize_theme select#input-cussize').change(function() {
            var size = $(this).val();
            var review = $('#soclall_customize_theme_review span.sa');
            
            var sizes = ['100','75','50'];
            for( i = 0; i < sizes.length; i++ ) {
                if( review.hasClass('sa-' + sizes[i]) ) {
                    review.removeClass( 'sa-' + sizes[i] );
                    break;
                }
            }
                
            review.addClass( 'sa-' + size );
        });
        
        $('#soclall_customize_theme input#input-custext').keyup(function() {
            var btn_text = $(this).val();
            if(!btn_text.trim().length)
                btn_text = '<?php echo $text_default_theme_button; ?>';
            
            $('#soclall_customize_theme_review span.sa').each(function() {
                network_text = $(this).find('span').html();
                $(this).html(btn_text + '<span>' + network_text + '</span>');
            });
        });
        
        $('#soclall_customize_theme input#input-cuswidth').keyup(function() {
            var btn_width = $(this).val();
            $('#soclall_customize_theme_review span.sa').css('width', btn_width + '%');
        });
    });    
    
    function soclLoginApplyTheme( ele, theme ) {
        $('input[name=\'soclall_theme_applied\']').val(theme);
        
        $('div.theme_block').removeClass('active');
        $(ele).parent().addClass('active');
        
        $('div.theme_block button').show();
        $(ele).hide();
        
        $('div.theme_block span.check_theme_applied').hide();
        $(ele).parent().find('span.check_theme_applied').show();
        
        if($(ele).parent().find('select').length)
            $('input[name=\'soclall_theme_resize\']').val($(ele).parent().find('select').val());
            
        if($(ele).parent().find('button.btn_custom').length) {
            var customized = (soclall_customize_theme_history[theme]) ? soclall_customize_theme_history[theme] : {size: '100', col: '1', width: '100', text: '<?php echo $text_default_theme_button; ?>', align: 'l', position: 'c'};
            soclLoginSetInput(theme, customized);
        }
    }
    
    function soclLoginSelectAll( ele ) {
        var select_all = $(ele).prop('checked');
        $('input[name=\'soclall_enabled_network[]\']').prop('checked', select_all);
    }
    
    function soclLoginResizeTheme( ele, check ) {
        var resize = $(ele).val();
        var theme = $(ele).parent().parent().find('div.sa_frame span');
            
        if(check == $('input[name=\'soclall_theme_applied\']').val())
            $('input[name=\'soclall_theme_resize\']').val(resize);
            
        var sizes = ['100','75','50'];
        for( i = 0; i < sizes.length; i++ ) {
            if( theme.hasClass('sa-' + sizes[i]) ) {
                theme.removeClass( 'sa-' + sizes[i] );
                break;
            }
        }
            
        theme.addClass( 'sa-' + resize );
    }
    
    function soclLoginCustomTheme( ele, theme ) {
        soclall_customize_theme = theme;
        
        var new_customized = {}; 
        if(soclall_customize_theme_history[theme])
            new_customized = soclall_customize_theme_history[theme];
        else {
            if(theme == '<?php echo $soclall_theme_applied; ?>')
                new_customized = {size: '<?php echo $soclall_theme_resize; ?>', col: '<?php echo $soclall_theme_custom_col; ?>', width: '<?php echo $soclall_theme_custom_width; ?>', text: '<?php echo $soclall_theme_custom_text; ?>', align: '<?php echo $soclall_theme_custom_align; ?>', position: '<?php echo $soclall_theme_custom_position; ?>'};
            else new_customized = {size: '100', col: '1', width: '100', text: '<?php echo $text_default_theme_button; ?>', align: 'l', position: 'c'};
            
            soclall_customize_theme_history[theme] = new_customized;
        }
        
        var icons_content = $(ele).parent().find('div.sa_frame').html();
        $('div#soclall_customize_theme_review').html(icons_content);
        
        if(theme == 'no7')
            $('#soclall_customize_theme select#input-cussize').parent().parent().show();
        else $('#soclall_customize_theme select#input-cussize').parent().parent().hide();
            
        if(theme == 'no7')
            $('#soclall_customize_theme select#input-cussize').val(new_customized.size);
            
        $('#soclall_customize_theme select#input-cuscol').val(new_customized.col);
        $('#soclall_customize_theme input#input-custext').val(new_customized.text);
        $('#soclall_customize_theme select#input-cusalign').val(new_customized.align);
        $('#soclall_customize_theme select#input-cusposition').val(new_customized.position);
        $('#soclall_customize_theme input#input-cuswidth').val(new_customized.width);
        
        $('div#soclall_manage_theme').hide();
        $('div#soclall_customize_theme').show(1000);
    }
    
    function soclLoginCancelCustomize() {
        $('div#soclall_customize_theme').hide();
        $('div#soclall_manage_theme').show(1000);
    }
    
    function soclLoginDoneCustomize() {
        var icons_content = $('div#soclall_customize_theme_review .sa-' + soclall_customize_theme).html();
        $('div#soclall_manage_theme .theme_block .sa-' + soclall_customize_theme).html(icons_content);
        
        soclall_customize_theme_history[soclall_customize_theme].col = $('#soclall_customize_theme select#input-cuscol').val();
        soclall_customize_theme_history[soclall_customize_theme].position = $('#soclall_customize_theme select#input-cusposition').val();
        soclall_customize_theme_history[soclall_customize_theme].align = $('#soclall_customize_theme select#input-cusalign').val();
        soclall_customize_theme_history[soclall_customize_theme].size = $('#soclall_customize_theme select#input-cussize').val();
        soclall_customize_theme_history[soclall_customize_theme].text = $('#soclall_customize_theme input#input-custext').val();
        soclall_customize_theme_history[soclall_customize_theme].width = $('#soclall_customize_theme input#input-cuswidth').val();
        
        if(soclall_customize_theme == $('input[name=\'soclall_theme_applied\']').val())
            soclLoginSetInput(soclall_customize_theme, soclall_customize_theme_history[soclall_customize_theme]);
            
        soclLoginCancelCustomize();
    }
    
    function soclLoginSetInput(theme, customized) {
        if(theme == 'no7')
            $('input[name=\'soclall_theme_resize\']').val(customized.size);
        $('input[name=\'soclall_theme_custom_col\']').val(customized.col);
        $('input[name=\'soclall_theme_custom_width\']').val(customized.width);
        $('input[name=\'soclall_theme_custom_text\']').val(customized.text);
        $('input[name=\'soclall_theme_custom_align\']').val(customized.align);
        $('input[name=\'soclall_theme_custom_position\']').val(customized.position);
    }
</script>							
<?php echo $footer; ?>