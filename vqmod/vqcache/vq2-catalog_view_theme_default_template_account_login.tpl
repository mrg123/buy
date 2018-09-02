<?php echo $header; ?>
<div class="container">
  <ul class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
    <?php } ?>
  </ul>
  <?php if ($success) { ?>
  <div class="alert alert-success"><i class="fa fa-check-circle"></i> <?php echo $success; ?></div>
  <?php } ?>
  <?php if ($error_warning) { ?>
  <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?></div>
  <?php } ?>
  <div class="row"><?php echo $column_left; ?>
    <?php if ($column_left && $column_right) { ?>
    <?php $class = 'col-sm-6'; ?>
    <?php } elseif ($column_left || $column_right) { ?>
    <?php $class = 'col-sm-9'; ?>
    <?php } else { ?>
    <?php $class = 'col-sm-12'; ?>
    <?php } ?>
    <div id="content" class="<?php echo $class; ?>"><?php echo $content_top; ?>
            
            <div id="socl_for_new_user">     
			
      <div class="row">
        <div class="col-sm-6">
          <div class="well">
            <h2><?php echo $text_new_customer; ?></h2>
            <p><strong><?php echo $text_register; ?></strong></p>
            <p><?php echo $text_register_account; ?></p>
            <a href="<?php echo $register; ?>" class="btn btn-primary"><?php echo $button_continue; ?></a></div>
        </div>
            
            <?php if(isset($social_login) && count($social_login)) { ?>
            <div class="col-sm-6">
                <div class="well" style="display: inline-block;">
                    <h2><?php echo $text_socl_login; ?></h2>
                    <div class="sa-<?php echo $social_login_theme; ?>">
                        <?php foreach($social_login as $social) { ?>    
                            <?php if($social_login_themes_customize_check) { ?>    
                            <div class="col col<?php echo $social_login_themes_customize_col; ?> pos-<?php echo $social_login_themes_customize_position; ?>">
                                <a href="<?php echo $social['href']; ?>" class="sa <?php if($social_login_theme_size != '0') { ?>sa-<?php echo $social_login_theme_size; } ?> sa-<?php echo $social['code']; ?> txt-<?php echo $social_login_themes_customize_align; ?>" style="width: <?php echo $social_login_themes_customize_width; ?>%;"><?php echo $social_login_themes_customize_text . " " . $social['name']; ?></a>
                            </div> 
                            <?php } else { ?>       
                            <a href="<?php echo $social['href']; ?>" class="sa <?php if($social_login_theme_size != '0') { ?>sa-<?php echo $social_login_theme_size; } ?> sa-<?php echo $social['code']; ?>"></a>                
                        <?php }} ?>
                    </div>
                </div>
            </div>
            <?php } ?>            
			
        <div class="col-sm-6">
          <div class="well">
            <h2><?php echo $text_returning_customer; ?></h2>
            <p><strong><?php echo $text_i_am_returning_customer; ?></strong></p>
            <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
              <div class="form-group">
                <label class="control-label" for="input-email"><?php echo $entry_email; ?></label>
                <input type="text" name="email" value="<?php echo $email; ?>" placeholder="<?php echo $entry_email; ?>" id="input-email" class="form-control" />
              </div>
              <div class="form-group">
                <label class="control-label" for="input-password"><?php echo $entry_password; ?></label>
                <input type="password" name="password" value="<?php echo $password; ?>" placeholder="<?php echo $entry_password; ?>" id="input-password" class="form-control" />
                <a href="<?php echo $forgotten; ?>"><?php echo $text_forgotten; ?></a></div>
              <input type="submit" value="<?php echo $button_login; ?>" class="btn btn-primary" />
              <?php if ($redirect) { ?>
              <input type="hidden" name="redirect" value="<?php echo $redirect; ?>" />
              <?php } ?>
            </form>
          </div>
        </div>
      </div>
            
            </div>     
			
      <?php echo $content_bottom; ?></div>
    <?php echo $column_right; ?></div>
