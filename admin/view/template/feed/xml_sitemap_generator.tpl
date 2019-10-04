<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  
  <div id="XmlSitemapGenerator">
        
    <div class="page-header">
      <div class="container-fluid">
        <div class="pull-right">
          <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a>
        </div>
        <h1><?php echo $heading_title; ?> <span class="version badge"><?php echo $version; ?></span></h1>
        <ul class="breadcrumb">
          <?php foreach ($breadcrumbs as $breadcrumb) { ?>
            <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
          <?php } ?>
        </ul> 
      </div>
    </div>        
        
    <div class="container-fluid">
      <?php if ($error_warning) { ?>
        <div class="alert alert-danger alert-dismissible"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
          <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
      <?php } ?>

      <?php if ($success) { ?>
        <div class="alert alert-success alert-dismissible"><i class="fa fa-check-circle"></i> <?php echo $success; ?>
          <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
      <?php } ?>    
      
      <div id="fountainG" class="ajax-loader">
        <div id="fountainG_1" class="fountainG"></div>
        <div id="fountainG_2" class="fountainG"></div>
        <div id="fountainG_3" class="fountainG"></div>
        <div id="fountainG_4" class="fountainG"></div>
        <div id="fountainG_5" class="fountainG"></div>
        <div id="fountainG_6" class="fountainG"></div>
        <div id="fountainG_7" class="fountainG"></div>
        <div id="fountainG_8" class="fountainG"></div>
      </div>      
      
      <div class="panel panel-default">
        <div class="panel-heading">
          <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_edit; ?></h3>
        </div>
        <div class="panel-body">
          
          <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-<?php echo $code; ?>" class="form-horizontal" autocomplete="off">
          
            <ul id="global-tabs" class="nav nav-tabs">
              <li class="active"><a href="#tab-sitemap-settings" data-toggle="tab"><i class="fa fa-cog darker-gray" aria-hidden="true"></i><?php echo $tab_sitemap_settings; ?></a></li>
              <li class="no-tab-content"><a href="<?php echo $base_sitemap_index_url; ?>" target="_blank"><i class="fa fa-sitemap green" aria-hidden="true"></i><?php echo $tab_view_sitemap; ?></a></li>
              <li><a href="#tab-pages" data-toggle="tab"><i class="fa fa-files-o aqua-green" aria-hidden="true"></i><?php echo $tab_pages; ?></a></li>
              <li><a href="#tab-config" data-toggle="tab"><i class="fa fa-cog violet" aria-hidden="true"></i><?php echo $tab_config; ?></a></li>
              <li><a href="#tab-help" data-toggle="tab"><i class="fa fa-life-ring marine-blue" aria-hidden="true"></i><?php echo $tab_help; ?> <span class="badge badge-tab-help"></span></a></li>
            </ul>

            <div class="tab-content">
            
              <div id="tab-sitemap-settings" class="tab-pane active">
                
                <div class="well well-sm">
                  <div class="text-right">
                    <button type="button" data-toggle="tooltip" title="<?php echo $button_generat_sitemaps; ?>" class="btn btn-success btn-generate-sitemaps"><i class="fa fa-refresh" aria-hidden="true"></i></button>
                  </div>
                </div>
                  
                <div class="space-10"></div>                
                
                <div id="progress">
                  <div class="progress-info" style="display: none;">
                    <div class="progress-message"></div>
                    <div class="progress-items-completed" style="display: none;"></div>
                    <div class="progress-time-reporting" style="display: none;"></div>
                  </div>
                  <div class="progress " style="display: none;">
                    <div class="progress-bar progress-bar-success progress-bar-striped active" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%">0%</div>
                  </div>
                </div>
                
                <div class="table-responsive">
                  <table id="table-sitemap-settings" class="table table-hover">
                    <colgroup>
                      <col span="1" style="width: 5%;">
                      <col span="1" style="width: 13%;">
                      <col span="1" style="width: 13%;">
                      <col span="1" style="width: 13%;">
                      <col span="1" style="width: 13%;">
                      <col span="1" style="width: 15%;">
                      <col span="1" style="width: 13%;">
                      <col span="1" style="width: 15%;">
                    </colgroup>
                    <thead>
                      <tr>
                        <td class="text-center"><input type="checkbox" class="check-all" /></td>
                        <td class="text-left"><?php echo $column_name; ?></td>
                        <td class="text-left"><?php echo $column_changefreq; ?></td>
                        <td class="text-left"><?php echo $column_priority; ?></td>
                        <td class="text-left"><?php echo $column_url_limit; ?></td>
                        <td class="text-left"><?php echo $column_stores; ?></td>
                        <td class="text-left"><?php echo $column_lastmod; ?></td>
                        <td class="text-right"><?php echo $column_action; ?></td>
                      </tr>
                    </thead>
                    <tfoot>
                      <tr>
                        <td colspan="8" class="text-right"></td>
                      </tr>
                    </tfoot>                    
                    <tbody>
                      <?php foreach ($sitemap_settings as $sitemap_setting) { ?>
                        <tr id="sitemap-setting-<?php echo $sitemap_setting['type']; ?>" data-type="<?php echo $sitemap_setting['type']; ?>">
                          <td class="text-center"><input type="checkbox" name="selected[]" value="" /></td>
                          <td class="text-left">
                            <div id="entry-sitemap-setting-<?php echo $sitemap_setting['type']; ?>-name">
                              <?php echo $sitemap_setting['name']; ?>
                            </div>
                          </td>
                          <td class="text-left">
                            <div id="entry-sitemap-setting-<?php echo $sitemap_setting['type']; ?>-changefreq" class="read-only-field">
                              <?php echo $sitemap_setting['changefreq']; ?>
                            </div>
                            <div class="edit-only-field">
                              <select id="input-sitemap-setting-<?php echo $sitemap_setting['type']; ?>-changefreq" class="input-sitemap-setting-changefreq form-control">
                                <?php foreach ($changefreqs as $value) { ?>
                                  <option value="<?php echo $value; ?>" <?php echo ($sitemap_setting['changefreq'] == $value) ? 'selected' : ''; ?>><?php echo $value; ?></option>
                                <?php } ?>
                              </select>
                            </div>
                          </td>
                          <td class="text-left">
                            <div id="entry-sitemap-setting-<?php echo $sitemap_setting['type']; ?>-priority" class="read-only-field">
                              <?php echo $sitemap_setting['priority']; ?>
                            </div>
                            <div class="edit-only-field">
                              <select id="input-sitemap-setting-<?php echo $sitemap_setting['type']; ?>-priority" class="input-sitemap-setting-priority form-control">
                                <?php foreach ($priorities as $value) { ?>
                                  <option value="<?php echo $value; ?>" <?php echo ($sitemap_setting['priority'] == $value) ? 'selected' : ''; ?>><?php echo $value; ?></option>
                                <?php } ?>
                              </select>
                            </div>
                          </td>
                          <td class="text-left">
                            <div id="entry-sitemap-setting-<?php echo $sitemap_setting['type']; ?>-url-limit" class="read-only-field">
                              <?php echo $sitemap_setting['url_limit']; ?>
                            </div>
                            <div class="edit-only-field">
                              <input type="number" value="<?php echo $sitemap_setting['url_limit']; ?>" placeholder="" id="input-sitemap-setting-<?php echo $sitemap_setting['type']; ?>-url-limit" class="input-sitemap-setting-url-limit form-control" min="0" max="50000" step="100" />
                            </div>
                          </td>
                          <td class="text-left">
                            <select id="input-sitemap-setting-<?php echo $sitemap_setting['type']; ?>-sitemap-setting-store" class="input-sitemap-setting-sitemap-setting-store form-control" multiple="multiple">
                              <?php foreach ($stores as $store) { ?>
                                <?php if (in_array($store['store_id'], $sitemap_setting['stores'])) { ?>
                                  <option value="<?php echo $store['store_id']; ?>" selected><?php echo $store['name']; ?></option>
                                <?php } else { ?>
                                  <option value="<?php echo $store['store_id']; ?>"><?php echo $store['name']; ?></option>
                                <?php } ?>
                              <?php } ?>
                            </select>
                          </td>
                          <td class="text-left">
                            <div id="entry-sitemap-setting-<?php echo $sitemap_setting['type']; ?>-lastmod">
                              <?php echo $sitemap_setting['lastmod']; ?>
                            </div>                            
                          </td>
                          <td class="text-right">
                            <button type="button" data-toggle="tooltip" title="<?php echo $button_apply; ?>" class="btn btn-info btn-sitemap-setting-apply"><i class="fa fa-check" aria-hidden="true"></i></button>
                            <button type="button" data-toggle="tooltip" title="<?php echo $button_edit; ?>" class="btn btn-primary btn-sitemap-setting-edit"><i class="fa fa-pencil" aria-hidden="true"></i></button>
                            <button type="button" data-toggle="tooltip" title="<?php echo $button_generat_sitemap; ?>" class="btn btn-success btn-generate-sitemap" <?php echo $config[$code . '_status'] ? '' : 'disabled'; ?>><i class="fa fa-refresh" aria-hidden="true"></i></button>
                          </td>
                        </tr>
                      <?php } ?>
                    </tbody>
                  </table>
                </div>
                  
              </div>
              <!-- /.tab-pane -->                 
              
              <div id="tab-pages" class="tab-pane">
                
                <div id="content-pages"></div>

              </div>
              <!-- /.tab-pane -->
              
              <div id="tab-config" class="tab-pane">

                <fieldset>
                  <legend><?php echo $text_general; ?></legend>
                  
                  <div class="form-group">
                    <label class="col-sm-2 control-label" for="input-config-status">
                      <span data-toggle="tooltip" title="<?php echo $help_config_status; ?>"><?php echo $entry_config_status; ?></span>
                    </label>
                    <div class="col-sm-4">
                      <select name="config[<?php echo $code; ?>_status]" id="input-config-status" class="form-control">
                        <?php if ($config[$code . '_status']) { ?>
                          <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                          <option value="0"><?php echo $text_disabled; ?></option>
                        <?php } else { ?>
                          <option value="1"><?php echo $text_enabled; ?></option>
                          <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                        <?php } ?>
                      </select>
                    </div>
                  </div>
                  
                  <hr />

                  <div class="form-group">
                    <label class="col-sm-2 control-label" for="input-config-js-debug">
                      <span data-toggle="tooltip" title="<?php echo $help_config_js_debug; ?>"><?php echo $entry_config_js_debug; ?></span>
                    </label>
                    <div class="col-sm-10">
                      <div class="bs-switch bs-switch-common" data-bs-switch-toggle-target="js_debug">
                        <input type="hidden" name="config[<?php echo $code; ?>_config][js_debug]" value="0" />
                        <div class="checkbox">
                          <label>
                            <input type="checkbox" id="input-config-js-debug" class="input-config-js-debug" name="config[<?php echo $code; ?>_config][js_debug]" value="1" <?php echo $config[$code . '_config']['js_debug'] == 1 ? 'checked' : ''; ?> />
                          </label>
                        </div>                            
                      </div>
                    </div>
                  </div>
                  
                  <hr />

                  <div class="form-group">
                    <label class="col-sm-2 control-label" for="input-config-use-xsl-stylesheets">
                      <span data-toggle="tooltip" title="<?php echo $help_config_use_xsl_stylesheets; ?>"><?php echo $entry_config_use_xsl_stylesheets; ?></span>
                    </label>
                    <div class="col-sm-10">
                      <div class="bs-switch bs-switch-common" data-bs-switch-toggle-target="use_xsl_stylesheets">
                        <input type="hidden" name="config[<?php echo $code; ?>_config][use_xsl_stylesheets]" value="0" />
                        <div class="checkbox">
                          <label>
                            <input type="checkbox" id="input-config-use-xsl-stylesheets" class="input-config-use-xsl-stylesheets" name="config[<?php echo $code; ?>_config][use_xsl_stylesheets]" value="1" <?php echo $config[$code . '_config']['use_xsl_stylesheets'] == 1 ? 'checked' : ''; ?> />
                          </label>
                        </div>                            
                      </div>
                    </div>
                  </div>
                  
                  <hr />

                  <div class="form-group">
                    <label class="col-sm-2 control-label" for="input-config-append-lang-param">
                      <span data-toggle="tooltip" title="<?php echo $help_config_append_lang_param; ?>"><?php echo $entry_config_append_lang_param; ?></span>
                    </label>
                    <div class="col-sm-10">
                      <div class="bs-switch bs-switch-common" data-bs-switch-toggle-target="append_lang_param">
                        <input type="hidden" name="config[<?php echo $code; ?>_config][append_lang_param]" value="0" />
                        <div class="checkbox">
                          <label>
                            <input type="checkbox" id="input-config-append-lang-param" class="input-config-append-lang-param" name="config[<?php echo $code; ?>_config][append_lang_param]" value="1" <?php echo $config[$code . '_config']['append_lang_param'] == 1 ? 'checked' : ''; ?> />
                          </label>
                        </div>                            
                      </div>
                    </div>
                  </div>
                        
                  <hr />

                  <div class="form-group">
                    <label class="col-sm-2 control-label" for="input-config-use-hreflang">
                      <span data-toggle="tooltip" title="<?php echo $help_config_use_hreflang; ?>"><?php echo $entry_config_use_hreflang; ?></span>
                    </label>
                    <div class="col-sm-10">
                      <div class="bs-switch bs-switch-common" data-bs-switch-toggle-target="use_hreflang">
                        <input type="hidden" name="config[<?php echo $code; ?>_config][use_hreflang]" value="0" />
                        <div class="checkbox">
                          <label>
                            <input type="checkbox" id="input-config-use-hreflang" class="input-config-use-hreflang" name="config[<?php echo $code; ?>_config][use_hreflang]" value="1" <?php echo $config[$code . '_config']['use_hreflang'] == 1 ? 'checked' : ''; ?> />
                          </label>
                        </div>                            
                      </div>
                    </div>
                  </div>                          
                       
                  <hr />

                  <div class="form-group">
                    <label class="col-sm-2 control-label" for="input-config-image-width">
                      <span data-toggle="tooltip" title="<?php echo $help_config_image_width; ?>"><?php echo $entry_config_image_width; ?></span>
                    </label>
                    <div class="col-sm-4 col-md-2">
                      <input type="number" id="input-config-image-width" class="input-config-image-width form-control" name="config[<?php echo $code; ?>_config][image_width]" value="<?php echo $config[$code . '_config']['image_width']; ?>" min="0" /> 
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="col-sm-2 control-label" for="input-config-image-height">
                      <span data-toggle="tooltip" title="<?php echo $help_config_image_height; ?>"><?php echo $entry_config_image_height; ?></span>
                    </label>
                    <div class="col-sm-4 col-md-2">
                      <input type="number" id="input-config-image-height" class="input-config-image-height form-control" name="config[<?php echo $code; ?>_config][image_height]" value="<?php echo $config[$code . '_config']['image_height']; ?>" min="0" />
                    </div>
                  </div>
                  
                  <hr />

                  <div class="form-group">
                    <label class="col-sm-2 control-label" for="input-config-max-execution-time">
                      <span data-toggle="tooltip" title="<?php echo $help_config_max_execution_time; ?>"><?php echo $entry_config_max_execution_time; ?></span>
                    </label>
                    <div class="col-sm-4 col-md-2">
                      <input type="number" id="input-config-max-execution-time" class="input-config-max-execution-time form-control" name="config[<?php echo $code; ?>_config][max_execution_time]" value="<?php echo $config[$code . '_config']['max_execution_time']; ?>" min="0" /> 
                    </div>
                  </div>
                  
                  <hr />
                  
                  <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                      <button type="button" class="btn btn-primary btn-save-config"><?php echo $button_save_configuration; ?></button>
                    </div>
                  </div>                          
                  
                </fieldset>
                
              </div>
              <!-- /.tab-pane -->              
              
              <div id="tab-help" class="tab-pane">               
                <div class="row">
                  <div class="col-sm-6">
                    <h3><i class="fa fa-key green"></i> License information</h3>
                    <div class="alert-lic-notice-container"></div>
                    <p>The following table shows your current license information:</p>
                    <table class="table table-striped table-lic-info">
                      <tbody>
                        <tr>
                          <td class="text-right">Licensee:</td>
                          <td class="lic-licensee-name"><?php echo $config[$code . '_lic']['licensee']['name']; ?></td>
                        </tr>
                        <tr>
                          <td class="text-right">Domain:</td>
                          <td class="lic-server"><?php echo $config[$code . '_lic']['server']; ?></td>
                        </tr>
                        <tr>
                          <td class="text-right">Purchase Date:</td>
                          <td class="lic-purchased_at-formatted"><?php echo $config[$code . '_lic']['purchased_at']['formatted']; ?></td>
                        </tr>
                        <tr>
                          <td class="text-right">Expiration Date:</td>
                          <td class="lic-expires_at-formatted"><?php echo $config[$code . '_lic']['expires_at']['formatted']; ?></td>
                        </tr>
                        <tr>
                          <td class="text-right">Status:</td>
                          <td class="lic-status-name"><i class="fa <?php echo $config[$code . '_lic']['status']['icon']['name']; ?> fa-fw" style="color: <?php echo $config[$code . '_lic']['status']['icon']['color']; ?>"></i> <?php echo $config[$code . '_lic']['status']['name'] ; ?></td>
                        </tr>
                      </tbody>
                      <tfoot>
                        <tr>
                          <td class="text-right" colspan="2">
                            <a class="btn btn-primary btn-manage-license-keys" target="_blank" href="<?php echo $config[$code . '_lic']['urls']['list']; ?>" role="button">Manage License Keys</a>
                          </td>
                        </tr>
                      </tfoot>
                    </table>
                    <input type="hidden" name="config[<?php echo $code; ?>_lic][key]" value="<?php echo $config[$code . '_lic']['key']; ?>" readonly="readonly" />
                    <input type="hidden" name="config[<?php echo $code; ?>_lic][licensee][name]" value="<?php echo $config[$code . '_lic']['licensee']['name']; ?>" readonly="readonly" />
                    <input type="hidden" name="config[<?php echo $code; ?>_lic][server]" value="<?php echo $config[$code . '_lic']['server']; ?>" readonly="readonly" />
                    <input type="hidden" name="config[<?php echo $code; ?>_lic][purchased_at][raw]" value="<?php echo $config[$code . '_lic']['purchased_at']['raw']; ?>" readonly="readonly" />
                    <input type="hidden" name="config[<?php echo $code; ?>_lic][purchased_at][formatted]" value="<?php echo $config[$code . '_lic']['purchased_at']['formatted']; ?>" readonly="readonly" />
                    <input type="hidden" name="config[<?php echo $code; ?>_lic][expires_at][raw]" value="<?php echo $config[$code . '_lic']['expires_at']['raw']; ?>" readonly="readonly" />
                    <input type="hidden" name="config[<?php echo $code; ?>_lic][expires_at][formatted]" value="<?php echo $config[$code . '_lic']['expires_at']['formatted']; ?>" readonly="readonly" />
                    <input type="hidden" name="config[<?php echo $code; ?>_lic][status][id]" value="<?php echo $config[$code . '_lic']['status']['id']; ?>" readonly="readonly" />
                    <input type="hidden" name="config[<?php echo $code; ?>_lic][status][name]" value="<?php echo $config[$code . '_lic']['status']['name']; ?>" readonly="readonly" />
                    <input type="hidden" name="config[<?php echo $code; ?>_lic][status][icon][name]" value="<?php echo $config[$code . '_lic']['status']['icon']['name']; ?>" readonly="readonly" />
                    <input type="hidden" name="config[<?php echo $code; ?>_lic][status][icon][color]" value="<?php echo $config[$code . '_lic']['status']['icon']['color']; ?>" readonly="readonly" />
                    <input type="hidden" name="config[<?php echo $code; ?>_lic][checked_at][raw]" value="<?php echo $config[$code . '_lic']['checked_at']['raw']; ?>" readonly="readonly" />
                    <input type="hidden" name="config[<?php echo $code; ?>_lic][checked_at][formatted]" value="<?php echo $config[$code . '_lic']['checked_at']['formatted']; ?>" readonly="readonly" />
                    <input type="hidden" name="config[<?php echo $code; ?>_lic][urls][list]" value="<?php echo $config[$code . '_lic']['urls']['list']; ?>" readonly="readonly" />
                    <input type="hidden" name="config[<?php echo $code; ?>_lic][urls][detail]" value="<?php echo $config[$code . '_lic']['urls']['detail']; ?>" readonly="readonly" />
                    <hr>
                    <h3><i class="fa fa-info-circle marine-blue"></i> About application</h3>
                    <p><?php echo $heading_title; ?>, version <?php echo $version; ?></p>
                    <p>Copyright &copy; <?php call_user_func( function($y) { $c = date('Y'); echo $y . (($y != $c) ? '-' . $c : ''); }, 2015); ?> Cuispi. All rights reserved.</p>
                  </div>
                  <div class="col-sm-6">
                    <div class="well">
                      <h3><i class="fa fa-life-ring orange"></i> Priority support</h3>
                      <p>
                        Cuispi Priority Support is a priority response support channel that is staffed with our friendly and experienced Technical Support team. 
                        Priority Support is automatically included in your initial purchase price for a period of one year.
                      </p>
                      <p class="text-right">
                        <a class="btn btn-primary" target="_blank" href="http://support.cuispi.com/" role="button">Get Support</a>
                      </p>
                    </div>
                    <div class="well">
                      <h3><i class="fa fa-tags aqua-green"></i> Other products you may like</h3>
                      <p>
                        Cuispi products, systems and services offer innovative solutions with outstanding added value to customers. 
                        Check out all our top quality products now!
                      </p>
                      <p class="text-right">
                        <a class="btn btn-primary" target="_blank" href="http://productcentral.cuispi.com/" role="button">Find Out More</a>
                      </p>                      
                    </div>                   
                  </div>
                </div>
                <!-- /.row -->
              </div>
              <!-- /.tab-pane -->       
              
            </div>
            <!-- /.tab-content -->   

          </form>
                  
          <input type="hidden" id="data_changed" name="data_changed" value="0" />
          <input type="hidden" id="lic-key" name="lic_key" value="<?php echo $lic_key; ?>" readonly="readonly" />                  
                  
        </div>
      </div>
    </div>    
    
  </div>
  <!-- /#XmlSitemapGenerator -->
  
  <div id="Activation" style="display: none;">
    <div class="page-header">
      <div class="container-fluid">
        <div class="pull-right">
          <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a>
        </div>
        <h1><?php echo $heading_title; ?> <span class="version badge"><?php echo $version; ?></span></h1>
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
          <h3 class="panel-title"><i class="fa fa-key"></i> Activate <?php echo $heading_title; ?></h3>
        </div>
        <div class="panel-body">
          <form>
            <p class="help-block">Please enter your license key to activate the extension.</p>
            <p class="help-block">
              Don&rsquo;t have a license key? <a href="http://getkey.cuispi.com/opencart" target="_blank">Get one now! <i class="fa fa-external-link"></i></a>
            </p>
            <div class="form-group">
              <label for="input-lic-key">License Key</label>
              <div class="row">
                <div class="col-sm-6">
                  <input type="text" id="input-lic-key" class="form-control" name="config[<?php echo $code; ?>_config][lic][key]" value="" placeholder="XXXXX-XXXXX-XXXXX-XXXXX-XXXXX"  maxlength="29">
                </div>
              </div>
              <p class="help-block">
                Before you enter your license key, please make sure that you are connected to the Internet and press &ldquo;Activate&rdquo; button to initiate the license verification process.
              </p>
            </div>
            <button type="button" id="btn-activate" class="btn btn-lg btn-success">Activate</button>
          </form>
        </div>
      </div>
    </div>
  </div>
  <!-- /#Activation -->
  
  <script type="text/javascript">
    
  $(function() {

    <?php if (isset($initialization_errors['error_admin_js_not_loaded'])) { ?>
        
      $('#XmlSitemapGenerator').hide();
      alert('<?php echo $initialization_errors.error_admin_js_not_loaded; ?>');
      
    <?php } else { ?>

      var options = {};

      options['js_debug'] = Boolean(<?php echo $config[$code . '_config']['js_debug']; ?>);
      options['oc_version'] = '<?php echo VERSION; ?>';
      options['code'] = '<?php echo $code; ?>';
      options['_code'] = '<?php echo $_code; ?>';
      options['extension_path'] = '<?php echo $extension_path; ?>';
      options['user_token_key'] = '<?php echo $user_token_key; ?>';
      options['user_token_value'] = '<?php echo $user_token_value; ?>';
      
      options['stores'] = <?php echo json_encode($stores); ?>;
      
      options['initialization_errors'] = <?php echo json_encode($initialization_errors) ?>;
      
      options['lic'] = {
        svr: '<?php echo $server_name; ?>',
        lang: '<?php echo $admin_language; ?>',
        tz: '<?php echo $date_default_timezone; ?>',
        ip: '<?php echo $server_addr; ?>'
      }; 

      options['translations'] = {
        text_on: '<?php echo $text_on; ?>',
        text_off: '<?php echo $text_off; ?>',
        text_page_stores_non_selected: '<?php echo $text_page_stores_non_selected; ?>',
        text_page_stores_all_selected: '<?php echo $text_page_stores_all_selected; ?>',
        text_confirm_remove_page: '<?php echo $text_confirm_remove_page; ?>',
        text_confirm_delete_pages: '<?php echo $text_confirm_delete_pages; ?>',
        text_page_search: '<?php echo $text_page_search; ?>',
        text_page_no_results: '<?php echo $text_page_no_results; ?>',
        text_enabled: '<?php echo $text_enabled; ?>',
        text_disabled: '<?php echo $text_disabled; ?>',
        text_page_new: '<?php echo $text_page_new; ?>',
        column_url: '<?php echo $column_url; ?>',
        column_stores: '<?php echo $column_stores; ?>',
        column_status: '<?php echo $column_status; ?>',
        column_date_added: '<?php echo $column_date_added; ?>',
        column_page_id: '<?php echo $column_page_id; ?>',
        column_action: '<?php echo $column_action; ?>',
        entry_page_url: '<?php echo $entry_page_url; ?>',
        entry_page_stores: '<?php echo $entry_page_stores; ?>',
        entry_page_status: '<?php echo $entry_page_status; ?>',      
        button_add: '<?php echo $button_add; ?>',
        button_delete: '<?php echo $button_delete; ?>',
        button_edit: '<?php echo $button_edit; ?>',
        button_remove: '<?php echo $button_remove; ?>',
        button_apply: '<?php echo $button_apply; ?>',
        button_save: '<?php echo $button_save; ?>',
        button_discard: '<?php echo $button_discard; ?>'
      };

      $('#XmlSitemapGenerator').xmlSitemapGenerator(options);
      
    <?php } ?>
    
  });
  </script>   
</div>
<!-- /#content -->

<?php echo $footer; ?>