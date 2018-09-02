<?php
/**
 * XML Sitemap Generator
 * 
 * @author  Cuispi
 * @version 1.0.1
 * @license Commercial License
 * @package admin
 * @subpackage  admin.language.en-gb.feed
 */

// Heading
$_['heading_title']                     = 'XML Sitemap Generator';

// Text
$_['text_extension']                    = 'Extensions';
$_['text_feed']                         = 'Feeds';
$_['text_success']                      = 'Success: You have modified XML Sitemap Generator feed!';
$_['text_edit']                         = 'Edit XML Sitemap Generator';
$_['text_on']                           = 'On';
$_['text_off']                          = 'Off';
$_['text_enabled']                      = 'Enabled';
$_['text_disabled']                     = 'Disabled';
$_['text_status']                       = 'Status';
$_['text_general']                      = 'General';
$_['text_sitemap_created']              = 'Success: The %s sitemap has been created successfully.';
$_['text_log_message']                  = '%s: %s on %s in %s';
$_['text_type_product']                 = 'Products';
$_['text_type_category']                = 'Categories';
$_['text_type_manufacturer']            = 'Manufacturers';
$_['text_type_information']             = 'Information';
$_['text_type_page']                    = 'Pages';
$_['text_page_stores_non_selected']     = 'No store selected';
$_['text_page_stores_all_selected']     = 'All stores';
$_['text_confirm_remove_page']          = 'Are you sure you want to delete this item?';
$_['text_confirm_delete_pages']         = 'Are you sure you want to delete selected item(s)?';
$_['text_page_search']                  = 'Search by URL or page ID';
$_['text_page_no_results']              = 'No pages found';
$_['text_page_new']                     = 'New Page';
$_['text_sitemap_setting_success']      = 'Success: Your sitemap settings have been saved successfully!';
$_['text_page_save_success']            = 'Success: Your page link has been saved successfully!';
$_['text_page_delete_success']          = 'Success: Your page link has been deleted successfully!';
$_['text_pages_delete_success']         = 'Success: Your page links have been deleted successfully!';
$_['text_progress_message_preparing']   = 'Preparing data for %s ...';
$_['text_progress_message_generating']  = 'Generating XML sitemap files for %s. Please wait ...';
$_['text_progress_items_completed']     = 'Completed: %d/%d';
$_['text_progress_time_reporting']      = 'Elapsed time: %s &nbsp; Remaining time: %s';

// Column
$_['column_name']                       = 'Name';
$_['column_changefreq']                 = 'Changefreq';
$_['column_priority']                   = 'Priority';
$_['column_url_limit']                  = 'URL Limit';
$_['column_lastmod']                    = 'Last Generated';
$_['column_action']                     = 'Action';
$_['column_page_id']                    = 'ID';
$_['column_url']                        = 'URL';
$_['column_stores']                     = 'Stores';
$_['column_status']                     = 'Status';
$_['column_date_added']                 = 'Date Added';

// Entry
$_['entry_status']                      = 'Status';
$_['entry_config_status']               = 'Extension Status';
$_['entry_config_js_debug']             = 'JavaScript Debugging';
$_['entry_config_use_xsl_stylesheets']  = 'Use XSL Stylesheets';
$_['entry_config_append_lang_param']    = 'Language Parameter In URL';
$_['entry_config_use_hreflang']         = 'Use Hreflang';
$_['entry_config_image_width']          = 'Image Width';
$_['entry_config_image_height']         = 'Image Height';
$_['entry_config_max_execution_time']   = 'Max Execution Time';
$_['entry_page_url']                    = 'URL';
$_['entry_page_stores']                 = 'Stores';
$_['entry_page_status']                 = 'Status';

// Help
$_['help_config_status']                = 'Set to Enabled to use this extension, or Disabled not to use it.';
$_['help_config_js_debug']              = 'When JavaScript Debugging is enabled, the extension logs detailed information to the JavaScript console of your web browser. This should be set to OFF for security reasons when not used.';
$_['help_config_use_xsl_stylesheets']   = 'Determines whether or not to apply XSL stylesheets to XML sitemap and XML sitemap index files.';
$_['help_config_append_lang_param']     = 'Appends a query string parameter for identifying a language, e.g., <code>&language=en-gb</code> to a URL on sitemap generation, when the URL contains no valid SEO URL.';
$_['help_config_use_hreflang']          = 'The <code>rel=&quot;alternate&quot; hreflang=&quot;x&quot;</code> link attribute specifies the language and optional geographic restrictions for a document. Hreflang is interpreted by search engines and can be used by webmasters to clarify the lingual and geographical targeting of a website.';
$_['help_config_image_width']           = 'The intrinsic width of the images in XML sitemap files, in CSS pixels.<br>DEFAULTS TO: <code>500</code>';
$_['help_config_image_height']          = 'The intrinsic height of the image in XML sitemap files, in CSS pixels.<br>DEFAULTS TO: <code>500</code>';
$_['help_config_max_execution_time']    = 'The maximum time in seconds a process for generating sitemap files is allowed to run before it is terminated by the parser. This value only applies to processes run from a web server, but has no effect on the command line or cron. The <code>max_execution_time</code> in your php.ini must be changeable through the <code>ini_set()</code> function before this option can be available.<br>DEFAULTS TO: <code>600</code>';

// Button
$_['button_save']                       = 'Save';
$_['button_save_and_close']             = 'Save &amp; Close';
$_['button_generat_sitemap']            = 'Generate Sitemap';
$_['button_generat_sitemaps']           = 'Generate Sitemaps';
$_['button_apply']                      = 'Apply';
$_['button_discard']                    = 'Discard';
$_['button_save_configuration']         = 'Save Configuration';

// Tab
$_['tab_sitemap_settings']              = 'Sitemap Settings';
$_['tab_view_sitemap']                  = 'View Sitemap';
$_['tab_pages']                         = 'Pages';
$_['tab_config']                        = 'Configuration';
$_['tab_help']                          = 'Help';

// Error
$_['error_permission']                  = 'Warning: You do not have permission to modify XML Sitemap Generator feed!';
$_['error_process_id']                  = 'Warning: Invalid process ID!';
$_['error_process_locked']              = 'Warning: A server process is currently running. Please try again after some time!';
$_['error_no_task_selected']            = 'Warning: You must select at least one checkbox to proceed with generating XML sitemaps!';
$_['error_image_width_max_value']       = 'Warning: The image width cannot be more than %d in CSS pixels!';
$_['error_image_height_max_value']      = 'Warning: The image height cannot be more than %d in CSS pixels!';
$_['error_image_width_negative_value']  = 'Warning: The image width cannot be a negative value!';
$_['error_image_height_negative_value'] = 'Warning: The image height cannot be a negative value!';
$_['error_cannot_open_file']            = 'Error: Cannot open file \'%s\'';
$_['error_cannot_write_to_file']        = 'Error: Cannot write to file \'%s\'';
$_['error_failed_to_create_sitemaps']   = 'Error: Failed to create sitemaps.';
$_['error_no_page_link_selected']       = 'Error: No page link has been selected.';
$_['error_library_not_loaded']          = 'Error: Library is not loaded!';
$_['error_admin_js_not_loaded']         = 'Error: Admin JS file is not loaded!';