</div>
  
            <?php if(isset($socl_id)) { ?>          
                <script type="text/javascript">
                    $(document).ready(function() {
                        $.ajax({
        					url: 'index.php?route=account/socl_login/register',
                            type: 'GET',
                            data: 'socl_id=<?php echo $socl_id; ?>&network=<?php echo $socl_network; ?>&email=<?php echo $socl_email; ?>&firstname=<?php echo $socl_firstname; ?>&lastname=<?php echo $socl_lastname; ?>',
        					dataType: 'html',                                                  
                            <?php if(!empty($socl_email) && isset($socl_required_entry_empty) && $socl_required_entry_empty == 1 && $socl_custom_fields_empty == 1) { ?>
                            complete: function() {
                                socl_login_actions.quickAddNewCustomer();
                            }, 
                            <?php } else { ?>
                            complete: function() { 
                                <?php if(isset($country_display) && $country_display == 1) { ?>
                                $('#socl_for_new_user select[name=\'country_id\']').trigger('change');
                                <?php } ?>
                                
                                $('#socl_for_new_user #account .form-group[data-sort]').detach().each(function() {
                                	if ($(this).attr('data-sort') >= 0 && $(this).attr('data-sort') <= $('#socl_for_new_user #account .form-group').length) {
                                		$('#socl_for_new_user #account .form-group').eq($(this).attr('data-sort')).before(this);
                                	} 
                                	
                                	if ($(this).attr('data-sort') > $('#socl_for_new_user #account .form-group').length) {
                                		$('#socl_for_new_user #account .form-group:last').after(this);
                                	}
                                		
                                	if ($(this).attr('data-sort') < -$('#socl_for_new_user #account .form-group').length) {
                                		$('#socl_for_new_user #account .form-group:first').before(this);
                                	}
                                });
                                
                                $('#socl_for_new_user #address .form-group[data-sort]').detach().each(function() {
                                	if ($(this).attr('data-sort') >= 0 && $(this).attr('data-sort') <= $('#socl_for_new_user #address .form-group').length) {
                                		$('#socl_for_new_user #address .form-group').eq($(this).attr('data-sort')).before(this);
                                	} 
                                	
                                	if ($(this).attr('data-sort') > $('#socl_for_new_user #address .form-group').length) {
                                		$('#socl_for_new_user #address .form-group:last').after(this);
                                	}
                                		
                                	if ($(this).attr('data-sort') < -$('#socl_for_new_user #address .form-group').length) {
                                		$('#socl_for_new_user #address .form-group:first').before(this);
                                	}
                                });
                                
                                $('.date').datetimepicker({
                                	pickTime: false
                                });
                                
                                $('.time').datetimepicker({
                                	pickDate: false
                                });
                                
                                $('.datetime').datetimepicker({
                                	pickDate: true,
                                	pickTime: true
                                });
                            },  
                            <?php } ?>                          
        					success: function(html) {
                                $('#socl_for_new_user').html(html); 
        					},
        					error: function(xhr, ajaxOptions, thrownError) {
        						alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        					}
        				});	                                            
                    });
                    
                    var socl_login_actions = {
                        <?php if (isset($country_display) && $country_display == 1 && ($postcode_display == 1 || $region_display == 1)) { ?>
                        changeSelectCountry : function() {
                            var country = $('#socl_for_new_user select[name=\'country_id\']');
                            $.ajax({
                        		url: 'index.php?route=account/account/country&country_id=' + country.val(),
                        		dataType: 'json',
                        		beforeSend: function() {
                        			$('select[name=\'country_id\']').after(' <i class="fa fa-circle-o-notch fa-spin"></i>');
                        		},
                        		complete: function() {
                        			$('.fa-spin').remove();
                        		},
                        		success: function(json) {
                  		            <?php if ($postcode_display == 1) { ?>
                        			if (json['postcode_required'] == '1') {
                        				$('input[name=\'postcode\']').parent().parent().addClass('required');
                        			} else {
                        				$('input[name=\'postcode\']').parent().parent().removeClass('required');
                        			}
                                    <?php } ?>
                        			
                                    <?php if ($region_display == 1) { ?>
                        			html = '<option value=""><?php echo $text_select; ?></option>';
                        			
                        			if (json['zone'] != '') {
                        				for (i = 0; i < json['zone'].length; i++) {
                        					html += '<option value="' + json['zone'][i]['zone_id'] + '" >' + json['zone'][i]['name'] + '</option>';
                        				}
                        			} else {
                        				html += '<option value="0" selected="selected"><?php echo $text_none; ?></option>';
                        			}
                        			
                        			$('select[name=\'zone_id\']').html(html);
                                    <?php } ?>
                        		},
                        		error: function(xhr, ajaxOptions, thrownError) {
                        			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                        		}
                        	});
                        },
                        <?php } ?>
                        validateAndSaveNewCustomerInfo: function() {
                            $.ajax({
                            	url: 'index.php?route=account/socl_login/validate',
                            	type: 'POST',
                            	data: $('#socl_for_new_user input[type=\'text\'], #socl_for_new_user input[type=\'hidden\'], #socl_for_new_user select, #socl_for_new_user input[type=\'date\'], #socl_for_new_user input[type=\'datetime-local\'], #socl_for_new_user input[type=\'time\'], #socl_for_new_user input[type=\'checkbox\']:checked, #socl_for_new_user input[type=\'radio\']:checked, #socl_for_new_user textarea'),
                            	dataType: 'json',
                            	beforeSend: function() {
                            		$('#socl_save_new_cus').button('loading');
                            	},
                            	complete: function() {
                            		$('#socl_save_new_cus').button('reset');                            		
                            	},
                            	success: function(json) {
                            		$('.alert, .text-danger').remove();
                                    $('.form-group').removeClass('has-error');
                                    
                            		if (json['redirect']) {
                            			location = json['redirect'];
                            		} else if (json['error']) {
                      		            if (json['error']['existed_email']) {
                      		                $('<div id="socl_confirm_pass"></div>').insertBefore('#socl_for_new_user');
                                            socl_login_actions.existedEmail();
                            			} else {
                            				for (i in json['error']) {
                            					var element = $('#input-' + i.replace('_', '-'));
                            					
                            					if ($(element).parent().hasClass('input-group')) {
                            						$(element).parent().after('<div class="text-danger">' + json['error'][i] + '</div>');
                            					} else {
                            						$(element).after('<div class="text-danger">' + json['error'][i] + '</div>');
                            					}
                            				}
                            				
                            				// Highlight any found errors
                            				$('.text-danger').parent().addClass('has-error');	
                                        }
                            		}
                            	},
                            	error: function(xhr, ajaxOptions, thrownError) {
                            		alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                            	}
                            });
                        },
                        quickAddNewCustomer: function() {
                            $.ajax({
                                url: 'index.php?route=account/socl_login/validate',
                            	type: 'POST',
                            	data: $('#socl_for_new_user input[type=\'text\'], #socl_for_new_user input[type=\'hidden\'], #socl_for_new_user select, #socl_for_new_user input[type=\'date\'], #socl_for_new_user input[type=\'datetime-local\'], #socl_for_new_user input[type=\'time\'], #socl_for_new_user input[type=\'checkbox\']:checked, #socl_for_new_user input[type=\'radio\']:checked, #socl_for_new_user textarea'),
                                dataType: 'json',
                                beforeSend: function() {
                                    $('#socl_for_new_user .well').prepend('<i class="fa fa-spinner"></i>&nbsp;<?php echo $text_please_wait; ?></b>');
                                    $('#text_fill_all').hide();
                                },
                                success: function(json) {
                                    if (json['redirect']) {
                            			location = json['redirect'];
                            		}
                                },
                                error: function(xhr, ajaxOptions, thrownError) {
                            		alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                            	}
                            });
                        },
                        uploadFile: function(fieldid) {
                            var node = "#socl_for_new_user button[id='button-custom-field" + fieldid + "']";

                        	$('#form-upload').remove();
                        
                        	$('body').prepend('<form enctype="multipart/form-data" id="form-upload" style="display: none;"><input type="file" name="file" /></form>');
                        
                        	$('#form-upload input[name=\'file\']').trigger('click');
                        
                        	timer = setInterval(function() {
                        		if ($('#form-upload input[name=\'file\']').val() != '') {
                        			clearInterval(timer);
                        		
                        			$.ajax({
                        				url: 'index.php?route=tool/upload',
                        				type: 'post',
                        				dataType: 'json',
                        				data: new FormData($('#form-upload')[0]),
                        				cache: false,
                        				contentType: false,
                        				processData: false,
                        				beforeSend: function() {
                        					$(node).button('loading');
                        				},
                        				complete: function() {
                        					$(node).button('reset');
                        				},
                        				success: function(json) {
                        					$('.text-danger').remove();
                        					
                        					if (json['error']) {
                        						$(node).parent().find('input[name^=\'custom_field\']').after('<div class="text-danger">' + json['error'] + '</div>');
                        					}
                        	
                        					if (json['success']) {
                        						alert(json['success']);
                        	
                        						$(node).parent().find('input[name^=\'custom_field\']').attr('value', json['code']);
                        					}
                        				},
                        				error: function(xhr, ajaxOptions, thrownError) {
                        					alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                        				}
                        			});
                        		}
                        	}, 500);
                        },
                        existedEmail: function() {
                            $.ajax({
                                url: 'index.php?route=account/socl_login/existed',
                                dataType: 'html',
                                beforeSend: function() {
                                    $('#socl_for_new_user').css('display', 'none');
                                    $('#socl_confirm_pass').html('<i class="fa fa-spinner"></i>&nbsp;<?php echo $text_please_wait; ?></b>');
                                },
                                success: function(html) {
                                    $('#socl_confirm_pass').html(html);
                                },
                                error: function(xhr, ajaxOptions, thrownError) {
                            		alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                            	}
                            });
                        },
                        confirmPassword: function() {
                            $.ajax({
                                url: 'index.php?route=account/socl_login/confirm',
                                type: 'POST',
                            	data: $('#socl_for_new_user input[name=\'email\'], #socl_for_new_user input[name=\'socl_id\'], #socl_for_new_user input[name=\'network\'], #socl_confirm_pass input[name=\'confirm_pass\']'),
                                dataType: 'json',
                                beforeSend: function() {
                                    $('#socl_btn_confirm').button('loading');
                                },
                                complete: function() {
                            		$('#socl_btn_confirm').button('reset'); 
                            	},
                                success: function(json) {
                                    $('.alert, .text-danger').remove();
                                    
                            		if (json['redirect']) {
                            			location = json['redirect'];
                            		} else if(json['error']) {
                          		        $('#socl_confirm_pass input[name=\'confirm_pass\']').after('<div class="text-danger">' + json['error'] + '</div>');
                          		    }
                                },
                                error: function(xhr, ajaxOptions, thrownError) {
                            		alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                            	}
                            });
                        },
                        cancelConfirmPass: function() {
                            $('#socl_confirm_pass').remove();
                            $('#socl_for_new_user').css('display', '');
                        }
                    };
                </script>  
            <?php } ?>         
			
<?php echo $footer; ?>